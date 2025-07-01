


@extends('layout')

@section('title')

DRH | Liste Du Personnel Enseignant

@endsection

@section('css')



    <link href="{{asset('app/css/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />


@endsection

@section('contenu')

    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4 class="fw-bold">Personnel Enseignant </h4>
                    <h6>Liste Du Personnel Enseignant   </h6>
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
                <table class="table datatable" id="table-PersonnelEnseignant">
                    <thead class="thead-light">
                        <tr>
                            <th class="no-sort" style="width: 5%">
                                <label class="checkboxs">
                                    <input type="checkbox" id="select-all">
                                    <span class="checkmarks"></span>
                                </label>
                            </th>
                            <th style="width: 10%">Nom</th>
                            <th style="width: 10%">Prénom</th>
                            
                            <th style="width: 10%">Contact</th>
                            <th style="width: 10%">Photo</th>
                            <th style="width: 10%">Sexe</th>
                            <th style="width: 10%">Poste</th>
                            <th class="no-sort" style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($personnels as $personnel)
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td>{{ $personnel->nom }}</td>
                            <td>{{ $personnel->prenom }}</td>
                            
                            <td>{{ $personnel->contact }}</td>
                            <td>
                                <img src="{{ asset('storage/photos/' . $personnel->photo) }}" alt="Photo" class="img-thumbnail" width="50">
                            </td>
                            <td>{{ $personnel->sexe }}</td>
                            <td>{{ $personnel->poste }}</td>
                            <td class="text-center">
                                    <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item" ><i data-feather="eye" class="info-img"></i>Détails  </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item  modifierPaiement"   data-id=""><i data-feather="edit" class="info-img"></i>Fiche comptable  </a>
                                        </li>

                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item" ><i data-feather="eye" class="info-img"></i>Fiche parent  </a>
                                        </li>


                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item" ><i data-feather="mail" class="info-img"></i>Envoyer un email  </a>
                                        </li>


                                    </ul>
                                </td>
                            </tr>

                            @endforeach

                     
                    </tbody>
                </table>

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

    let table = $('#table-PersonnelEnseignant').DataTable();
    let data = table.rows({ search: 'applied' }).data().toArray();
    let headers = [];

    // Commencer à 1 pour ignorer la colonne de case à cocher
    $('#table-PersonnelEnseignant thead th').each(function (index, th) {
        if (index > 0 && index < $('#table-PersonnelEnseignant thead th').length - 1) {
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
    XLSX.writeFile(wb, "Personnel_Enseignants.xlsx");
    });



    document.getElementById('exportPdf').addEventListener('click', function (e) {
        e.preventDefault();
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'pt', 'a4'); // Mode portrait

        let table = $('#table-PersonnelEnseignant').DataTable();
        let data = table.rows({ search: 'applied' }).data().toArray();
        let headers = [];

        $('#table-PersonnelEnseignant thead th').each(function (index, th) {
            if (index < $('#table-PersonnelEnseignant thead th').length - 1) { // ignore la colonne Action
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

        doc.save('Personnel_Enseignants.pdf');
    });


    </script>

@endsection
