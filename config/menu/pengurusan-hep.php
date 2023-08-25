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
            'route' => 'pengurusan.hep.pusat-islam.*',
            'children' => [
                [
                    'title' => 'Aktiviti',
                    'route' => 'pengurusan.hep.pusat-islam.aktiviti.index',
                    'parameters' => [],
                ],
                [
                    'title' => 'Jadual Tugasan',
                    'route' => 'pengurusan.hep.pusat-islam.jadual-tugasan.index',
                    'parameters' => [],
                ],
                [
                    'title' => 'Orang Awam',
                    'route' => 'pengurusan.hep.pusat-islam.orang-awam.index',
                    'parameters' => [],
                ],
                [
                    'title' => 'Rekod Kehadiran',
                    'route' => 'pengurusan.hep.pusat-islam.rekod-kehadiran.index',
                    'parameters' => [],
                ],
                [
                    'title' => 'Surat Rasmi',
                    'route' => 'pengurusan.hep.pusat-islam.surat-rasmi.index',
                    'parameters' => [],
                ],
            ],
        ],
        [
            'title' => 'Kaunseling',
            'route' => 'kaunseling*',
            'children' => [
                [
                    'title' => 'Senarai',
                    'route' => 'pengurusan.hep.kaunseling.index',
                    'parameters' => [],
                ],
                [
                    'title' => 'Rekod Kaunseling',
                    'route' => 'pengurusan.hep.rekod-kaunseling.index',
                    'parameters' => [],
                ],
                [
                    'title' => 'Laporan',
                    'route' => 'pengurusan.hep.laporan-kaunseling.index',
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
                    'title' => 'Pusat Islam',
                    'route' => 'pengurusan.hep.tetapan.lookup.index',
                    'parameters' => [
                        'category' => Lookup::CATEGORY_PUSAT_ISLAM,
                    ],
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
