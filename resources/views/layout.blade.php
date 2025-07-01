<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dreamspos.dreamstechnologies.com/html/template/contacts.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 20 Apr 2025 21:55:47 GMT -->
<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    

    <script src="{{asset('app')}}/assets/js/theme-script.js" type="text/javascript"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('app')}}/assets/img/favicon.png">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('app')}}/assets/img/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/css/bootstrap.min.css">

    <!-- animation CSS -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/css/animate.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/plugins/select2/css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/css/bootstrap-datetimepicker.min.css">

    <!-- Mobile CSS-->
    <link rel="stylesheet" href="{{asset('app')}}/assets/plugins/intltelinput/css/intlTelInput.css">
    <link rel="stylesheet" href="{{asset('app')}}/assets/plugins/intltelinput/css/demo.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/css/dataTables.bootstrap5.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{asset('app')}}/assets/plugins/fontawesome/css/all.min.css">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/plugins/tabler-icons/tabler-icons.css">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/plugins/%40simonwep/pickr/themes/nano.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">


    @yield('css')

</head>
<body>

<div id="global-loader" >
    <div class="whirly-loader"> 

    </div>
</div>

<!-- Main Wrapper -->
<div class="main-wrapper">


    @include('components.header')
    @include('components.sidebar')
    @include('components.horizontal')
    @include('components.colsidebar')



    <div class="page-wrapper">

        @yield('contenu')




        @include('components.footer')


    </div>
</div>
<!-- /Main Wrapper -->


<!-- jQuery -->


<script src="{{asset('app')}}/assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>

<!-- Feather Icon JS -->
<script src="{{asset('app')}}/assets/js/feather.min.js" type="text/javascript"></script>

<!-- Slimscroll JS -->
<script src="{{asset('app')}}/assets/js/jquery.slimscroll.min.js" type="text/javascript"></script>

<!-- Datatable JS -->
<script src="{{asset('app')}}/assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="{{asset('app')}}/assets/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>

<!-- Bootstrap Core JS -->
<script src="{{asset('app')}}/assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>

<!-- Datetimepicker JS -->
<script src="{{asset('app')}}/assets/js/moment.min.js" type="text/javascript"></script>
<script src="{{asset('app')}}/assets/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<!-- Mobile Input -->
<script src="{{asset('app')}}/assets/plugins/intltelinput/js/intlTelInput.js" type="text/javascript"></script>

<!-- Select2 JS -->
<script src="{{asset('app')}}/assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>

<!-- Color Picker JS -->
<script src="{{asset('app')}}/assets/plugins/%40simonwep/pickr/pickr.es5.min.js" type="text/javascript"></script>

<!-- Custom JS -->
<script src="{{asset('app')}}/assets/js/theme-colorpicker.js" type="text/javascript"></script>
<script src="{{asset('app')}}/assets/js/script.js" type="text/javascript"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK',
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: "{{ session('error') }}",
            confirmButtonColor: '#d33',
            confirmButtonText: 'Fermer',
        });
    </script>
@endif

@yield('js')

</body>

<!-- Mirrored from dreamspos.dreamstechnologies.com/html/template/contacts.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 20 Apr 2025 21:55:48 GMT -->
</html>
