<?php

use App\Models\Lookup;

return [
    'sidebar' => [
        [
            'title' => 'Pengurusan',
            'route' => 'pengurusan.hep.pengurusan.*',
            'children' => [
                [
                    'title' => 'Salah Laku Pelajar',
                    'route' => 'pengurusan.hep.pengurusan.salahlaku_pelajar.index',
                    'parameters' => [],
                ],
            ],
        ],
        [
            'title' => 'Permohonan',
            'route' => 'pengurusan.hep.permohonan.*',
            'children' => [
                [
                    'title' => 'Keluar Masuk',
                    'route' => 'pengurusan.hep.permohonan.keluar_masuk.index',
                ],
            ],
        ],
        [
            'title' => 'Pusat Islam',
            'route' => 'pengurusan.hep.pusat-islam.dashboard.*',
            'children' => [
                [
                    'title' => 'Senarai',
                    'route' => 'pengurusan.hep.pusat-islam.dashboard.index',
                    'parameters' => [],
                ],
            ],
        ],
        [
            'title' => 'Kaunseling',
            'route' => 'pengurusan.hep.kaunseling.dashboard.*',
            'children' => [
                [
                    'title' => 'Senarai',
                    'route' => 'pengurusan.hep.kaunseling.dashboard.index',
                    'parameters' => [],
                ],
            ],
        ],
        [
            'title' => 'Tetapan',
            'route' => 'pengurusan.hep.tetapan.*',
            'children' => [
                [
                    'title' => 'Keluar Masuk',
                    'route' => 'pengurusan.hep.tetapan.keluar_masuk.index',
                    'parameters' => [],
                ],
                [
                    'title' => 'Kaunseling',
                    'route' => 'pengurusan.hep.tetapan.lookup.index',
                    'parameters' => [
                        'category' => Lookup::CATEGORY_KAUNSELING,
                    ]
                ],
            ],
        ],

    ],
];
