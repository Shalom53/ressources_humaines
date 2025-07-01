


@extends('layout')

@section('title')

DRH | Types De Sanctions

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
                <h4 class="fw-bold">Types De Sanctions </h4>
                <h6>Liste Des Types De Sanctions</h6>
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

          <!-- Modal d'ajout de type de sanction -->
            <div class="modal fade" id="addSanctionModal" tabindex="-1" aria-labelledby="addSanctionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <form action="{{ route('typeSanction.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                    <h5 class="modal-title" id="addSanctionModalLabel">Ajouter une sanction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Type de sanction</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="reduction" class="form-label">Pourcentage de réduction (%)</label>
                        <input type="number" name="reduction" class="form-control" required min="0" max="100">
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
                        <table class="table datatable" id="table-PersonnelAdministratif">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 10%">Type</th>
                                    <th style="width: 10%">Pourcentage de réduction</th>
                                    <th class="no-sort" style="width: 10%; padding-left: 50px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($typeSanctions as $typeSanction)
                                    <tr>
                                        <td>{{ $typeSanction->nom }}</td>
                                        <td>{{ $typeSanction->reduction }}%</td>
                                        <td class="text-center align-middle" style="width: 10%; padding-left: 50px;">
                                            <a href="javascript:void(0);" class="text-primary me-2 modifierSanction" title="Modifier" 
                                            data-bs-toggle="modal" data-bs-target="#editSanctionModal" 
                                            data-id="{{ $typeSanction->id }}" data-nom="{{ $typeSanction->nom }}" 
                                            data-reduction="{{ $typeSanction->reduction }}">
                                                <i class="fa fa-edit fa-lg"></i>
                                            </a>
                                            <a href="javascript:void(0);" 
                                            class="text-danger supprimerTypeSanction" 
                                            data-id="{{ $typeSanction->id }}" 
                                            title="Supprimer">
                                            <i class="fa fa-trash fa-lg"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Aucun type de sanction trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal de modification -->
            <div class="modal fade" id="editSanctionModal" tabindex="-1" aria-labelledby="editSanctionModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editSanctionModalLabel">Modifier le type de sanction</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="editSanctionForm" method="POST">
                            @csrf
                            @method('POST')
                             <div class="modal-body">
                                <div class="mb-3">
                                    <label for="editNom" class="form-label">Type de sanction</label>
                                    <input type="text" class="form-control" id="editNom" name="nom" value="{{ $typeSanction->nom }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editReduction" class="form-label">Pourcentage de réduction</label>
                                    <input type="number" class="form-control" id="editReduction" name="reduction" value="{{ $typeSanction->reduction }}" required>
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

 <!-- Modification du type de sanction -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bouton "Modifier" ouvre le modal et remplit les champs
            document.querySelectorAll('.modifierSanction').forEach(function(button) {
                button.addEventListener('click', function() {
                    const modal = new bootstrap.Modal(document.getElementById('editSanctionModal'));
                    modal.show();

                    const id = button.getAttribute('data-id');
                    const nom = button.getAttribute('data-nom');
                    const reduction = button.getAttribute('data-reduction');

                    document.getElementById('editNom').value = nom || '';
                    document.getElementById('editReduction').value = reduction || '';
                    document.getElementById('editSanctionForm').setAttribute('data-id', id);
                });
            });

            // Soumission AJAX du formulaire de modification
            document.getElementById('editSanctionForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const id = this.getAttribute('data-id');
                const formData = new FormData(this);

                fetch(`/modifier-sanction/${id}`, {
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
