


@extends('layout')

@section('title')

DRH | Liste des Postes

@endsection

@section('css')



    <link href="{{asset('app/css/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


@endsection

@section('contenu')

    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                <h4 class="fw-bold">Liste des Postes </h4>
                <h6>Liste des Postes</h6>
                </div>
            </div>
            <ul class="table-top-head">
            <li>
                <a href="#" id="exportPdf" data-bs-toggle="tooltip" data-bs-placement="top" title="Exporter en Pdf"><img src="{{asset('app')}}/assets/img/icons/pdf.svg" alt="PDF"></a>
            </li>
            <li>
                <a href="#" id="exportExcel" data-bs-toggle="tooltip" data-bs-placement="top" title="Exporter en Excel"><img src="{{asset('app')}}/assets/img/icons/excel.svg" alt="Excel"></a>
            </li>

            <li>
                <a href="javascript:void(0);" class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                data-bs-toggle="modal" data-bs-target="#addPosteModal">
                    <i class="bi bi-plus"></i> 
                </a>
            </li>


            </ul>
            <div class="page-btn">

                <!-- Modal d'ajout de poste -->
                <div class="modal fade" id="addPosteModal" tabindex="-1" aria-labelledby="addPosteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <form action="{{ route('listePostes.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                        <h5 class="modal-title" id="addPosteModalLabel">Ajouter un poste</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>

                        <div class="modal-body">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Intitulé du poste</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="type_personnel" class="form-label">Type de personnel</label>
                            <select name="type_personnel" id="type_personnel" class="form-select" required>
                            <option value="" selected disabled>Choisir le type</option>
                            <option value="administratif">Administratif</option>
                            <option value="enseignant">Enseignant</option>
                            </select>
                        </div>

                        <div class="mb-3" id="salaire_base_group" style="display:none;">
                            <label for="salaire_base" class="form-label">Salaire de base (Administratif)</label>
                            <input type="number" name="salaire_base" class="form-control" min="0" step="0.01">
                        </div>

                        <div class="mb-3" id="salaire_horaire_group" style="display:none;">
                            <label for="salaire_horaire" class="form-label">Salaire horaire (Enseignant)</label>
                            <input type="number" name="salaire_horaire" class="form-control" min="0" step="0.01">
                        </div>
                        </div>

                        <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>

                   

            </div>
            </div>
        <!-- /product list -->

      
        <!-- Table des types de sanctions -->
        
    
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table datatable" id="table-Postes">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 45%">Intitulé</th>
                                <th style="width: 25%">Salaire Base (FCFA)</th>
                                <th style="width: 25%">Salaire Horaire (FCFA)</th>
                                <th class="no-sort text-center" style="width: 20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($postes as $poste)
                                <tr>
                                    <td>{{ $poste->nom }}</td>
                                    <td>
                                        @if ($poste->salaire_base > 0)
                                        {{ number_format($poste->salaire_base, 0, ',', ' ') }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($poste->salaire_horaire > 0)
                                        {{ number_format($poste->salaire_horaire, 0, ',', ' ') }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="javascript:void(0);" 
                                        class="text-primary me-2 modifierPoste" 
                                        title="Modifier"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editPosteModal"
                                        data-id="{{ $poste->id }}"
                                        data-nom="{{ $poste->nom }}"
                                        data-salaire="{{ $poste->salaire }}">
                                            <i class="fa fa-edit fa-lg"></i>
                                        </a>
                                        <a href="javascript:void(0);" 
                                        class="text-danger Supprimerposte" 
                                        data-id="{{ $poste->id }}" 
                                        title="Supprimer">
                                            <i class="fa fa-trash fa-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                               
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

           <!-- Modal de modification -->
            <div class="modal fade" id="editPosteModal" tabindex="-1" aria-labelledby="editPosteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <form id="editPosteForm" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                    <h5 class="modal-title" id="editPosteModalLabel">Modifier le poste</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                    <div class="mb-3">
                        <label for="editNom" class="form-label">Intitulé du poste</label>
                        <input type="text" class="form-control" id="editNom" name="nom" required>
                    </div>

                    <div class="mb-3">
                        <label for="editTypePersonnel" class="form-label">Type de personnel</label>
                        <select name="type_personnel" id="editTypePersonnel" class="form-select" required>
                        <option value="" disabled>Choisir le type</option>
                        <option value="administratif">Administratif</option>
                        <option value="enseignant">Enseignant</option>
                        </select>
                    </div>

                    <div class="mb-3" id="editSalaireBaseGroup" style="display:none;">
                        <label for="editSalaireBase" class="form-label">Salaire de base (Administratif)</label>
                        <input type="number" class="form-control" id="editSalaireBase" name="salaire_base" min="0" step="0.01">
                    </div>

                    <div class="mb-3" id="editSalaireHoraireGroup" style="display:none;">
                        <label for="editSalaireHoraire" class="form-label">Salaire horaire (Enseignant)</label>
                        <input type="number" class="form-control" id="editSalaireHoraire" name="salaire_horaire" min="0" step="0.01">
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </form>
                </div>
            </div>
            </div>


        
            <!-- /product list -->
    
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



                <!-- Modale D'ajout de poste -->
                <script>
                document.getElementById('type_personnel').addEventListener('change', function() {
                    const type = this.value;
                    const baseGroup = document.getElementById('salaire_base_group');
                    const horaireGroup = document.getElementById('salaire_horaire_group');

                    if (type === 'administratif') {
                    baseGroup.style.display = 'block';
                    horaireGroup.style.display = 'none';
                    baseGroup.querySelector('input').required = true;
                    horaireGroup.querySelector('input').required = false;
                    horaireGroup.querySelector('input').value = '';
                    } else if (type === 'enseignant') {
                    baseGroup.style.display = 'none';
                    horaireGroup.style.display = 'block';
                    horaireGroup.querySelector('input').required = true;
                    baseGroup.querySelector('input').required = false;
                    baseGroup.querySelector('input').value = '';
                    } else {
                    baseGroup.style.display = 'none';
                    horaireGroup.style.display = 'none';
                    baseGroup.querySelector('input').required = false;
                    horaireGroup.querySelector('input').required = false;
                    }
                });
                </script>


        <script>
                document.getElementById('exportExcel').addEventListener('click', function (e) {
                e.preventDefault();

                let table = $('#table-PersonnelAdministratif').DataTable();
                let data = table.rows({ search: 'applied' }).data().toArray();
                let headers = [];

                // Commencer à 1 pour ignorer la colonne de case à cocher
                $('#table-PersonnelAdministratif thead th').each(function (index, th) {
                    if (index > 0 && index < $('#table-PersonnelAdministratif thead th').length - 1) {
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
                XLSX.writeFile(wb, "Types_Personnels.xlsx");
                });



                document.getElementById('exportPdf').addEventListener('click', function (e) {
                    e.preventDefault();
                    const { jsPDF } = window.jspdf;
                    const doc = new jsPDF('p', 'pt', 'a4'); // Mode portrait

                    let table = $('#table-PersonnelAdministratif').DataTable();
                    let data = table.rows({ search: 'applied' }).data().toArray();
                    let headers = [];

                    $('#table-PersonnelAdministratif thead th').each(function (index, th) {
                        if (index < $('#table-PersonnelAdministratif thead th').length - 1) { // ignore la colonne Action
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

                    doc.save('Types_Personnels.pdf');
                });


        </script>

        
        <!-- Modification du poste -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Bouton "Modifier" : ouvre le modal et remplit les champs
                document.querySelectorAll('.modifierPoste').forEach(function (button) {
                    button.addEventListener('click', function () {
                        const modal = new bootstrap.Modal(document.getElementById('editPosteModal'));
                        modal.show();

                        const id = button.getAttribute('data-id');
                        const nom = button.getAttribute('data-nom');
                        const salaireBase = button.getAttribute('data-salaire-base');
                        const salaireHoraire = button.getAttribute('data-salaire-horaire');

                        // Remplit les champs communs
                        document.getElementById('editNom').value = nom || '';
                        document.getElementById('editPosteForm').setAttribute('data-id', id);

                        // Détermine le type de personnel
                        const editTypeSelect = document.getElementById('editTypePersonnel');
                        const salaireBaseGroup = document.getElementById('editSalaireBaseGroup');
                        const salaireHoraireGroup = document.getElementById('editSalaireHoraireGroup');

                        if (parseFloat(salaireBase) > 0) {
                            editTypeSelect.value = 'administratif';
                            salaireBaseGroup.style.display = 'block';
                            salaireHoraireGroup.style.display = 'none';
                            document.getElementById('editSalaireBase').value = salaireBase;
                            document.getElementById('editSalaireHoraire').value = '';
                        } else if (parseFloat(salaireHoraire) > 0) {
                            editTypeSelect.value = 'enseignant';
                            salaireBaseGroup.style.display = 'none';
                            salaireHoraireGroup.style.display = 'block';
                            document.getElementById('editSalaireHoraire').value = salaireHoraire;
                            document.getElementById('editSalaireBase').value = '';
                        } else {
                            editTypeSelect.value = '';
                            salaireBaseGroup.style.display = 'none';
                            salaireHoraireGroup.style.display = 'none';
                            document.getElementById('editSalaireBase').value = '';
                            document.getElementById('editSalaireHoraire').value = '';
                        }
                    });
                });

                // Gère l'affichage dynamique des champs de salaire en fonction du type sélectionné
                document.getElementById('editTypePersonnel').addEventListener('change', function () {
                    const type = this.value;
                    const baseGroup = document.getElementById('editSalaireBaseGroup');
                    const horaireGroup = document.getElementById('editSalaireHoraireGroup');

                    if (type === 'administratif') {
                        baseGroup.style.display = 'block';
                        horaireGroup.style.display = 'none';
                        baseGroup.querySelector('input').required = true;
                        horaireGroup.querySelector('input').required = false;
                        horaireGroup.querySelector('input').value = '';
                    } else if (type === 'enseignant') {
                        baseGroup.style.display = 'none';
                        horaireGroup.style.display = 'block';
                        horaireGroup.querySelector('input').required = true;
                        baseGroup.querySelector('input').required = false;
                        baseGroup.querySelector('input').value = '';
                    } else {
                        baseGroup.style.display = 'none';
                        horaireGroup.style.display = 'none';
                        baseGroup.querySelector('input').required = false;
                        horaireGroup.querySelector('input').required = false;
                    }
                });

                // Soumission AJAX du formulaire de modification
                document.getElementById('editPosteForm').addEventListener('submit', function (e) {
                    e.preventDefault();

                    const id = this.getAttribute('data-id');
                    const formData = new FormData(this);

                    fetch(`/modifier-poste/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur réseau ou validation.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Modifié', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Erreur', data.message || 'Une erreur est survenue.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Erreur', 'Une erreur est survenue lors de la modification.', 'error');
                    });
                });
            });
        </script>


<!-- formulaire de Suppression du type de sanction -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.Supprimerposte').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Confirmation',
                        text: "Voulez-vous vraiment supprimer ce poste ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Oui',
                        cancelButtonText: 'Non'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/Supprimerposte/${id}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Content-Type': 'application/json',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Supprimé', data.message, 'success')
                                    .then(() => location.reload());
                                }
                            });
                        }
                    });
                });
            });
        });
    </script>

@endsection
