<?php


return [
    'basic_buyer' => [
        'common' => [
            'percentage' => 10,  // 10% fee
            'min' => 10,       // Minimum fee
            'max' => 50       // Maximum fee
        ],
        'luxury' => [
            'percentage' => 10,  // 10% fee
            'min' => 25,       // Minimum fee
            'max' => 200       // Maximum fee
        ]
    ],

    'seller_special' => [
        'common' => 2.0,
        'luxury' => 4.0
    ],

    'association' => [
        'thresholds' => [
            [
                'max' => 500,
                'fee' => 5
            ],
            [
                'max' => 1000,
                'fee' => 10
            ],
            [
                'max' => 3000,
                'fee' => 15
            ],
            [
                'max' => null,
                'fee' => 20
            ]
        ]
    ],

    'storage' => 100.0  // Fixed storage fee
];