<?php
    return [
        'podcast'              => [
            'img_dir'          => '/podcast/',
            'img_dir_original' => public_path() . '/podcast/',
        ],
        /*
      |--------------------------------------------------------------------------
      | Cache Config
      |--------------------------------------------------------------------------
       * Cache in Minutes.
       *
       *
      */
        'default_cache_time'   => '60',
        // Default Cache Time min.
        'one_day_cache_time'   => '1440',
        // one day Cache Time min. => 1 Day
        'medium_cache_time'    => '10080',
        // Long Term Cache Time min => 1 Week.
        'long_cache_time'      => '43800',
        // Long Term Cache Time min => 1 Month.
        'very_long_cache_time' => '525599',
        // Long Term Cache Time min => 1 Year.
    ];
