<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css')}}">
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">General Settings</h4>
                        <p class="mb-0">Configure your system's general settings including display, currency, and notifications</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('settings.general.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <!-- System Settings -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>System Name</label>
                                        <input type="text" class="form-control" name="system_name" 
                                               value="{{ old('system_name', $settings['system_name'] ?? 'MD-Autos') }}">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Timezone</label>
                                        <select class="form-control" name="timezone">
                                            @foreach(timezone_identifiers_list() as $tz)
                                                <option value="{{ $tz }}" {{ (old('timezone', $settings['timezone'] ?? 'UTC') == $tz ? 'selected' : '' }}>
                                                    {{ $tz }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Date Format</label>
                                        <select class="form-control" name="date_format">
                                            <option value="d-m-Y" {{ (old('date_format', $settings['date_format'] ?? 'd-m-Y') == 'd-m-Y' ? 'selected' : '' }}>DD-MM-YYYY</option>
                                            <option value="m-d-Y" {{ (old('date_format', $settings['date_format'] ?? 'd-m-Y') == 'm-d-Y' ? 'selected' : '' }}>MM-DD-YYYY</option>
                                            <option value="Y-m-d" {{ (old('date_format', $settings['date_format'] ?? 'd-m-Y') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Display Settings -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Logo</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="logo" name="logo">
                                            <label class="custom-file-label" for="logo">Choose file</label>
                                        </div>
                                        @if($settings['logo'] ?? false)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/'.$settings['logo']) }}" alt="Logo" style="max-height: 50px;">
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Currency</label>
                                        <select class="form-control" name="currency">
                                            @foreach(config('currencies') as $code => $currency)
                                                <option value="{{ $code }}" {{ (old('currency', $settings['currency'] ?? 'Rs') == $code ? 'selected' : '' }}>
                                                    {{ $currency['name'] }} ({{ $currency['symbol'] }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Records Per Page</label>
                                        <input type="number" class="form-control" name="records_per_page" 
                                               value="{{ old('records_per_page', $settings['records_per_page'] ?? 25) }}" min="5" max="100">
                                    </div>
                                </div>
                                
                                <!-- Notification Settings -->
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="low_stock_notification" 
                                                   name="low_stock_notification" value="1" {{ (old('low_stock_notification', $settings['low_stock_notification'] ?? true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="low_stock_notification">Enable Low Stock Notifications</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Notification Email</label>
                                        <input type="email" class="form-control" name="notification_email" 
                                               value="{{ old('notification_email', $settings['notification_email'] ?? '') }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Save Settings</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('backend/assets/js/backend-bundle.min.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('backend/assets/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('backend/assets/js/customizer.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('backend/assets/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Show file name when file is selected
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
    @endpush
</x-app-layout>