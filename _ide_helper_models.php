<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $lecture_id
 * @property \App\Enums\BookingStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Lecture $lecture
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereLectureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Booking whereUserId($value)
 */
	class Booking extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExhibitorProfile> $exhibitorProfiles
 * @property-read int|null $exhibitor_profiles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $start_date
 * @property string|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sponsor> $diamondSponsors
 * @property-read int|null $diamond_sponsors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventOccurrence> $occurrences
 * @property-read int|null $occurrences_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereUpdatedAt($value)
 */
	class Cycle extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $cycle_id
 * @property int $sponsor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cycle $cycle
 * @property-read \App\Models\Sponsor $sponsor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CycleSponsor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CycleSponsor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CycleSponsor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CycleSponsor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CycleSponsor whereCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CycleSponsor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CycleSponsor whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CycleSponsor whereUpdatedAt($value)
 */
	class CycleSponsor extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $event_day_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EventDay $eventDay
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance whereEventDayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAttendance whereUserId($value)
 */
	class EventAttendance extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $event_occurrences_id
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Lecture> $lectures
 * @property-read int|null $lectures_count
 * @property-read \App\Models\EventOccurrence|null $occurrence
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDay query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDay whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDay whereEventOccurrencesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventDay whereUpdatedAt($value)
 */
	class EventDay extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property int $cycle_id
 * @property int $location_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property int $is_voting_enabled
 * @property \App\Enums\EventOccurrenceStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cycle $cycle
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventDay> $days
 * @property-read int|null $days_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExhibitorProfile> $exhibitors
 * @property-read int|null $exhibitors_count
 * @property-read \App\Models\Location $location
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sponsor> $sponsors
 * @property-read int|null $sponsors_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventOccurrence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventOccurrence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventOccurrence query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventOccurrence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventOccurrence whereCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventOccurrence whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventOccurrence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventOccurrence whereIsVotingEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventOccurrence whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventOccurrence whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventOccurrence whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventOccurrence whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventOccurrence whereUpdatedAt($value)
 */
	class EventOccurrence extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $event_occurrences_id
 * @property int $category_id
 * @property \App\Enums\ExhibitorStatus $status
 * @property int $experience_years
 * @property string $portfolio_url
 * @property string $bio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\EventOccurrence $eventOccurrence
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SocialLink> $socialLinks
 * @property-read int|null $social_links_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorApplication whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorApplication whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorApplication whereEventOccurrencesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorApplication whereExperienceYears($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorApplication wherePortfolioUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorApplication whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorApplication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorApplication whereUserId($value)
 */
	class ExhibitorApplication extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $event_occurrences_id
 * @property int $category_id
 * @property int $experience_years
 * @property string $portfolio_url
 * @property string $bio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\EventOccurrence $eventOccurrence
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SocialLink> $socialLinks
 * @property-read int|null $social_links_count
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vote> $votes
 * @property-read int|null $votes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorProfile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorProfile whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorProfile whereEventOccurrencesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorProfile whereExperienceYears($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorProfile wherePortfolioUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExhibitorProfile whereUserId($value)
 */
	class ExhibitorProfile extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $start_date
 * @property string|null $end_date
 * @property \App\Enums\ExperienceStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Experience newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Experience newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Experience query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Experience whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Experience whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Experience whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Experience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Experience whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Experience whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Experience whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Experience whereUpdatedAt($value)
 */
	class Experience extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string $speaker_name
 * @property int $max_seats
 * @property int $event_day_id
 * @property string $date
 * @property \Illuminate\Support\Carbon $start_time
 * @property \Illuminate\Support\Carbon $end_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LectureAttendance> $attendance
 * @property-read int|null $attendance_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read int|null $bookings_count
 * @property-read \App\Models\EventDay $day
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereEventDayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereMaxSeats($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereSpeakerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Lecture whereUpdatedAt($value)
 */
	class Lecture extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $lecture_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Lecture $lecture
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LectureAttendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LectureAttendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LectureAttendance query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LectureAttendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LectureAttendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LectureAttendance whereLectureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LectureAttendance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LectureAttendance whereUserId($value)
 */
	class LectureAttendance extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventOccurrence> $occurrences
 * @property-read int|null $occurrences_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereUpdatedAt($value)
 */
	class Location extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $role
 * @property string $bio
 * @property string|null $portfolio_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SocialLink> $socialLinks
 * @property-read int|null $social_links_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member wherePortfolioUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member whereUpdatedAt($value)
 */
	class Member extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $event_occurrence_id
 * @property int $sponsor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EventOccurrence $occurrence
 * @property-read \App\Models\Sponsor $sponsor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OccurrenceSponsor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OccurrenceSponsor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OccurrenceSponsor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OccurrenceSponsor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OccurrenceSponsor whereEventOccurrenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OccurrenceSponsor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OccurrenceSponsor whereSponsorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OccurrenceSponsor whereUpdatedAt($value)
 */
	class OccurrenceSponsor extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $linkable_type
 * @property int $linkable_id
 * @property string $platform
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $linkable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLink query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLink whereLinkableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLink whereLinkableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLink wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLink whereUrl($value)
 */
	class SocialLink extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $logo_url
 * @property \App\Enums\SponsorType $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cycle> $cycles
 * @property-read int|null $cycles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventOccurrence> $occurrences
 * @property-read int|null $occurrences_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor whereLogoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sponsor whereUpdatedAt($value)
 */
	class Sponsor extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistic query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistic whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Statistic whereValue($value)
 */
	class Statistic extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property \App\Enums\Role $role
 * @property string|null $qr_token
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ExhibitorProfile|null $exhibitorProfile
 * @property-read string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LectureAttendance> $lectureAttendance
 * @property-read int|null $lecture_attendance_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\UserProfile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SocialLink> $socialLinks
 * @property-read int|null $social_links_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vote> $votes
 * @property-read int|null $votes_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereQrToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereUserId($value)
 */
	class UserProfile extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $exhibitor_id
 * @property int $event_occurrence_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EventOccurrence $eventOccurrence
 * @property-read \App\Models\ExhibitorProfile $exhibitor
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote whereEventOccurrenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote whereExhibitorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vote whereUserId($value)
 */
	class Vote extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $image_url
 * @property int $max_seats
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereMaxSeats($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereUpdatedAt($value)
 */
	class Workshop extends \Eloquent {}
}

