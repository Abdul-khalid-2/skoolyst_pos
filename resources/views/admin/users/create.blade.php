
<x-app-layout>

    @push('css')
        <link rel="shortcut icon" href="{{ asset('Backend/assets/images/favicon.ico') }}" />
        <link rel="stylesheet" href="{{ asset('Backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('Backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('Backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('Backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush
        <div class="container-fluid add-form-list">

        </div>
    @push('js')
            <!-- Backend Bundle JavaScript -->
            <script src="{{ asset('Backend/assets/js/backend-bundle.min.js') }}"></script>
            <!-- Table Treeview JavaScript -->
            <script src="{{ asset('Backend/assets/js/table-treeview.js') }}"></script>
            <!-- Chart Custom JavaScript -->
            <script src="{{ asset('Backend/assets/js/customizer.js') }}"></script>
            <!-- Chart Custom JavaScript -->
            <script async src="{{ asset('Backend/assets/js/chart-custom.js') }}"></script>
            <!-- app JavaScript -->
            <script src="{{ asset('Backend/assets/js/app.js') }}"></script>
    @endpush
</x-app-layout>