


@extends('layout')

@section('title')

DRH | Gestion de paie

@endsection

@section('css')



    <link href="{{asset('app/css/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />


@endsection

@section('contenu')

    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4 class="fw-bold">Gestion de Paie </h4>
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
                                <th style="width: 15%">Employé</th>
                                <th style="width: 10%">Poste</th>
                                <th style="width: 15%">Type de Personnel</th>
                                <th style="width: 10%">Contact</th>
                                <th style="width: 10%">Salaire</th>
                                <th style="width: 10%">Statut du mois</th>
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($personnels as $personnel)
                                <tr>
                                    {{-- 1. EMPLOYÉ (Nom + Prénom) --}}
                                    <td>{{ $personnel->nom }} {{ $personnel->prenom }}</td>

                                    {{-- 2. POSTE (nom du poste) --}}
                                    <td>
                                        {{ $personnel->poste ? $personnel->poste->nom : 'Non défini' }}
                                    </td>

                                    {{-- 3. TYPE DE PERSONNEL --}}
                                    <td>
                                        @if($personnel->enseignant)
                                            <span class="badge bg-primary">Enseignant</span>
                                        @elseif($personnel->administratif)
                                            <span class="badge bg-success">Administratif</span>
                                        @else
                                            <span class="badge bg-danger">Non défini</span>
                                        @endif
                                    </td>

                                    {{-- 4. CONTACT (attribut de personnel) --}}
                                    <td>{{ $personnel->contact }}</td>

                                    {{-- 5. SALAIRE --}}
                                    <td>
                                        @if($personnel->enseignant && $personnel->poste)
                                            {{-- Enseignant: salaire_horaire * volume_horaire --}}
                                            @php
                                                $volume = $personnel->enseignant->volume_horaire ?? 0;
                                                $salaire = $personnel->poste->salaire_horaire ?? 0;
                                                $total = $volume * $salaire;
                                            @endphp
                                            {{ number_format($total, 2, ',', ' ') }} FCFA
                                        @elseif($personnel->administratif && $personnel->poste)
                                            {{-- Administratif: salaire_base --}}
                                            {{ number_format($personnel->poste->salaire_base, 2, ',', ' ') }} FCFA
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    {{-- 6. STATUT DU MOIS (Oui/Non) --}}
                                    <td>
                                        @if($personnel->salaire_du_mois) 
                                            <span class="badge bg-success">Oui</span>
                                        @else
                                            <span class="badge bg-danger">Non</span>
                                        @endif
                                    </td>
 
 

  
                                    {{-- 7. ACTIONS --}}
                                  
                                <td class="text-center">
                                    <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                        <a href="javascript:void(0);" 
                                            class="dropdown-item showDetails" 
                                            data-id="{{ $personnel->id }}"
                                            data-nom="{{ $personnel->nom }}"
                                            data-prenom="{{ $personnel->prenom }}"
                                            data-adresse="{{ $personnel->contact }}"
                                            data-poste="{{ $personnel->poste->nom ?? '' }}"

                                            data-type="{{ $personnel->enseignant ? 'enseignant' : ($personnel->administratif ? 'administratif' : '') }}"
                                            data-salaire_base="{{ $personnel->poste->salaire_base ?? 0 }}"
                                            data-salaire_horaire="{{ $personnel->poste->salaire_horaire ?? 0 }}"
                                            data-volume="{{ $personnel->enseignant->volume_horaire ?? 0 }}">
                                                <i class="fa fa-money-bill info-img"></i> Payer
                                        </a>




                                        </li>

                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item modifierPersonnel" data-id="123"> <i class="fa fa-gavel info-img"></i> Appliquer sanction</a>
                                        </li>



                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item" >  <i data-feather="eye" class="info-img"></i> Détails  </a>
                                        </li>

                                        



                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item" ><i data-feather="mail" class="info-img"></i>Envoyer un email  </a>
                                        </li>


                                    </ul>
                                </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Aucun personnel trouvé</td>
                                </tr>
                            @endforelse

                            <!-- Modal -->
                            <div class="modal fade" id="paiementModal" tabindex="-1" aria-labelledby="paiementModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                <form id="paiementForm">
                                     <input type="hidden" name="personnel_id" id="personnel_id" value="">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="paiementModalLabel">Paiement du Personnel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        
                                    <div class="row g-3">
                                        <!-- Champs préremplis -->
                                        <div class="col-md-4">
                                        <label>Nom</label>
                                        <input type="text" id="modal_nom"name="nom" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-4">
                                        <label>Prénom</label>
                                        <input type="text" id="modal_prenom" name="prenom" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-4">
                                        <label>Contact</label>
                                        <input type="text" id="modal_adresse" name="adresse" class="form-control" readonly>
                                        </div>
                                        <div class="col-md-4">
                                        <label>Poste</label>
                                        <input type="text" id="poste" name="modal_poste" class="form-control" readonly>
                                        </div>
                                         <div class="col-md-4">
                                            <label>Période</label>
                                            <input type="month" name="periode" id="periode" class="form-control" 
                                                placeholder="Mois/Année"
                                                data-date-prise-service="{{ \Carbon\Carbon::parse($personnel->date_prise_service)->format('Y-m') }}">
                                         </div>


                                        <!-- Heures supp & Primes -->
                                        <div class="col-md-2">
                                        <label>Heures Supp.</label>
                                        <input type="number" step="0.01" name="heures_supp" class="form-control calc">
                                        </div>
                                        <div class="col-md-2">
                                        <label>Logement</label>
                                        <input type="number" step="0.01" name="logement" class="form-control calc">
                                        </div>
                                        <div class="col-md-2">
                                        <label>Commission</label>
                                        <input type="number" step="0.01" name="commission" class="form-control calc">
                                        </div>
                                        <div class="col-md-2">
                                        <label>Transport</label>
                                        <input type="number" step="0.01" name="transport" class="form-control calc">
                                        </div>
                                        <div class="col-md-2">
                                        <label>Congés</label>
                                        <input type="number" step="0.01" name="conges" class="form-control calc">
                                        </div>
                                        <div class="col-md-2">
                                        <label>Prime repos</label>
                                        <input type="number" step="0.01" name="prime_repos" class="form-control calc">
                                        </div>
                                        <div class="col-md-2">
                                        <label>Divers</label>
                                        <input type="number" step="0.01" name="divers" class="form-control calc">
                                        </div>

                                        <!-- Affichage salaire brut -->
                                        <div class="col-md-12 mt-3">
                                        <h5>Salaire Brut: <span id="salaire_brut">0</span> FCFA</h5>
                                        </div>

                                        <!-- Retenues -->
                                        <div class="col-md-2">
                                        <label>CNSS</label>
                                        <input type="number" step="0.01" name="cnss" class="form-control retenue">
                                        </div>
                                        <div class="col-md-2">
                                        <label>INS</label>
                                        <input type="number" step="0.01" name="ins" class="form-control retenue">
                                        </div>
                                        <div class="col-md-2">
                                        <label>IRPP</label>
                                        <input type="number" step="0.01" name="irpp" class="form-control retenue">
                                        </div>
                                        <div class="col-md-2">
                                        <label>TCS</label>
                                        <input type="number" step="0.01" name="tcs" class="form-control retenue">
                                        </div>
                                        <div class="col-md-2">
                                        <label>Crédit</label>
                                        <input type="number" step="0.01" name="credit" class="form-control retenue">
                                        </div>
                                        <div class="col-md-2">
                                        <label>Absences</label>
                                        <input type="number" step="0.01" name="absences" class="form-control retenue">
                                        </div>
                                        <div class="col-md-2">
                                        <label>Avance</label>
                                        <input type="number" step="0.01" name="avance_salaire" class="form-control retenue">
                                        </div>
                                        <div class="col-md-2">
                                        <label>Acompte</label>
                                        <input type="number" step="0.01" name="acompte" class="form-control retenue">
                                        </div>
                                        <div class="col-md-2">
                                        <label>Autre Retenue</label>
                                        <input type="number" step="0.01" name="autre_retenue" class="form-control retenue">
                                        </div>

                                        <!-- Affichage total retenues & net -->
                                        <div class="col-md-12 mt-3">
                                        <h5>Total Retenues: <span id="total_retenue">0</span> FCFA</h5>
                                        <h4>Salaire Net à Payer: <span id="salaire_net">0</span> FCFA</h4>
                                        </div>
                                        <input type="hidden" name="salaire_base" id="salaire_base" value="">
                                    </div>
                                    </div>

                                    <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Valider Paiement</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                            </div>

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


        <!-- SheetJS pour LE MODALE DE PAYEMENT -->
    <script>
        // Gestion de l'ouverture de la modal et calcul initial
        $(document).on('click', '.showDetails', function () {
            let modal = $('#paiementModal');
            let id = $(this).data('id');
            let type = $(this).data('type');
            let salaire_base = parseFloat($(this).data('salaire_base'));
            let salaire_horaire = parseFloat($(this).data('salaire_horaire'));
            let volume = parseFloat($(this).data('volume'));

            var nom = $(this).data('nom');
            var prenom = $(this).data('prenom');
            var adresse = $(this).data('adresse');
            var poste = $(this).data('poste');

            // Remplir les champs du modal
            $('#modal_nom').val(nom);
            $('#modal_prenom').val(prenom);
            $('#modal_adresse').val(adresse);
            $('#poste').val(poste);

            // Mettre à jour le champ caché personnel_id
            $('#personnel_id').val(id);
            $('#salaire_base').val(salaire_base);

            // Calcul salaire de base
            let salaire_base_calcule = 0;
            if (type === 'enseignant') {
            salaire_base_calcule = volume * salaire_horaire;
            } else if (type === 'administratif') {
            salaire_base_calcule = salaire_base;
            }

            // Stockage dans un champ caché
            modal.data('salaire_base_calcule', salaire_base_calcule);

            // Mise à jour brut au début
            recalculerSalaire();

            modal.modal('show');
        });

        // Recalcul des totaux
        $(document).on('input', '.calc, .retenue', function () {
            recalculerSalaire();
        });

        function recalculerSalaire() {
            let modal = $('#paiementModal');
            let salaire_base_calcule = modal.data('salaire_base_calcule') || 0;

           let total_primes = 0;
            $('.calc').each(function () {
                if ($(this).attr('id') !== 'salaire_horaire') { // Exclure salaire_horaire
                    total_primes += parseFloat($(this).val()) || 0;
                }
            });


            let salaire_brut = salaire_base_calcule + total_primes;
            $('#salaire_brut').text(salaire_brut.toLocaleString());

            let total_retenue = 0;
            $('.retenue').each(function () {
            total_retenue += parseFloat($(this).val()) || 0;
            });

            $('#total_retenue').text(total_retenue.toLocaleString());

            let salaire_net = salaire_brut - total_retenue;
            $('#salaire_net').text(salaire_net.toLocaleString());
        }

        // Gestion de la période (champ mois/année)
        document.addEventListener('DOMContentLoaded', function () {
            let periodeInput = document.getElementById('periode');

            // Par défaut : le mois actuel
            let now = new Date();
            let moisActuel = now.toISOString().slice(0, 7); // Format "YYYY-MM"
            periodeInput.value = moisActuel;
            periodeInput.max = moisActuel;

            // Récupération de date_prise_service
            let datePriseService = periodeInput.dataset.datePriseService;
            if (datePriseService) {
            periodeInput.min = datePriseService;
            }

            // Vérification dynamique lors de la saisie
            periodeInput.addEventListener("input", function () {
            const [year, month] = this.value.split("-").map(Number);
            const currentYear = now.getFullYear();
            const currentMonth = now.getMonth() + 1;

            if (year === currentYear && month > currentMonth) {
                Swal.fire("Impossible de sélectionner un mois dans le futur !");
                this.value = moisActuel;
            } else if (datePriseService && this.value < datePriseService) {
                Swal.fire("Impossible de sélectionner une date avant la prise de service !");
                this.value = datePriseService;
            }
            });
        });

        // Soumission AJAX du formulaire
       document.getElementById("paiementForm").addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch("/paiement/store", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire("Paiement enregistré avec succès !");
                const modal = bootstrap.Modal.getInstance(document.getElementById("paiementModal"));
                modal.hide();

                // Ouvrir le PDF de la facture
                window.open(data.pdf_url, "_blank");

                // Générer automatiquement le bulletin
                fetch("/bulletins/store", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: new FormData(document.querySelector("#paiementForm")) // adapte si un autre formulaire est nécessaire
                })
                .then(response => response.json())
                .then(bulletinData => {
                    if (bulletinData.success) {
                        // Ouvrir le PDF du bulletin généré
                        window.open(`/imprimer-bulletin/${bulletinData.bulletin_id}`, "_blank");
                    } else {
                        Swal.fire("Échec de la génération du bulletin.");
                    }

                    // Recharger la page après la génération (ou l’échec)
                    location.reload();
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire("Erreur lors de la génération du bulletin !");
                    location.reload(); // recharger même en cas d'erreur de génération
                });

            } else {
                Swal.fire("Erreur : " + data.message);
            }
        })
        .catch(error => {
            console.error(error);
           Swal.fire("Erreur lors de l’enregistrement !");
        });
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
             
             $(document).on('click', '.modifierPersonnel', function (e) {
            e.preventDefault();

            const personnelId = $(this).data('id');

            $.ajax({
                url: '/personnel/' + personnelId,
                type: 'GET',
                success: function (response) {
                    if (response.success) {
                        const p = response.personnel;

                        $('#nom').val(p.nom);
                        $('#prenom').val(p.prenom);
                        $('#contact').val(p.contact);
                        $('#email').val(p.email);
                        $('#date_naissance').val(p.date_naissance);
                        $('#lieu_naissance').val(p.lieu_naissance);
                        $('#prefecture_naissance').val(p.prefecture_naissance);
                        $('#sexe').val(p.sexe);
                        $('#quartier_residentiel').val(p.quartier_residentiel);
                        $('#situation_familiale').val(p.situation_familiale);
                        $('#nombre_enfants').val(p.nombre_enfants);
                        $('#situation_agent').val(p.situation_agent);
                        $('#diplome_academique_plus_eleve').val(p.diplome_academique_plus_eleve);
                        $('#intitule_diplome').val(p.intitule_diplome);
                        $('#universite_obtention').val(p.universite_obtention);
                        $('#annee_obtention_diplome').val(p.annee_obtention_diplome);
                        $('#diplome_professionnel').val(p.diplome_professionnel);
                        $('#lieu_obtention_diplome_professionnel').val(p.lieu_obtention_diplome_professionnel);
                        $('#annee_obtention_diplome_professionnel').val(p.annee_obtention_diplome_professionnel);
                        $('#anciennete').val(p.anciennete);
                        $('#nom_epoux_ou_epouse').val(p.nom_epoux_ou_epouse);
                        $('#contact_epoux_ou_epouse').val(p.contact_epoux_ou_epouse);
                        $('#date_prise_service').val(p.date_prise_service);
                        $('#statut').val(p.statut);
                        $('#etat').val(p.etat);

                        if (p.photo) {
                            $('#photoPreview').attr('src', '/chemin/vers/images/' + p.photo);
                        }

                        $('#modifierPersonnelModal').modal('show');
                    } else {
                        alert("Le personnel n’a pas été trouvé.");
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert("Erreur lors du chargement des données.");
                }
            });
          });


        </script>


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


@endsection
