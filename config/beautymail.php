<?php

return [

    // These CSS rules will be applied after the regular template CSS

    /*
        'css' => [
            '.button-content .button { background: red }',
        ],
    */

    'colors' => [

        'highlight' => '#004ca3',
        'button'    => '#004cad',

    ],

    'view' => [
        'senderName'  => null,
        'reminder'    => null,
        'unsubscribe' => null,
        'address'     => null,

        'logo'        => [
            'path'   => public_path('img/logo.jpg'),
            'width'  => '40',
            'height' => '40',
        ],

        'twitter'  => null,
        'facebook' => null,
        'flickr'   => null,
    ],

];
