


@extends('layout')

@section('title')

DRH | Statistiques De Pointage

@endsection

@section('css')



    <link href="{{asset('app/css/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />


@endsection



@section('contenu')
<div class="content">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div class="card-body">
            <h2 class="text-center mb-3">Rapport détaillé du pointage sur les 30 derniers jours ouvrables</h2>
        </div>

    </div>

    <div class="row mt-4 text-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="text-muted">Taux de Présence</h6>
                    <h3 id="tauxPresence" class="text-success">-- %</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="text-muted">Taux de Retard</h6>
                    <h3 id="tauxRetard" class="text-warning">-- %</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="text-muted">Taux d'Absence</h6>
                    <h3 id="tauxAbsence" class="text-danger">-- %</h3>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="text-center mb-3">Rapport graphique du pointage sur les 30 derniers jours ouvrables</h5>
                    <canvas id="courbePresence" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="text-center mb-3">Top 5 des employés les plus Absents</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="tableClassement">
                        <thead class="table-secondary">
                            <tr>
                                <th>Rang</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Présences</th>
                                <th>Retards</th>
                                <th>Absences</th>
                            </tr>
                        </thead>
                        <tbody id="classementBody">
                            <!-- Rempli dynamiquement -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="text-center mb-3">Top 5 des employés les plus ponctuels</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-success">
                                <tr>
                                    <th>Rang</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Présences à l'heure</th>
                                </tr>
                            </thead>
                            <tbody id="topPonctuels">
                                <!-- À remplir dynamiquement -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="text-center mb-3">📅 Jour de la semaine le plus problématique</h5>
                    <canvas id="barreHebdo"></canvas>
                </div>
            </div>
        </div>
    </div>








</div>
@endsection



@section('js')

    <script src="{{asset('app/js/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{asset('pages/paiement.js')}}"></script>


        <!-- SheetJS pour l'Évolution des présences  -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('/statistiques-globales')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('courbePresence').getContext('2d');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.jours,
                        datasets: [
                            {
                                label: 'Présences',
                                data: data.presences,
                                borderColor: 'green',
                                backgroundColor: 'rgba(0,128,0,0.2)',
                                fill: true,
                                tension: 0.3
                            },
                            {
                                label: 'Retards',
                                data: data.retards,
                                borderColor: 'orange',
                                backgroundColor: 'rgba(255,165,0,0.2)',
                                fill: true,
                                tension: 0.3
                            },
                            {
                                label: 'Absences',
                                data: data.absences,
                                borderColor: 'red',
                                backgroundColor: 'rgba(255,0,0,0.2)',
                                fill: true,
                                tension: 0.3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'top' },
                            title: {
                                display: true,
                                text: 'Évolution globale des présences, retards et absences'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                // optionnel, max peut être le nombre total de personnels
                                // max: {{ $personnels->count() }},
                                ticks: { stepSize: 1 }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Erreur lors du chargement des statistiques globales :', error);
            });
        });
    </script>

    <script>
        fetch('/classement-absences')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('classementBody');
            tbody.innerHTML = '';
            data.forEach((personnel, index) => {
                const row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${personnel.nom}</td>
                        <td>${personnel.prenom}</td>
                        <td>${personnel.presences}</td>
                        <td>${personnel.retards}</td>
                        <td>${personnel.absences}</td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        })
        .catch(error => {
            console.error('Erreur chargement classement :', error);
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch('/taux-globaux')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tauxPresence').textContent = data.presence + ' %';
                    document.getElementById('tauxRetard').textContent = data.retard + ' %';
                    document.getElementById('tauxAbsence').textContent = data.absence + ' %';
                })
                .catch(error => {
                    console.error("Erreur lors du chargement des taux :", error);
                });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch('/top-ponctuels')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('topPonctuels');
                    tbody.innerHTML = '';

                    data.forEach((employe, index) => {
                        const row = document.createElement('tr');

                        row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${employe.nom}</td>
                            <td>${employe.prenom}</td>
                            <td>${employe.ponctualite}</td>
                        `;

                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error("Erreur lors du chargement du classement :", error);
                });
        });
    </script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    fetch('/statistiques-hebdomadaires')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('barreHebdo').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.jours,
                    datasets: [
                        {
                            label: 'Absences',
                            data: data.absences,
                            backgroundColor: 'rgba(243, 20, 68, 0.7)'
                        },
                        {
                            label: 'Retards',
                            data: data.retards,
                            backgroundColor: 'rgba(255, 206, 86, 0.7)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: {
                            display: true,
                            text: 'Répartition des absences et retards par jour de la semaine'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error("Erreur lors du chargement des stats hebdomadaires :", error);
        });
});
</script>





@endsection
