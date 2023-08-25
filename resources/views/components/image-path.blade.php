<div id="outputImage" class="grid grid-cols-2 gap-4"></div>

<input x-data @change="displayImages"
    class="block w-full border text-sm border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm cursor-pointer bg-gray-50 file-input"
    id="inputImage" type="file" accept="image/jpeg, image/png, image/jpg" name="image_path[]" id="image_path" multiple>

<script>
    const outputImage = document.getElementById('outputImage')

    function displayImages() {
        let images = inputImage.files;
    outputImage.innerHTML = '';
        for (let i = 0; i < images.length; i++) {
            const image = `
                <div class="image border mt-3 mb-3 overflow-hidden h-[200px] w-[200px]">
                    <img src="${URL.createObjectURL(images[i])}" class="object-cover h-full w-full drop-shadow-lg">
                </div>`;
            outputImage.innerHTML += image;
        }
    }
</script>
