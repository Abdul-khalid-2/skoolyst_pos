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
                        <h4 class="mb-3">Business Settings</h4>
                        <p class="mb-0">Configure your business information and financial settings</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('settings.business.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Business Name</label>
                                        <input type="text" class="form-control" name="business_name" 
                                               value="{{ old('business_name', $business->name ?? '') }}" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Tax Number (TIN)</label>
                                        <input type="text" class="form-control" name="tax_number" 
                                               value="{{ old('tax_number', $business->tax_number ?? '') }}">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Registration Number</label>
                                        <input type="text" class="form-control" name="registration_number" 
                                               value="{{ old('registration_number', $business->registration_number ?? '') }}">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Business Email</label>
                                        <input type="email" class="form-control" name="business_email" 
                                               value="{{ old('business_email', $business->email ?? '') }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Business Phone</label>
                                        <input type="text" class="form-control" name="business_phone" 
                                               value="{{ old('business_phone', $business->phone ?? '') }}" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Business Address</label>
                                        <textarea class="form-control" name="business_address" rows="3" required>{{ old('business_address', $business->address ?? '') }}</textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Business Logo</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="business_logo" name="business_logo">
                                            <label class="custom-file-label" for="business_logo">Choose file</label>
                                        </div>
                                        @if($business->logo_path ?? false)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/'.$business->logo_path) }}" alt="Business Logo" style="max-height: 100px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Default Currency</label>
                                        <select class="form-control" name="default_currency">
                                            @foreach(config('currencies') as $code => $currency)
                                                <option value="{{ $code }}" {{ (old('default_currency', $settings['default_currency'] ?? 'Rs') == $code ? 'selected' : '' }}>
                                                    {{ $currency['name'] }} ({{ $currency['symbol'] }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Fiscal Year Start</label>
                                        <input type="date" class="form-control" name="fiscal_year_start" 
                                               value="{{ old('fiscal_year_start', $settings['fiscal_year_start'] ?? date('Y-01-01')) }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Default Account</label>
                                        <select class="form-control" name="default_account">
                                            @foreach($accounts as $account)
                                                <option value="{{ $account->id }}" {{ (old('default_account', $settings['default_account'] ?? '') == $account->id ? 'selected' : '' }}>
                                                    {{ $account->name }} ({{ $account->type }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Fiscal Year End</label>
                                        <input type="date" class="form-control" name="fiscal_year_end" 
                                               value="{{ old('fiscal_year_end', $settings['fiscal_year_end'] ?? date('Y-12-31')) }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Receipt Header</label>
                                        <textarea class="form-control" name="receipt_header" rows="2">{{ old('receipt_header', $business->receipt_header ?? '') }}</textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Receipt Footer</label>
                                        <textarea class="form-control" name="receipt_footer" rows="2">{{ old('receipt_footer', $business->receipt_footer ?? 'Thank you for your business!') }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Save Business Settings</button>
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