<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use App\Models\Category;
use App\Models\Post;
use App\Models\Color;
use App\Models\Size;
use App\Models\Brand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $post_hot = Post::where('post_hot',1)->where('status',1)->orderBy('date_create', 'desc')->paginate(5);

        View::share([
            'post_hot'=>$post_hot,
        ]);
    }
}