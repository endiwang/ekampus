<?php

use App\Models\Lookup;

return [
    'sidebar' => [
        [
            'title' => 'Pengurusan Aset',
            'route' => 'pengurusan.kolej_kediaman.pengurusan_aset.*',
            'children' => [
                [
                    'title' => 'Maklumat Blok',
                    'route' => 'pengurusan.kolej_kediaman.pengurusan_aset.pengurusan_blok.index',
                ],
                [
                    'title' => 'Maklumat Bilik',
                    'route' => 'pengurusan.kolej_kediaman.pengurusan_aset.pengurusan_bilik.index',
                ]
            ],
        ],
        [
            'title' => 'Permohonan',
            'route' => 'pengurusan.kolej_kediaman.permohonan.*',
            'children' => [
                [
                    'title' => 'Kemasukan',
                    'route' => 'home',
                ],
                [
                    'title' => 'Mendapatkan Rawatan',
                    'route' => 'pengurusan.kolej_kediaman.permohonan.mendapatkan_rawatan.index',
                ],
                [
                    'title' => 'Bantuan Kebajikan',
                    'route' => 'pengurusan.kolej_kediaman.permohonan.bantuan_kebajikan.index',
                ],
                [
                    'title' => 'Penggunaan Kemudahan',
                    'route' => 'pengurusan.kolej_kediaman.permohonan.penggunaan_kemudahan.index',
                ],
                [
                    'title' => 'Penginapan Sementara',
                    'route' => 'pengurusan.kolej_kediaman.permohonan.penginapan_sementara.index',
                ],
            ],
        ],

    ],
];
