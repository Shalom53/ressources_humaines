@extends('layout')

@section('title')
    DRH | Ajout Personnel
@endsection

@section('css')


@endsection




@section('contenu')

                <div class="content">


                    <div class="page-header">
                        <div class="add-item d-flex">
                            <div class="page-title">
                                <h4 class="fw-bold">Enregistrer un employé</h4>
                                <h6>Veuillez renseigner les informations demandées</h6>
                            </div>
                        </div>
                        <ul class="table-top-head">

                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i class="ti ti-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="page-btn mt-0">
                            <a href="product-list.html" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Retour</a>
                        </div>
                    </div>
                <form  action="{{ route('enregistrerPersonnel') }}" method="POST" enctype="multipart/form-data">
                         @csrf
                        <div class="add-product">
                            <div class="accordions-items-seperate" id="accordionSpacingExample">
                           <div class="accordion-item border mb-4">
                            <h2 class="accordion-header" id="headingPersonnel">
                                <div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#PersonnelForm" aria-expanded="true" aria-controls="PersonnelForm">
                                <div class="d-flex align-items-center justify-content-between flex-fill">
                                    <h5 class="d-flex align-items-center"><i data-feather="info" class="text-primary me-2"></i><span>Informations sur le personnel</span></h5>
                                </div>
                                </div>
                            </h2>
                            <div id="PersonnelForm" class="accordion-collapse collapse show" aria-labelledby="headingPersonnel">
                                <div class="accordion-body border-top">
                                <div class="row">
                                    <!-- Nom -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nom<span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" name="nom" required>
                                    </div>
                                    </div>
                                    <!-- Prénom -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Prénom<span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" name="prenom" required>
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Contact -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Contact<span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" name="contact" required>
                                    </div>
                                    </div>

                                    
                                    <!-- Poste -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Poste <span class="text-danger ms-1">*</span></label>
                                        <select class="form-control" name="poste_id" required>
                                        <option value="">-- Sélectionner un Poste --</option>
                                        @foreach($postes as $poste)
                                        <option value="{{ $poste->id }}">{{ $poste->nom }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    </div>
                               
                                </div>

                               
                                <div class="row">
                                    <!-- Nom Epoux/épouse -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nom du conjoint (époux/épouse)</label>
                                        <input type="text" class="form-control" name="nom_epoux_ou_epouse">
                                    </div>
                                    </div>
                                    <!-- Contact Epoux/épouse -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Contact du conjoint (époux/épouse)</label>
                                        <input type="text" class="form-control" name="contact_epoux_ou_epouse">
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Email -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email<span class="text-danger ms-1">*</span></label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    </div>
                                    <!-- Date de naissance -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Date de naissance<span class="text-danger ms-1">*</span></label>
                                        <input type="date" class="form-control" name="date_naissance" required>
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Lieu de naissance -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Lieu de naissance<span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" name="lieu_naissance" required>
                                    </div>
                                    </div>
                                    <!-- Préfecture de naissance -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Préfecture de naissance<span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" name="prefecture_naissance" required>
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Sexe -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Sexe<span class="text-danger ms-1">*</span></label>
                                        <select class="form-control" name="sexe" required>
                                        <option value="Masculin">Masculin</option>
                                        <option value="Féminin">Féminin</option>
                                        </select>
                                    </div>
                                    </div>
                                    <!-- Photo -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Photo</label>
                                        <input type="file" class="form-control" name="photo" accept="image/*">
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Quartier résidentiel -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Quartier résidentiel<span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" name="quartier_residentiel" required>
                                    </div>
                                    </div>
                                    <!-- Situation familiale -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Situation familiale<span class="text-danger ms-1">*</span></label>
                                        <select class="form-control" name="situation_familiale" required>
                                        <option value="Marié(e)">Marié(e)</option>
                                        <option value="Célibataire">Célibataire</option>
                                        <option value="Divorcé(e)">Divorcé(e)</option>
                                        <option value="Veuf(ve)">Veuf(ve)</option>
                                        </select>
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Nombre d'enfants -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre d'enfants</label>
                                        <input type="number" class="form-control" name="nombre_enfants" value="0" min="0">
                                    </div>
                                    </div>
                                    <!-- Situation agent -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Situation de l'agent<span class="text-danger ms-1">*</span></label>
                                        <select class="form-control" name="situation_agent" required>
                                        <option value="Permanent">Permanent</option>
                                        <option value="Vacataire">Vacataire</option>
                                        <option value="Stagiaire">Stagiaire</option>
                                        </select>
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Diplôme académique -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Diplôme académique le plus élevé<span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" name="diplome_academique_plus_eleve" required>
                                    </div>
                                    </div>
                                    <!-- Intitulé du diplôme -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Intitulé du diplôme<span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" name="intitule_diplome" required>
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Université d'obtention -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Université d'obtention<span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" name="universite_obtention" required>
                                    </div>
                                    </div>
                                    <!-- Année d'obtention du diplôme -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Année d'obtention du diplôme<span class="text-danger ms-1">*</span></label>
                                        <input type="number" class="form-control" name="annee_obtention_diplome" min="2000" max="2025" required>
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Diplôme professionnel -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Diplôme professionnel</label>
                                        <input type="text" class="form-control" name="diplome_professionnel">
                                    </div>
                                    </div>
                                    <!-- Lieu d'obtention du diplôme professionnel -->
                                    <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Lieu d'obtention du diplôme professionnel</label>
                                        <input type="text" class="form-control" name="lieu_obtention_diplome_professionnel">
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Date de prise de service -->
                                    <div class="col-lg-6 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Date de Prise de Service<span class="text-danger ms-1">*</span></label>
                                        <input type="date" class="form-control" name="date_prise_service" required>
                                    </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-12">
<div class="mb-3">
    <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
    <div class="input-group">
        <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
        <span class="input-group-text" onclick="togglePasswordVisibility()" style="cursor: pointer;">
            <i id="eyeIcon" class="fa fa-eye"></i>
        </span>
    </div>
</div>


                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>




                        <div class="accordion-item border mb-4">
                            <h2 class="accordion-header" id="headingSpacingTwo">
                                <div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingTwo" aria-expanded="true" aria-controls="SpacingTwo">
                                    <div class="d-flex align-items-center justify-content-between flex-fill">
                                        <h5 class="d-flex align-items-center">
                                            <i data-feather="users" class="text-primary me-2"></i>
                                            <span>Choix du Type de Personnel</span>
                                        </h5>
                                    </div>
                                </div>
                            </h2>

                            <div id="SpacingTwo" class="accordion-collapse collapse show" aria-labelledby="headingSpacingTwo">
                                <div class="accordion-body border-top">
                                    <div class="mb-3">
                                        <label class="form-label">Type de Personnel <span class="text-danger ms-1">*</span></label>
                                        <ul class="nav nav-pills mb-3" id="typePersonnelTabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="admin-tab" data-bs-toggle="pill" data-bs-target="#admin-form" type="button" role="tab" aria-controls="admin-form" aria-selected="true">
                                                    Personnel Administratif
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="enseignant-tab" data-bs-toggle="pill" data-bs-target="#enseignant-form" type="button" role="tab" aria-controls="enseignant-form" aria-selected="false">
                                                    Personnel Enseignant
                                                </button>
                                            </li>
                                        </ul>

                                        <!-- Champ caché pour transmettre le type de personnel sélectionné -->
                                        <input type="hidden" name="type_personnel" id="type_personnel_input" value="">

                                    </div>

                                    <div class="tab-content" id="typePersonnelTabsContent">
                                         <!-- Pour l'administratif -->
                                        <div class="tab-pane fade show active" id="admin-form" role="tabpanel" aria-labelledby="admin-tab">
                                            
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-6 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Fonction Occupée <span class="text-danger ms-1">*</span></label>
                                                        <input type="text" class="form-control" name="admin_fonction_occupee" placeholder="Fonction Occupée">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-6 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Service <span class="text-danger ms-1">*</span></label>
                                                        <input type="text" class="form-control" name="admin_service" placeholder="Service">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pour l'enseignant -->
                                        <div class="tab-pane fade" id="enseignant-form" role="tabpanel" aria-labelledby="enseignant-tab">
                                            
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-6 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Dominante <span class="text-danger ms-1">*</span></label>
                                                        <input type="text" class="form-control" name="enseignant_dominante" placeholder="Dominante">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-6 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Sous-Dominante</label>
                                                        <input type="text" class="form-control" name="enseignant_sous_dominante" placeholder="Sous-Dominante">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-6 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Volume Horaire <span class="text-danger ms-1">*</span></label>
                                                        <input type="number" class="form-control" name="enseignant_volume_horaire" placeholder="Volume Horaire">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-6 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Classe d'Intervention <span class="text-danger ms-1">*</span></label>
                                                        <input type="text" class="form-control" name="enseignant_classe_intervention" placeholder="Classe d'Intervention">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item border mb-4">
                        <h2 class="accordion-header" id="headingSpacingThree">
                            <div class="accordion-button collapsed bg-white" data-bs-toggle="collapse" data-bs-target="#SpacingThree" aria-expanded="true" aria-controls="SpacingThree">
                                <div class="d-flex align-items-center justify-content-between flex-fill">
                                    <h5 class="d-flex align-items-center">
                                        <i data-feather="user-check" class="text-primary me-2"></i> <!-- J'ai modifié l'icône pour correspondre à "personne à revenir" -->
                                        <span>Personne à Prévenir</span>
                                    </h5>
                                </div>
                            </div>
                        </h2>

                            <div id="SpacingThree" class="accordion-collapse collapse show" aria-labelledby="headingSpacingThree">
                                <div class="accordion-body border-top">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Nom<span class="text-danger ms-1">*</span></label>
                                                <input type="text" class="form-control" name="pp_nom" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Prénom<span class="text-danger ms-1">*</span></label>
                                                <input type="text" class="form-control" name="pp_prenom" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Profession<span class="text-danger ms-1">*</span></label>
                                                <input type="text" class="form-control" name="profession" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Lien de Parenté<span class="text-danger ms-1">*</span></label>
                                                <input type="text" class="form-control" name="pp_lien_parente" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Adresse<span class="text-danger ms-1">*</span></label>
                                                <input type="text" class="form-control" name="pp_adresse" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Contact<span class="text-danger ms-1">*</span></label>
                                                <input type="text" class="form-control" name="pp_contact" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <button type="button" class="btn btn-secondary me-2">Cancel</button>
                                <button type="submit" >Enregistrer</button>
                            </div>
                        </div>
                </form>
                </div>
                




@endsection

@section('js')

<!-- ApexChart JS -->
<script src="{{asset('admin')}}/assets/plugins/apexchart/apexcharts.min.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>
<script src="{{asset('admin')}}/assets/plugins/apexchart/chart-data.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>

<!-- Chart JS -->
<script src="{{asset('admin')}}/assets/plugins/chartjs/chart.min.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>
<script src="{{asset('admin')}}/assets/plugins/chartjs/chart-data.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>

<!-- Daterangepikcer JS -->
<script src="{{asset('admin')}}/assets/js/moment.min.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>
<script src="{{asset('admin')}}/assets/plugins/daterangepicker/daterangepicker.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>

<!-- Select2 JS -->
<script src="{{asset('admin')}}/assets/plugins/select2/js/select2.min.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>

<!-- Color Picker JS -->
<script src="{{asset('admin')}}/assets/plugins/%40simonwep/pickr/pickr.es5.min.js" type="971c37a9497d43b5d76f2274-text/javascript"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeInput = document.getElementById('type_personnel_input');
        const adminTab = document.getElementById('admin-tab');
        const enseignantTab = document.getElementById('enseignant-tab');

        // Par défaut : administratif
        typeInput.value = 'administratif';

        // Mise à jour dynamique du type de personnel
        adminTab.addEventListener('click', () => {
            typeInput.value = 'administratif';
        });

        enseignantTab.addEventListener('click', () => {
            typeInput.value = 'enseignant';
        });

        // Au moment de la soumission du formulaire
        const form = document.querySelector('form');
        form.addEventListener('submit', function (e) {
            if (typeInput.value === 'administratif') {
                // Désactiver les champs enseignants
                document.querySelectorAll('#enseignant-form :input').forEach(input => input.disabled = true);
            } else if (typeInput.value === 'enseignant') {
                // Désactiver les champs administratifs
                document.querySelectorAll('#admin-form :input').forEach(input => input.disabled = true);
            }

            // Si aucun type sélectionné (sécurité)
            if (!typeInput.value) {
                alert("Veuillez sélectionner un type de personnel.");
                e.preventDefault();
            }
        });
    });
</script>


<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('mot_de_passe');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>


@endsection