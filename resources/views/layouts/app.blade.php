

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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




        /* loader style start  */

        .advanced-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader-backdrop {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(3px);
        }

        .loader-content {
            position: relative;
            background: white;
            border-radius: 12px;
            padding: 30px;
            width: 300px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            z-index: 10000;
        }

        .spinner-container {
            margin: 0 auto 20px;
            width: 80px;
            height: 80px;
            position: relative;
        }

        .spinner {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .spinner-circle {
            position: absolute;
            border-radius: 50%;
            border: 4px solid transparent;
            animation: spin 1.5s linear infinite;
        }

        .spinner-circle-outer {
            width: 100%;
            height: 100%;
            border-top-color: #3498db;
            border-bottom-color: #3498db;
        }

        .spinner-circle-inner {
            width: 70%;
            height: 70%;
            top: 15%;
            left: 15%;
            border-top-color: #e74c3c;
            border-bottom-color: #e74c3c;
            animation-direction: reverse;
        }

        .spinner-circle-single-1 {
            width: 40%;
            height: 40%;
            top: 30%;
            left: 30%;
            border-top-color: #2ecc71;
            animation-duration: 2s;
        }

        .spinner-circle-single-2 {
            width: 20%;
            height: 20%;
            top: 40%;
            left: 40%;
            border-top-color: #f39c12;
            animation-duration: 2.5s;
        }

        .loader-text {
            margin-bottom: 15px;
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        .progress-container {
            width: 100%;
            height: 6px;
            background: #f0f0f0;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, #3498db, #2ecc71);
            transition: width 0.3s ease;
        }

        .progress-bar.error {
            background: #e74c3c;
        }

        .error-icon {
            font-size: 50px;
            color: #e74c3c;
            animation: bounce 0.5s;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes bounce {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
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
   
<script>
    function showLoader(text = 'Loading...') {
            // Remove any existing loader first
            $('.advanced-loader').remove();
            
            const loaderHtml = `
                <div class="advanced-loader">
                    <div class="loader-backdrop"></div>
                    <div class="loader-content">
                        <div class="spinner-container">
                            <div class="spinner">
                                <div class="spinner-circle spinner-circle-outer"></div>
                                <div class="spinner-circle spinner-circle-inner"></div>
                                <div class="spinner-circle spinner-circle-single-1"></div>
                                <div class="spinner-circle spinner-circle-single-2"></div>
                            </div>
                        </div>
                        <div class="loader-text">${text}</div>
                        <div class="progress-container">
                            <div class="progress-bar"></div>
                        </div>
                    </div>
                </div>
            `;
            
            $('body').append(loaderHtml);
            $('.advanced-loader').fadeIn(200);
        }
        
        // Hide loader
        function hideLoader() {
            $('.advanced-loader').fadeOut(200, function() {
                $(this).remove();
            });
        }
</script>
    @stack('js')

</body>

</html>
