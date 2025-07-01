


@extends('layout')

@section('title')

DRH | Voir les demandes d'emploi

@endsection

@section('css')



    <link href="{{asset('app/css/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />


@endsection

@section('contenu')

<div class="content">
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Liste des demandes d'emploies  </h4>
                <h6>Liste des demandes d'emploies </h6>
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
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
            <div class="search-set">
                <div class="search-input">
                    <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                </div>
            </div>
            <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">


            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table datatable" id="ListeDemandesEmploies">
                    <thead class="thead-light">
                    <tr>
                        <th class="no-sort" style="width: 5%">
                            <label class="checkboxs">
                                <input type="checkbox" id="select-all">
                                <span class="checkmarks"></span>
                            </label>
                        </th>
                        <th style="width: 25%">Nom</th>
                        <th style="width: 25%">Prénom </th>
                        <th style="width: 15%">Téléphone  </th>
                        <th style="width: 15%">Expérience</th>
                        <th style="width: 15%">Domaine</th>
                        <th style="width: 15%">Date  </th>
                        <th class="no-sort" style="width: 10%"> Actions </th>
                    </tr>
                    </thead>
                    <tbody >

                         @forelse($demandes as $demande)


                    <tr>
                        <td>
                            <label class="checkboxs">
                                <input type="checkbox">
                                <span class="checkmarks"></span>
                            </label>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">

                            {{ $demande->nom }}
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">

                            {{ $demande->prenom }}
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">

                            {{ $demande->telephone }}
                            </div>
                        </td>


                        <td>
                            <div class="d-flex align-items-center">

                            {{ $demande->experience }} ans
                            </div>
                        </td>


                        <td>
                            <div class="d-flex align-items-center">

                            {{ $demande->domaine }} 
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">

                            {{ $demande->created_at->format('d-m-Y') }}
                            </div>
                        </td>
                                         <td>
                                            <div class="hstack gap-2 fs-15">
                                                <a href="{{ route('telecharger.dossier', $demande->id) }}" class="btn btn-sm btn-primary" title="Télécharger le dossier complet">
                                                    <i data-feather="download-cloud"></i>
                                                </a>
                                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $demande->email }}&su=Ecole%20International%20Mariam%20-%20Réponse%20à%20votre%20candidature%20pour%20le%20poste%20de%20:{{ urlencode($demande->domaine) }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-primary"
                                                    title="Répondre par email">
                                                    <i data-feather="mail"></i>
                                                </a>
                                            </div>
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
    <script src="{{asset('pages/chiffre.js')}}"></script>


    <!-- SheetJS pour Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <!-- jsPDF et AutoTable pour PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

    <script>
    document.getElementById('exportExcel').addEventListener('click', function (e) {
    e.preventDefault();

    let table = $('#ListeDemandesEmploies').DataTable();
    let data = table.rows({ search: 'applied' }).data().toArray();
    let headers = [];

    // Commencer à 1 pour ignorer la colonne de case à cocher
    $('#ListeDemandesEmploies thead th').each(function (index, th) {
        if (index > 0 && index < $('#ListeDemandesEmploies thead th').length - 1) {
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
    XLSX.writeFile(wb, "ListeDemandesEmploies.xlsx");
    });



    document.getElementById('exportPdf').addEventListener('click', function (e) {
        e.preventDefault();
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'pt', 'a4'); // Mode portrait

        let table = $('#ListeDemandesEmploies').DataTable();
        let data = table.rows({ search: 'applied' }).data().toArray();
        let headers = [];

        $('#ListeDemandesEmploies thead th').each(function (index, th) {
            if (index < $('#ListeDemandesEmploies thead th').length - 1) { // ignore la colonne Action
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

        doc.save('ListeDemandesEmploies.pdf');
    });


</script>


@endsection
