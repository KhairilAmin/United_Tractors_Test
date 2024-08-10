<?php

    namespace App\Helpers;

    class Storage
    {
        public static function uploadImage($fileImage)
        {
            $ext = $fileImage->getClientOriginalExtension();
            $nameImage = Uuid::createNameForImage($ext);
            $fileImage->move(base_path('public/storage/images/'),$nameImage);

            return $nameImage;
        }
        
        public static function getImage($nameImage)
        {
            return url('/storage/images/'.$nameImage);
        }
    }
