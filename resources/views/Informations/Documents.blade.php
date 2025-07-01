


@extends('layout')

@section('title')

DRH | Liste Des Documents

@endsection

@section('css')



    <link href="{{asset('app/css/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />


@endsection

@section('contenu')

    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4 class="fw-bold">Liste Des Documents </h4>
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
                                <th style="width: 15%">Total Documents</th>
                                <th style="width: 10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($personnels as $personnel)
                                <tr>
                                    <td>{{ $personnel->nom }} {{ $personnel->prenom }}</td>
                                    <td>{{ $personnel->poste ? $personnel->poste->nom : 'Non défini' }}</td>
                                    <td>
                                        <span class="badge badge-document">
                                            {{ $personnel->documents_count }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="hstack gap-2 fs-15">
                                            <a href="javascript:void(0);"
                                            class="btn btn-sm btn-danger voir-documents"
                                            data-id="{{ $personnel->id }}"
                                            title="Voir les documents">
                                            <i data-feather="folder"></i>
                                            </a>


                                            <a href="javascript:void(0);"
                                            class="btn btn-sm btn-danger ajouter-document"
                                            data-id="{{ $personnel->id }}"
                                            title="Ajouter un document">
                                                <i data-feather="plus"></i>
                                            </a>
                                        </div>
                                    </td>



                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucun personnel trouvé</td>
                                </tr>
                            @endforelse
                        </tbody>

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


                        <!-- Modal Voir les Documents -->
                        <div class="modal fade" id="modalDocuments" tabindex="-1" aria-labelledby="modalDocumentsLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Documents de l’employé</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body" id="documents-container">
                                <!-- Contenu des documents chargés par JS ici -->
                            </div>
                            </div>
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

    <!-- SheetJS pour Le Modal d'ajout des documents -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".ajouter-document").forEach(function (btn) {
                btn.addEventListener("click", function () {
                    const personnelId = this.dataset.id;
                    document.getElementById('modal_personnel_id').value = personnelId;
                    const modal = new bootstrap.Modal(document.getElementById('ajouterDocumentModal'));
                    modal.show();
                });
            });
        });
    </script>

    <!-- SheetJS pour Le Modal voirdocuments -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.voir-documents').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const personnelId = this.getAttribute('data-id');

                    // Requête AJAX pour récupérer les documents
                    fetch(`/personnel/${personnelId}/documents/json`)
                        .then(response => response.json())
                        .then(data => {
                            let html = '';

                            if (data.length === 0) {
                                html = '<p>Aucun document trouvé pour cet employé.</p>';
                            } else {
                                data.forEach(doc => {
                                    html += `
                                        <div class="border rounded p-3 mb-3">
                                            <h6 class="mb-2">${doc.libelle ?? 'Sans libellé'}</h6>
                                            <div class="d-flex gap-2">
                                                <!-- Télécharger -->
                                                <a href="/documents/${doc.id}/telecharger" class="btn btn-sm btn-outline-primary" title="Télécharger">
                                                    <i class="bi bi-download"></i>
                                                </a>

                                                <!-- Modifier -->
                                                <button class="btn btn-sm btn-outline-warning modifier-document" data-id="${doc.id}" title="Modifier">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <!-- Supprimer -->
                                                <button class="btn btn-sm btn-outline-danger supprimer-document" data-id="${doc.id}" title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </div>
                                        </div>
                                    `;
                                });
                            }

                            document.getElementById('documents-container').innerHTML = html;
                            new bootstrap.Modal(document.getElementById('modalDocuments')).show();
                        })
                        .catch(err => {
                            console.error(err);
                            alert("Une erreur est survenue lors du chargement des documents.");
                        });
                });
            });
        });

                $(document).on('click', '.supprimer-document', function () {
            const documentId = $(this).data('id');

            if (!confirm('Êtes-vous sûr de vouloir supprimer ce document ?')) return;

            $.ajax({
                url: `/documents/${documentId}/supprimer`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Supprimé',
                        text: response.message
                    });

                    // Optionnel : Retirer l’élément du DOM
                    $(`#document-row-${documentId}`).remove();
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Une erreur est survenue lors de la suppression du document.'
                    });
                }
            });
        });

    </script>



    @if(session('document_ajoute'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Document ajouté',
                text: 'Le document {{ session('libelle') }} a été ajouté à l\'employé avec succès.',
                confirmButtonText: 'OK'
            });
        </script>
    @endif








    <style>.badge-document {
        background-color: #007bff;
        color: white;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 14px;
    }
    </style>

    <div class="modal fade" id="modalModifierDocument" tabindex="-1" aria-labelledby="modalModifierLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formModifierDocument" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalModifierLabel">Modifier le document</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modifier-document-id" name="id">
                <div class="mb-3">
                    <label for="modifier-libelle" class="form-label">Libellé</label>
                    <input type="text" class="form-control" id="modifier-libelle" name="libelle" required>
                </div>
                <div class="mb-3">
                    <label for="modifier-fichier" class="form-label">Fichier (laisser vide pour ne pas changer)</label>
                    <input type="file" class="form-control" id="modifier-fichier" name="fichier">
                </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-success">Enregistrer</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            </div>
        </div>
        </form>
    </div>
    </div>

    <script>$(document).on('click', '.modifier-document', function () {
            const id = $(this).data('id');

            fetch(`/documents/modifier/${id}`)
                .then(response => response.json())
                .then(doc => {
                    $('#modifier-document-id').val(doc.id);
                    $('#modifier-libelle').val(doc.libelle);
                    $('#modalModifierDocument').modal('show');
                })
                .catch(error => {
                    console.error(error);
                    alert("Erreur lors du chargement du document.");
                });
        });
    </script>

    <script>
        document.getElementById('formModifierDocument').addEventListener('submit', function (e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch("{{ route('documents.update') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Erreur réseau');
                return response.json();
            })
            .then(data => {
                alert(data.message);
                // Fermer le modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalModifierDocument'));
                modal.hide();

                // Optionnel : recharger ou mettre à jour la liste des documents
                location.reload();
            })
            .catch(error => {
                console.error(error);
                alert("Erreur lors de la modification.");
            });
        });
    </script>

@endsection
