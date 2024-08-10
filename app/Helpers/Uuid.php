<?php

    namespace App\Helpers;

    use Ramsey\Uuid\Uuid as UuidLib;
    class Uuid
    {
        public static function getId()
        {
            return UuidLib::uuid4()->toString();
        }
        
        public static function createNameForImage($ext)
        {
            return UuidLib::uuid6()->toString() . "." . $ext;
        }
    }

