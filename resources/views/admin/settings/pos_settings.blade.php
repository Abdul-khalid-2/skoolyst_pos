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
                        <h4 class="mb-3">POS Settings</h4>
                        <p class="mb-0">Configure your Point of Sale system settings and receipt preferences</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('settings.pos.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Default Branch</label>
                                        <select class="form-control" name="default_branch">
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ (old('default_branch', $settings['default_branch'] ?? '') == $branch->id ? 'selected' : '' }}>
                                                    {{ $branch->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Default Customer</label>
                                        <select class="form-control" name="default_customer">
                                            <option value="0">Walk-in Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ (old('default_customer', $settings['default_customer'] ?? '') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Default Payment Method</label>
                                        <select class="form-control" name="default_payment_method">
                                            @foreach($paymentMethods as $method)
                                                <option value="{{ $method->id }}" {{ (old('default_payment_method', $settings['default_payment_method'] ?? '') == $method->id ? 'selected' : '' }}>
                                                    {{ $method->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="show_product_images" 
                                                   name="show_product_images" value="1" {{ (old('show_product_images', $settings['show_product_images'] ?? true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="show_product_images">Show Product Images in POS</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="enable_discount" 
                                                   name="enable_discount" value="1" {{ (old('enable_discount', $settings['enable_discount'] ?? true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="enable_discount">Enable Discounts</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="enable_tax" 
                                                   name="enable_tax" value="1" {{ (old('enable_tax', $settings['enable_tax'] ?? true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="enable_tax">Enable Taxes</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="print_receipt_after_sale" 
                                                   name="print_receipt_after_sale" value="1" {{ (old('print_receipt_after_sale', $settings['print_receipt_after_sale'] ?? true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="print_receipt_after_sale">Auto Print Receipt</label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Receipt Size</label>
                                        <select class="form-control" name="receipt_size">
                                            <option value="58mm" {{ (old('receipt_size', $settings['receipt_size'] ?? '58mm') == '58mm' ? 'selected' : '' }}>58mm (Small)</option>
                                            <option value="80mm" {{ (old('receipt_size', $settings['receipt_size'] ?? '58mm') == '80mm' ? 'selected' : '' }}>80mm (Medium)</option>
                                            <option value="A4" {{ (old('receipt_size', $settings['receipt_size'] ?? '58mm') == 'A4' ? 'selected' : '' }}>A4 (Large)</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Receipt Header</label>
                                        <textarea class="form-control" name="receipt_header" rows="2">{{ old('receipt_header', $settings['receipt_header'] ?? '') }}</textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Receipt Footer</label>
                                        <textarea class="form-control" name="receipt_footer" rows="2">{{ old('receipt_footer', $settings['receipt_footer'] ?? 'Thank you for your business!') }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Save POS Settings</button>
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
    @endpush
</x-app-layout>