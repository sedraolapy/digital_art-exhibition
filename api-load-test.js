import http from 'k6/http';
import { check } from 'k6';
import { Rate, Trend } from 'k6/metrics';

const BASE_URL = (__ENV.BASE_URL || 'http://127.0.0.1:8000').replace(/\/$/, '');

const START_RPS = Number(__ENV.START_RPS || 10);
const MAX_RPS = Number(__ENV.MAX_RPS || 500);
const STAGE_SECONDS = Number(__ENV.STAGE_SECONDS || 30);
const HOLD_SECONDS = Number(__ENV.HOLD_SECONDS || 30);

const SMOKE = __ENV.SMOKE === '1';

const K6_EMAIL = __ENV.K6_EMAIL || '';
const K6_PASSWORD = __ENV.K6_PASSWORD || '';

const apiErrors = new Rate('api_errors');
const endpointLatency = new Trend('endpoint_latency', true);


/*
|--------------------------------------------------------------------------
| Build Load Stages
|--------------------------------------------------------------------------
*/

function buildStages() {

    if (SMOKE) {
        return [
            { target: 1, duration: '5s' },
            { target: 1, duration: '10s' },
            { target: 0, duration: '5s' },
        ];
    }

    const targets = [];

    let rps = START_RPS;

    while (rps < MAX_RPS) {
        targets.push(rps);
        rps *= 2;
    }

    targets.push(MAX_RPS);

    const stages = [];

    for (const target of targets) {

        stages.push({
            target: target,
            duration: `${STAGE_SECONDS}s`,
        });

        stages.push({
            target: target,
            duration: `${HOLD_SECONDS}s`,
        });
    }

    stages.push({
        target: 0,
        duration: '15s',
    });

    return stages;
}


/*
|--------------------------------------------------------------------------
| k6 Configuration
|--------------------------------------------------------------------------
*/

export const options = {

    scenarios: {

        api_stress: {

            executor: 'ramping-arrival-rate',

            startRate: SMOKE ? 1 : START_RPS,

            timeUnit: '1s',

            preAllocatedVUs: Number(
                __ENV.PREALLOCATED_VUS || 50
            ),

            maxVUs: Number(
                __ENV.MAX_VUS || 1000
            ),

            stages: buildStages(),

            gracefulStop: '10s',
        },
    },

    thresholds: {

        http_req_failed: [
            {
                threshold: 'rate<0.01',
                abortOnFail: false,
            },
        ],

        http_req_duration: [
            {
                threshold: 'p(95)<1000',
                abortOnFail: false,
            },

            {
                threshold: 'p(99)<2000',
                abortOnFail: false,
            },
        ],

        checks: [
            {
                threshold: 'rate>0.95',
                abortOnFail: false,
            },
        ],
    },

    discardResponseBodies: false,

    noConnectionReuse: false,
};


/*
|--------------------------------------------------------------------------
| Request Parameters
|--------------------------------------------------------------------------
*/

function params(token = null) {

    const headers = {

        Accept: 'application/json',

        'Content-Type': 'application/json',
    };

    if (token) {

        headers.Authorization = `Bearer ${token}`;
    }

    return {

        headers: headers,

        timeout: '10s',
    };
}


/*
|--------------------------------------------------------------------------
| GET Request
|--------------------------------------------------------------------------
*/

function get(path, token = null, expected = 200) {

    const response = http.get(

        `${BASE_URL}${path}`,

        params(token)
    );

    endpointLatency.add(

        response.timings.duration,

        {
            endpoint: path,
        }
    );

    const success = response.status === expected;

    check(response, {

        [`GET ${path} -> ${expected}`]:
            () => success,

    });

    apiErrors.add(

        !success,

        {
            endpoint: path,

            status: String(response.status),
        }
    );

    return response;
}


/*
|--------------------------------------------------------------------------
| POST Request
|--------------------------------------------------------------------------
*/

function post(
    path,
    body,
    token = null,
    expected = 200
) {

    const response = http.post(

        `${BASE_URL}${path}`,

        JSON.stringify(body),

        params(token)
    );

    endpointLatency.add(

        response.timings.duration,

        {
            endpoint: path,
        }
    );

    const success = response.status === expected;

    check(response, {

        [`POST ${path} -> ${expected}`]:
            () => success,

    });

    apiErrors.add(

        !success,

        {
            endpoint: path,

            status: String(response.status),
        }
    );

    return response;
}


/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

function login(email, password) {

    if (!email || !password) {

        return null;
    }

    const response = post(

        '/api/login',

        {
            email: email,

            password: password,
        },

        null,

        200
    );


    if (
        response.status < 200 ||
        response.status >= 300
    ) {

        console.error(
            `Login failed: HTTP ${response.status}`
        );

        return null;
    }


    try {

        const body = response.json();

        /*
         * Default:
         *
         * {
         *     "token": "..."
         * }
         *
         * If your response is:
         *
         * {
         *     "data": {
         *         "token": "..."
         *     }
         * }
         *
         * run with:
         *
         * -e TOKEN_PATH=data.token
         */

        const tokenPath =
            __ENV.TOKEN_PATH || 'token';


        const token =
            tokenPath
                .split('.')
                .reduce(

                    (object, key) => {

                        if (
                            object === null ||
                            object === undefined
                        ) {

                            return null;
                        }

                        return object[key];
                    },

                    body
                );


        if (token) {

            return token;
        }


        console.error(
            'Login succeeded but token was not found.'
        );

    } catch (error) {

        console.error(
            'Login response is not valid JSON.'
        );
    }


    return null;
}


/*
|--------------------------------------------------------------------------
| Setup
|--------------------------------------------------------------------------
*/

export function setup() {

    const data = {

        userToken: null,
    };


    /*
     * Login ONCE before the load test.
     *
     * We intentionally do NOT call login on every iteration
     * because your Laravel login route has:
     *
     * throttle:3,1
     */

    if (
        K6_EMAIL &&
        K6_PASSWORD
    ) {

        data.userToken =
            login(
                K6_EMAIL,
                K6_PASSWORD
            );
    }


    /*
     |--------------------------------------------------------------------------
     | Public API Smoke Check
     |--------------------------------------------------------------------------
     */

    const publicEndpoints = [

        '/api/members',

        '/api/exhibitors',

        '/api/experiences',

        '/api/statistics',

        '/api/lectures',

        '/api/sponsors',

        '/api/categories',

        '/api/days',

        '/api/workshops',

        '/api/check-in/session',
    ];


    for (
        const endpoint of publicEndpoints
    ) {

        get(endpoint);
    }


    return data;
}


/*
|--------------------------------------------------------------------------
| Main Load Test
|--------------------------------------------------------------------------
*/

export default function (data) {

    const token =
        data.userToken || null;


    const random =
        Math.random();


    /*
     |--------------------------------------------------------------------------
     | Members
     |--------------------------------------------------------------------------
     */

    if (random < 0.12) {

        get('/api/members');

    }


    /*
     |--------------------------------------------------------------------------
     | Exhibitors
     |--------------------------------------------------------------------------
     */

    else if (random < 0.24) {

        get('/api/exhibitors');

    }


    /*
     |--------------------------------------------------------------------------
     | Experiences
     |--------------------------------------------------------------------------
     */

    else if (random < 0.34) {

        get('/api/experiences');

    }


    /*
     |--------------------------------------------------------------------------
     | Statistics
     |--------------------------------------------------------------------------
     */

    else if (random < 0.43) {

        get('/api/statistics');

    }


    /*
     |--------------------------------------------------------------------------
     | Lectures
     |--------------------------------------------------------------------------
     */

    else if (random < 0.52) {

        get('/api/lectures');

    }


    /*
     |--------------------------------------------------------------------------
     | Sponsors
     |--------------------------------------------------------------------------
     */

    else if (random < 0.61) {

        get('/api/sponsors');

    }


    /*
     |--------------------------------------------------------------------------
     | Categories
     |--------------------------------------------------------------------------
     */

    else if (random < 0.70) {

        get('/api/categories');

    }


    /*
     |--------------------------------------------------------------------------
     | Days
     |--------------------------------------------------------------------------
     */

    else if (random < 0.79) {

        get('/api/days');

    }


    /*
     |--------------------------------------------------------------------------
     | Workshops
     |--------------------------------------------------------------------------
     */

    else if (random < 0.88) {

        get('/api/workshops');

    }


    /*
     |--------------------------------------------------------------------------
     | Check-in Session
     |--------------------------------------------------------------------------
     */

    else if (random < 0.94) {

        get('/api/check-in/session');

    }


    /*
     |--------------------------------------------------------------------------
     | Authenticated User
     |--------------------------------------------------------------------------
     */

    else {

        if (token) {

            get(
                '/api/user',
                token
            );

        } else {

            /*
             * If no credentials were supplied,
             * use a public endpoint instead of intentionally
             * generating 401 responses.
             */

            get('/api/members');
        }
    }
}
