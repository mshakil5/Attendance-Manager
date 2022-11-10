
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>Employee Attendance System</title>
    
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    </head>
    
    <body>
    
        <!-- header section -->
    
        <section class='header-main'>
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light ">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#"><img src="{{ asset('assets/images/logo.png') }}" style="height: 66px" class="img-fluid d-block"></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0"> </ul>
                            <ul class="navbar-nav mb-2 mb-lg-0">
    
                                @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link btn-theme" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link btn-theme" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>
                                </li>
                            @endguest
    
                            </ul>
                        </div>
                    </div>
                </nav> 
            </div>
        </section>
    
        @yield('content')
    
        <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="https://code.iconify.design/2/2.0.1/iconify.min.js"></script>
        <script src='{{ asset('assets/js/app.js') }}'> </script>


        <script>
            // page schroll top
            function pagetop() {
                window.scrollTo({
                    top: 130,
                    behavior: 'smooth',
                });
            }
      
      
            function success(msg){
                   $.notify({
                           // title: "Update Complete : ",
                           message: msg,
                           // icon: 'fa fa-check'
                       },{
                           type: "info"
                       });
      
               }
           function dlt(){
             swal({
               title: "Are you sure?",
               text: "You will not be able to recover this imaginary file!",
               type: "warning",
               showCancelButton: true,
               confirmButtonText: "Yes, delete it!",
               cancelButtonText: "No, cancel plx!",
               closeOnConfirm: false,
               closeOnCancel: false
           }, function(isConfirm) {
               if (isConfirm) {
                   swal("Deleted!", "Your imaginary file has been deleted.", "success");
               } else {
                  swal("Cancelled", "Your imaginary file is safe :)", "error");
      
               }
            });
      
      
           }
      
        </script>
    
    
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> 
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script> 
     <script type="text/javascript" src="{{asset('js/plugins/bootstrap-notify.min.js')}}"></script>
     <script type="text/javascript" src="{{asset('js/plugins/sweetalert.min.js')}}"></script>
        @yield('script')




    </body>
    
    </html>