


@extends('layout')

@section('title')

DRH | Liste Du Personnel

@endsection

@section('css')



    <link href="{{asset('app/css/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />


@endsection

@section('contenu')

    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4 class="fw-bold">Personnel </h4>
                    <h6>Liste Du Personnel   </h6>
                </div>
            </div>
            <ul class="table-top-head">
            <li>
                <a href="#" id="exportPdf" data-bs-toggle="tooltip" data-bs-placement="top" title="Exporter en Pdf"><img src="{{asset('app')}}/assets/img/icons/pdf.svg" alt="PDF"></a>
            </li>
            <li>
                <a href="#" id="exportExcel" data-bs-toggle="tooltip" data-bs-placement="top" title="Exporter en Excel"><img src="{{asset('app')}}/assets/img/icons/excel.svg" alt="Excel"></a>
            </li>

            </ul>
            <div class="page-btn">


            </div>
        </div>
        <!-- /product list -->

      

        <div class="card">
          
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table datatable" id="table-Personnel">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 10%">Photo</th>
                            <th style="width: 10%">Nom</th>
                            <th style="width: 10%">Prénom</th>
                            <th style="width: 15%">Type de Personnel</th>
                            <th style="width: 10%">Contact</th>
                            
                            <th style="width: 10%">QR Code</th>
                            
                            <th style="width: 10%">Poste</th>
                            <th style="width: 10%">Sexe</th>
                            <th class="no-sort" style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($personnels as $personnel)
                        <tr>
                            @php
                                $photoPath = 'storage/' . $personnel->photo;
                                $photoExiste = $personnel->photo && file_exists(public_path($photoPath));

                                $imageDefaut = $personnel->sexe === 'Féminin'
                                    ? asset('RessourcesHumaines/demande/img/femme.png')
                                    : asset('RessourcesHumaines/demande/img/homme.png');
                            @endphp

                            <td>
                                <img src="{{ $photoExiste ? asset($photoPath) : $imageDefaut }}" 
                                    alt="Photo" 
                                    class="rounded-circle" 
                                    style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #ccc;">
                            </td>

                            <td>{{ $personnel->nom }}</td>
                            <td>{{ $personnel->prenom }}</td>

                            <td>
                                @if($personnel->enseignant)
                                    <span class="badge bg-primary">Enseignant</span>
                                @elseif($personnel->administratif)
                                    <span class="badge bg-success">Administratif</span>
                                @else
                                    <span class="badge bg-danger">Non défini (ID: {{ $personnel->id }})</span>
                                @endif
                            </td>




                            <td>{{ $personnel->contact }}</td>

                           <td>
                                @if($personnel->qr_code)
                                    <img src="{{ asset('storage/' . $personnel->qr_code) }}" 
                                        alt="QR Code" 
                                        class="rounded" 
                                        style="width: 50px; height: 50px; object-fit: contain; border: 1px solid #ccc;">
                                @else
                                    <span>Aucun QR</span>
                                @endif
                            </td>




                            <td>
                                @if($personnel->poste)
                                    {{ $personnel->poste->nom }}
                                @else
                                    Non défini
                                @endif
                            </td>

                            <td>
                                @if ($personnel->sexe === 'Féminin')
                                    <i class="fas fa-venus" style="color:#e83e8c;" title="Féminin"></i>
                                @else
                                    <i class="fas fa-mars" style="color:#007bff;" title="Masculin"></i>
                                @endif
                            </td>
                            <td class="text-center">
                                    <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('personnel.fiche', ['id' => $personnel->id]) }}" class="dropdown-item">
                                                <i class="fas fa-id-card"></i> Fiche de l'employé

                                            </a>
                                        </li>




                                        </li>

                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item modifierPersonnel" data-id="{{ $personnel->id }}">
                                                <i data-feather="edit" class="info-img"></i>Modifier
                                            </a>
                                        </li>





                                    

                                        <li>
                                            <a href="javascript:void(0);" 
                                            class="dropdown-item" 
                                            title="Supprimer"
                                            onclick="deletePersonnelConfirmation({{ $personnel->id }})">
                                                <i class="fa fa-trash info-img"></i> Supprimer
                                            </a>
                                        </li>



                                        <a href="mailto:{{ $personnel->email }}?subject=Objet%20du%20mail&body=Bonjour%20{{ $personnel->prenom }},%0A%0ACordialement,%0ADirecteur des ressources humaines%0AEcole Internationale Mariam"
                                        class="dropdown-item">
                                            <i data-feather="mail" class="info-img"></i> Envoyer un email
                                        </a>






                                    </ul>
                            </td>
                            </tr>
                            {{-- Modal Details personnel --}}
        
                            <div class="modal fade" id="personnelDetailsModal{{ $personnel->id }}" tabindex="-1" aria-labelledby="personnelDetailsModalLabel{{ $personnel->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="personnelDetailsModalLabel{{ $personnel->id }}">
                                                Détails du Personnel : {{ $personnel->nom }} {{ $personnel->prenom }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">

                                            {{-- Photo du personnel en haut à droite --}}
                                            @if($personnel->photo)
                                                <div class="photo-du-personnel">
                                                    <img src="{{ asset('storage/' . $personnel->photo) }}" alt="Photo de {{ $personnel->nom }}">
                                                </div>
                                            @endif

                                            {{-- Bloc Détails du personnel --}}
                                            <div class="bloc-section">
                                                <h6>Détails du Personnel</h6>
                                                <p><strong>Statut :</strong> {{ $personnel->statut }}</p>
                                                <p><strong>Date de naissance :</strong> {{ \Carbon\Carbon::parse($personnel->date_naissance)->format('d/m/Y') }}</p>
                                                <p><strong>Lieu de naissance :</strong> {{ $personnel->lieu_naissance }}</p>
                                                <p><strong>Email :</strong> {{ $personnel->email }}</p>
                                                <p><strong>Sexe :</strong> {{ $personnel->sexe }}</p>
                                                <p><strong>Situation familiale :</strong> {{ $personnel->situation_familiale }}</p>
                                                <p><strong>Nombre d’enfants :</strong> {{ $personnel->nombre_enfants }}</p>
                                                <p><strong>Situation agent :</strong> {{ $personnel->situation_agent }}</p>
                                                <p><strong>Diplôme :</strong> {{ $personnel->diplome_academique_plus_eleve }} - {{ $personnel->intitule_diplome }}</p>
                                                <p><strong>Année obtention :</strong> {{ $personnel->annee_obtention_diplome }}</p>
                                                <p><strong>Date de prise de service :</strong> {{ \Carbon\Carbon::parse($personnel->date_prise_service)->format('d/m/Y') }}</p>
                                                @if($personnel->date_prise_service)
                                            @php
                                                $anciennete = \Carbon\Carbon::parse($personnel->date_prise_service)->diffInYears(now());
                                            @endphp
                                            <p><strong>Ancienneté :</strong> {{ $anciennete }} {{ $anciennete == 1 ? 'an' : 'ans' }}</p>
                                            @else
                                            <p><strong>Ancienneté :</strong> Non renseignée</p>
                                            @endif

                                                @if($personnel->situation_familiale == 'Marié(e)' && !empty($personnel->contact_epoux_ou_epouse))
                                                    <p><strong>Contact du conjoint :</strong> {{ $personnel->contact_epoux_ou_epouse }}</p>
                                                @endif
                                            </div>

                                            {{-- Bloc Informations Enseignant --}}
                                            @if($personnel->enseignant)
                                                <div class="bloc-section enseignant-block">
                                                    <h6>Informations Enseignant</h6>
                                                    <p><strong>Dominante :</strong> {{ $personnel->enseignant->dominante }}</p>
                                                    <p><strong>Sous-dominante :</strong> {{ $personnel->enseignant->sous_dominante }}</p>
                                                    <p><strong>Volume horaire :</strong> {{ $personnel->enseignant->volume_horaire }}</p>
                                                    <p><strong>Classe :</strong> {{ $personnel->enseignant->classe_intervention }}</p>
                                                </div>
                                            @elseif($personnel->administratif)
                                                {{-- Bloc Informations Administratif --}}
                                                <div class="bloc-section admin-block">
                                                    <h6>Informations Administratif</h6>
                                                    <p><strong>Fonction :</strong> {{ $personnel->administratif->fonction_occupee }}</p>
                                                    <p><strong>Service :</strong> {{ $personnel->administratif->service }}</p>
                                                </div>
                                            @else
                                                <p>Ce personnel n'a pas d'information correspondante (enseignant ou administratif).</p>
                                            @endif


                                            {{-- Bloc Personne à prévenir --}}
                                            <div class="bloc-section urgence-block">
                                                <h6>Personne à prévenir</h6>
                                                @if($personnel->personneAPrevenir)
                                                    <p><strong>Nom :</strong> {{ $personnel->personneAPrevenir->nom }} {{ $personnel->personneAPrevenir->prenom }}</p>
                                                    <p><strong>Profession :</strong> {{ $personnel->personneAPrevenir->profession }}</p>
                                                    <p><strong>Lien :</strong> {{ $personnel->personneAPrevenir->lien_parente }}</p>
                                                    <p><strong>Contact :</strong> {{ $personnel->personneAPrevenir->contact }}</p>
                                                @else
                                                    <p>Aucune personne à prévenir.</p>
                                                @endif
                                            </div>

                                            </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                            @endforeach

                     
                    </tbody>
                </table>

                </div>
            </div>
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

    <script>
         document.getElementById('exportExcel').addEventListener('click', function (e) {
        e.preventDefault();

        let table = $('#table-Personnel').DataTable();
        let data = table.rows({ search: 'applied' }).data().toArray();
        let headers = [];

        // Commencer à 1 pour ignorer la colonne de case à cocher
        $('#table-Personnel thead th').each(function (index, th) {
            if (index > 0 && index < $('#table-Personnel thead th').length - 1) {
                headers.push($(th).text().trim());
            }
        });

        let exportData = [headers];
        data.forEach(function (row) {
            let rowData = [];

            // Commencer à 1 pour ignorer la colonne de case à cocher
            for (let i = 1; i < headers.length + 1; i++) {
                let cell = $('<div>').html(row[i]).text().trim();
                rowData.push(cell);
            }

            exportData.push(rowData);
        });

        let wb = XLSX.utils.book_new();
        let ws = XLSX.utils.aoa_to_sheet(exportData);
        XLSX.utils.book_append_sheet(wb, ws, "Élèves");
        XLSX.writeFile(wb, "Liste_Du_Personnel.xlsx");
        });



        document.getElementById('exportPdf').addEventListener('click', function (e) {
            e.preventDefault();
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'pt', 'a4'); // Mode portrait

            let table = $('#table-Personnel').DataTable();
            let data = table.rows({ search: 'applied' }).data().toArray();
            let headers = [];

            $('#table-Personnel thead th').each(function (index, th) {
                if (index < $('#table-Personnel thead th').length - 1) { // ignore la colonne Action
                    headers.push($(th).text().trim());
                }
            });

            let body = [];
            data.forEach(function (row) {
                let rowData = [];
                for (let i = 0; i < headers.length; i++) {
                    let cell = $('<div>').html(row[i]).text().trim(); // nettoie HTML
                    rowData.push(cell);
                }
                body.push(rowData);
            });

            doc.autoTable({
                head: [headers],
                body: body,
                styles: {
                    fontSize: 8,
                    lineHeight: 1, // ← réduit l’espacement vertical
                },
                margin: { top: 40 },
                headStyles: { fillColor: [22, 160, 133] },
            });

            doc.save('Liste_Du_Personnel.pdf');
        });


    </script>

        <!-- SheetJS pour Le Modal -->
        <script>
          document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.showDetails').forEach(function (button) {
                button.addEventListener('click', function () {
                    const personnelId = this.getAttribute('data-id');
                    const modalId = '#personnelDetailsModal' + personnelId;

                    // Vérifie si le modal existe avant de tenter de l'ouvrir
                    const modalElement = document.querySelector(modalId);
                    if (modalElement) {
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    } else {
                        console.error("Modal introuvable pour l'ID :", modalId);
                    }
                });
            });
            });

        </script>

        <!-- Style CSS pour Le Modal -->
        <style>
            .modal-body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f9f9f9;
                padding: 1.5rem;
                border-radius: 5px;
            }

            .bloc-section {
                background-color: #ffffff;
                padding: 1.2rem;
                margin-bottom: 1.5rem;
                border-left: 6px solid #007bff;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            }

            .bloc-section h6 {
                font-size: 1.1rem;
                font-weight: bold;
                margin-bottom: 1rem;
                color: #0056b3;
                text-transform: uppercase;
            }

            .bloc-section p {
                margin: 0.3rem 0;
                color: #333;
                font-size: 0.95rem;
            }

            .enseignant-block {
                border-left-color: #28a745;
            }

            .admin-block {
                border-left-color: #ffc107;
            }

            .urgence-block {
                border-left-color: #dc3545;
            }

            .photo-du-personnel {
                position: absolute;
                top: 0;
                right: 0;
                margin: 1rem;
            }

            .photo-du-personnel img {
                width: 150px;
                height: 150px;
                object-fit: cover;
                border-radius: 10px;
                border: 2px solid #ccc;
            }
        </style>





        <script>

            function deletePersonnelConfirmation(id) {
                Swal.fire({
                    title: "Voulez-vous vraiment supprimer ce personnel ?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: "Valider",
                    cancelButtonText: "Annuler",
                    reverseButtons: true
                }).then(function (result) {
                    if (result.value === true) {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            type: 'POST',
                            url: "/personnel/delete/" + id,
                            data: {
                                _token: CSRF_TOKEN
                            },
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.success === true) {
                                    Swal.fire("Succès", response.message, "success");
                                    setTimeout(function () {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    Swal.fire("Erreur", response.message, "error");
                                }
                            },
                            error: function (xhr) {
                                Swal.fire("Erreur", "Une erreur est survenue lors de la suppression.", "error");
                                console.error(xhr.responseText);
                            }
                        });
                    }
                });
            }



        </script>



        <!-- Modal de modification du personnel -->
        <div class="modal fade" id="modifierPersonnelModal" tabindex="-1" aria-labelledby="modifierPersonnelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifierPersonnelModalLabel">Modifier le personnel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="formModifierPersonnel">
                    @csrf
                    <input type="hidden" name="personnel_id" id="personnel_id">

                    <h5 class="mt-4">Informations personnel de l'employé</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label>Prénom</label>
                            <input type="text" name="prenom" id="prenom" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Contact</label>
                            <input type="text" name="contact" id="contact" class="form-control">
                        </div>


                            <div class="col-md-6 mt-2">
                                <label for="photo">Photo</label>
                                <input type="file" name="photo" id="photo" class="form-control">
                                <small class="form-text text-muted">
                                    Laissez ce champ vide pour conserver la photo actuelle.
                                </small>
                            </div>

                        <div class="col-md-6 mt-2">
                            <label>Date de naissance</label>
                            <input type="date" name="date_naissance" id="date_naissance" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Lieu de naissance</label>
                            <input type="text" name="lieu_naissance" id="lieu_naissance" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Préfecture de naissance</label>
                            <input type="text" name="prefecture_naissance" id="prefecture_naissance" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Sexe</label>
                            <select name="sexe" id="sexe" class="form-control">
                                <option value="Masculin">Masculin</option>
                                <option value="Féminin">Féminin</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Quartier résidentiel</label>
                            <input type="text" name="quartier_residentiel" id="quartier_residentiel" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Situation familiale</label>
                            <select name="situation_familiale" id="situation_familiale" class="form-control">
                                <option value="Marié(e)">Marié(e)</option>
                                <option value="Célibataire">Célibataire</option>
                                <option value="Divorcé(e)">Divorcé(e)</option>
                                <option value="Veuf(ve)">Veuf(ve)</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Nombre d'enfants</label>
                            <input type="number" name="nombre_enfants" id="nombre_enfants" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Situation agent</label>
                            <select name="situation_agent" id="situation_agent" class="form-control">
                                <option value="Permanent">Permanent</option>
                                <option value="Vacataire">Vacataire</option>
                                <option value="Stagiaire">Stagiaire</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Diplôme académique le plus élevé</label>
                            <input type="text" name="diplome_academique_plus_eleve" id="diplome_academique_plus_eleve" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Intitulé du diplôme</label>
                            <input type="text" name="intitule_diplome" id="intitule_diplome" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Université d'obtention</label>
                            <input type="text" name="universite_obtention" id="universite_obtention" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Année d'obtention du diplôme</label>
                            <input type="number" name="annee_obtention_diplome" id="annee_obtention_diplome" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Diplôme professionnel</label>
                            <input type="text" name="diplome_professionnel" id="diplome_professionnel" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Lieu d'obtention diplôme professionnel</label>
                            <input type="text" name="lieu_obtention_diplome_professionnel" id="lieu_obtention_diplome_professionnel" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Année d'obtention diplôme professionnel</label>
                            <input type="number" name="annee_obtention_diplome_professionnel" id="annee_obtention_diplome_professionnel" class="form-control">
                        </div>


                        <div class="col-md-6 mt-2">
                            <label>Date de prise de service</label>
                            <input type="date" name="date_prise_service" id="date_prise_service" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Nom de l'époux(se)</label>
                            <input type="text" name="nom_epoux_ou_epouse" id="nom_epoux_ou_epouse" class="form-control">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Contact de l'époux(se)</label>
                            <input type="text" name="contact_epoux_ou_epouse" id="contact_epoux_ou_epouse" class="form-control">
                        </div>

                        <h5 class="mt-4">Personne à prévenir en cas d'urgence</h5>
                        <div class="row">

                            <div class="col-md-6 mt-2">
                                <label>Nom</label>
                                <input type="text" name="p_nom" id="p_nom" class="form-control">
                            </div>

                            <div class="col-md-6 mt-2">
                                <label>Prénom</label>
                                <input type="text" name="p_prenom" id="p_prenom" class="form-control">
                            </div>

                            <div class="col-md-6 mt-2">
                                <label>Profession</label>
                                <input type="text" name="p_profession" id="p_profession" class="form-control">
                            </div>

                            <div class="col-md-6 mt-2">
                                <label>Lien de parenté</label>
                                <input type="text" name="p_lien_parente" id="p_lien_parente" class="form-control">
                            </div>

                            <div class="col-md-6 mt-2">
                                <label>Adresse</label>
                                <input type="text" name="p_adresse" id="p_adresse" class="form-control">
                            </div>

                            <div class="col-md-6 mt-2">
                                <label>Contact</label>
                                <input type="text" name="p_contact" id="p_contact" class="form-control">
                            </div>

                        </div>

                        <h5 class="mt-4">Type de personnel</h5>

                        <div class="row">
                            <div class="col-md-6 mt-2">
                                <label for="type_personnel">Type</label>
                                <select name="type_personnel" id="type_personnel" class="form-control">
                                    <option value="">-- Sélectionner --</option>
                                    <option value="administratif" {{ $personnel->administratif ? 'selected' : '' }}>Administratif</option>
                                    <option value="enseignant" {{ $personnel->enseignant ? 'selected' : '' }}>Enseignant</option>

                                </select>
                            </div>
                        </div>

                        {{-- Section Administratif --}}
                        <div id="section_administratif" style="{{ $personnel->administratif ? '' : 'display:none;' }}">
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <label for="fonction_occupee">Fonction occupée</label>
                                    <input type="text" name="fonction_occupee" class="form-control" value="{{ $personnel->administratif->fonction_occupee ?? '' }}">
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="service">Service</label>
                                    <input type="text" name="service" class="form-control" value="{{ $personnel->administratif->service ?? '' }}">
                                </div>
                            </div>
                        </div>

                        {{-- Section Enseignant --}}
                        <div id="section_enseignant" style="{{ $personnel->enseignant ? '' : 'display:none;' }}">
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <label for="dominante">Dominante</label>
                                    <input type="text" name="dominante" class="form-control" value="{{ $personnel->enseignant->dominante ?? '' }}">
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="sous_dominante">Sous-dominante</label>
                                    <input type="text" name="sous_dominante" class="form-control" value="{{ $personnel->enseignant->sous_dominante ?? '' }}">
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="volume_horaire">Volume horaire</label>
                                    <input type="number" name="volume_horaire" class="form-control" value="{{ $personnel->enseignant->volume_horaire ?? '' }}">
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="classe_intervention">Classe d’intervention</label>
                                    <input type="text" name="classe_intervention" class="form-control" value="{{ $personnel->enseignant->classe_intervention ?? '' }}">
                                </div>

                            
                            </div>
                        </div>

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="enregistrerModification">Enregistrer</button>
            </div>
            </div>
        </div>
        </div>




        <script>
            $(document).ready(function () {
                // Ouvrir le modal avec les données du personnel à modifier
                $('.modifierPersonnel').click(function () {
                    var id = $(this).data('id');

                    $.ajax({
                        url: '/personnel/' + id + '/edit',
                        method: 'GET',
                        success: function (data) {
                            $('#personnel_id').val(data.id);
                            $('#nom').val(data.nom);
                            $('#prenom').val(data.prenom);
                            $('#email').val(data.email);
                            $('#contact').val(data.contact);
                            $('#date_naissance').val(data.date_naissance);
                            $('#lieu_naissance').val(data.lieu_naissance);
                            $('#prefecture_naissance').val(data.prefecture_naissance);
                            $('#sexe').val(data.sexe);
                            $('#quartier_residentiel').val(data.quartier_residentiel);
                            $('#situation_familiale').val(data.situation_familiale);
                            $('#nombre_enfants').val(data.nombre_enfants);
                            $('#situation_agent').val(data.situation_agent);
                            $('#diplome_academique_plus_eleve').val(data.diplome_academique_plus_eleve);
                            $('#intitule_diplome').val(data.intitule_diplome);
                            $('#universite_obtention').val(data.universite_obtention);
                            $('#annee_obtention_diplome').val(data.annee_obtention_diplome);
                            $('#diplome_professionnel').val(data.diplome_professionnel);
                            $('#lieu_obtention_diplome_professionnel').val(data.lieu_obtention_diplome_professionnel);
                            $('#annee_obtention_diplome_professionnel').val(data.annee_obtention_diplome_professionnel);
                            $('#anciennete').val(data.anciennete);
                            $('#nom_epoux_ou_epouse').val(data.nom_epoux_ou_epouse);
                            $('#contact_epoux_ou_epouse').val(data.contact_epoux_ou_epouse);
                            $('#date_prise_service').val(data.date_prise_service);
                            $('#statut').val(data.statut);

                            if (data.personne_a_prevenir) {
                                $('#p_nom').val(data.personne_a_prevenir.nom);
                                $('#p_prenom').val(data.personne_a_prevenir.prenom);
                                $('#p_profession').val(data.personne_a_prevenir.profession);
                                $('#p_lien_parente').val(data.personne_a_prevenir.lien_parente);
                                $('#p_adresse').val(data.personne_a_prevenir.adresse);
                                $('#p_contact').val(data.personne_a_prevenir.contact);
                            }

                            if (data.administratif) {
                                $('#type_personnel').val('administratif');
                                $('#section_administratif').show();
                                $('#section_enseignant').hide();
                                $('input[name="fonction_occupee"]').val(data.administratif.fonction_occupee);
                                $('input[name="service"]').val(data.administratif.service);
                            } else if (data.enseignant) {
                                $('#type_personnel').val('enseignant');
                                $('#section_administratif').hide();
                                $('#section_enseignant').show();
                                $('input[name="dominante"]').val(data.enseignant.dominante);
                                $('input[name="sous_dominante"]').val(data.enseignant.sous_dominante);
                                $('input[name="volume_horaire"]').val(data.enseignant.volume_horaire);
                                $('input[name="classe_intervention"]').val(data.enseignant.classe_intervention);
                            } else {
                                $('#type_personnel').val('');
                                $('#section_administratif, #section_enseignant').hide();
                            }

                            $('#modifierPersonnelModal').modal('show');
                        }
                    });
                });

                // Soumission du formulaire via jQuery AJAX
                $('#enregistrerModification').click(function (e) {
                    e.preventDefault();

                    var form = $('#formModifierPersonnel')[0]; // Récupère le formulaire en natif
                    var formData = new FormData(form); // Utilise FormData pour envoyer les données

                    $.ajax({
                        url: "{{ route('personnel.update') }}",
                        type: 'POST',
                        data: formData,
                        processData: false, // Ne pas transformer les données
                        contentType: false, // Laisser le navigateur définir le bon type
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: data.message,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                $('#modifierPersonnelModal').modal('hide');
                                location.reload();
                            });
                        },

                        error: function (xhr) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Une erreur est survenue lors de la mise à jour.',
                            });
                        }

                    });
                });

                // Affichage conditionnel des sections selon le type de personnel
                $('#type_personnel').change(function () {
                    var type = $(this).val();
                    if (type === 'administratif') {
                        $('#section_administratif').show();
                        $('#section_enseignant').hide();
                    } else if (type === 'enseignant') {
                        $('#section_administratif').hide();
                        $('#section_enseignant').show();
                    } else {
                        $('#section_administratif, #section_enseignant').hide();
                    }
                });
            });
        </script>


        <script>
            document.getElementById('type_personnel').addEventListener('change', function () {
                const type = this.value;
                document.getElementById('section_administratif').style.display = (type === 'administratif') ? 'block' : 'none';
                document.getElementById('section_enseignant').style.display = (type === 'enseignant') ? 'block' : 'none';
            });
            

        </script>

@endsection
