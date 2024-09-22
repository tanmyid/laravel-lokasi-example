<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API Lokasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                API Lokasi
            </div>
            <div class="card-body">
                <form action="{{ route('lokasi-store') }}" method="POST">
                    @csrf

                    <!-- Pilih Nasional/Internasional -->
                    <div class="form-group">
                        <label class="form-label" for="lokasi_type">Tipe Lokasi</label>
                        <select id="lokasi_type" name="lokasi_type" class="form-control select2">
                            <option value=""></option>
                            <option value="nasional">Nasional</option>
                            <option value="internasional">Internasional</option>
                        </select>
                    </div>

                    <!-- Input untuk Internasional -->
                    <div class="form-group internasional-field" style="display:none;">
                        <label class="form-label" for="negara">Negara</label>
                        <input type="text" id="negara" name="negara" class="form-control" placeholder="Masukkan Negara">
                    </div>

                    <!-- Opsi untuk Nasional -->
                    <div class="nasional-field" style="display:none;">
                        <div class="form-group">
                            <label class="form-label" for="provinsi">Provinsi</label>
                            <select id="provinsi" name="provinsi" class="form-control select2">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="kabupaten">Kabupaten</label>
                            <select id="kabupaten" name="kabupaten" class="form-control select2">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="kecamatan">Kecamatan</label>
                            <select id="kecamatan" name="kecamatan" class="form-control select2">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="desa">Desa</label>
                            <select id="desa" name="desa" class="form-control select2">
                                <option></option>
                            </select>
                        </div>
                    </div>

                    <!-- Input Jalan untuk keduanya -->
                    <div class="form-group">
                        <label for="jalan" class="form-label">Jalan / Alamat Lengkap</label>
                        <input type="text" id="jalan" name="jalan" class="form-control" placeholder="Jalan">
                    </div>

                    <button type="submit" class="btn btn-block btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- Javascript --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle visibility based on "Tipe Lokasi" selection
        document.getElementById('lokasi_type').addEventListener('change', function() {
            const tipe = this.value;
            const nasionalField = document.querySelector('.nasional-field');
            const internasionalField = document.querySelector('.internasional-field');

            if (tipe === 'nasional') {
                nasionalField.style.display = 'block';
                internasionalField.style.display = 'none';
            } else if (tipe === 'internasional') {
                nasionalField.style.display = 'none';
                internasionalField.style.display = 'block';
            } else {
                nasionalField.style.display = 'none';
                internasionalField.style.display = 'none';
            }
        });

        // Fetch Provinsi, Kabupaten, Kecamatan, Desa logic remains here
        // Misalnya gunakan fetch untuk mengambil data wilayah nasional
        // Sesuai dengan contoh yang telah Anda buat sebelumnya
    });
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

{{-- Send Value as ID --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch Provinces
        fetch(`https://blog.tan.my.id/api-wilayah-indonesia/api/provinces.json`)
            .then(response => response.json())
            .then(provinces => {
                const provinsi = document.getElementById('provinsi');
                provinsi.innerHTML = '<option></option>';
                for (const province of provinces) {
                    provinsi.innerHTML += `<option value="${province.id}">${province.name}</option>`;
                }
            });

        // On Change Provinsi
        $(document).on('change', '#provinsi', function() {
            const provinsi = $(this).val();
            const kabupaten = document.getElementById('kabupaten');
            kabupaten.innerHTML = '<option></option>'; // Default option
            fetch(`https://blog.tan.my.id/api-wilayah-indonesia/api/regencies/${provinsi}.json`)
                .then(response => response.json())
                .then(regencies => {
                    for (const regency of regencies) {
                        kabupaten.innerHTML += `<option value="${regency.id}">${regency.name}</option>`;
                    }
                });

            // Reset kecamatan and desa on provinsi change
            document.getElementById('kecamatan').innerHTML = '<option></option>';
            document.getElementById('desa').innerHTML = '<option></option>';
        });

        // On Change Kabupaten
        $(document).on('change', '#kabupaten', function() {
            const kabupaten = $(this).val();
            const kecamatan = document.getElementById('kecamatan');
            kecamatan.innerHTML = '<option></option>'; // Default option
            fetch(`https://blog.tan.my.id/api-wilayah-indonesia/api/districts/${kabupaten}.json`)
                .then(response => response.json())
                .then(districts => {
                    for (const district of districts) {
                        kecamatan.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                    }
                });

            // Reset desa on kabupaten change
            document.getElementById('desa').innerHTML = '<option></option>';
        });

        // On Change Kecamatan
        $(document).on('change', '#kecamatan', function() {
            const kecamatan = $(this).val();
            const desa = document.getElementById('desa');
            desa.innerHTML = '<option></option>'; // Default option
            fetch(`https://blog.tan.my.id/api-wilayah-indonesia/api/villages/${kecamatan}.json`)
                .then(response => response.json())
                .then(villages => {
                    for (const village of villages) {
                        desa.innerHTML += `<option value="${village.id}">${village.name}</option>`;
                    }
                });
        });
    });
</script> --}}


</html>
