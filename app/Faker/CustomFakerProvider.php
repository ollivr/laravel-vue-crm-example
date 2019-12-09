<?php

namespace App\Faker;

use Faker\Provider\Image;
use Illuminate\Support\Facades\Storage;
use File;

class CustomFakerProvider extends Image
{
    public function getFakeImage($path, $w, $h, $cat = null, $fullPath = false)
    {
        sleep(1);
        $fileName = $this->image($path, $w, $h, $cat, false);
        if(!$fileName) {
            $fileName = $this->getFakeImage($path, $w, $h, $cat, false);
        }

        if($this->getImageSize($path, $fileName) === 0) {
            File::delete($path . DIRECTORY_SEPARATOR . $fileName);
            $this->getFakeImage($path, $w, $h, $cat, false);
        }

        return $fileName;
    }

    public function getImageSize($path, $fileName)
    {
        return File::size($path . DIRECTORY_SEPARATOR . $fileName);
    }
}