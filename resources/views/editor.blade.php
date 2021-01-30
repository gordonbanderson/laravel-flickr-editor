<x-app-layout>

    <!-- main -->
    <div class="container mx-auto px-4" style="background: cyan; >
        <div class="flex justify-center pt-20">
            <h1>Editor</h1>
            <div>
                <div id="root">

                </div>
            </div>
        </div>


    </div>

    <!-- Scripts -->
    <script src="{{ asset('vendor/suilven/flickr-editor/js/manifest.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('vendor/suilven/flickr-editor/js/vendor.js') }}" type="text/javascript" defer></script>
    <script src="{{ asset('vendor/suilven/flickr-editor/js/index.js') }}" type="text/javascript" defer></script>

</x-app-layout>
