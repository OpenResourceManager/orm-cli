<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Makes sure that the ORM Home exists
        if (!file_exists(ORM_HOME)) {
            mkdir(ORM_HOME, 0740, true);
        }

        // Makes the ORM SQLite file if it does not exist
        if (!file_exists(ORM_DB_PATH)) {
            touch(ORM_DB_PATH);
            chmod(ORM_DB_PATH, 0640);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
