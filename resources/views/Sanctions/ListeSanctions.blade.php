


@extends('layout')

@section('title')

DRH | Liste De Sanctions

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
                <h4 class="fw-bold">Liste De Sanctions </h4>
                <h6>Liste Des Sanctions</h6>
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
                data-bs-toggle="modal" data-bs-target="#addSanctionModal">
                    <i class="bi bi-plus"></i> 
                </a>
            </li>


            </ul>
            <div class="page-btn">

         
                    <!-- Modal d'ajout de sanction -->
                <div class="modal fade" id="addSanctionModal" tabindex="-1" aria-labelledby="addSanctionModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <form action="{{ route('sanction.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                        <h5 class="modal-title" id="addSanctionModalLabel">Ajouter une sanction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>

                        <div class="modal-body">
                        <!-- Type de sanction -->
                        <div class="mb-3">
                            <label for="type_id" class="form-label">Type de sanction</label>
                            <select name="type_id" class="form-select" required>
                            <option value="" disabled selected>-- Sélectionnez un type --</option>
                            @foreach ($typeSanctions as $type)
                                <option value="{{ $type->id }}">{{ $type->nom }}</option>
                            @endforeach
                            </select>
                        </div>

                        <!-- Motif -->
                        <div class="mb-3">
                            <label for="motif" class="form-label">Motif</label>
                            <input type="text" name="motif" class="form-control" required>
                        </div>

                        <!-- Date début -->
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de début</label>
                            <input type="date" name="date_debut" class="form-control" required>
                        </div>

                        <!-- Date fin -->
                        <div class="mb-3">
                            <label for="date_fin" class="form-label">Date de fin</label>
                            <input type="date" name="date_fin" class="form-control" required>
                        </div>

                        <!-- Personnel -->
                        <div class="mb-3">
                            <label for="personnel_id" class="form-label">Personnel concerné</label>
                            <select name="personnel_id" class="form-select" required>
                            <option value="" disabled selected>-- Sélectionnez un personnel --</option>
                            @foreach ($personnels as $personnel)
                                <option value="{{ $personnel->id }}">{{ $personnel->nom }} {{ $personnel->prenom }}</option>
                            @endforeach
                            </select>
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
     
      
        <!-- Table des sanctions -->
        
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table datatable" id="table-Sanctions">
                        <thead class="thead-light">
                            <tr>
                                <th>Type</th>
                                <th>Motif</th>
                                <th>Date début</th>
                                <th>Date fin</th>
                                <th>Personnel</th>
                                <th class="no-sort text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sanctions as $sanction)
                                <tr>
                                    <td>{{ $sanction->type }}</td>
                                    <td>{{ $sanction->motif ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sanction->date_debut)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sanction->date_fin)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($sanction->personnel)
                                            {{ $sanction->personnel->nom }} {{ $sanction->personnel->prenom }}
                                        @else
                                            <em>Non assigné</em>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="text-primary me-2 editSanctionModal" data-bs-toggle="modal" data-bs-target="#editSanctionModal"title="Modifier"  
                                            data-id="{{ $sanction->id }}"
                                            data-type-id="{{ $sanction->type_id }}"
                                            data-motif="{{ $sanction->motif }}"
                                            data-date-debut="{{ $sanction->date_debut }}"
                                            data-date-fin="{{ $sanction->date_fin }}"
                                            data-personnel-id="{{ $sanction->personnel_id }}">
                                                <i class="fa fa-edit fa-lg"></i>
                                        </a>

                                        <a href="#" class="text-danger supprimerSanction" data-id="{{ $sanction->id }}">
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
      

        @foreach ($sanctions as $sanction)
           <!-- Modal de modification de sanction -->
        <div class="modal fade" id="editSanctionModal" tabindex="-1" aria-labelledby="editSanctionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editSanctionForm" method="POST" action="{{ route('modifierSanctions', $sanction->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="editSanctionModalLabel">Modifier une sanction</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Type de sanction -->
                            <div class="mb-3">
                                <label for="type_id" class="form-label">Type de sanction</label>
                                <select name="type_id" class="form-select" required>
                                    <option value="" disabled>-- Sélectionnez un type --</option>
                                    @foreach ($typeSanctions as $type)
                                        <option value="{{ $type->id }}" {{ $sanction->type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Motif -->
                            <div class="mb-3">
                                <label for="motif" class="form-label">Motif</label>
                                <input type="text" name="motif" class="form-control" value="{{ $sanction->motif }}" required>
                            </div>

                            <!-- Date début -->
                            <div class="mb-3">
                                <label for="date_debut" class="form-label">Date de début</label>
                                <input type="date" name="date_debut" class="form-control" value="{{ $sanction->date_debut }}" required>
                            </div>

                            <!-- Date fin -->
                            <div class="mb-3">
                                <label for="date_fin" class="form-label">Date de fin</label>
                                <input type="date" name="date_fin" class="form-control" value="{{ $sanction->date_fin }}" required>
                            </div>

                            <!-- Personnel -->
                            <div class="mb-3">
                                <label for="personnel_id" class="form-label">Personnel concerné</label>
                                <select name="personnel_id" class="form-select" required>
                                    <option value="" disabled>-- Sélectionnez un personnel --</option>
                                    @foreach ($personnels as $personnel)
                                        <option value="{{ $personnel->id }}" {{ $sanction->personnel_id == $personnel->id ? 'selected' : '' }}>
                                            {{ $personnel->nom }} {{ $personnel->prenom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endforeach
       
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

    <!-- Modification de sanction -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ouvre le modal de modification avec les données remplies
            document.querySelectorAll('.modifierSanctions').forEach(function(button) {
                button.addEventListener('click', function() {
                    const modal = new bootstrap.Modal(document.getElementById('editSanctionModal'));
                    modal.show();

                    // Récupération des attributs depuis le bouton
                    const id = button.getAttribute('data-id');
                    const typeId = button.getAttribute('data-type-id');
                    const motif = button.getAttribute('data-motif');
                    const dateDebut = button.getAttribute('data-date-debut');
                    const dateFin = button.getAttribute('data-date-fin');
                    const personnelId = button.getAttribute('data-personnel-id');

                    // Remplissage des champs du formulaire
                    document.querySelector('#editSanctionForm select[name="type_id"]').value = typeId || '';
                    document.querySelector('#editSanctionForm input[name="motif"]').value = motif || '';
                    document.querySelector('#editSanctionForm input[name="date_debut"]').value = dateDebut || '';
                    document.querySelector('#editSanctionForm input[name="date_fin"]').value = dateFin || '';
                    document.querySelector('#editSanctionForm select[name="personnel_id"]').value = personnelId || '';

                    // Stocker l'ID dans l'attribut data-id du formulaire
                    document.getElementById('editSanctionForm').setAttribute('data-id', id);
                });
            });

            // Soumission AJAX du formulaire
            document.getElementById('editSanctionForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const id = this.getAttribute('data-id');
                const formData = new FormData(this);

                fetch(`/modifier-sanctions/${id}`, {
                    method: 'POST', // Laravel accepte PUT via POST avec _method
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
                        Swal.fire('Erreur', data.message || 'Erreur inconnue.', 'error');
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
        document.querySelectorAll('.supprimerTypeSanction').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Confirmation',
                    text: "Voulez-vous vraiment désactiver ce type de sanction ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/Supprimertypesanction/${id}`, {
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
