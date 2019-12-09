<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Faker', function($app) {
            $faker = \Faker\Factory::create();
            $newClass = new class($faker) extends \Faker\Provider\Base {
                public function getFakeImage($path, $w, $h, $cat = null, $fullPath = false)
                {
                    sleep(1);
                    $image = $this->faker->image($path, $w, $h, $cat, $fullPath);
                    if(!$image) {
                        $image = $this->getFakeImage($path, $w, $h, $cat, $fullPath);
                    }
                    return $image;
                }
            };

            $faker->addProvider($newClass);
            return $faker;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
