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
                ],
                [
                    'title' => 'Disiplin Pelajar',
                    'route' => 'pengurusan.hep.pengurusan.disiplin_pelajar.index',
                ],
                [
                    'title' => 'Tatatertib Pelajar',
                    'route' => 'pengurusan.hep.pengurusan.tatatertib_pelajar.index',
                ],
                [
                    'title' => 'Keluar Masuk',
                    'route' => 'pengurusan.hep.pengurusan.keluar_masuk.index',
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
                [
                    'title' => 'Bawa Barang',
                    'route' => 'pengurusan.hep.permohonan.bawa_barang.index',
                ],
                [
                    'title' => 'Bawa Kenderaan',
                    'route' => 'pengurusan.hep.permohonan.bawa_kenderaan.index',
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
                    'route' => 'pengurusan.hep.kaunseling.index',
                    'parameters' => [],
                ],
                [
                    'title' => 'Rekod Kaunseling',
                    'route' => 'pengurusan.hep.kaunseling.rekod-kaunseling.index',
                    'parameters' => [],
                ],
                [
                    'title' => 'Laporan',
                    'route' => 'pengurusan.hep.kaunseling.laporan-kaunseling.index',
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
                    ],
                ],
            ],
        ],

    ],
];
