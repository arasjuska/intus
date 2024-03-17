<?php

return [
    'api_key' => env('GOOGLE_SAFE_BROWSING_API_KEY'),
    'api_domain' => env('GOOGLE_SAFE_BROWSING_API_DOMAIN'),
    'threat_types' => [
        'THREAT_TYPE_UNSPECIFIED',
        'MALWARE',
        'SOCIAL_ENGINEERING',
        'UNWANTED_SOFTWARE',
        'POTENTIALLY_HARMFUL_APPLICATION',
    ],

    'threat_platforms' => [
        'ANY_PLATFORM',
    ],

    'client_id' => 'aras-google-safe-browsing',
    'client_version' => '1.0.0',
];
