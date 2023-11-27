@extends('layout')

@section('content')

<div class="container mx-auto p-6">
    <div class="flex flex-col gap-6">
        <section class="bg-white p-2 shadow-md rounded-lg mt-6">
            <h2 class="text-xl font-semibold mb-2 ml-2 text-center">
                Ingestuurde bonnetjes
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach($receipts as $receipt)
                <div class="w-full px-1 mb-4">
                    <div class="bg-gray-100 p-2 rounded-lg shadow-md relative flex flex-col items-center justify-center">
                        <p class="mb-2">Ingestuurd op: {{ optional($receipt->created_at)->format('F j, Y') }}</p>
                        <a href="#" onclick="openImageModal('{{ url('') . '/' . $receipt->media }}')">
                            <img src="{{ url('') . '/' . $receipt->media }}" class="max-w-[550px] max-h-[300px]" alt="Receipt Image">
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>

{{-- Laat de foto full-size zien --}}
<div id="imageModal" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 hidden flex justify-center items-center">
    <div class="max-w-3xl max-h-3/4 overflow-hidden">
        <div id="modalContent" class="w-full h-full">
        </div>
    </div>
</div>

<script>
    // Vindt elementen "modalContent en imageModal" en past bestaande classes aan zodat de image full-size weergegeven wordt.
    function openImageModal(imageSrc) {
        document.getElementById('modalContent').innerHTML = '<img src="' + imageSrc + '" class="w-full h-full object-cover">';
        document.getElementById('imageModal').classList.remove('hidden');
    }

    // Sluit de full-size image wanneer er buiten de foto geklikt wordt.
    document.getElementById('imageModal').addEventListener('click', function (event) {
        if (event.target === this) {
            this.classList.add('hidden');
        }
    });
</script>
@endsection
