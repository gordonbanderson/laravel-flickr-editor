<x-app-layout>
    <!-- Scripts -->
    <script src="{{ asset('vendor/suilven/flickr-editor/js/vendor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/suilven/flickr-editor/js/editor.js') }}" type="text/javascript" ></script>

    <!-- main -->
    <div class="container mx-auto px-4">
        <div class="flex justify-center pt-20">
            <div>
               <p>This is the editor : </p>

                <div id="root">Edit here

                </div>
            </div>
        </div>


    </div>

</x-app-layout>