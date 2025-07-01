


@extends('layout')

@section('title')

DRH | Liste De Pointage

@endsection

@section('css')



    <link href="{{asset('app/css/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />


@endsection



@section('contenu')
<div class="content">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div class="card-body">
            <h2 class="text-center mb-3">Tableau récapitulatif des présences et absences</h2>
        </div>
        <ul class="table-top-head d-flex gap-3">
            <li><a href="#" id="exportPdf" title="Exporter en PDF"><img src="{{asset('app')}}/assets/img/icons/pdf.svg" alt="PDF"></a></li>
            <li><a href="#" id="exportExcel" title="Exporter en Excel"><img src="{{asset('app')}}/assets/img/icons/excel.svg" alt="Excel"></a></li>
        </ul>
    </div>

    <!-- Filtres -->
    <form method="GET" class="mb-4 d-flex gap-3 align-items-end">
        <div>
            <label for="date">Date :</label>
            <input type="date" id="date" name="date" class="form-control" value="{{ request('date', now()->toDateString()) }}">
        </div>

        <div>
            <label for="statut">Statut :</label>
            <select id="statut" name="statut" class="form-control">
                <option value="">-- Tous --</option>
                <option value="present" {{ request('statut') == 'present' ? 'selected' : '' }}>Présent</option>
                <option value="retard" {{ request('statut') == 'retard' ? 'selected' : '' }}>En retard</option>
                <option value="absent" {{ request('statut') == 'absent' ? 'selected' : '' }}>Absent</option>
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter me-2"></i> Filtrer
            </button>
        </div>


        @php
            $dateFr = \Carbon\Carbon::parse($date)->locale('fr')->isoFormat('dddd D MMMM Y');
            $dateFr = mb_convert_case($dateFr, MB_CASE_TITLE, "UTF-8");
        @endphp

        <div>
            <h3>{{ $dateFr }}</h3>
        </div>

    </form>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            
            <div class="table-responsive">
                

                <table class="table datatable">
                   
                    <thead class="table-primary">
                        
                        <tr>
                            
                            <th>Employé</th>
                            <th>Heure d'arrivée</th>
                            <th>Heure de départ</th>
                            <th>Statut</th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($personnels as $personnel)
                            @php
                                $pointage = $personnel->pointages->where('date', $date)->first();
                                $arrivee = $pointage?->heure_arrivee;
                                $depart = $pointage?->heure_depart;

                                if ($arrivee) {
                                    $heureArrivee = \Carbon\Carbon::parse($arrivee);
                                    $retard = $heureArrivee->gt(\Carbon\Carbon::createFromTime(8, 0));
                                    $statutActuel = $retard ? 'retard' : 'present';
                                } else {
                                    $statutActuel = 'absent';
                                }

                                $filtre = request('statut');
                                if ($filtre && $filtre !== $statutActuel) continue;
                            @endphp

                            <tr>
                                <td>{{ $personnel->nom }} {{ $personnel->prenom }}</td>
                                
                                <td>
                                    @if($arrivee)
                                        {{ \Carbon\Carbon::parse($arrivee)->format('H:i') }}
                                    @else
                                        <span class="text-danger">Non pointé</span>
                                    @endif
                                </td>
                                <td>
                                    @if($depart)
                                        {{ \Carbon\Carbon::parse($depart)->format('H:i') }}
                                    @else
                                        <span class="text-muted">Non pointé</span>
                                    @endif
                                </td>
                                <td>
                                    @if($statutActuel === 'present')
                                        <span class="badge bg-success">Présent</span>
                                    @elseif($statutActuel === 'retard')
                                        <span class="badge bg-warning text-dark">En retard</span>
                                    @else
                                        <span class="badge bg-danger">Absent</span>
                                    @endif
                                </td>
                                                            <td class="text-center">
                                    <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item btn-stats" data-id="{{ $personnel->id }}">
                                                <i class="fas fa-id-card"></i> Voir plus
                                            </a>
                                        </li>

                                        <a href="mailto:{{ $personnel->email }}?subject=Objet%20du%20mail&body=Bonjour%20{{ $personnel->prenom }},%0A%0ACordialement,%0ADirecteur des ressources humaines%0AEcole Internationale Mariam"
                                        class="dropdown-item">
                                            <i data-feather="mail" class="info-img"></i> Envoyer un email
                                        </a>
                                    </ul>
                            </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="modalStatsPointage" tabindex="-1" aria-labelledby="statsLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Statistiques de Pointage</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="contenu-statistiques">
                                                <p>Chargement...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>
                </table>

                @if($personnels->isEmpty())
                    <p class="text-center text-muted py-3">Aucun enregistrement trouvé pour cette date.</p>
                @endif
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



    <script>
        
        document.addEventListener("DOMContentLoaded", function() {
            const dateInput = document.getElementById("date");
            const today = new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD
            dateInput.max = today;
        });
    </script>

        <!-- SheetJS pour le modale  -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('modalStatsPointage'));

            document.querySelectorAll('.btn-stats').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const personnelId = this.getAttribute('data-id');

                    // Afficher le modal
                    modal.show();

                    // Lancer la requête AJAX
                    fetch(`/personnel/${personnelId}/statistiques`)
                        .then(response => response.json())
                        .then(data => {
                            const statsHtml = `
                                <ul class="list-group">
                                    <li class="list-group-item"><strong>Nom :</strong> ${data.nom} ${data.prenom}</li>
                                    <li class="list-group-item"><strong>Présences :</strong> ${data.presences}</li>
                                    <li class="list-group-item"><strong>Absences :</strong> ${data.absences}</li>
                                    <li class="list-group-item"><strong>Retards :</strong> ${data.retards}</li>
                                </ul>
                            `;
                            document.getElementById('contenu-statistiques').innerHTML = statsHtml;
                        })
                        .catch(() => {
                            document.getElementById('contenu-statistiques').innerHTML = '<p class="text-danger">Erreur de chargement</p>';
                        });
                });
            });
        });
    </script>





@endsection
