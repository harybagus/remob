const imageLabel = document.querySelector('#img-label');
const colImagePreview = document.querySelector('#col-img-preview');
const imagePreview = document.querySelector('.img-preview');
const image = document.querySelector('#image');

if (image != null) {
    image.addEventListener('change', function () {
        const [file] = image.files;
        imagePreview.src = URL.createObjectURL(file);

        if (colImagePreview && imageLabel) {
            colImagePreview.classList.remove('d-none');
            imageLabel.classList.add('d-none')
        }

        var fileName = $(this).val().replace('C:\\fakepath\\', " ");
        $(this).next('.custom-file-label').html(fileName);
    });
}

const ktpImageLabel = document.querySelector('#ktp-img-label');
const colKtpImagePreview = document.querySelector('#col-ktp-img-preview');
const ktpImage = document.querySelector('#ktp-image');
const ktpImagePreview = document.querySelector('.ktp-img-preview');

if (ktpImage != null) {
    ktpImage.addEventListener('change', function () {
        const [file] = ktpImage.files;
        ktpImagePreview.src = URL.createObjectURL(file);

        if (colKtpImagePreview && ktpImageLabel) {
            colKtpImagePreview.classList.remove('d-none');
            ktpImageLabel.classList.add('d-none')
        }

        var fileName = $(this).val().replace('C:\\fakepath\\', " ");
        $(this).next('.custom-file-label').html(fileName);
    });
}

const simImageLabel = document.querySelector('#sim-img-label');
const colSimImagePreview = document.querySelector('#col-sim-img-preview');
const simImage = document.querySelector('#sim-image');
const simImagePreview = document.querySelector('.sim-img-preview');

if (simImage != null) {
    simImage.addEventListener('change', function () {
        const [file] = simImage.files;
        simImagePreview.src = URL.createObjectURL(file);

        if (colSimImagePreview && simImageLabel) {
            colSimImagePreview.classList.remove('d-none');
            simImageLabel.classList.add('d-none')
        }

        var fileName = $(this).val().replace('C:\\fakepath\\', " ");
        $(this).next('.custom-file-label').html(fileName);
    });
}

function formatRupiah(number, prefix) {
    let number_string = number.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

    return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
}