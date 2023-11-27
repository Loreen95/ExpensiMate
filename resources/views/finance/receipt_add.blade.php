@extends('layout')

@section('content')
<form action="{{ route('finance.receipt_add') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <!-- Bestand Uploaden -->
    <div class="mb-4">
        <label for="file" class="block text-sm font-medium text-gray-700">
            {{ trans('dashboard.upload.file') }}
        </label>
        <div id="previewImage" class="w-3/5 h-64 border-2 rounded-xl ml-auto mr-auto">
            <input name="media" id="media" type="file" accept=".pdf, .jpg, .jpeg, .png" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
        </div>
    </div>

    <!-- Omschrijving -->
    <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700">
            {{ trans('dashboard.upload.description') }}
        </label>
        <textarea name="description" id="description" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
    </div>

    <!-- Verzendknop -->
    <div class="mb-4">
        <button type="submit" class="px-4 py-2 w-full text-sm font-medium text-white bg-green-600 rounded-md hover:bg-blue-600">
            {{ trans('dashboard.upload.upload_button') }}
        </button>
    </div>
</form>

<script>
    const imageInput = document.getElementById('media');
    const previewImage = document.getElementById('previewImage');

    imageInput.addEventListener('change', function () {
        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = new Image();
                img.src = e.target.result;
                img.onload = function () {
                    const aspectRatio = img.width / img.height;
                    const maxWidth = parseFloat(getComputedStyle(previewImage).width);
                    const newHeight = maxWidth / aspectRatio;

                    if(newHeight > 1080){
                        alert('please use a shorter image')
                    }else{
                    previewImage.style.backgroundImage = `url(${e.target.result})`;
                    previewImage.style.height = newHeight + 'px';
                    previewImage.style.backgroundSize = "100% auto";
                    }
                };
            };
            reader.readAsDataURL(imageInput.files[0]);
        } else {
            // Reset styles when no image is selected
            previewImage.style.backgroundImage = 'none';
            previewImage.style.height = 'auto';
            previewImage.style.backgroundSize = 'auto';
        }
    });
</script>
@endsection
