<?php

$path = PUB_PATH
    . DIRECTORY_SEPARATOR . 'files'
    . DIRECTORY_SEPARATOR . 'blackboard_data'
    . DIRECTORY_SEPARATOR . 'blackboard_data.json';
if (!file_exists($path)) {
    $data = [
        'person'     => [
            [
                'id'   => 0,
                'name' => 'Horst Schlämmer'
            ]
        ],
        'dance'      => [
            [
                'id'   => 0,
                'name' => 'Salsa'
            ],
            [
                'id'   => 1,
                'name' => 'Kizomba'
            ],
            [
                'id'   => 2,
                'name' => 'Bachata'
            ]
        ],
        'experience' => [
            [
                'id'   => 0,
                'name' => 'Totaler Anfänger'
            ],
            [
                'id'   => 1,
                'name' => 'Anfänger'
            ],
            [
                'id'   => 2,
                'name' => 'Fortgeschritten'
            ],
            [
                'id'   => 3,
                'name' => 'Fast Profi'
            ],
            [
                'id'   => 4,
                'name' => 'Profi'
            ]
        ]
    ];

    file_put_contents($path, json_encode($data));
}