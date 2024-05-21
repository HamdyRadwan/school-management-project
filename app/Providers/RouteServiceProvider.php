<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    protected $namespace = 'App\Http\Controllers';

    public const HOME = '/dashboard';
    public const STUDENT = '/student/dashboard';
    public const TEACHER = '/teacher/dashboard';
    public const PARENT = '/parent/dashboard';


    public function boot()
    {
        //

        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }


    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/student.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/teacher.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/ajax.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/parent.php'));
    }


    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}


//////////////////////////////////default////////////////////////////////////


// namespace App\Providers;

// use Illuminate\Cache\RateLimiting\Limit;
// use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\RateLimiter;
// use Illuminate\Support\Facades\Route;

// class RouteServiceProvider extends ServiceProvider
// {

//     public const HOME = '/dashboard';
//     public const STUDENT = '/student/dashboard';
//     public const TEACHER = '/dashboard';
//     public const PARENT = '/dashboard';

//     public function boot(): void
//     {
//         $this->configureRateLimiting();

//         $this->routes(function () {
//             Route::middleware('api')
//                 ->prefix('api')
//                 ->group(base_path('routes/api.php'));

//             Route::middleware('web')
//                 ->group(base_path('routes/web.php'));
// ///
//             Route::middleware('web')
//                 ->group(base_path('routes/student.php'));
//         });
//     }


//     protected function configureRateLimiting(): void
//     {
//         RateLimiter::for('api', function (Request $request) {
//             return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
//         });
//     }
// }
