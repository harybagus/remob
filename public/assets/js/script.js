/**
 * Menangkap elemen html yang dibutuhkan.
 */
const imageLabel = document.querySelector('#img-label');
const colImagePreview = document.querySelector('#col-img-preview');
const imagePreview = document.querySelector('.img-preview');
const image = document.querySelector('#image');

// Cek apakah user(admin/penyewa) sudah meng-upload gambar.
if (image != null) {
    // Jika iya, beri kondisi jika gambar di-upload maka jalankan function berikut.
    image.addEventListener('change', function () {
        // Mengambil file gambar yang diinputkan.
        const [file] = image.files;
        // Menampilkan gambar yang diinputkan.
        imagePreview.src = URL.createObjectURL(file);

        // Cek apakah ada col image preview dan iamge label.
        if (colImagePreview && imageLabel) {
            /**
             * Jika iya,
             * Hapus class d-none pada col image preview.
             * Tambahkan class d-none pada iamge label.
             */
            colImagePreview.classList.remove('d-none');
            imageLabel.classList.add('d-none')
        }

        /**
         * Menampilkan nama file gambar pada kolom input file.
         */
        var fileName = $(this).val().replace('C:\\fakepath\\', " ");
        $(this).next('.custom-file-label').html(fileName);
    });
}

/**
 * Menangkap elemen html yang dibutuhkan.
 */
const ktpImageLabel = document.querySelector('#ktp-img-label');
const colKtpImagePreview = document.querySelector('#col-ktp-img-preview');
const ktpImage = document.querySelector('#ktp-image');
const ktpImagePreview = document.querySelector('.ktp-img-preview');

// Cek apakah penyewa sudah meng-upload gambar ktp.
if (ktpImage != null) {
    // Jika iya, beri kondisi jika gambar ktp di-upload maka jalankan function berikut.
    ktpImage.addEventListener('change', function () {
        // Mengambil file gambar ktp yang diinputkan.
        const [file] = ktpImage.files;
        // Menampilkan gambar ktp yang diinputkan.
        ktpImagePreview.src = URL.createObjectURL(file);

        // Cek apakah ada col ktp image preview dan ktp iamge label.
        if (colKtpImagePreview && ktpImageLabel) {
            /**
             * Jika iya,
             * Hapus class d-none pada col ktp image preview.
             * Tambahkan class d-none pada ktp iamge label.
             */
            colKtpImagePreview.classList.remove('d-none');
            ktpImageLabel.classList.add('d-none')
        }

        /**
         * Menampilkan nama file gambar ktp pada kolom input file.
         */
        var fileName = $(this).val().replace('C:\\fakepath\\', " ");
        $(this).next('.custom-file-label').html(fileName);
    });
}

/**
 * Menangkap elemen html yang dibutuhkan.
 */
const simImageLabel = document.querySelector('#sim-img-label');
const colSimImagePreview = document.querySelector('#col-sim-img-preview');
const simImage = document.querySelector('#sim-image');
const simImagePreview = document.querySelector('.sim-img-preview');

// Cek apakah penyewa sudah meng-upload gambar sim.
if (simImage != null) {
    // Jika iya, beri kondisi jika gambar sim di-upload maka jalankan function berikut.
    simImage.addEventListener('change', function () {
        // Mengambil file gambar sim yang diinputkan.
        const [file] = simImage.files;
        // Menampilkan gambar sim yang diinputkan.
        simImagePreview.src = URL.createObjectURL(file);

        // Cek apakah ada col sim image preview dan sim iamge label.
        if (colSimImagePreview && simImageLabel) {
            /**
             * Jika iya,
             * Hapus class d-none pada col sim image preview.
             * Tambahkan class d-none pada sim iamge label.
             */
            colSimImagePreview.classList.remove('d-none');
            simImageLabel.classList.add('d-none')
        }

        /**
         * Menampilkan nama file gambar sim pada kolom input file.
         */
        var fileName = $(this).val().replace('C:\\fakepath\\', " ");
        $(this).next('.custom-file-label').html(fileName);
    });
}

/**
 * Membuat function formatRupiah untuk menampilkan harga dengan format rupiah ketika user(admin/penyewa) menginput harga.
 */
function formatRupiah(number, prefix) {
    // Mengganti semua inputan user(admin/penyewa) yang bukan angka dengan string kosong.
    let number_string = number.replace(/[^,\d]/g, '').toString(),
        // Memisahkan angka diantara koma(jika ada).
        split = number_string.split(','),
        // Menampung 3 angka terakhir sebelum koma.
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        // Ketika angka ribuan, tangkap setiap 3 angka.
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // Tambahkan titik jika yang diinput sudah ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    // Jika ada angka dibelakang koma.
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

    /**
     * Jika prefix tidak ada maka tampilkan rupiah,
     * tapi jika prefix ada maka cek apakah ada rupiah,
     * jika ada rupiah maka tampilkan Rp + rupiah,
     * tapi jika tidak maka tampilkan string kosong.
     */
    return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
}