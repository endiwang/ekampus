<?php

use App\Models\Lookup;

return [
    'sidebar' => [
        [
            'title' => 'Pengurusan Aset',
            'route' => 'pengurusan.hep.pengurusan_aset.*',
            'children' => [
                [
                    'title' => 'Maklumat Blok',
                    'route' => 'pengurusan.kolej_kediaman.pengurusan_blok.index',
                ],
                [
                    'title' => 'Maklumat Bilik',
                    'route' => 'pengurusan.kolej_kediaman.pengurusan_bilik.index',
                ]
            ],
        ],
        [
            'title' => 'Permohonan',
            'route' => 'pengurusan.hep.permohonan.*',
            'children' => [
                [
                    'title' => 'Kemasukan',
                    'route' => 'pengurusan.hep.permohonan.keluar_masuk.index',
                ],
                [
                    'title' => 'Mendapatkan Rawatan',
                    'route' => 'pengurusan.hep.permohonan.bawa_barang.index',
                ],
                [
                    'title' => 'Bantuan Kebajikan',
                    'route' => 'pengurusan.hep.permohonan.bawa_kenderaan.index',
                ],
                [
                    'title' => 'Penggunaan Kemudahan',
                    'route' => 'pengurusan.hep.permohonan.bawa_kenderaan.index',
                ],
                [
                    'title' => 'Penginapan Sementara',
                    'route' => 'pengurusan.hep.permohonan.bawa_kenderaan.index',
                ],
            ],
        ],

    ],
];
