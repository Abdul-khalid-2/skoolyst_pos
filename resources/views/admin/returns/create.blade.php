
<x-app-layout>

    @push('css')
        <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}" />
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend-plugin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/css/backend.css?v=1.0.0') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('backend/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/assets/vendor/remixicon/fonts/remixicon.css') }}">
    @endpush
        <div class="container-fluid add-form-list">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Add Product</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="page-list-product.html" data-toggle="validator">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Product Type *</label>
                                            <select name="type" class="selectpicker form-control" data-style="py-0">
                                                <option>Standard</option>
                                                <option>Combo</option>
                                                <option>Digital</option>
                                                <option>Service</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name *</label>
                                            <input type="text" class="form-control" placeholder="Enter Name"
                                                data-errors="Please Enter Name." required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Code *</label>
                                            <input type="text" class="form-control" placeholder="Enter Code"
                                                data-errors="Please Enter Code." required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Barcode Symbology *</label>
                                            <select name="type" class="selectpicker form-control" data-style="py-0">
                                                <option>CREM01</option>
                                                <option>UM01</option>
                                                <option>SEM01</option>
                                                <option>COF01</option>
                                                <option>FUN01</option>
                                                <option>DIS01</option>
                                                <option>NIS01</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Category *</label>
                                            <select name="type" class="selectpicker form-control" data-style="py-0">
                                                <option>Beauty</option>
                                                <option>Grocery</option>
                                                <option>Food</option>
                                                <option>Furniture</option>
                                                <option>Shoes</option>
                                                <option>Frames</option>
                                                <option>Jewellery</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cost *</label>
                                            <input type="text" class="form-control" placeholder="Enter Cost"
                                                data-errors="Please Enter Cost." required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Price *</label>
                                            <input type="text" class="form-control" placeholder="Enter Price"
                                                data-errors="Please Enter Price." required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Tax Method *</label>
                                            <select name="type" class="selectpicker form-control" data-style="py-0">
                                                <option>Exclusive</option>
                                                <option>Inclusive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Quantity *</label>
                                            <input type="text" class="form-control" placeholder="Enter Quantity"
                                                required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input type="file" class="form-control image-file" name="pic"
                                                accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description / Product Details</label>
                                            <textarea class="form-control" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Add Product</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
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