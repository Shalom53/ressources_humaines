


@extends('layout')

@section('title')

DRH | Liste Des Contrats

@endsection

@section('css')



    <link href="{{asset('app/css/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />


@endsection

@section('contenu')

    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4 class="fw-bold">Liste Des Contrats </h4>
                    <h6>Employées  </h6>
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
                                <th style="width: 15%">Type de contrat</th>
                                <th style="width: 15%">Durée</th>
                                <th style="width: 15%">Date début</th>
                                <th style="width: 15%">Date fin</th>
                                <th style="width: 15%">Ancienneté</th>
                                 <th style="width: 15%">Décompte</th>
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($personnels as $personnel)
                                <tr>
                                    <td>{{ $personnel->nom }} {{ $personnel->prenom }}</td>
                                    <td>{{ $personnel->poste ? $personnel->poste->nom : 'Non défini' }}</td>
                                    <td>{{ $personnel->contrat->type ?? 'Non défini' }}</td>
                                    <td>{{ $personnel->contrat->Dure ?? 'Non définie' }}</td>
                                    <td>{{ $personnel->contrat->date_debut ?? 'Non définie' }}</td>
                                    <td>{{ $personnel->contrat->date_fin ?? 'Non définie' }}</td>
                                    <td>
                                        @if($personnel->contrat)
                                            @php
                                                $debut = \Carbon\Carbon::parse($personnel->contrat->date_debut)->locale('fr');
                                                $maintenant = \Carbon\Carbon::now();

                                                $mois = $debut->diffInMonths($maintenant);
                                                $ans = floor($mois / 12);
                                                $moisRestant = $mois % 12;
                                            @endphp

                                            @if($mois < 1)
                                                {{ $debut->diffInDays($maintenant) }} jour(s)
                                            @elseif($mois < 12)
                                                {{ $mois }} mois
                                            @else
                                                {{ $ans }} an(s) @if($moisRestant > 0) et {{ $moisRestant }} mois @endif
                                            @endif
                                        @else
                                            Non défini
                                        @endif
                                    </td>



                                    <td>
                                        @if($personnel->contrat && $personnel->contrat->date_fin)
                                            @php
                                                $fin = \Carbon\Carbon::parse($personnel->contrat->date_fin)->locale('fr');
                                                $maintenant = \Carbon\Carbon::now();

                                                $moisRestants = $maintenant->diffInMonths($fin, false); // false pour avoir des valeurs négatives
                                                $joursRestants = $maintenant->diffInDays($fin, false);

                                                $ans = floor($moisRestants / 12);
                                                $mois = $moisRestants % 12;
                                            @endphp

                                            @if($joursRestants < 0)
                                                Expiré depuis {{ abs($joursRestants) }} jour(s)
                                            @elseif($moisRestants < 1)
                                                {{ $joursRestants }} jour(s)
                                            @elseif($moisRestants < 12)
                                                {{ $moisRestants }} mois
                                            @else
                                                {{ $ans }} an(s) @if($mois > 0) et {{ $mois }} mois @endif
                                            @endif
                                        @else
                                            Non défini
                                        @endif
                                    </td>



                                    <td>
                                        <div class="hstack gap-2 fs-15">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger voir-contrats"
                                            data-id="{{ $personnel->id }}" title="Voir le contrat">
                                            <i data-feather="folder"></i>
                                            </a>


                                            @if($personnel->contrat)
                                                <a href="javascript:void(0);" class="btn btn-sm btn-warning modifier-Contrat" data-id="{{ $personnel->contrat->id }}" title="Modifier le contrat">
                                                    <i data-feather="edit"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0);" class="btn btn-sm btn-danger ajouter-Contrat" data-id="{{ $personnel->id }}" title="Ajouter un contrat">
                                                    <i data-feather="plus"></i>
                                                </a>
                                            @endif


                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Aucun personnel trouvé</td>
                                </tr>
                            @endforelse
                        </tbody>


                        <!-- Modal d'ajout/modification de contrat -->
                        <div class="modal fade" id="ajouterContratModal" tabindex="-1" aria-labelledby="ajouterContratLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <form id="formContrat" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="personnel_id" id="modal_personnel_id">
                                    <input type="hidden" name="_method" id="form_method" value="POST">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ajouterContratLabel">Ajouter un contrat</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Champs identiques à ton modal d'origine -->
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
                                                        <label for="fichier" class="form-label">Fichier du contrat (PDF) <span class="text-danger">*</span></label>
                                                        <input type="file" name="fichier" id="fichier" class="form-control" accept=".pdf">
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

    <!-- SheetJS pour ouvrir Le Modal d'ajout des Contrats -->

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Ouvrir modal Ajout
            document.querySelectorAll(".ajouter-Contrat").forEach(btn => {
                btn.addEventListener("click", function () {
                    let personnelId = this.dataset.id;
                    // Reset formulaire
                    resetForm();
                    // Remplir personnel_id
                    document.getElementById('modal_personnel_id').value = personnelId;
                    // Mettre action et méthode du formulaire pour store
                    let form = document.getElementById('formContrat');
                    form.action = "{{ route('contrats.store') }}";
                    document.getElementById('form_method').value = 'POST';
                    // Changer titre et bouton
                    document.getElementById('ajouterContratLabel').textContent = "Ajouter un contrat";
                    document.getElementById('submitBtn').textContent = "Ajouter";
                    // Ouvrir modal
                    new bootstrap.Modal(document.getElementById('ajouterContratModal')).show();
                });
            });

            // Ouvrir modal Modification
            document.querySelectorAll(".modifier-Contrat").forEach(btn => {
                btn.addEventListener("click", function () {
                    let contratId = this.dataset.id;
                    fetch(`/contrats/${contratId}/edit`)  // route API à créer
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                fillForm(data.contrat);
                                // Mettre action et méthode pour update
                                let form = document.getElementById('formContrat');
                                form.action = `/contrats/${contratId}`;
                                document.getElementById('form_method').value = 'PUT';
                                // Changer titre et bouton
                                document.getElementById('ajouterContratLabel').textContent = "Modifier le contrat";
                                document.getElementById('submitBtn').textContent = "Modifier";
                                // Ouvrir modal
                                new bootstrap.Modal(document.getElementById('ajouterContratModal')).show();
                            } else {
                                alert("Erreur lors de la récupération des données du contrat.");
                            }
                        });
                });
            });

            // Fonction pour remplir le formulaire avec les données du contrat
            function fillForm(contrat) {
                document.getElementById('modal_personnel_id').value = contrat.personnel_id;
                document.getElementById('type').value = contrat.type;
                document.getElementById('Dure').value = contrat.Dure;
                document.getElementById('date_debut').value = contrat.date_debut;
                document.getElementById('date_fin').value = contrat.date_fin;
                document.getElementById('salaire').value = contrat.salaire;
                // Le fichier PDF ne peut pas être prérempli (sécurité), laisser vide
                document.getElementById('fichier').value = '';
                document.getElementById('description').value = contrat.description;
            }

            // Fonction pour reset le formulaire
            function resetForm() {
                document.getElementById('formContrat').reset();
                document.getElementById('form_method').value = 'POST';
            }
        });

    </script>

    <!-- SheetJS pour soumettre Le Modal d'ajout des Contrats -->
    <script>
        $(document).ready(function () {
            $('#formContrat').on('submit', function (e) {
                e.preventDefault();

                let form = this;
                let formData = new FormData(form);

                let url = form.action;
                let method = $('#form_method').val() || 'POST';

                // Si method est PUT, on envoie en POST avec _method=PUT (méthode "spoofing" Laravel)
                let ajaxType = method === 'PUT' ? 'POST' : method;
                if (method === 'PUT') {
                    formData.set('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    type: ajaxType,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Succès',
                            text: response.message || (method === 'POST' ? 'Contrat ajouté avec succès' : 'Contrat modifié avec succès'),
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#ajouterContratModal').modal('hide');
                            $('#formContrat')[0].reset();
                            location.reload();
                        });
                    },
                    error: function (xhr) {
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







<div class="modal fade" id="voirContratModal" tabindex="-1" aria-labelledby="voirContratLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="voirContratLabel">Détails du contrat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div id="contrat-details">
          <!-- Les infos du contrat seront injectées ici via JS -->
          <p><strong>Type :</strong> <span id="contrat-type"></span></p>
          <p><strong>Durée :</strong> <span id="contrat-duree"></span></p>
          <p><strong>Date de début :</strong> <span id="contrat-date-debut"></span></p>
          <p><strong>Date de fin :</strong> <span id="contrat-date-fin"></span></p>
          <p><strong>Salaire :</strong> <span id="contrat-salaire"></span> FCFA</p>
          <p><strong>Description :</strong> <span id="contrat-description"></span></p>
          <p><strong>Statut :</strong> <span id="contrat-statut"></span></p>
          
          <p><strong>Fichier :</strong> <a href="#" id="contrat-fichier" target="_blank" download>Télécharger le PDF</a></p>
        </div>
      </div>
      <div class="modal-footer">
<button type="button"
        class="btn btn-sm btn-outline-primary"
        id="btnModifierStatut" data-id=>
    Modifier le statut
</button>



        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function () {
    // 🔹 Afficher les détails du contrat
    $('.voir-contrats').click(function () {
        const personnelId = $(this).data('id');

        $.ajax({
            url: '/contrats/' + personnelId,
            method: 'GET',
            success: function (data) {
                $('#contrat-type').text(data.type);
                $('#contrat-duree').text(data.duree || 'Non défini');
                $('#contrat-date-debut').text(data.date_debut);
                $('#contrat-date-fin').text(data.date_fin);
                $('#contrat-salaire').text(data.salaire || '0');
                $('#contrat-description').text(data.description);
                $('#contrat-statut').text(data.statut);
                $('#contrat-fichier').attr('href', data.fichier_url);

                // Injecte les données dans le bouton
                 $('#btnModifierStatut')
               
                    .attr('data-id', data.id)
                    .attr('data-statut', data.statut);


                var modal = new bootstrap.Modal(document.getElementById('voirContratModal'));
                modal.show();
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: xhr.responseJSON?.message || 'Impossible de charger le contrat.'
                });
            }
        });
    });

    // 🔹 Modifier le statut (avec les bons data-id dynamiques)
    $('#btnModifierStatut').click(function () {
    const contratId = $(this).attr('data-id');

    alert (contratId)
    const statutActuel = $(this).attr('data-statut');

        if (!contratId) {
            Swal.fire('Erreur', 'Identifiant du contrat non trouvé.', 'error');
            return;
        }

        Swal.fire({
            title: 'Modifier le statut du contrat',
            input: 'select',
            inputOptions: {
                actif: 'Actif',
                licencie: 'Licencié',
                retraite: 'En retraite',
                renouvele: 'Renouvelé'
            },
            inputValue: statutActuel,
            showCancelButton: true,
            confirmButtonText: 'Modifier',
            cancelButtonText: 'Annuler'
        }).then(result => {
            if (result.isConfirmed) {
                fetch(`/contrats/${contratId}/changer-statut`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ statut: result.value })
                })
                    .then(res => res.json())
                    .then(data => {
                        Swal.fire('Succès', 'Statut mis à jour', 'success');
                        location.reload();
                    })
                    .catch(() => {
                        Swal.fire('Erreur', 'Une erreur est survenue', 'error');
                    });
            }
        });
    });
});
</script>







@endsection
