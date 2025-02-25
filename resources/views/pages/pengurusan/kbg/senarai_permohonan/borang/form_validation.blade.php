var step = [
    bahagianA = FormValidation.formValidation(
    formBahagianA,
        {
            fields: {
                'nama_pemohon': {
                    validators: {
                        notEmpty: {
                            message: 'Sila isi nama penuh anda.'
                        }
                    }
                },
                nama_jawi: {
                    validators: {
                        notEmpty: { message: "Sila isi nama jawi anda, ikut arahan di atas." },
                    },
                },
                no_kp: {
                    validators: {
                        notEmpty: { message: "Sila isi no kad pengenalan atau no pasport anda." },
                    },
                },
                tarikh_lahir: {
                    validators: {
                        notEmpty: { message: "Sila isi tarikh lahir anda." },
                    },
                },
                alamat_emel: {
                    validators: {
                        notEmpty: { message: "Sila isi alamat emel anda." },
                    },
                },
                alamat_tetap: {
                    validators: {
                        notEmpty: { message: "Sila isi alamat tetap anda." },
                    },
                },
                alamat_rumah: {
                    validators: {
                        notEmpty: { message: "Sila isi alamat surat-menyurat anda." },
                    },
                },
                poskod: {
                    validators: {
                        notEmpty: { message: "Sila isi poskod anda." },
                    },
                },
                no_telefon: {
                    validators: {
                        notEmpty: { message: "Sila isi nombor telefon anda." },
                    },
                },
                jantina: {
                    validators: {
                        notEmpty: { message: "Sila pilih jantina." },
                    },
                },
                negeri_kelahiran: {
                    validators: {
                        notEmpty: { message: "Sila pilih negeri kelahiran anda." },
                    },
                },
                keturunan: {
                    validators: {
                        notEmpty: { message: "Sila pilih negeri keturunan anda." },
                    },
                },
                bumiputra: {
                    validators: {
                        notEmpty: { message: "Sila pilih jenis bumiputra anda." },
                    },
                },
                mualaf: {
                    validators: {
                        notEmpty: { message: "Sila pilih ya jika anda mualaf dan tidak jika sebaliknya." },
                    },
                },
                kewarganegaraan: {
                    validators: {
                        notEmpty: { message: "Sila pilih status kewarganegaraan anda." },
                    },
                },
                kedaaan_fizikal: {
                    validators: {
                        notEmpty: { message: "Sila pilih kedaaan fizikal anda." },
                    },
                },
                penyakit_kronik: {
                    validators: {
                        notEmpty: { message: "Sila pilih penyakit kronik jika berkenaan dan pilih tiada jika sebaliknya." },
                    },
                },
                rekod_kemasukan_wad: {
                    validators: {
                        notEmpty: { message: "Sila pilih rekod kemasukan wad jika berkenaan dan pilih tiada jika sebaliknya." },
                    },
                },

            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''

                })
            }
        }
    ),
    bahagianB = FormValidation.formValidation(
    formBahagianB,
        {
            fields: {
                'pusat_temuduga': {
                    validators: {
                        notEmpty: {
                            message: 'Sila pilih tempat temuduga.'
                        }
                    }
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        }
    ),
    bahagianC = FormValidation.formValidation(
    formBahagianC,
        {
            fields: {
                'status_bapa': {
                    validators: {
                        notEmpty: {
                            message: 'Sila pilih status bapa.'
                        }
                    }
                },
                'nama_bapa': {
                    validators: {
                        notEmpty: {
                            message: 'Sila masukkan nama bapa.'
                        }
                    }
                },
                'ic_no_bapa': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan no kad pengenalan bapa.'
                        }
                    }
                },
                'alamat_bapa': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan alamat bapa.'
                        }
                    }
                },
                'poskod_bapa': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan poskod bapa.'
                        }
                    }
                },
                'no_telefon_bapa': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan no telefon bapa.'
                        }
                    }
                },
                'status_pekerjaan_bapa': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila pilih status pekerjaan bapa.'
                        }
                    }
                },
                'jenis_pekerjaan_bapa': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila pilih jenis pekerjaan bapa.'
                        }
                    }
                },
                'pendapatan_bapa': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan pendapatan bapa.'
                        }
                    }
                },
                'status_ibu': {
                    validators: {
                        notEmpty: {
                            message: 'Sila pilih status ibu.'
                        }
                    }
                },
                'nama_ibu': {
                    validators: {
                        notEmpty: {
                            message: 'Sila masukkan nama ibu.'
                        }
                    }
                },
                'ic_no_ibu': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan no kad pengenalan ibu.'
                        }
                    }
                },
                'alamat_ibu': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan alamat ibu.'
                        }
                    }
                },
                'poskod_ibu': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan poskod ibu.'
                        }
                    }
                },
                'no_telefon_ibu': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan no telefon ibu.'
                        }
                    }
                },
                'status_pekerjaan_ibu': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila pilih status pekerjaan ibu.'
                        }
                    }
                },
                'jenis_pekerjaan_ibu': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila pilih jenis pekerjaan ibu.'
                        }
                    }
                },
                'pendapatan_ibu': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan pendapatan ibu.'
                        }
                    }
                },
                'pemohon_tinggal_bersama': {
                    validators: {
                        notEmpty: {
                            message: 'Sila pilih pemohon tinggal bersama siapa.'
                        }
                    }
                },
                'nama_penjaga': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan nama penajaga.'
                        }
                    }
                },
                'ic_no_penjaga': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan no kad pengenalan penjaga.'
                        }
                    }
                },
                'alamat_penjaga': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan alamat penjaga.'
                        }
                    }
                },
                'poskod_penjaga': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan poskod penjaga.'
                        }
                    }
                },
                'no_telefon_penjaga': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan no telefon penjaga.'
                        }
                    }
                },
                'status_pekerjaan_penjaga': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila pilih status pekerjaan penjaga.'
                        }
                    }
                },
                'jenis_pekerjaan_penjaga': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila pilih jenis pekerjaan penjaga.'
                        }
                    }
                },
                'pendapatan_penjaga': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila masukkan pendapatan penjaga.'
                        }
                    }
                },
                'pertalian_penjaga': {
                    validators: {
                        notEmpty: {
                            enabled: false,
                            message: 'Sila pilih pertalian dengan penjaga.'
                        }
                    }
                },

            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        }
    ),
    bahagianD = FormValidation.formValidation(
        formBahagianD,
            {
                fields: {
                    'tahun_peperiksaan': {
                        validators: {
                            notEmpty: {
                                message: 'Sila pilih tahun peperiksaan.'
                            }
                        }
                    },
                    'jenis_peperiksaan': {
                        validators: {
                            notEmpty: {
                                message: 'Sila pilih jenis peperiksaan.'
                            }
                        }
                    },
                    'subjek[0].nama': {
                        validators: {
                            notEmpty: {
                                message: 'Sila masukkan nama subjek.'
                            }
                        }
                    },
                    'subjek[0].gred': {
                        validators: {
                            notEmpty: {
                                message: 'Sila masukkan gred subjek.'
                            }
                        }
                    },
                    @foreach ($subjek_spm as $subjek)
                    '{!! $subjek->slug !!}': {
                        validators: {
                            notEmpty: {
                                enabled: false,
                                message: 'Sila pilih.'
                            }
                        }
                    },
                    @endforeach
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        ),
]
