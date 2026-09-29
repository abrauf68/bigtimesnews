<?php

namespace App\Providers;

use App\Contracts\Social\CaptionGeneratorContract;
use App\Models\Post;
use App\Observers\PostObserver;
use App\Rules\MaxUploadSize;
use App\Support\Social\ClaudeCaptionGenerator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CaptionGeneratorContract::class, ClaudeCaptionGenerator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('max_size', function ($attribute, $value, $parameters, $validator) {
            $rule = new MaxUploadSize();
            $fail = function ($message) use ($validator, $attribute) {
                $validator->errors()->add($attribute, $message);
            };
            $rule->validate($attribute, $value, $fail);
            return !$validator->errors()->has($attribute);
        });

        Post::observe(PostObserver::class);
    }
}
