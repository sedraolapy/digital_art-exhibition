<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactMessageRequest;
use App\Services\Auth\RecaptchaService;
use App\Services\Contact\ContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(
        private ContactService $contactService,
        private RecaptchaService $recaptchaService
        ) {}

    public function store(ContactMessageRequest $request)
    {
        $data = $request->validated();

        if (! $this->recaptchaService->verify($request->captcha_token)) {
            return response()->json([
                'message' => 'فشل التحقق من reCAPTCHA.',
                'data'  => null,
            ]);
        }

        $contactMessage = $this->contactService->store($data);

        return response()->json([
            'message' => 'تم إرسال رسالتك بنجاح.',
            'data' => null,
        ]);

    }
}
