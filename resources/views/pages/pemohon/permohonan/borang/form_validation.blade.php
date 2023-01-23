var step = [
    FormValidation.formValidation(
    form,
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
                        notEmpty: { message: "Sila isi nama jawi anda, ikut arahan di atas." },
                    },
                },
            },

            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: 'is-invalid',
                    eleValidClass: ''
                })
            }
        }
    ),
]
