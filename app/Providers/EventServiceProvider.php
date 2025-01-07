<?php

namespace App\Providers;

use App\Listeners\UpdateLoginTimestamp;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use RateLimiter;
use Request;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // Authenticated::class => [
        //     UpdateLoginTimestamp::class,
        // ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
//     protected function configureRateLimiting()
// {
//     RateLimiter::for('custom_throttle', function (Request $request) {
//         return Limit::perMinutes(1, 6) // Giới hạn 6 lần mỗi phút (tương đương 10 giây một lần)
//             ->by($request->user()?->id ?: $request->ip())
//             ->response(function () {
//                 return response()->json([
//                     'message' => 'Bạn phải đợi 10 giây trước khi thử lại.'
//                 ], 429);
//             });
//     });
// }
}
