


@extends('layout')

@section('title')

DRH | Paiement Employés

@endsection

@section('css')



    <link href="{{asset('app/css/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />


@endsection

@section('contenu')

    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h2 class="fw-bold">Activation de Paie </h2>
                    <h5>
                        <span class="text-primary">Billetage :</span>
                        {{ $nbBilletage }} {{ Str::plural('employé', $nbBilletage) }}
                        ({{ number_format($totalBilletageSalaire, 0, ',', ' ') }} FCFA)

                        <span class="mx-2">|</span>

                        <span class="text-info">Banque :</span>
                        {{ $nbBanque }} {{ Str::plural('employé', $nbBanque) }}
                        ({{ number_format($totalBanqueSalaire, 0, ',', ' ') }} FCFA)
                    </h5>


                </div>
            </div>
            <ul class="table-top-head">

            <li>
            <form method="GET" id="formMoisPaie">
                <input type="month" name="mois" id="moisDePaie"
                    class="form-control form-control-sm"
                    style="width: 160px;"
                    value="{{ $mois ?? \Carbon\Carbon::now()->format('Y-m') }}"
                    onchange="document.getElementById('formMoisPaie').submit();"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Choisir le mois de paie">
            </form>


            </li>

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


      

        <div class="card">
          
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table datatable" id="table-Personnel">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 15%">Employé</th>
                                <th style="width: 10%">Poste</th>
                                
                                <th style="width: 10%">Contact</th>
                                <th style="width: 10%">Salaire</th>
                                <th style="width: 10%">Mode d'encaissement</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($personnelsEligibles as $personnel)
                                <tr>
                                    {{-- 1. EMPLOYÉ (Nom + Prénom) --}}
                                    <td>{{ $personnel->nom }} {{ $personnel->prenom }}</td>

                                    {{-- 2. POSTE --}}
                                    <td>{{ $personnel->poste->nom ?? 'Non défini' }}</td>

                                    {{-- 3. CONTACT --}}
                                    <td>{{ $personnel->contact }}</td>

                                    {{-- 4. SALAIRE NET --}}
                                    <td>
                                        @php
                                            $salaireNet = 0;
                                            $remuneration = $personnel->remuneration;
                                            $debutMois = \Carbon\Carbon::createFromFormat('Y-m', $mois)->startOfMonth();


                                            if ($remuneration) {
                                                $salaireBrut = $remuneration->salaire_brut ?? 0;

                                                $totalPrimes = $remuneration->primes->filter(function ($prime) use ($debutMois) {
                                                    if ($prime->etat != 1) return false;

                                                    if (strtolower($prime->periode) === 'indéterminé') return true;

                                                    $mois = (int) $prime->periode;
                                                    $ref = $prime->updated_at ?? $prime->created_at;
                                                    return $ref->copy()->addMonths($mois)->greaterThanOrEqualTo($debutMois);
                                                })->sum('montant');

                                                $totalRetenues = $remuneration->retenues->filter(function ($retenue) use ($debutMois) {
                                                    if ($retenue->etat != 1) return false;

                                                    if (strtolower($retenue->periode) === 'indéterminé') return true;

                                                    $mois = (int) $retenue->periode;
                                                    $ref = $retenue->updated_at ?? $retenue->created_at;
                                                    return $ref->copy()->addMonths($mois)->greaterThanOrEqualTo($debutMois);
                                                })->sum('montant');

                                                $salaireNet = $salaireBrut + $totalPrimes - $totalRetenues;
                                            }
                                        @endphp
                                        {{ number_format($salaireNet, 0, ',', ' ') }} FCFA
                                    </td>

                                    {{-- 5. MODE DE PAIEMENT --}}
                                    <td>
                                        @if ($personnel->billetage && $personnel->billetage->etat == 1)
                                            <span class="badge bg-primary">Billetage</span>
                                        @elseif ($personnel->banque && $personnel->banque->etat == 1)
                                            <span class="badge bg-info">
                                                Banque : {{ $personnel->banque->nom ?? 'Non spécifiée' }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Aucun moyen défini</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty

                            @endforelse
                        </tbody>

                        
                    </table>

                </div>
            </div>
        </div>
       

    </div>
    <!-- Styles CSS pour Le tableau -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        #table-Personnel {
            font-size: 14px;
            color: #333;
        }

        #table-Personnel thead {
            background-color: #f8f9fa;
            color: #444;
            font-weight: 600;
        }

        #table-Personnel thead th {
            padding: 12px;
            border-bottom: 2px solid #dee2e6;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        #table-Personnel tbody td {
            vertical-align: middle;
            padding: 10px;
            border-top: 1px solid #e9ecef;
        }

        #table-Personnel tbody tr:hover {
            background-color: #f1f3f5;
        }

        .badge {
            font-size: 12px;
            font-weight: 500;
            padding: 6px 10px;
            border-radius: 12px;
        }

        .badge.bg-primary {
            background-color: #4e73df;
        }

        .badge.bg-success {
            background-color: #1cc88a;
        }

        .badge.bg-info {
            background-color: #36b9cc;
        }

        .badge.bg-danger {
            background-color: #e74a3b;
        }

        .badge.bg-secondary {
            background-color: #858796;
        }

        .btn-outline-secondary {
            font-size: 12px;
            padding: 5px 10px;
        }
    </style>


@endsection


@section('js')

    <script src="{{asset('app/js/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('pages/paiement.js')}}"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">


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





@endsection
