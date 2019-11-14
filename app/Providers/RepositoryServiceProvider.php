<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Auto link repository to interface by model name
        $pattern = '/(\.php)|(\.)|(BaseModel\.php)/';
        $path = app_path() . "/Models";
        $path_array = scandir($path);
        array_push($path_array, 'User');

        if(isset($path_array)) {
            foreach ($path_array as $value) {
                $value = preg_replace($pattern, '', $value);
                if(!empty($value)) {
                    $this->app->bind('App\Repositories\\' . $value .'\\' . $value .'Interface',
                      'App\Repositories\\' . $value .'\\' . $value .'Repository'
                    );
                }
            }
        }
    }
}
