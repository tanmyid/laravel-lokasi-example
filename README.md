<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Contoh Alamat by API

### Send value as name

```sh
<script>
    $(document).ready(function() {
        $('#provinsi').select2({
            placeholder: 'Pilih Provinsi',
            allowClear: true
        });
        $('#kabupaten').select2({
            placeholder: 'Pilih Kabupaten',
            allowClear: true
        });
        $('#kecamatan').select2({
            placeholder: 'Pilih Kecamatan',
            allowClear: true
        });
        $('#desa').select2({
            placeholder: 'Pilih Desa',
            allowClear: true
        });
    });

    // Send value as name
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch API Data
        fetch(`https://blog.tan.my.id/api-wilayah-indonesia/api/provinces.json`)
            .then(response => response.json())
            .then(provinces => {
                const provinsi = document.getElementsByName('provinsi')[0];
                provinsi.innerHTML = '<option></option>';
                for (const province of provinces) {
                    provinsi.innerHTML += `<option value="${province.name}" data-id="${province.id}">${province.name}</option>`;
                }
            });

        $(document).on('change', '[name="provinsi"]', function() {
            const selectedOption = $(this).find('option:selected');
            const provinsiId = selectedOption.data('id');
            const kabupaten = document.getElementsByName('kabupaten')[0];
            kabupaten.innerHTML = '<option></option>';

            fetch(`https://blog.tan.my.id/api-wilayah-indonesia/api/regencies/${provinsiId}.json`)
                .then(response => response.json())
                .then(regencies => {
                    for (const regency of regencies) {
                        kabupaten.innerHTML += `<option value="${regency.name}" data-id="${regency.id}">${regency.name}</option>`;
                    }
                });

            document.getElementsByName('kecamatan')[0].innerHTML = '<option></option>';
            document.getElementsByName('desa')[0].innerHTML = '<option></option>';
        });

        $(document).on('change', '[name="kabupaten"]', function() {
            const selectedOption = $(this).find('option:selected');
            const kabupatenId = selectedOption.data('id');
            const kecamatan = document.getElementsByName('kecamatan')[0];
            kecamatan.innerHTML = '<option></option>';

            fetch(`https://blog.tan.my.id/api-wilayah-indonesia/api/districts/${kabupatenId}.json`)
                .then(response => response.json())
                .then(districts => {
                    for (const district of districts) {
                        kecamatan.innerHTML += `<option value="${district.name}" data-id="${district.id}">${district.name}</option>`;
                    }
                });

            document.getElementsByName('desa')[0].innerHTML = '<option></option>';
        });

        $(document).on('change', '[name="kecamatan"]', function() {
            const selectedOption = $(this).find('option:selected');
            const kecamatanId = selectedOption.data('id');
            const desa = document.getElementsByName('desa')[0];
            desa.innerHTML = '<option></option>';

            fetch(`https://blog.tan.my.id/api-wilayah-indonesia/api/villages/${kecamatanId}.json`)
                .then(response => response.json())
                .then(villages => {
                    for (const village of villages) {
                        desa.innerHTML += `<option value="${village.name}" data-id="${village.id}">${village.name}</option>`;
                    }
                });
        });
    });
</script>
```

[https://blog.tan.my.id/api-wilayah-indonesia/][https://blog.tan.my.id/api-wilayah-indonesia/]
