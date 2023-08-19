<?php

return [
    'sidebar' => [
        [
            'title' => 'Pengurusan',
            'route' => 'pengurusan.hep.pengurusan.*',
            'children' => [
                [
                    'title' => 'Salah Laku Pelajar',
                    'route' => 'pengurusan.hep.pengurusan.salahlaku_pelajar.index',
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
                ],
            ],
        ],

    ],
];
