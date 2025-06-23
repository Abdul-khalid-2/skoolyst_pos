

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MD-Autos</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href=" {{ asset('/backend/assets/images/favicon.ico') }}" />
   <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Select2 Global Styling */
        .select_two_functionality + .select2-container {
            width: 100% !important;
            /* margin-bottom: 15px; */
        }

        .select_two_functionality + .select2-container .select2-selection {
            min-height: 45px;
            border: 2px solid #ced4da;
            border-radius: 10px;
            padding: 8px 12px;
        }

        .select_two_functionality + .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        /* Fix for modals */
        .modal .select2-dropdown {
            z-index: 1060 !important;
        }

        /* Dark mode support */
        [data-bs-theme="dark"] .select_two_functionality + .select2-container .select2-selection {
            background-color: #212529;
            border-color: #495057;
            color: #f8f9fa;
        }
    </style>
    @stack('css')
</head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">

        {{-- sidebar code here start  --}}
        @include('layouts.sidebar')
        {{-- sidebar code here end  --}}
        
        {{-- navigation code here start  --}}
        @include('layouts.navigation')
        {{-- navigation code here end  --}}
        



        <div class="modal fade" id="new-order" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="popup text-left">
                            <h4 class="mb-3">New Order</h4>
                            <div class="content create-workform bg-body">
                                <div class="pb-3">
                                    <label class="mb-2">Email</label>
                                    <input type="text" class="form-control" placeholder="Enter Name or Email">
                                </div>
                                <div class="col-lg-12 mt-4">
                                    <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                                        <div class="btn btn-primary mr-4" data-dismiss="modal">Cancel</div>
                                        <div class="btn btn-outline-primary" data-dismiss="modal">Create</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-page">




            {{ $slot }}




        </div>
    </div>
    <!-- Wrapper End-->
    {{-- <footer class="iq-footer">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item"><a href="../backend/privacy-policy.html">Privacy Policy</a>
                                </li>
                                <li class="list-inline-item"><a href="../backend/terms-of-service.html">Terms of Use</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6 text-right">
                            <span class="mr-1">
                                <script>document.write(new Date().getFullYear())</script>©
                            </span> <a href="#" class="">MD-Autos</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer> --}}
   

    @stack('js')

</body>

</html>
