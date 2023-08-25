@if (@isset($user) && $user->avatar)
    <div id="outputImage" class="image border rounded-full mt-3 mb-3 overflow-hidden h-[150px] w-[150px]">
        <img src="{{ asset('storage/avatar/' . $user->avatar) }}" class="object-cover h-full w-full drop-shadow-lg">
    </div>
@else
    <div id="outputImage" class=""></div>
@endif

<input x-data @change="displayImages"
    class="block w-full red text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
    id="inputImage" type="file" accept="image/jpeg, image/png, image/jpg" name="avatar">

<script>
    const outputImage = document.getElementById('outputImage')

    function displayImages() {
        let images = inputImage.files;
    outputImage.innerHTML = '';
        for (let i = 0; i < images.length; i++) {
            const image = `
                <div class="image border rounded-full mt-3 mb-3 overflow-hidden h-[150px] w-[150px]">
                    <img src="${URL.createObjectURL(images[i])}" class="object-cover h-full w-full drop-shadow-lg">
                </div>`;
            outputImage.innerHTML += image;
        }
    }
</script>
