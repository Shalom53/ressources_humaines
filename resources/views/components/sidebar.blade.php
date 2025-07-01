<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <a href="{{route('tableau')}}" class="logo logo-normal">
            <img src="{{asset('app')}}/assets/img/logomariam.png" alt="Img">
        </a>
        <a href="{{url('/')}}" class="logo logo-white">
            <img src="{{asset('app')}}/assets/img/logomariam.png" alt="Img">
        </a>
        <a href="{{url('/')}}" class="logo-small">
            <img src="{{asset('app')}}/assets/img/logomariam.png" alt="Img">
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
            <i data-feather="chevrons-left" class="feather-16"></i>
        </a>
    </div>
    <!-- /Logo -->
    <div class="modern-profile p-3 pb-0">
        <div class="text-center rounded bg-light p-3 mb-4 user-profile">
            <div class="avatar avatar-lg online mb-3">
                <img src="{{asset('app')}}/assets/img/customer/customer15.jpg" alt="Img" class="img-fluid rounded-circle">
            </div>
            <h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
            <p class="fs-12 mb-0">System Admin</p>
        </div>
        <div class="sidebar-nav mb-3">
            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
                <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
                <li class="nav-item"><a class="nav-link border-0" href="chat.html">Chats</a></li>
                <li class="nav-item"><a class="nav-link border-0" href="email.html">Inbox</a></li>
            </ul>
        </div>
    </div>
    <div class="sidebar-header p-3 pb-0 pt-2">
        <div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
            <div class="avatar avatar-md onlin">
                <img src="{{asset('app')}}/assets/img/customer/customer15.jpg" alt="Img" class="img-fluid rounded-circle">
            </div>
            <div class="text-start sidebar-profile-info ms-2">
                <h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
                <p class="fs-12">System Admin</p>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between menu-item mb-3">
            <div>
                <a href="{{route('tableau')}}" class="btn btn-sm btn-icon bg-light">
                    <i class="ti ti-layout-grid-remove"></i>
                </a>
            </div>
            <div>
                <a href="chat.html" class="btn btn-sm btn-icon bg-light">
                    <i class="ti ti-brand-hipchat"></i>
                </a>
            </div>
            <div>
                <a href="email.html" class="btn btn-sm btn-icon bg-light position-relative">
                    <i class="ti ti-message"></i>
                </a>
            </div>
            <div class="notification-item">
                <a href="activities.html" class="btn btn-sm btn-icon bg-light position-relative">
                    <i class="ti ti-bell"></i>
                    <span class="notification-status-dot"></span>
                </a>
            </div>
            <div class="me-0">
                <a href="general-settings.html" class="btn btn-sm btn-icon bg-light">
                    <i class="ti ti-settings"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Bienvenue  </h6>
                    <ul>
                       

                    </ul>
                </li>



                <li class="submenu-open">
                    <h6 class="submenu-hdr">Ressources Humaines </h6>
                    <ul>
                        <li class="">
                            <a href="{{url('/')}}"><i class="ti ti-layout-grid fs-16 me-2"></i><span>Tableau de bord </span></a>

                        </li>

                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="ti ti-users fs-16 me-2"></i>
                        <span>Personnel</span><span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{route('AjoutPersonnel')}}">Ajouter un employé</a></li>
                        <li><a href="{{ route('ListeDuPersonnel') }}">Liste du personnel</a></li>
                        <li><a href="{{route('ListeEnseignant')}}">Enseignants</a></li>
                        <li><a href="{{route('ListeAdministratif')}}">Administratifs</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="ti ti-file-text fs-16 me-2"></i>
                        <span>Contrats & Documents</span><span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('listeContrats') }}">Contrats</a></li>
                        <li><a href="{{ route('listeDocuments') }}">Documents</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="ti ti-calendar fs-16 me-2"></i>
                        <span>Congés & Absences</span><span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{url('/drh/conges/demandes')}}">Demandes de congé</a></li>
                        <li><a href="{{url('/drh/conges/validation')}}">Validation</a></li>
                        <li><a href="{{url('/drh/conges/historique')}}">Historique</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="ti ti-briefcase fs-16 me-2"></i>
                        <span>Demandes d'emploi</span><span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('demandes.voir') }}">Liste des candidatures</a></li>
                        <li><a href="{{url('/drh/demandes/nouvelle')}}">Nouvelle demande</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="ti ti-check fs-16 me-2"></i>
                        <span>Présence & Absence</span><span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{route('liste.presences')}}">Pointages</a></li>
                        <li><a href="{{route('Courbestatistiques')}}">Statistiques</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);">
                        <i class="ti ti-currency-dollar fs-16 me-2"></i>
                        <span>Gestion de Paie</span><span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{route('Paiement.employe')}}">Paiement</a></li>
                        <li><a href="{{route('fiche.paie')}}">Fiches de paie</a></li>
                        <li><a href="{{url('/drh/paie/primes')}}">Primes & Avantages</a></li>
                        <li><a href="{{ route('sanctions.index') }}">Sanctions</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{url('/drh/journal')}}">
                        <i class="ti ti-notebook fs-16 me-2"></i>
                        <span>Journal RH</span>
                    </a>
                </li>
                
                <li class="submenu">
                    <a href="{{url('/drh/settings')}}">
                        <i class="ti ti-settings fs-16 me-2"></i>
                        <span>Paramètres</span><span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{route('listePostes')}}">Poste</a></li>
                        <li><a href="{{url('/drh/paie/primes')}}">Primes & Avantages</a></li>
                        <li><a href="{{ route('typesanctions.index') }}">Type de Sanctions</a></li>

                    </ul>
                </li>
                
            </ul>
                </li>


                <li class="submenu-open">
                    <h6 class="submenu-hdr">Parametres </h6>
                    <ul>
                        <li class="submenu submenu-two"><a href="javascript:void(0);">Admin  <span class="menu-arrow inside-submenu"></span></a>
                            <ul>
                                <li><a href="{{url('/annees/add')}}">Annees scolaires    </a></li>
                                <li><a href="{{url('/cycles/add')}}">Cycles   </a></li>
                                <li><a href="{{url('/niveaux/add')}}">Niveaux    </a></li>
                                <li><a href="{{url('/classes/add')}}">Classes     </a></li>
                                <li><a href="{{url('/utilisateurs/add')}}">Utilisateurs     </a></li>

                            </ul>
                        </li>


                    </ul>
                </li>


                <li class="submenu-open">
                    <h6 class="submenu-hdr">Communication </h6>
                    <ul>
                        <li class="submenu submenu-two"><a href="javascript:void(0);">Emails   <span class="menu-arrow inside-submenu"></span></a>
                            <ul>
                                <li><a href="{{url('/emails/relance')}}">Faire une relance    </a></li>
                                <li><a href="{{url('/emails/inbox')}}">Inbox    </a></li>
                                <li><a href="{{url('/emails/add')}}">Ecrire un email     </a></li>


                            </ul>
                        </li>


                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>


