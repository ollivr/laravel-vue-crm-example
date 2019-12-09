<?php

namespace App\Factories;

use Faker\Generator;

class CustomFakerGenerator extends Generator
{
    public function getFakeImage($path, $w, $h, $cat = null, $fullPath = false)
    {
        sleep(1);

        $image = $this->faker->image($path, $w, $h, $cat, $fullPath);

        if(!$image) {
            $image = $this->getFakeImage($path, $w, $h, $cat, $fullPath);
        }

        return $image;
    }
}