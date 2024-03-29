<?php

/**
 * This file is part of the GeocoderLaravel library.
 *
 * (c) Antoine Corcy <contact@sbin.dk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Ivory\HttpAdapter\CurlHttpAdapter;
use Ivory\HttpAdapter\Guzzle6HttpAdapter;
use Geocoder\Provider\Chain;
use Geocoder\Provider\BingMaps;
use Geocoder\Provider\FreeGeoIp;
use Geocoder\Provider\GoogleMaps;
use Geocoder\Provider\MaxMindBinary;

return [
    'cache-duraction' => 999999999,
    'providers' => [
        Chain::class => [
            GoogleMaps::class => [
                'en',
                'us',
                true,
                env('AIzaSyA_rvJMk-ltWyRfMv1YTZf8Deng-xUoPCs'),
            ],
            FreeGeoIp::class  => [],
        ],
        BingMaps::class => [
            'en-US',
            env('BING_MAPS_API_KEY'),
        ],
        GoogleMaps::class => [
            'en',
            'us',
            true,
            env('AIzaSyA_rvJMk-ltWyRfMv1YTZf8Deng-xUoPCs'),
        ],
    ],
    'adapter'  => CurlHttpAdapter::class,
];
