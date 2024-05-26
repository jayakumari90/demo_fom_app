<?php

use App\Models\Role;
use Intervention\Image\ImageManagerStatic as Image;
// use Mail;4


    function startQueryLog()
    {
        \DB::enableQueryLog();
    }

    if (!function_exists('getRoles')) {
        function getRoles()
        {
            return Role::get();
        }
    }
    