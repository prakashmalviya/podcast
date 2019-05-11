<?php
    namespace App\Providers;

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\Schema;
    use Image;
    use Intervention\Image\ImageManagerStatic;

    class AppServiceProvider extends ServiceProvider
    {
        /**
         * Register any application services.
         * @return void
         */
        public function register()
        {
            //
        }

        /**
         * Bootstrap any application services.
         * @return void
         */
        public function boot()
        {
            Schema::defaultStringLength(191);
            \Validator::extend('base64_image', function ($attribute, $value, $parameters, $validator) {
                try {
                    if ($value != '') {
                        ImageManagerStatic::make($value);
                        return true;
                    } else {
                        return true;
                    }
                } catch (\Exception $e) {
                    return false;
                }
            });
            \Validator::extend('unique_comment', function ($attribute, $value, $parameters, $validator) {
                try {
                    if ($value != '') {

                        return true;
                    } else {
                        return true;
                    }
                } catch (\Exception $e) {
                    return false;
                }
            });
        }
    }
