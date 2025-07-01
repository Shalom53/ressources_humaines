<!DOCTYPE html>
<html lang="en">


<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Comptabilite  | Créer son compte </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="{{asset('app')}}/assets/js/theme-script.js" type="text/javascript"></script>

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




    <link href="{{asset('app/css/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('app')}}/assets/css/style.css">



    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">


</head>
<body class="account-page bg-white">

<div id="global-loader" >
    <div class="whirly-loader"> </div>
</div>

<!-- Main Wrapper -->
<div class="main-wrapper">
    <div class="account-content">
        <div class="login-wrapper login-new">
            <div class="row w-100">
                <div class="col-lg-5 mx-auto">
                    <div class="login-content user-login">
                        <div class="login-logo">
                            <img src="{{asset('app')}}/assets/img/logomariam.png" alt="img">
                            <a href="{{url('/')}}" class="login-logo logo-white">
                                <img src="{{asset('app')}}/assets/img/logo-white.svg"  alt="Img">
                            </a>
                        </div>
                        <form action="" id="form">

                            @csrf
                            <div class="card">
                                <div class="card-body p-5">
                                    <div class="login-userheading">
                                        <h3>EIM RESSOURCES HUMAINES | CREER SON COMPTE </h3>

                                    </div>

                                    <div id="erreurAjax" style="color: red; margin-bottom: 10px;"></div>
                                    <div class="mb-3">
                                        <label class="form-label">Nom  <span class="text-danger"> *</span></label>
                                        <div class="input-group">
                                            <input type="text" value="" class="form-control border-end-0" name="nom" id="nom">
                                            <span class="input-group-text border-start-0">
                                                        <i class="ti ti-user"></i>
                                                    </span>
                                        </div>

                                        <span class="text-danger error-text nom_error"> </span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Prénom   <span class="text-danger"> *</span></label>
                                        <div class="input-group">
                                            <input type="text" value="" class="form-control border-end-0" name="prenom" id="prenom">
                                            <span class="input-group-text border-start-0">
                                                        <i class="ti ti-user"></i>
                                                    </span>
                                        </div>

                                        <span class="text-danger error-text prenom_error"> </span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Login <span class="text-danger"> *</span></label>
                                        <div class="input-group">
                                            <input type="text" value="" class="form-control border-end-0" name="login" id="login">
                                            <span class="input-group-text border-start-0">
                                                        <i class="ti ti-mail"></i>
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
                                    <div class="mb-3">
                                        <label class="form-label">Confirmer mot de passe  <span class="text-danger"> *</span></label>
                                        <div class="pass-group">
                                            <input type="password" class="pass-inputs form-control" name="mot_passe_confirmed" id="mot_passe_confirmed">
                                            <span class="ti toggle-passwords ti-eye-off text-gray-9"></span>
                                        </div>

                                        <span class="text-danger error-text mot_passe_confirmed_error"> </span>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Role  <span class="text-danger"> *</span></label>
                                        <div class="pass-group">
                                            <select class="form-control" name="role" id="role">
                                                <option>Choisir un  role   </option>




                                                    <option value="{{\App\Types\Role::ADMIN}}" >Admin </option>
                                                    <option value="{{\App\Types\Role::COMPTABLE}}" >Comptable </option>
                                                    <option value="{{\App\Types\Role::DIRECTEUR}}" >Directeur </option>
                                                    <option value="{{\App\Types\Role::CAISSIER}}" >Caissier </option>



                                            </select>

                                        </div>

                                        <span class="text-danger error-text role_error"> </span>
                                    </div>


                                    <div class="form-login authentication-check">
                                        <div class="row">

                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="form-login">
                                        <button type="submit" class="btn btn-primary w-100" id="validerRegister">Valider </button>
                                    </div>
                                    <div class="signinform">
                                        <h4>Avez vous deja un compte  ? <a href="{{url('/login')}}" class="hover-a">Se connecter </a></h4>
                                    </div>
                                   <br>
                                   <br>
                                   <br>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                        <p>Copyright &copy; 2025 ECOLE INTERNATIONALE MARIAM </p>
                    </div>
                </div>
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

<script src="{{asset('app/js/sweetalert2/sweetalert2.min.js')}}"></script>

<script src="{{asset('pages/register.js')}}"></script>

</body>


</html>
