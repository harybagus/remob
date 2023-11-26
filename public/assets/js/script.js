const imageLabel = document.querySelector('#img-label');
const colImagePreview = document.querySelector('#col-img-preview');
const imagePreview = document.querySelector('.img-preview');
const image = document.querySelector('#image');

if (image != null) {
    image.addEventListener('change', function () {
        const [file] = image.files;
        imagePreview.src = URL.createObjectURL(file);

        colImagePreview.classList.remove('d-none');
        imageLabel.classList.add('d-none')

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