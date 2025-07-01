<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dreamspos.dreamstechnologies.com/html/template/signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 20 Apr 2025 21:55:18 GMT -->
<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Comptabilite | Login </title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('app')}}/assets/img/favicon.png">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('app')}}/assets/img/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{asset('app')}}/assets/plugins/fontawesome/css/all.min.css">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/plugins/tabler-icons/tabler-icons.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">


</head>
<body class="account-page">

<div id="global-loader" >
    <div class="whirly-loader"> </div>
</div>

<!-- Main Wrapper -->
<div class="main-wrapper">
    <div class="account-content">
        <div class="login-wrapper bg-img">
            <div class="login-content authent-content">
                <form action="" id="form">

                    @csrf
                    <div class="login-userset">
                        <div class="login-logo logo-normal">
                            <img src="{{asset('app')}}/assets/img/logomariam.png" alt="img">
                        </div>
                        <a href="{{url('/')}}" class="login-logo logo-white">
                            <img src="{{asset('app')}}/assets/img/logomariam.png"  alt="Img">
                        </a>
                        <div class="login-userheading">
                            <h3 style="text-align: center"> EIM  |   RESSOURCES HUMAINES </h3>

                        </div>

                        <div id="erreurAjax" style="color: red; margin-bottom: 10px;"></div>
                        <div class="mb-3">
                            <label class="form-label">Login  <span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <input type="text" value="" class="form-control border-end-0" name="login" id="login">
                                <span class="input-group-text border-start-0">
                                            <i class="ti ti-user"></i>
                                        </span>
                            </div>

                            <span class="text-danger error-text login_error"> </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mot de passe  <span class="text-danger"> *</span></label>
                            <div class="pass-group">
                                <input type="password" class="pass-input form-control" name="mot_passe" id="mot_passe">
                                <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                            </div>

                            <span class="text-danger error-text mot_passe_error"> </span>
                        </div>
                        <div class="form-login authentication-check">
                           <br>
                           <br>
                           <br>

                        </div>
                        <div class="form-login">
                            <button type="submit" class="btn btn-primary w-100" id="authentifier">Valider </button>
                        </div>
                        <div class="signinform">
                            <h4>Pas encore inscrit ?<a href="{{url('/register')}}" class="hover-a"> Créer son compte </a></h4>
                        </div>

                        <br>
                        <br>

                        <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                            <p>Copyright &copy; 2025 ECOLE INTERNATIONALE MARIAM </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Main Wrapper -->


<!-- jQuery -->
<script src="{{asset('app')}}/assets/js/jquery-3.7.1.min.js" type="text/javascript"></script>

<!-- Feather Icon JS -->
<script src="{{asset('app')}}/assets/js/feather.min.js" type="text/javascript"></script>

<!-- Bootstrap Core JS -->
<script src="{{asset('app')}}/assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>

<!-- Custom JS -->
<script src="{{asset('app')}}/assets/js/script.js" type="text/javascript"></script>


<script src="{{asset('pages/login.js')}}"></script>

</body>



</html>
