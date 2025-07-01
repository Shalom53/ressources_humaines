


@extends('layout')

@section('title')

DRH | Fiche d'employé

@endsection

@section('css')



    <link href="{{asset('app/css/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />


@endsection

@section('contenu')
    <div class="container">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('ListeDuPersonnel') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-arrow-left-circle"></i> Retour à la liste
            </a>
        </div>
        @php
            // Vérifie si la photo existe physiquement dans le stockage
            $photoPath = 'storage/' . $personnel->photo;
            $photoExiste = $personnel->photo && file_exists(public_path($photoPath));

            // Choix de l'image selon le sexe si aucune photo personnalisée
            $imageDefaut = $personnel->sexe === 'Féminin'
                ? asset('RessourcesHumaines/demande/img/femme.png')
                : asset('RessourcesHumaines/demande/img/homme.png');
        @endphp

        <h2 class="mb-4 d-flex align-items-center gap-3">
            Fiche de l'employé : {{ $personnel->nom }} {{ $personnel->prenom }}

            <img 
                src="{{ $photoExiste ? asset($photoPath) : $imageDefaut }}" 
                alt="Photo de {{ $personnel->prenom }}" 
                class="rounded-circle" 
                style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #ccc;">
        </h2>



        <!-- Onglets -->
        <ul class="nav nav-tabs" id="personnelTab" role="tablist" style="flex-wrap: wrap; gap: 0.5rem 1rem;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#infoPerso" type="button" role="tab">
                    <i class="ti ti-user me-1"></i> Informations personnelles
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#coordonnees" type="button" role="tab">
                    <i class="ti ti-map-pin me-1"></i> Coordonnées
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#professionnel" type="button" role="tab">
                    <i class="ti ti-briefcase me-1"></i> Professionnel
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#contrat" type="button" role="tab">
                    <i class="ti ti-file-text me-1"></i> Contrat
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#salaire" type="button" role="tab">
                    <i class="ti ti-currency-dollar me-1"></i> Rémunération
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#diplomes" type="button" role="tab">
                    <i class="ti ti-award me-1"></i> Diplômes & Formations
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#experience" type="button" role="tab">
                    <i class="ti ti-calendar-event me-1"></i> Congés et absences
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab">
                    <i class="ti ti-folder me-1"></i> Documents
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#suivi" type="button" role="tab">
                    <i class="ti ti-clock me-1"></i> Présences et Pointage
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#acces" type="button" role="tab">
                    <i class="ti ti-building me-1"></i> Carrière à l'école international MARIAM
                </button>
            </li>
        </ul>


        <!-- Contenu des onglets -->
        <div class="tab-content p-3 border border-top-0" id="personnelTabContent">
            <!-- Onglet Informations personnelles -->
            <div class="tab-pane fade show active" id="infoPerso" role="tabpanel">
                <div class="row">
                    <!-- Colonne gauche : Informations personnelles -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mt-3">
                            <div class="card-body">
                                <h6 class="text-primary mb-3">Informations personnelles</h6>

                                <p><strong><i class="ti ti-user me-1 text-dark"></i> Nom :</strong> {{ $personnel->nom }}</p>
                                <p><strong><i class="ti ti-user me-1 text-dark"></i> Prénom :</strong> {{ $personnel->prenom }}</p>
                                @php
                                    \Carbon\Carbon::setLocale('fr');
                                    $dateNaissance = $personnel->date_naissance 
                                        ? \Carbon\Carbon::parse($personnel->date_naissance)->translatedFormat('l j F Y')
                                        : null;
                                @endphp
                                <p>
                                    <strong><i class="ti ti-calendar me-1 text-info"></i> Date de naissance :</strong> 
                                    {{ $dateNaissance ? mb_convert_case($dateNaissance, MB_CASE_TITLE, "UTF-8") : 'N/A' }}
                                </p>
                                <p><strong><i class="ti ti-map-pin me-1 text-danger"></i> Lieu de naissance :</strong> {{ $personnel->lieu_naissance ?? 'N/A' }}</p>
                                <p><strong><i class="ti ti-gender-bigender me-1 text-primary"></i> Sexe :</strong> {{ $personnel->sexe }}</p>
                                <p><strong><i class="ti ti-flag me-1 text-warning"></i> Nationalité :</strong> {{ $personnel->nationalite ?? 'N/A' }}</p>
                                <p><strong><i class="ti ti-heart me-1 text-danger"></i> Situation familiale :</strong> {{ $personnel->situation_familiale }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Colonne droite : Conjoint et personne à prévenir -->
                    <div class="col-md-6">
                        @if($personnel->situation_familiale === 'Marié(e)')
                            <div class="card shadow-sm border-0 mt-3">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">Informations sur le conjoint</h6>

                                    <p><strong><i class="ti ti-user-heart me-1 text-danger"></i> Nom du conjoint :</strong> {{ $personnel->nom_epoux_ou_epouse ?? 'N/A' }}</p>
                                    <p><strong><i class="ti ti-phone me-1 text-success"></i> Contact du conjoint :</strong> {{ $personnel->contact_epoux_ou_epouse ?? 'N/A' }}</p>
                                </div>
                            </div>
                        @endif

                        @if($personnel->personneAPrevenir)
                            <div class="card shadow-sm border-0 mt-3">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">Personne à prévenir</h6>

                                    <p><strong><i class="ti ti-user-exclamation me-1 text-warning"></i> Nom :</strong> {{ $personnel->personneAPrevenir->nom ?? 'N/A' }}</p>
                                    <p><strong><i class="ti ti-user-exclamation me-1 text-warning"></i> Prénom :</strong> {{ $personnel->personneAPrevenir->prenom ?? 'N/A' }}</p>
                                    <p><strong><i class="ti ti-map-pin me-1 text-danger"></i> Adresse :</strong> {{ $personnel->personneAPrevenir->adresse ?? 'N/A' }}</p>
                                    <p><strong><i class="ti ti-phone me-1 text-success"></i> Contact :</strong> {{ $personnel->personneAPrevenir->contact ?? 'N/A' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>







            <!-- Coordonnées -->
            <div class="tab-pane fade" id="coordonnees" role="tabpanel">
                <div class="row">
                    <!-- Colonne gauche : Coordonnées -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mt-3">
                            <div class="card-body">
                                <h6 class="text-primary mb-3">Coordonnées</h6>

                                <p>
                                    <strong><i class="ti ti-map-pin me-1 text-danger"></i> Adresse :</strong> 
                                    {{ $personnel->quartier_residentiel ?? 'N/A' }}
                                </p>

                                <p>
                                    <strong><i class="ti ti-phone me-1 text-success"></i> Téléphone :</strong> 
                                    {{ $personnel->contact ?? 'N/A' }}
                                </p>

                                <p>
                                    <strong><i class="ti ti-mail me-1 text-info"></i> Email :</strong> 
                                    {{ $personnel->email ?? 'N/A' }}
                                </p>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Informations professionnelles -->
            <div class="tab-pane fade" id="professionnel" role="tabpanel">
                    <div class="row">
                    <!-- Colonne gauche : Coordonnées -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mt-3">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">Informations professionnelles</h6>

                                    <div class="row align-items-center mb-3">
                                        <!-- Matricule avec style -->
                                        <div class="col-auto">
                                            <div class="alert alert-secondary py-2 px-3 d-inline-block fw-bold mb-0">
                                                <i class="bi bi-upc-scan"></i> Matricule : <span class="text-uppercase">{{ $personnel->matricule ?? 'N/A' }}</span>
                                            </div>
                                        </div>

                                        <!-- Poste avec style -->
                                        <div class="col-auto">
                                            @if($personnel->enseignant)
                                                <div class="alert alert-info py-2 px-3 d-inline-block fw-bold mb-0">
                                                    <i class="bi bi-person-badge"></i> Poste : <span class="text-uppercase">Enseignant</span>
                                                </div>
                                            @elseif($personnel->administratif)
                                                <div class="alert alert-warning py-2 px-3 d-inline-block fw-bold mb-0">
                                                    <i class="bi bi-briefcase"></i> Poste : <span class="text-uppercase">Personnel administratif</span>
                                                </div>
                                            @else
                                                <div class="alert alert-light py-2 px-3 d-inline-block fw-bold mb-0 text-muted">
                                                    Poste : <span class="text-uppercase">Non renseigné</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    </div>
                                    <!-- Autres infos professionnelles -->
                                    <div>
                                        @if($personnel->enseignant)
                                            <p>
                                                <strong><i class="ti ti-book-2 me-1 text-primary"></i> Dominante :</strong> 
                                                {{ $personnel->enseignant->dominante ?? 'N/A' }}
                                            </p>
                                            <p>
                                                <strong><i class="ti ti-book me-1 text-secondary"></i> Sous-dominante :</strong> 
                                                {{ $personnel->enseignant->sous_dominante ?? 'N/A' }}
                                            </p>
                                            <p>
                                                <strong><i class="ti ti-clock-hour-5 me-1 text-success"></i> Volume horaire :</strong> 
                                                {{ $personnel->enseignant->volume_horaire ?? 'N/A' }}
                                            </p>
                                            <p>
                                                <strong><i class="ti ti-users me-1 text-info"></i> Classe d'intervention :</strong> 
                                                {{ $personnel->enseignant->classe_intervention ?? 'N/A' }}
                                            </p>

                                        @elseif($personnel->administratif)
                                            <p>
                                                <strong><i class="ti ti-briefcase me-1 text-warning"></i> Fonction occupée :</strong> 
                                                {{ $personnel->administratif->fonction_occupee ?? 'N/A' }}
                                            </p>
                                            <p>
                                                <strong><i class="ti ti-building me-1 text-secondary"></i> Département :</strong> 
                                                {{ $personnel->administratif->service ?? 'N/A' }}
                                            </p>

                                        @else
                                            <p class="text-muted">
                                                <i class="ti ti-info-circle me-1"></i> Aucune donnée professionnelle enregistrée.
                                            </p>
                                        @endif
                                    </div>

                                </div>
                        </div>
                    </div>
            </div>



            <!-- Contrat -->
            <div class="tab-pane fade" id="contrat" role="tabpanel">
                <div class="card shadow-sm border-0 mt-3">
                    <div class="card-body">




                        @php
                            $contrat = $dernierContrat ?? null;


                            $anciennete = null;
                            $tempsRestant = null;
                            $pourcentage = null;

                            if ($contrat) {
                                $debut = \Carbon\Carbon::parse($contrat->date_debut);
                                $now = \Carbon\Carbon::now();

                                // Ancienneté
                                $moisTotal = $debut->diffInMonths($now);
                                $ans = floor($moisTotal / 12);
                                $moisRestants = $moisTotal % 12;

                                if ($moisTotal < 1) {
                                    $anciennete = $debut->diffInDays($now) . ' jour(s)';
                                } elseif ($moisTotal < 12) {
                                    $anciennete = $moisTotal . ' mois';
                                } else {
                                    $anciennete = $ans . ' an(s)' . ($moisRestants > 0 ? ' et ' . $moisRestants . ' mois' : '');
                                }

                                // Temps restant
                                if ($contrat->date_fin) {
                                    $fin = \Carbon\Carbon::parse($contrat->date_fin);
                                    $moisRestants = $now->diffInMonths($fin, false);
                                    $joursRestants = $now->diffInDays($fin, false);

                                    if ($joursRestants < 0) {
                                        $tempsRestant = 'Expiré depuis ' . abs($joursRestants) . ' jour(s)';
                                    } elseif ($moisRestants < 1) {
                                        $tempsRestant = $joursRestants . ' jour(s)';
                                    } elseif ($moisRestants < 12) {
                                        $tempsRestant = $moisRestants . ' mois';
                                    } else {
                                        $ansRestants = floor($moisRestants / 12);
                                        $mois = $moisRestants % 12;
                                        $tempsRestant = $ansRestants . ' an(s)' . ($mois > 0 ? ' et ' . $mois . ' mois' : '');
                                    }

                                    // Progression
                                    $joursEcoules = $debut->diffInDays($now);
                                    $dureeTotale = $debut->diffInDays($fin);
                                    $pourcentage = $dureeTotale > 0 ? round(($joursEcoules / $dureeTotale) * 100) : null;
                                }
                            }
                        @endphp
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-primary m-0">Informations sur le contrat</h6>

                            @if(!$contrat)
                                <button type="button"
                                    class="btn btn-sm btn-outline-success"
                                    onclick="ouvrirModalContrat('ajout', {{ $personnel->id }})">
                                    <i class="ti ti-plus me-1"></i> Ajouter Contrat
                                </button>
                            @elseif(str_contains(strtolower($tempsRestant), 'expiré'))
                                <button type="button"
                                    class="btn btn-sm btn-outline-warning"
                                    onclick="confirmerRenouvellement({{ $personnel->id }}, {{ $contrat->id }})">
                                    <i class="ti ti-refresh me-1"></i> Renouveler le contrat
                                </button>


                            @else
                                <button type="button"
                                    class="btn btn-sm btn-outline-primary"
                                    onclick="ouvrirModalContrat('modification', {{ $personnel->id }}, {{ $contrat->id }})">
                                    <i class="ti ti-edit me-1"></i> Éditer le contrat
                                </button>

                            @endif
                        </div>



                        @if($contrat)
                            <div class="row">
                                <!-- Colonne gauche -->
                                <div class="col-md-6">


                                    <div class="row">
                                        <!-- Type -->
                                        <div class="col-6 d-flex align-items-center">
                                            @php
                                                $typeClass = match(strtolower($contrat->type)) {
                                                    'cdi' => 'text-success',
                                                    'cdd' => 'text-primary',
                                                    'stage' => 'text-warning',
                                                    default => 'text-secondary',
                                                };
                                            @endphp
                                            <strong><i class="ti ti-clipboard-text me-1"></i> Type :</strong>
                                            <span class="ms-1 {{ $typeClass }}">{{ $contrat->type }}</span>
                                        </div>

                                        <!-- Durée -->
                                        <div class="col-6 d-flex align-items-center">
                                            <strong><i class="ti ti-timer me-1"></i> Durée :</strong>
                                            <span class="ms-1 duree-texte">{{ $contrat->Dure ?? 'N/A' }}</span>
                                        </div>
                                    </div>



                                    {{-- Date de début --}}
                                    <p><strong><i class="ti ti-calendar-event me-1"></i> Date de début :</strong> {{ $debut->format('d/m/Y') }}</p>

                                    {{-- Date de fin --}}
                                    <p><strong><i class="ti ti-calendar-time me-1"></i> Date de fin :</strong> 
                                        {{ $contrat->date_fin 
                                            ? \Carbon\Carbon::parse($contrat->date_fin)->format('d/m/Y') 
                                            : ($contrat->type === 'CDI' ? 'Indéterminée' : 'N/A') }}
                                    </p>

                                    {{-- Ancienneté --}}
                                    <p><strong><i class="ti ti-hourglass-empty me-1"></i> Ancienneté :</strong> <span class="text-info">{{ $anciennete }}</span></p>

                                    {{-- Temps restant --}}
                                    @php
                                        $tempsRestantClass = str_contains($tempsRestant, 'Expiré') ? 'text-danger' : 'text-success';
                                    @endphp
                                    <p><strong><i class="ti ti-clock me-1"></i> Temps restant :</strong> <span class="{{ $tempsRestantClass }}">{{ $tempsRestant ?? 'Non défini' }}</span></p>

                                    {{-- Salaire --}}
                                    <p><strong><i class="ti ti-currency-dollar me-1"></i> Salaire :</strong> <span class="text-primary">{{ $contrat->salaire ?? 'N/A' }} FCFA</span></p>

                                    {{-- Description --}}
                                    <p><strong><i class="ti ti-info-circle me-1"></i> Description :</strong> {{ $contrat->description ?? 'N/A' }}</p>
                                </div>



                                <!-- Colonne droite -->
                                <div class="col-md-6">
                                    {{-- Statut avec badge coloré --}}
                                    @php
                                        $statut = strtolower($contrat->statut);
                                        $classStatut = match ($statut) {
                                            'actif' => 'text-success',
                                            'expiré', 'expire' => 'text-danger',
                                            'suspendu' => 'text-warning',
                                            default => 'text-secondary'
                                        };

                                        $statutIcon = match ($statut) {
                                            'actif' => 'ti ti-check-circle',
                                            'expiré', 'expire' => 'ti ti-alert-circle',
                                            'suspendu' => 'ti ti-pause-circle',
                                            default => 'ti ti-info-circle'
                                        };
                                    @endphp

                                    <p>
                                        <strong><i class="{{ $statutIcon }} me-1"></i> Statut :</strong>
                                        <span class="{{ $classStatut }}">{{ ucfirst($contrat->statut) }}</span>
                                    </p>

                                    {{-- Lien fichier avec icônes --}}
                                    <div class="d-flex align-items-center">
                                        <strong class="me-2 text-primary">
                                            <i class="ti ti-folder me-1"></i> Fichier :
                                        </strong>

                                        @if($contrat->fichier)
                                            <i class="ti ti-file-text text-info me-2"></i>
                                            <a href="{{ route('contrats.telecharger', $contrat->id) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                                <i class="ti ti-download me-1"></i> Télécharger
                                            </a>
                                        @else
                                            <span class="text-muted">Aucun fichier</span>
                                        @endif
                                    </div>


                                    {{-- Progression --}}
                                    @if($pourcentage !== null)
                                        <p><strong><i class="ti ti-progress me-1"></i> Progression du contrat :</strong> {{ $pourcentage }}%</p>
                                        <div class="progress mb-2">
                                            <div class="progress-bar bg-info" style="width: {{ $pourcentage }}%;" role="progressbar" aria-valuenow="{{ $pourcentage }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ $pourcentage }}%
                                            </div>
                                        </div>
                                    @endif
                                </div>


                            </div>
                        @else
                            <p class="text-muted">Aucun contrat enregistré.</p>
                        @endif
                    </div>
                </div>
            </div>


            <!-- Documents -->
            <div class="tab-pane fade" id="documents" role="tabpanel">
                <div class="row">
                    <!-- Colonne gauche : Documents -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mt-3">
                            <div class="card-body">
                                <!-- Titre avec bouton + -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="text-primary mb-0">Documents</h6>
                                    <button id="ouvrirAjouterDocument" class="btn btn-sm btn-outline-success ajouter-document"
                                            data-personnel-id="{{ $personnel->id }}">
                                        <i class="ti ti-plus"></i> Ajouter
                                    </button>


                                </div>

                                @if($personnel->documents->isEmpty())
                                    <p class="text-muted">Aucun document disponible.</p>
                                @else
                                    <ul class="list-group">
                                        @foreach($personnel->documents as $doc)
                                            <li class="list-group-item d-flex align-items-center justify-content-between">
                                                <span>
                                                    <strong>
                                                        <i class="ti ti-file-text me-2 text-primary"></i> 
                                                        {{ $doc->libelle ?? 'Document' }}
                                                    </strong>
                                                </span>
                                                <div class="d-flex align-items-center gap-2">
                                                    <a href="{{ route('document.telecharger', $doc->id) }}" class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                                        Télécharger <i class="ti ti-download ms-1"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modifierDocumentModal_{{ $doc->id }}">
                                                        <i class="ti ti-edit"></i>
                                                    </button>
                                                </div>
                                            </li>



                                            

                                            <!-- Modal de modification pour ce document -->

                                        @endforeach
                                    </ul>
                                @endif
                                                <!-- Modal d'ajout de document -->
                                    <div class="modal fade" id="ajouterDocumentModal" tabindex="-1" aria-labelledby="ajouterDocumentLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('documents.ajouter') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="personnel_id" id="modal_personnel_id">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ajouterDocumentLabel">Ajouter un document</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="libelle" class="form-label">Libellé</label>
                                                    <input type="text" class="form-control" name="libelle" id="libelle" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fichier" class="form-label">Fichier</label>
                                                    <input type="file" class="form-control" name="fichier" id="fichier" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Ajouter</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            </div>
                                            </div>
                                        </form>
                                    </div>
                                    </div>

                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div>





            <!-- Rémunération -->
            <div class="tab-pane fade" id="salaire" role="tabpanel">
                <div class="row">
                    <!-- Partie Salaire principal -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mt-3">
                        @php
                            $salaireBrut = $personnel->remuneration->salaire_brut ?? null;

                            if (!$salaireBrut && $personnel->contrats->count()) {
                                $dernierContrat = $personnel->contrats->sortByDesc(function ($contrat) {
                                    return $contrat->updated_at > $contrat->created_at ? $contrat->updated_at : $contrat->created_at;
                                })->first();
                                $salaireBrut = $dernierContrat->salaire ?? null;
                            }

                            if (!$salaireBrut && $personnel->poste) {
                                if ($personnel->administratif) {
                                    $salaireBrut = $personnel->poste->salaire_base ?? null;
                                } elseif ($personnel->enseignant) {
                                    $salaireBrut = $personnel->poste->salaire_horaire ?? null;
                                }
                            }

                            $salaireBrut = $salaireBrut ?? 0;
                        @endphp

                        <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="text-primary mb-3">Salaire</h6>

                                        @if(optional($personnel->remuneration)->salaire_brut)
                                            <!-- Si le salaire existe, bouton modifier -->
                                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalDefinirSalaire">
                                                Modifier le salaire
                                            </button>
                                        @else
                                            <!-- Si aucun salaire, bouton définir -->
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalDefinirSalaire">
                                                Définir le salaire
                                            </button>
                                        @endif
                                    </div>

                                    <input type="hidden" id="salaire_brut_cache" value="{{ $salaireBrut }}">

                                    <p><strong>Salaire brut :</strong> {{ number_format($salaireBrut, 0, ',', ' ') }} FCFA</p>
                                    <p><strong>Total primes :</strong> <span id="total-primes">0 FCFA</span></p>

                                    <p><strong>Total retenues :</strong> <span id="total-retenues">0 FCFA</span></p>
                                    <p><strong>Salaire net :</strong> <span id="salaire-net">0 FCFA</span></p>
                        </div>

                        <!-- Modale Bootstrap pour définir le salaire -->
                        <div class="modal fade" id="modalDefinirSalaire" tabindex="-1" aria-labelledby="modalDefinirSalaireLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <form id="formDefinirSalaire" method="POST" action="{{ route('remunerations.store') }}">

                                @csrf
                                <input type="hidden" name="personnel_id" value="{{ $personnel->id }}">
                                <input type="hidden" id="remuneration_id" name="remuneration_id" value="{{ optional($personnel->remuneration)->id }}">
                                <div class="modal-header">
                                <h5 class="modal-title" id="modalDefinirSalaireLabel">Définir le salaire brut</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                </div>
                                <div class="modal-body">
                                <div class="mb-3">
                                    <label for="salaire_brut" class="form-label">Salaire brut (FCFA)</label>
                                    <input type="number" step="0.01" min="0" class="form-control" name="salaire_brut" id="salaire_brut" placeholder="Exemple : 150000" required>
                                </div>
                                </div>
                                <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                </div>
                            </form>
                            </div>
                        </div>
                        </div>

                        </div>
                    </div>






                    <!-- Partie Primes -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mt-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-primary mb-3">Primes</h6>
                                <!-- Bouton pour ouvrir la modale -->
                                <button type="button" class="btn btn-primary float-end" id="btnAddPrime">
                                    Ajouter prime
                                </button>
                                </div>
                                <!-- Modale Bootstrap -->
                                <div class="modal fade" id="modalAddPrime" tabindex="-1" aria-labelledby="modalAddPrimeLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <form id="formAddPrime" method="POST" action="{{ route('primes.store') }}">
                                        @csrf
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="modalAddPrimeLabel">Ajouter une prime</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                        <input type="hidden" name="remuneration_id" value="{{ optional($personnel->remuneration)->id }}">
                                        <div class="mb-3">
                                            <label for="libelle" class="form-label">Libellé</label>
                                            <input type="text" class="form-control" name="libelle" id="libelle" placeholder="Libellé de la prime">
                                        </div>
                                        <div class="mb-3">
                                            <label for="periode" class="form-label">Période</label>
                                            <input type="text" class="form-control" name="periode" id="periode" placeholder="Ex: 1 mois, 2 mois, indéterminé">
                                        </div>
                                        <div class="mb-3">
                                            <label for="montant" class="form-label">Montant (FCFA)</label>
                                            <input type="number" step="0.01" class="form-control" name="montant" id="montant" placeholder="Montant de la prime">
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Enregistrer</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>

                                <ul class="list-group">
                                    @if(optional($personnel->remuneration)->primes && $personnel->remuneration->primes->count() > 0)
                                        @foreach($personnel->remuneration->primes as $prime)
                                            <li class="list-group-item d-flex justify-content-between align-items-center prime-item" 
                                                data-montant="{{ $prime->montant ?? 0 }}"
                                                data-periode="{{ $prime->periode ?? 'indéterminée' }}"
                                                data-date="{{ optional($prime->created_at)->format('Y-m-d') ?? '' }}"
                                                data-etat="{{ $prime->etat }}">
                                                <div>
                                                    {{ $prime->libelle ?? 'Sans libellé' }} : 
                                                    {{ number_format($prime->montant ?? 0, 0, ',', ' ') }} FCFA
                                                    <span class="text-muted small">(période : {{ $prime->periode ?? 'indéterminée' }})</span>
                                                </div>
                                                <div class="btn-group btn-group-sm">
                                                          <!-- Bouton Modifier -->
                                                    <button class="btn btn-outline-primary btn-sm"
                                                        title="Modifier"
                                                        onclick="modifierPrime(this)"
                                                        data-id="{{ $prime->id }}"
                                                        data-libelle="{{ $prime->libelle }}"
                                                        data-periode="{{ $prime->periode }}"
                                                        data-montant="{{ $prime->montant }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>

                                                        <!-- Bouton Supprimer -->
                                                    <button class="btn btn-outline-danger btn-sm" title="Supprimer" onclick="supprimerPrime({{ $prime->id }})">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </li>
                                        @endforeach

                                    @else
                                        <li class="list-group-item text-muted">Aucune prime enregistrée</li>
                                    @endif
                                                <!-- Modale de modification -->
                                    <div class="modal fade" id="modalEditPrime" tabindex="-1" aria-labelledby="modalEditPrimeLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form id="formEditPrime" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalEditPrimeLabel">Modifier une prime</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="prime_id" id="edit_prime_id">
                                                        <div class="mb-3">
                                                            <label for="edit_libelle_prime" class="form-label">Libellé</label>
                                                            <input type="text" class="form-control" name="libelle" id="edit_libelle_prime" placeholder="Libellé de la prime">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_periode_prime" class="form-label">Période</label>
                                                            <input type="text" class="form-control" name="periode" id="edit_periode_prime" placeholder="Ex: 1 mois, 2 mois, indéterminé">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_montant_prime" class="form-label">Montant (FCFA)</label>
                                                            <input type="number" step="0.01" class="form-control" name="montant" id="edit_montant_prime" placeholder="Montant de la prime">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Mettre à jour</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        
                    </div>


                    <!-- Partie Billetage et Banque -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mt-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary mb-3">Billetage & Banque</h6>

                                    @if(($personnel->billetage && $personnel->billetage->statut === 'actif') || ($personnel->banque && $personnel->banque->etat == 1))
                                        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#changerMoyenModal">
                                            Changer le moyen de versement
                                        </button>
                                    @endif
                                </div>


                                @if($personnel->billetage && $personnel->billetage->statut === 'actif')
                                    {{-- Billetage actif trouvé --}}
                                    <p>
                                        <strong>Employé enregistré au billetage</strong>
                                    </p>
                                @elseif($personnel->banque && $personnel->banque->etat == 1)
                                    {{-- Sinon, vérifier la banque --}}
                                    <p><strong>Banque :</strong> {{ $personnel->banque->nom ?? 'N/A' }}</p>
                                    <p><strong>Numéro de compte :</strong> {{ $personnel->banque->numero_compte ?? 'N/A' }}</p>
                                @else
                                    {{-- Aucun des deux --}}
                                    <p class="text-muted">Veillez choisir un moyen de versement.</p>

                                    <!-- Select visible seulement si aucun mode défini -->
                                    <div class="form-group mt-3">
                                        <label for="type_financement">Choisir un mode :</label>
                                        <select id="type_financement" class="form-control" required>
                                            <option value="">-- Sélectionner --</option>
                                            <option value="billetage">Billetage</option>
                                            <option value="banque">Banque</option>
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>



                    <!-- Formulaire pour billetage -->
                    <form id="form-billetage" action="{{ route('personnel.choisir.financement', $personnel->id) }}" method="POST" style="display:none;">
                        @csrf
                        <input type="hidden" name="type_financement" value="billetage">
                    </form>

                    <!-- Modal Bootstrap pour Banque -->
                    <div class="modal fade" id="banqueModal" tabindex="-1" aria-labelledby="banqueModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('personnel.choisir.financement', $personnel->id) }}">
                                @csrf
                                <input type="hidden" name="type_financement" value="banque">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="banqueModalLabel">Informations Bancaires</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="nom_banque" class="form-label">Nom de la banque</label>
                                            <input type="text" class="form-control" name="nom" id="nom_banque" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="numero_compte" class="form-label">Numéro de compte</label>
                                            <input type="text" class="form-control" name="numero_compte" id="numero_compte" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Changer le moyen -->
                    <div class="modal fade" id="changerMoyenModal" tabindex="-1" aria-labelledby="changerMoyenModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('personnel.choisir.financement', $personnel->id) }}">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="changerMoyenModalLabel">Changer le moyen de versement</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="nouveau_type_financement" class="form-label">Nouveau mode de versement</label>
                                        <select id="nouveau_type_financement" name="type_financement" class="form-select" required>
                                            <option value="">-- Sélectionner --</option>
                                            <option value="billetage">Billetage</option>
                                            <option value="banque">Banque</option>
                                        </select>

                                        <div id="formulaire-banque-fields" style="display: none;" class="mt-3">
                                            <div class="mb-3">
                                                <label class="form-label">Nom de la banque</label>
                                                <input type="text" class="form-control" name="nom" id="changer_nom_banque">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Numéro de compte</label>
                                                <input type="text" class="form-control" name="numero_compte" id="changer_numero_compte">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>








                    <!-- Partie Retenues -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mt-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-danger mb-3">Retenues</h6>
                                    <!-- Bouton pour ouvrir la modale -->
                                <button type="button" class="btn btn-primary float-end" id="btnAddRetenue">
                                    Ajouter Retenue
                                </button>
                                </div>
                                <!-- Modale Bootstrap -->
                                <div class="modal fade" id="modalAddRetenue" tabindex="-1" aria-labelledby="modalAddRetenueLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <form id="formAddRetenue" method="POST" action="{{ route('retenue.store') }}">
                                        @csrf
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="modalAddRetenueLabel">Ajouter une retenue</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                        <input type="hidden" name="remuneration_id" value="{{ optional($personnel->remuneration)->id }}">
                                        <div class="mb-3">
                                            <label for="libelle" class="form-label">Libellé</label>
                                            <input type="text" class="form-control" name="libelle" id="libelle" placeholder="Libellé de la retenue">
                                        </div>
                                        <div class="mb-3">
                                            <label for="periode" class="form-label">Période</label>
                                            <input type="text" class="form-control" name="periode" id="periode" placeholder="Ex: 1 mois, 2 mois, indéterminé">
                                        </div>
                                        <div class="mb-3">
                                            <label for="montant" class="form-label">Montant (FCFA)</label>
                                            <input type="number" step="0.01" class="form-control" name="montant" id="montant" placeholder="Montant de la retenue">
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Enregistrer</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                                <ul class="list-group">
                                    @if(optional($personnel->remuneration)->retenues && $personnel->remuneration->retenues->where('etat', 1)->count() > 0)
                                        @foreach($personnel->remuneration->retenues->where('etat', 1) as $r)
                                        <li class="list-group-item d-flex justify-content-between align-items-center retenue-item" 
                                            data-montant="{{ $r->montant ?? 0 }}" 
                                            data-pourcentage="{{ $r->pourcentage ?? 0 }}"
                                            data-periode="{{ $r->periode ?? 'indéterminée' }}"
                                            data-date="{{ $r->created_at }}"
                                            data-etat="{{ $r->etat }}">

                                            <div>
                                                {{ $r->libelle ?? 'Sans libellé' }} : 
                                                {{ $r->montant !== null 
                                                    ? number_format($r->montant, 0, ',', ' ') . ' FCFA' 
                                                    : '( ' . ($r->pourcentage ?? 0) . '% )' 
                                                }}
                                                <span class="text-muted small">(période : {{ $r->periode ?? 'indéterminée' }})</span>
                                            </div>

                                            <div class="btn-group btn-group-sm">
                                                <!-- Bouton Modifier -->
                                                <button class="btn btn-outline-primary btn-sm"
                                                    title="Modifier"
                                                    onclick="modifierRetenue(this)"
                                                    data-id="{{ $r->id }}"
                                                    data-libelle="{{ $r->libelle }}"
                                                    data-periode="{{ $r->periode }}"
                                                    data-montant="{{ $r->montant }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <!-- Bouton Supprimer -->
                                                <button class="btn btn-outline-danger btn-sm" title="Supprimer" onclick="supprimerRetenue({{ $r->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </li>
                                        @endforeach
                                    @else
                                        <li class="list-group-item text-muted">Aucune retenue enregistrée</li>
                                    @endif

                                            <!-- Modale de modification -->
                                    <div class="modal fade" id="modalEditRetenue" tabindex="-1" aria-labelledby="modalEditRetenueLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form id="formEditRetenue" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalEditRetenueLabel">Modifier une retenue</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="retenue_id" id="edit_retenue_id">
                                                        <div class="mb-3">
                                                            <label for="edit_libelle" class="form-label">Libellé</label>
                                                            <input type="text" class="form-control" name="libelle" id="edit_libelle" placeholder="Libellé de la retenue">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_periode" class="form-label">Période</label>
                                                            <input type="text" class="form-control" name="periode" id="edit_periode" placeholder="Ex: 1 mois, 2 mois, indéterminé">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_montant" class="form-label">Montant (FCFA)</label>
                                                            <input type="number" step="0.01" class="form-control" name="montant" id="edit_montant" placeholder="Montant de la retenue">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Mettre à jour</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </ul>

                            </div>
                        </div>
                    </div>


                </div>
            </div>


            <!-- Diplômes -->
            <div class="tab-pane fade" id="diplomes" role="tabpanel">
                <div class="row">
                    <!-- Colonne gauche : Diplôme académique -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mt-3">
                            <div class="card-body">
                                <h6 class="text-primary mb-3">Diplôme académique</h6>

                                <div class="mb-3">
                                    <div class="alert alert-secondary py-2 px-3 d-inline-block fw-bold mb-1">
                                        <i class="ti ti-award"></i> Diplôme : 
                                        <span>{{ $personnel->diplome_academique_plus_eleve ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <p>
                                    <strong><i class="ti ti-book me-1 text-info"></i> Intitulé :</strong> 
                                    {{ $personnel->intitule_diplome ?? 'N/A' }}
                                </p>
                                <p>
                                    <strong><i class="ti ti-building me-1 text-secondary"></i> Université :</strong> 
                                    {{ $personnel->universite_obtention ?? 'N/A' }}
                                </p>
                                <p>
                                    <strong><i class="ti ti-calendar-time me-1 text-success"></i> Année d’obtention :</strong> 
                                    {{ $personnel->annee_obtention_diplome ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Colonne droite : Diplôme professionnel -->
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 mt-3">
                            <div class="card-body">
                                <h6 class="text-primary mb-3">Diplôme professionnel</h6>

                                <div class="mb-3">
                                    <div class="alert alert-info py-2 px-3 d-inline-block fw-bold mb-1">
                                        <i class="ti ti-certificate"></i> Diplôme :
                                        <span>{{ $personnel->diplome_professionnel ?? 'N/A' }}</span>
                                    </div>
                                </div>

                                <p>
                                    <strong><i class="ti ti-map-pin me-1 text-warning"></i> Lieu d’obtention :</strong> 
                                    {{ $personnel->lieu_obtention_diplome_professionnel ?? 'N/A' }}
                                </p>
                                <p>
                                    <strong><i class="ti ti-calendar me-1 text-danger"></i> Année d’obtention :</strong> 
                                    {{ $personnel->annee_obtention_diplome_professionnel ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Expérience -->
            <div class="tab-pane fade" id="experience" role="tabpanel">
                <p><strong>Poste précédent :</strong> </p>
            </div>



            <!-- Présences et Pointage -->
<div class="tab-pane fade" id="suivi" role="tabpanel">
    <h5 class="mb-3">Bilan des présences (30 derniers jours ouvrés)</h5>

    @if($pointagesComplets->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Date</th>
                        <th>Heure d'arrivée</th>
                        <th>Heure de départ</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pointagesComplets as $p)
                        <tr>
                            <td>{{ $p['date']->locale('fr')->isoFormat('dddd D MMMM Y') }}</td>
                            <td>
                                {{ $p['heure_arrivee'] ? \Carbon\Carbon::parse($p['heure_arrivee'])->format('H:i') : '—' }}
                            </td>
                            <td>
                                {{ $p['heure_depart'] ? \Carbon\Carbon::parse($p['heure_depart'])->format('H:i') : '—' }}
                            </td>
                            <td>
                                @if($p['heure_arrivee'] || $p['heure_depart'])
                                    <span class="text-success fw-bold">Présent</span>
                                @else
                                    <span class="text-danger fw-bold">Absent</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted">Aucun pointage trouvé pour les 30 derniers jours.</p>
    @endif
</div>




            <!-- Accès -->
            <div class="tab-pane fade" id="acces" role="tabpanel">
                <p><strong>Nom d'utilisateur :</strong> </p>
                <p><strong>Rôle :</strong> </p>
            </div>
        </div>
    </div>

    <style>/* Style global pour la fiche */
        .container {
            background-color: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-top: 30px;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Titre de la fiche */
        .container h2 {
            font-weight: 700;
            color: #2c3e50;
            border-left: 6px solid #3498db;
            padding-left: 15px;
        }

        /* Style des onglets */
        .nav-tabs .nav-link {
            color: #34495e;
            font-weight: 500;
            padding: 10px 15px;
            transition: 0.3s;
            border-radius: 5px 5px 0 0;
            background-color: #f1f1f1;
            margin-right: 5px;
        }

        .nav-tabs .nav-link:hover {
            background-color: #dcefff;
            color: #2980b9;
        }

        .nav-tabs .nav-link.active {
            background-color: #3498db;
            color: white;
            font-weight: 600;
        }

        /* Contenu des onglets */
        .tab-content {
            background-color: #fefefe;
            border: 1px solid #dee2e6;
            border-radius: 0 0 8px 8px;
            padding: 25px;
        }

        /* Paragraphes dans les onglets */
        .tab-content p {
            font-size: 16px;
            padding: 8px 0;
            border-bottom: 1px dashed #e0e0e0;
            margin-bottom: 8px;
        }

        .tab-content strong {
            color: #2c3e50;
            width: 220px;
            display: inline-block;
        }

        /* Lien de téléchargement */
        a[target="_blank"] {
            color: #3498db;
            font-weight: 500;
            text-decoration: none;
        }

        a[target="_blank"]:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .tab-content p {
                font-size: 15px;
            }

            .container {
                padding: 20px;
            }

            .nav-tabs {
                flex-wrap: wrap;
            }

            .nav-tabs .nav-link {
                margin-bottom: 5px;
            }
        }


        .info-section {
            background: #f8f9fa;
            padding: 20px 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .info-section h6 {
            font-weight: bold;
            color: #0d6efd;
            margin-top: 20px;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 5px;
        }

        .info-section p {
            margin-bottom: 10px;
            font-size: 15px;
            color: #333;
        }

        .info-section p strong {
            width: 220px;
            display: inline-block;
            color: #212529;
        }

                #personnelTab {
        flex-wrap: wrap; /* Assure que les onglets peuvent passer à la ligne */
        gap: 0.5rem 1rem; /* espace vertical (0.5rem) et horizontal (1rem) entre boutons */
        }
        #personnelTab .nav-item {
        margin-bottom: 0.5rem; /* un petit espace entre les lignes si wrap */
        }


                .duree-texte {
            font-weight: 600;      /* un peu plus gras */
            color:rgb(15, 15, 15);        /* couleur orange/or brillante */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* police moderne et claire */
            font-size: 1rem;       /* taille standard un peu plus visible */
        }

    </style>


             
    <!-- Modal unique pour ajout/modification/renouvellement (contrat)-->
    <div class="modal fade" id="contratModal" tabindex="-1" aria-labelledby="contratModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="formContrat" method="POST" enctype="multipart/form-data" action="">
                @csrf
                <input type="hidden" name="personnel_id" id="modal_personnel_id" value="">
                <input type="hidden" name="_method" id="form_method" value="POST">
                <input type="hidden" name="contrat_id" id="contrat_id" value="">
                <input type="hidden" name="mode" id="form_mode" value="ajout">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="contratModalLabel">Ajouter un contrat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="type" class="form-label">Type de contrat <span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="">-- Sélectionner --</option>
                                        <option value="CDD">CDD</option>
                                        <option value="CDI">CDI</option>
                                        <option value="Stage">Stage</option>
                                        <option value="Prestation">Prestation</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="Dure" class="form-label">Durée</label>
                                    <input type="text" name="Dure" id="Dure" class="form-control" placeholder="Ex : 6 mois">
                                </div>

                                <div class="col-md-6">
                                    <label for="date_debut" class="form-label">Date de début <span class="text-danger">*</span></label>
                                    <input type="date" name="date_debut" id="date_debut" class="form-control" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="date_fin" class="form-label">Date de fin</label>
                                    <input type="date" name="date_fin" id="date_fin" class="form-control" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label for="salaire" class="form-label">Salaire</label>
                                    <input type="number" name="salaire" id="salaire" class="form-control" step="0.01" placeholder="Ex : 250000">
                                </div>

                                <div class="col-md-6">
                                    <label for="fichier" class="form-label">Fichier du contrat (PDF) <span class="text-danger" id="fichierRequired">*</span></label>
                                    <input type="file" name="fichier" id="fichier" class="form-control" accept=".pdf">
                                    <small id="fileHelp" class="form-text text-muted"></small>
                                </div>

                                <div class="col-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Détails supplémentaires..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submitBtn" class="btn btn-primary">Ajouter</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </form>
        </div>
    </div>




@endsection


@section('js')

    <script src="{{asset('app/js/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('pages/paiement.js')}}"></script>


        <!-- SheetJS pour Excel -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

        <!-- jsPDF et AutoTable pour PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>




         <!-- SheetJS pour soumettre Le Modal d'ajout des Contrats -->
    <script>
        $(document).ready(function () {
            $('#formContrat').on('submit', function (e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);
                formData.set('personnel_id', $('#modal_personnel_id').val());

                let mode = $('#form_mode').val();
                let contratId = $('#contrat_id').val();

                // 🔴 Vérifier si le type est CDI et nettoyer les champs inutiles
                const typeContrat = document.getElementById('type').value;
                if (typeContrat.toUpperCase() === 'CDI') {
                    formData.set('Dure', '');
                    formData.set('date_fin', '');
                }

                let url = '';
                let method = 'POST';

                if (mode === 'ajout') {
                    url = '{{ route("contrats.store") }}';
                    form.setAttribute('action', url);
                    $('#form_method').val('POST');
                    $('#submitBtn').text('Ajouter');

                } else if (mode === 'modification') {
                    url = `/contrats/${contratId}`;
                    form.setAttribute('action', url);
                    formData.set('_method', 'PUT');
                    $('#form_method').val('PUT');
                    $('#submitBtn').text('Mettre à jour');

                } else if (mode === 'renouvellement') {
                    url = `/contrats/${contratId}/renouveler-personnalise`;
                    form.setAttribute('action', url);

                    
                    $('#form_method').val('POST');
                    $('#submitBtn').text('Renouveler');

                } else {
                    console.error('Mode inconnu:', mode);
                    return;
                }

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Succès',
                            text: response.message || 'Opération réussie',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6',
                            allowOutsideClick: false
                        }).then(() => {
                            $('#contratModal').modal('hide');
                            form.reset();
                            location.reload();
                        });
                    },
                    error: function (xhr) {
                        console.log(xhr.responseJSON);
                        let errors = xhr.responseJSON?.errors;
                        let message = 'Une erreur est survenue lors de l\'enregistrement.';
                        if (errors) {
                            message = Object.values(errors).flat().join('\n');
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: message
                        });
                    }
                });
            });

        });

        function ouvrirModalContrat(mode, personnelId, contratId = null) {
            const modalElement = document.getElementById('contratModal');
            const modal = new bootstrap.Modal(modalElement);

            const titreElement = document.getElementById('contratModalLabel');
            const form = document.getElementById('formContrat');
            const submitBtn = document.getElementById('submitBtn');
            const fichierInput = document.getElementById('fichier');
            const fileHelp = document.getElementById('fileHelp');
            const fichierRequired = document.getElementById('fichierRequired');

            // Réinitialisation
            form.reset();
            $('#form_mode').val(mode); // <- mise à jour du champ caché "mode"
            $('#modal_personnel_id').val(personnelId);

            document.getElementById('contrat_id').value = contratId ?? '';
            form.setAttribute('action', ''); // vider temporairement

            if (mode === 'ajout') {
                titreElement.innerText = "Ajouter un contrat";
                submitBtn.innerText = "Ajouter";
                fichierInput.required = true;
                fichierRequired.style.display = "inline";
                fileHelp.innerText = "";
                modal.show();

            } else if (mode === 'modification') {
                titreElement.innerText = "Modifier le contrat";
                submitBtn.innerText = "Mettre à jour";
                fichierInput.required = false;
                fichierRequired.style.display = "none";
                fileHelp.innerText = "Laissez vide si vous ne souhaitez pas modifier le fichier.";

                $.get(`/contrats/${contratId}/edit`, function (data) {
                    document.getElementById('type').value = data.type ?? '';
                    document.getElementById('Dure').value = data.Dure ?? '';
                    document.getElementById('date_debut').value = data.date_debut ?? '';
                    document.getElementById('date_fin').value = data.date_fin ?? '';
                    document.getElementById('salaire').value = data.salaire ?? '';
                    document.getElementById('description').value = data.description ?? '';
                    modal.show();
                }).fail(function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Impossible de charger les données du contrat.'
                    });
                });

            } else if (mode === 'renouvellement') {
                titreElement.innerText = "Renouveler le contrat (personnalisé)";
                submitBtn.innerText = "Renouveler";
                fichierInput.required = true;
                fichierRequired.style.display = "inline";
                fileHelp.innerText = "";
                
                modal.show();
            }

        }
    </script>



    <!-- SheetJS pour Le Calcul de la date de fin du contrat automatiquement-->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dureInput = document.querySelector('input[name="Dure"]');
            const dateDebutInput = document.querySelector('input[name="date_debut"]');
            const dateFinInput = document.querySelector('input[name="date_fin"]');

            function calculerDateFin() {
                const dateDebut = new Date(dateDebutInput.value);
                const dureeTexte = dureInput.value.trim().toLowerCase();

                if (isNaN(dateDebut.getTime()) || !dureeTexte) {
                    dateFinInput.value = '';
                    return;
                }

                const regex = /(\d+)\s*(jour|jours|semaine|semaines|mois|an|ans)/i;
                const match = dureeTexte.match(regex);

                if (!match) {
                    dateFinInput.value = '';
                    return;
                }

                const quantite = parseInt(match[1]);
                const unite = match[2];

                let dateFin = new Date(dateDebut);

                switch (unite) {
                    case 'jour':
                    case 'jours':
                        dateFin.setDate(dateFin.getDate() + quantite);
                        break;
                    case 'semaine':
                    case 'semaines':
                        dateFin.setDate(dateFin.getDate() + quantite * 7);
                        break;
                    case 'mois':
                        dateFin.setMonth(dateFin.getMonth() + quantite);
                        break;
                    case 'an':
                    case 'ans':
                        dateFin.setFullYear(dateFin.getFullYear() + quantite);
                        break;
                    default:
                        dateFinInput.value = '';
                        return;
                }

                // Format YYYY-MM-DD
                const yyyy = dateFin.getFullYear();
                const mm = String(dateFin.getMonth() + 1).padStart(2, '0');
                const dd = String(dateFin.getDate()).padStart(2, '0');

                dateFinInput.value = `${yyyy}-${mm}-${dd}`;
            }

            dureInput.addEventListener('input', calculerDateFin);
            dateDebutInput.addEventListener('change', calculerDateFin);
        });
    </script>



    <!-- SheetJS pour rendre le champ "Durée"grisé lorsqu'on sélectionne "CDI" -->
    <script>
        $(document).ready(function () {
            // Cibler le select du type de contrat
            $('select[name="type"]').on('change', function () {
                const typeContrat = $(this).val();

                if (typeContrat === 'CDI') {
                    $('input[name="Dure"]').val('') // Réinitialise le champ
                        .prop('readonly', true)     // Rend le champ non modifiable
                        .addClass('bg-light');      // Ajoute un fond visuellement désactivé
                } else {
                    $('input[name="Dure"]').prop('readonly', false).removeClass('bg-light');
                }
            });
        });
    </script>

    <!-- SheetJS pour ouvrir le modale de Renouvellement de contrat -->
    <script>
        function confirmerRenouvellement(personnelId, contratId) {
            Swal.fire({
                icon: 'warning',
                title: 'Renouvellement rapide du contrat',
                text: 'Souhaitez-vous reconduire ce contrat à l’identique ? Le salaire, la durée et le type seront conservés. Seule la date de début sera mise à aujourd’hui.',
                showCancelButton: true,
                confirmButtonText: 'Oui, reconduire',
                cancelButtonText: 'Non, personnaliser',
            }).then((result) => {
                if (result.isConfirmed) {
                    // 🔁 Requête AJAX pour cloner le contrat
                    $.ajax({
                        url: `/contrats/${contratId}/renouveler-identique`,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('input[name="_token"]').val()
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Contrat renouvelé',
                                text: response.message || 'Le contrat a été reconduit avec succès.',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#3085d6',
                                allowOutsideClick: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: xhr.responseJSON?.message || 'Échec du renouvellement.'
                            });
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // ✍️ Ouvre le formulaire modale pour personnaliser
                    ouvrirModalContrat('renouvellement', personnelId, contratId);
                }
            });
        }
    </script>



    <!-- SheetJS pour ouvrir le modale d'ajout de document -->

    <script>
        $(document).ready(function () {
            // Ouvrir la modale et insérer le personnel_id
            $('.ajouter-document').on('click', function (e) {
                e.preventDefault();
                const personnelId = $(this).data('personnel-id');

                $('#modal_personnel_id').val(personnelId);

                $('#ajouterDocumentModal').modal('show');
            });

            // Envoi AJAX du formulaire
            $('form[action="{{ route('documents.ajouter') }}"]').on('submit', function (e) {
                e.preventDefault();

                const form = $(this)[0];
                const formData = new FormData(form);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Document ajouté',
                            text: 'Le document a été ajouté avec succès.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6',
                            allowOutsideClick: false
                        }).then(() => {
                            location.reload(); // Recharge la liste des documents
                        });
                    },
                    error: function (xhr) {
                        console.log(xhr.responseJSON); // Debug

                        const erreurs = xhr.responseJSON?.errors;
                        let message = "Une erreur est survenue";

                        if (erreurs) {
                            message = Object.values(erreurs).flat().join('<br>');
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur de validation',
                            html: message
                        });
                    }
                });
            });
        });
    </script>


    <!--
    Ce script permet de conserver l’onglet actif même après un rechargement de page.
    Il enregistre dans le stockage local (localStorage) le dernier onglet cliqué,
    et le réactive automatiquement lors du chargement suivant.

    Cela améliore l’expérience utilisateur en gardant sa position dans les onglets.
    -->

    <script>
        $(document).ready(function () {
            // Quand un onglet est cliqué, on stocke son id dans localStorage
            $('button[data-bs-toggle="tab"]').on('click', function () {
                const target = $(this).attr('data-bs-target');
                localStorage.setItem('ongletActif', target);
            });

            // Au chargement de la page, on récupère l'onglet précédemment actif
            const ongletSauvegarde = localStorage.getItem('ongletActif');
            if (ongletSauvegarde) {
                // Supprimer les classes actives par défaut
                $('.nav-link').removeClass('active');
                $('.tab-pane').removeClass('show active');

                // Activer l'onglet et son contenu sauvegardé
                $(`button[data-bs-target="${ongletSauvegarde}"]`).addClass('active');
                $(ongletSauvegarde).addClass('show active');
            }
        });
    </script>


         <!-- SheetJS pour ouvrir le modale des primes -->
    <script>
            document.getElementById('btnAddPrime').addEventListener('click', function() {
            var myModal = new bootstrap.Modal(document.getElementById('modalAddPrime'));
            myModal.show();
        });

    </script>
         <!-- SheetJS pour soumettre le modale des primes -->
    <script>
        document.getElementById('formAddPrime').addEventListener('submit', function(e) {
            e.preventDefault(); // Empêche l'envoi classique

            let form = e.target;
            let url = form.action;
            let formData = new FormData(form);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Token CSRF Laravel
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    // Si erreur validation ou autre
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                // Ici tu peux fermer la modale et afficher un message succès
                let modal = bootstrap.Modal.getInstance(document.getElementById('modalAddPrime'));
                modal.hide();

                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: data.message || 'Prime ajouté avec succès.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                    allowOutsideClick: false
                }).then(() => {
                    location.reload(); // Recharge la page après confirmation
                });

                // Optionnel : tu peux aussi rafraîchir la liste des primes via AJAX
            })
            .catch(errorData => {
                
                let errors = errorData.errors || {};
                let errorsHtml = Object.values(errors).map(e => e.join('<br>')).join('<br>');
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    html: errorsHtml || 'Une erreur est survenue.',
                    confirmButtonText: 'Fermer'
                });

            });
        });
    </script>
        <!-- SheetJS pour soumettre le modale du salaire -->
    <script>
        $(document).ready(function () {
            $('#formDefinirSalaire').on('submit', function (e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);
                let remunerationId = $('#remuneration_id').val(); // champ caché dans le formulaire

                let isUpdate = remunerationId !== undefined && remunerationId !== null && remunerationId !== '';
                let url = isUpdate 
                    ? `/remunerations/update/${remunerationId}` 
                    : form.getAttribute('action'); // route de création par défaut
                let method = isUpdate ? 'POST' : 'POST'; // ou PUT si tu configures correctement côté Laravel

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Succès',
                            text: response.message || (isUpdate ? 'Salaire modifié.' : 'Salaire défini.'),
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6',
                            allowOutsideClick: false
                        }).then(() => {
                            $('#modalDefinirSalaire').modal('hide');
                            form.reset();
                            location.reload(); // Rafraîchir pour afficher les nouvelles données
                        });
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON?.errors;
                        let message = 'Une erreur est survenue.';
                        if (errors) {
                            message = Object.values(errors).flat().join('\n');
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: message
                        });
                    }
                });
            });
        });
    </script>


        <!-- SheetJS pour gérer le calcul automatique du salaire brute des primes des retenues et du salaire net -->
    <script>
        function formaterMontant(valeur) {
            return new Intl.NumberFormat('fr-FR').format(valeur) + ' FCFA';
        }

        function ajouterMois(date, nbMois) {
            let d = new Date(date);
            d.setMonth(d.getMonth() + nbMois);
            return d;
        }

        function ajouterAnnees(date, nbAnnees) {
            let d = new Date(date);
            d.setFullYear(d.getFullYear() + nbAnnees);
            return d;
        }

        function estPrimeValide(dateCreation, periode) {
            if (!dateCreation) return false; // pas de date => invalide

            let now = new Date();
            let dateDebut = new Date(dateCreation);

            periode = periode.toLowerCase();

            if (periode === 'indéterminée' || periode === 'indeterminee' || periode === 'indeterminée') {
                return true; // toujours valide
            }

            // Chercher si c'est 1 mois, 2 mois, 1 an, 3 ans, etc.
            let matchMois = periode.match(/(\d+)\s*mois/);
            if (matchMois) {
                let mois = parseInt(matchMois[1], 10);
                let dateFin = ajouterMois(dateDebut, mois);
                return now <= dateFin;
            }

            let matchAnnees = periode.match(/(\d+)\s*an/);
            if (matchAnnees) {
                let annees = parseInt(matchAnnees[1], 10);
                let dateFin = ajouterAnnees(dateDebut, annees);
                return now <= dateFin;
            }

            // Si aucune correspondance, on considère la prime toujours valide
            return true;
        }


        function estRetenueValide(dateCreation, periode) {
            if (!dateCreation) return false;

            let now = new Date();
            let dateDebut = new Date(dateCreation);
            let dateLimite;

            periode = periode.toLowerCase();

            if (['indéterminée', 'indeterminee', 'indeterminée'].includes(periode)) {
                return true;
            }

            let matchMois = periode.match(/(\d+)\s*mois/);
            if (matchMois) {
                let mois = parseInt(matchMois[1], 10);
                dateLimite = ajouterMois(dateDebut, mois);
            }

            let matchAn = periode.match(/(\d+)\s*an/);
            if (matchAn) {
                let annees = parseInt(matchAn[1], 10);
                dateLimite = ajouterAnnees(dateDebut, annees);
            }

            if (!dateLimite) {
                return true;
            }

            dateLimite.setDate(dateLimite.getDate() + 3); // Tolérance de 3 jours

            return now <= dateLimite;
        }


        function calculerTotaux() {
            let salaireBrut = parseFloat($('#salaire_brut_cache').val()) || 0;

            let totalPrimes = 0;
            $('.prime-item').each(function() {
                let etat = parseInt($(this).data('etat')) || 0;
                if (etat !== 1) return; // Ignorer si etat différent de 1

                let montant = parseFloat($(this).data('montant')) || 0;
                let periode = $(this).data('periode') || 'indéterminée';
                let dateCreation = $(this).data('date');

                if (estPrimeValide(dateCreation, periode)) {
                    totalPrimes += montant;
                } else {
                    $(this).hide(); // cacher la prime expirée
                }
            });

            let totalRetenues = 0;
            $('.retenue-item').each(function() {
                let etat = parseInt($(this).data('etat')) || 0;
                if (etat !== 1) return; // Ignorer si etat différent de 1

                let montant = parseFloat($(this).data('montant')) || 0;
                let periode = $(this).data('periode') || 'indéterminée';
                let dateCreation = $(this).data('date');

                if (estRetenueValide(dateCreation, periode)) {
                    totalRetenues += montant;
                } else {
                    $(this).hide(); // cacher la retenue expirée
                }
            });

            // Mise à jour des affichages
            $('#total-primes').text(formaterMontant(totalPrimes));
            $('#total-retenues').text(formaterMontant(totalRetenues));

            let salaireNet = salaireBrut + totalPrimes - totalRetenues;
            $('#salaire-net').text(formaterMontant(salaireNet));
        }




        $(document).ready(function(){
            calculerTotaux();
        });

    </script>


         <!-- SheetJS pour ouvrir le modale des retenue -->
    <script>
            document.getElementById('btnAddRetenue').addEventListener('click', function() {
            var myModal = new bootstrap.Modal(document.getElementById('modalAddRetenue'));
            myModal.show();
        });

    </script>

        <!-- SheetJS pour soumettre le modale des retenues -->
    <script>
        document.getElementById('formAddRetenue').addEventListener('submit', function(e) {
            e.preventDefault(); // Empêche l'envoi classique

            let form = e.target;
            let url = form.action;
            let formData = new FormData(form);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Token CSRF Laravel
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                let modal = bootstrap.Modal.getInstance(document.getElementById('modalAddRetenue'));
                modal.hide();
                form.reset();

                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: data.message || 'Retenue ajoutée avec succès.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                    allowOutsideClick: false
                }).then(() => {
                    
                    location.reload();
                });
            })
            .catch(errorData => {
                let errors = errorData.errors || {};
                let errorsHtml = Object.values(errors).map(e => e.join('\n')).join('\n');

                Swal.fire({
                    icon: 'error',
                    title: 'Erreur lors de la soumission',
                    html: `<pre style="text-align:left">${errorsHtml}</pre>`,
                });
            });
        });
    </script>

        <!-- SheetJS pour remplir et afficher le modale de modification des retenues -->
    <script>
        function modifierRetenue(button) {
            let id = button.dataset.id;
            let libelle = button.dataset.libelle;
            let periode = button.dataset.periode;
            let montant = button.dataset.montant;

            // Remplir les champs
            document.getElementById('edit_retenue_id').value = id;
            document.getElementById('edit_libelle').value = libelle;
            document.getElementById('edit_periode').value = periode;
            document.getElementById('edit_montant').value = montant;

            // Définir l'action du formulaire
            let form = document.getElementById('formEditRetenue');
            form.action = `/retenue/${id}`; // ou route('retenue.update', id) si tu veux le générer côté Blade

            // Afficher la modale
            let modal = new bootstrap.Modal(document.getElementById('modalEditRetenue'));
            modal.show();
        }
    </script>
         <!-- SheetJS pour soumettre le modale de modification des retenues -->
    <script>
        document.getElementById('formEditRetenue').addEventListener('submit', function(e) {
            e.preventDefault();

            let form = e.target;
            let url = form.action;
            let formData = new FormData(form);
            formData.append('_method', 'PUT'); // important pour méthode PUT

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                let modal = bootstrap.Modal.getInstance(document.getElementById('modalEditRetenue'));
                modal.hide();

                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: data.message || 'Retenue modifiée avec succès.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                    allowOutsideClick: false
                }).then(() => {
                    location.reload(); // Recharge la page après confirmation
                });
            })
            .catch(errorData => {
                let errors = errorData.errors || {};
                let errorsHtml = Object.values(errors).map(e => e.join('\n')).join('\n');

                Swal.fire({
                    icon: 'error',
                    title: 'Erreur de validation',
                    html: `<pre style="text-align:left">${errorsHtml}</pre>`
                });
            });
        });
    </script>

      <!-- SheetJS pour supprimer des retenues -->
    <script>
        function supprimerRetenue(id) {
            Swal.fire({
                title: 'Confirmer la suppression',
                text: 'Voulez-vous vraiment supprimer cette retenue ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Non',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/retenue/${id}/etat`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ etat: 2 })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Supprimée',
                            text: data.message || 'Retenue supprimée avec succès.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(); // Recharge la page
                        });
                    })
                    .catch(errorData => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Une erreur est survenue lors de la suppression.'
                        });
                    });
                }
                // Si "Non", rien à faire : le SweetAlert se ferme
            });
        }
    </script>


        <!-- SheetJS pour remplir et afficher le modale de modification des Primes -->
    <script>
        function modifierPrime(button) {
            let id = button.dataset.id;
            let libelle = button.dataset.libelle;
            let periode = button.dataset.periode;
            let montant = button.dataset.montant;

            // Remplir les champs
            document.getElementById('edit_prime_id').value = id;
            document.getElementById('edit_libelle_prime').value = libelle;
            document.getElementById('edit_periode_prime').value = periode;
            document.getElementById('edit_montant_prime').value = montant;

            // Définir l'action du formulaire
            let form = document.getElementById('formEditPrime');
            form.action = `/prime/${id}`; // ou route('prime.update', id) si tu veux le générer côté Blade

            // Afficher la modale
            let modal = new bootstrap.Modal(document.getElementById('modalEditPrime'));
            modal.show();
        }
    </script>
         <!-- SheetJS pour soumettre le modale de modification des Primes -->
    <script>
        document.getElementById('formEditPrime').addEventListener('submit', function(e) {
            e.preventDefault();

            let form = e.target;
            let url = form.action;
            let formData = new FormData(form);
            formData.append('_method', 'PUT'); // important pour méthode PUT

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                let modal = bootstrap.Modal.getInstance(document.getElementById('modalEditPrime'));
                modal.hide();

                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: data.message || 'Prime modifiée avec succès.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                    allowOutsideClick: false
                }).then(() => {
                    location.reload(); // Recharge la page après confirmation
                });
            })
            .catch(errorData => {
                let errors = errorData.errors || {};
                let errorsHtml = Object.values(errors).map(e => e.join('\n')).join('\n');

                Swal.fire({
                    icon: 'error',
                    title: 'Erreur de validation',
                    html: `<pre style="text-align:left">${errorsHtml}</pre>`
                });
            });
        });
    </script>


      <!-- SheetJS pour supprimer des primes -->
    <script>
        function supprimerPime(id) {
            Swal.fire({
                title: 'Confirmer la suppression',
                text: 'Voulez-vous vraiment supprimer cette prime ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Non',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/prime/${id}/etat`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ etat: 2 })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Supprimée',
                            text: data.message || 'Prime supprimée avec succès.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(); // Recharge la page
                        });
                    })
                    .catch(errorData => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Une erreur est survenue lors de la suppression.'
                        });
                    });
                }
                // Si "Non", rien à faire : le SweetAlert se ferme
            });
        }
    </script>



<!-- JS : afficher modal ou soumettre form -->
<script>
    document.getElementById('type_financement').addEventListener('change', function () {
        const value = this.value;
        if (value === 'banque') {
            var banqueModal = new bootstrap.Modal(document.getElementById('banqueModal'));
            banqueModal.show();
        } else if (value === 'billetage') {
            document.getElementById('form-billetage').submit();
        }
    });
</script>

<script>
    document.getElementById('nouveau_type_financement').addEventListener('change', function () {
        const banqueFields = document.getElementById('formulaire-banque-fields');
        if (this.value === 'banque') {
            banqueFields.style.display = 'block';
            document.getElementById('changer_nom_banque').required = true;
            document.getElementById('changer_numero_compte').required = true;
        } else {
            banqueFields.style.display = 'none';
            document.getElementById('changer_nom_banque').required = false;
            document.getElementById('changer_numero_compte').required = false;
        }
    });
</script>







@endsection
