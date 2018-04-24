<?php

$path = PUB_PATH
    . DIRECTORY_SEPARATOR . 'files'
    . DIRECTORY_SEPARATOR . 'blackboard_data'
    . DIRECTORY_SEPARATOR . 'blackboard_data.json';
if (!file_exists($path)) {
    $data = [
        'person'     => [
            [
                'id'   => 1,
                'name' => 'Horst Schlämmer'
            ]
        ],
        'dance'      => [
            [
                'id'   => 1,
                'name' => 'Salsa'
            ],
            [
                'id'   => 2,
                'name' => 'Kizomba'
            ],
            [
                'id'   => 3,
                'name' => 'Bachata'
            ]
        ],
        'experience' => [
            [
                'id'   => 1,
                'name' => 'Totaler Anfänger'
            ],
            [
                'id'   => 2,
                'name' => 'Anfänger'
            ],
            [
                'id'   => 3,
                'name' => 'Fortgeschritten'
            ],
            [
                'id'   => 4,
                'name' => 'Fast Profi'
            ],
            [
                'id'   => 5,
                'name' => 'Profi'
            ]
        ]
    ];

    file_put_contents($path, json_encode($data));
}