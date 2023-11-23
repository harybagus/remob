const image = document.querySelector('#image');
const imagePreview = document.querySelector('.img-preview');

if (image != null) {
    image.addEventListener('change', function () {
        const [file] = image.files;
        imagePreview.src = URL.createObjectURL(file);

        var fileName = $(this).val().replace('C:\\fakepath\\', " ");
        $(this).next('.custom-file-label').html(fileName);
    });
}