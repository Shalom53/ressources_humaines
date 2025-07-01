	
		
		<div class="content">
				<div class="d-lg-flex align-items-center justify-content-between mb-4">
					<div>
						<h2 class="mb-1">Bienvenue, RH Manager</h2>
						<p>Vous avez <span class="text-primary fw-bold">12</span> nouvelles demandes aujourd'hui</p>
					</div>
					<ul class="table-top-head">
						<li>
							<div class="input-icon-start position-relative">
								<span class="input-icon-addon fs-16 text-gray-9">
									<i class="ti ti-calendar"></i>
								</span>
								<input type="text" class="form-control date-range bookingrange" placeholder="Rechercher par date">
							</div>
						</li>
						<li>
							<a data-bs-toggle="tooltip" data-bs-placement="top" id="collapse-header" aria-label="Réduire" class=""><i data-feather="chevron-up" class="feather-16"></i></a>
						</li>
					</ul>
				</div>

<style>

.card-stat {
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    padding: 30px; /* plus de padding */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease-in-out;
}

.card-stat:hover {
    transform: translateY(-5px);
}

.card-icon {
    border-radius: 12px;
    padding: 18px; /* plus grand */
    color: white;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 32px; /* icône plus grosse */
    width: 70px;
    height: 70px;
}

.kpi-label {
    font-size: 16px;
    color: #555;
    margin-top: 4px;
    font-weight: 500;
}

.card-stat h1 {
    font-size: 42px; /* chiffre plus grand */
    font-weight: bold;
    color: #111;
}


.dashboard-section {
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
}

/* Arrière-plan légèrement teinté pour chaque ligne */
.section-effectif {
    background: linear-gradient(135deg, #e3f2fd, #f1f8ff);
}

.section-presence {
    background: linear-gradient(135deg, #e8f5e9, #f1f8f5);
}

.section-salaire {
    background: linear-gradient(135deg, #fff3e0, #fff8e1);
}

.section-demandes {
    background: linear-gradient(135deg, #fce4ec, #f8bbd0);
}




    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }







    .card-icon {
        border-radius: 12px;
        padding: 10px;
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        width: 45px;
        height: 45px;
    }

    .bg-dark { background: linear-gradient(to right, #434343, #000000); }
    .bg-success { background: linear-gradient(to right, #1D976C, #93F9B9); }
    .bg-warning { background: linear-gradient(to right, #F7971E, #FFD200); }
    .bg-danger { background: linear-gradient(to right, #CB2D3E, #EF473A); }
    .bg-primary { background: linear-gradient(to right, #396afc, #2948ff); }

    .kpi-label {
        font-size: 14px;
        color: #666;
        margin-top: 10px;
        text-transform: capitalize;
        font-weight: 500;
    }

    .kpi-value {
        font-size: 26px;
        font-weight: bold;
        color: #111;
    }
</style>


<div class="container-fluid">

    <!-- Ligne 1 : EFFECTIFS -->
    <div class="dashboard-section">
        <div class="section-title">Statistiques des Effectifs</div>
        <div class="row gy-4">
			<div class="col-md-4">
				<div class="card-stat d-flex align-items-center justify-content-between">
					<div class="card-icon bg-dark me-3">
						<i class="ti ti-users"></i>
					</div>
					<div class="text-end">
						<h1 class="mb-0 count-up" data-end="{{ $totalActif }}">0</h1>

						<div class="kpi-label">Effectif Total</div>
					</div>
				</div>
			</div>


			<div class="col-md-4">
				<div class="card-stat d-flex align-items-center justify-content-between">
					<div class="card-icon bg-primary">
						<i class="ti ti-user"></i>
					</div>
					<div class="text-end">
						<h1 class="mb-0 count-up" data-end="{{ $totalActifEnseignant }}">0</h1>
						
						<div class="kpi-label">Personnel Enseignant</div>
					</div>
				</div>
			</div>


			<div class="col-md-4">
				<div class="card-stat d-flex align-items-center justify-content-between">
					<div class="card-icon bg-primary"><i class="ti ti-user-check"></i></div>
					<div class="text-end">
						<h1 class="mb-0 count-up" data-end="{{ $totalActifAdministratif }}">0</h1>
						
						<div class="kpi-label">Personnel Administratif</div>
					</div>
				</div>
			</div>


        </div>
    </div>

	<div class="row mt-4">
		<div class="col-md-12">
			<div class="card shadow-sm">
				<div class="card-body p-3"> <!-- Réduit le padding -->
					<h6 class="text-center mb-3">Évolution du personnel</h6> <!-- Titre plus petit -->
					<canvas id="courbePersonnel" height ="100px"></canvas> <!-- Hauteur réduite -->
				</div>
			</div>
		</div>
	</div>



    <!-- Ligne 2 : PRÉSENCES -->
	<div class="dashboard-section">
		<div class="section-title">Statistiques de Présence du Jour</div>
		<div class="row gy-4">

			<div class="col-md-4">
				<div class="card-stat d-flex align-items-center justify-content-between">
					<div class="card-icon bg-success"><i class="ti ti-calendar-check"></i></div>
					<div class="text-end">
						<h1 class="mb-0 count-up" data-end="{{ $presentCount }}">0</h1>
						<div class="kpi-label">Présents aujourd'hui</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card-stat d-flex align-items-center justify-content-between">
					<div class="card-icon bg-danger"><i class="ti ti-calendar-x"></i></div>
					<div class="text-end">
						<h1 class="mb-0 count-up" data-end="{{ $absentCount }}">0</h1>
						<div class="kpi-label">Absents aujourd'hui</div>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card-stat d-flex align-items-center justify-content-between">
					<div class="card-icon bg-warning"><i class="ti ti-clock"></i></div>
					<div class="text-end">
						<h1 class="mb-0 count-up" data-end="{{ $retardCount }}">0</h1>
						<div class="kpi-label">Retards aujourd'hui</div>
					</div>
				</div>
			</div>

		</div>
	</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="text-center mb-3">Évolution du pointage sur les 30 derniers jours ouvrables</h5>
                <canvas id="graphPresence30Jours" height="100px"></canvas>
            </div>
        </div>
    </div>
</div>

    <!-- Ligne 3 : SALAIRES -->
    <div class="dashboard-section">
        <div class="section-title">Salaires du Mois en Cours</div>
        <div class="row gy-4">
            <div class="col-md-4">
                <div class="card-stat">
                    <div class="card-icon bg-dark"><i class="ti ti-currency-dollar"></i></div>
                    <div class="kpi-value"> CFA</div>
                    <div class="kpi-label">Salaire total du mois</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-stat">
                    <div class="card-icon bg-primary"><i class="ti ti-currency-dollar"></i></div>
                    <div class="kpi-value"> CFA</div>
                    <div class="kpi-label">Salaire Enseignants</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-stat">
                    <div class="card-icon bg-success"><i class="ti ti-currency-dollar"></i></div>
                    <div class="kpi-value"> CFA</div>
                    <div class="kpi-label">Salaire Administratifs</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ligne 4 : DEMANDES -->
    <div class="dashboard-section">
        <div class="section-title">Demandes en cours</div>
        <div class="row gy-4">
            <div class="col-md-4">
                <div class="card-stat">
                    <div class="card-icon bg-warning"><i class="ti ti-beach"></i></div>
                    <div class="kpi-value"></div>
                    <div class="kpi-label">Demandes de Congé</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-stat">
                    <div class="card-icon bg-danger"><i class="ti ti-door-enter"></i></div>
                    <div class="kpi-value"></div>
                    <div class="kpi-label">Demandes de Permission</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-stat">
                    <div class="card-icon bg-dark"><i class="ti ti-user-plus"></i></div>
                    <div class="kpi-value"></div>
                    <div class="kpi-label">Demandes d'emploi</div>
                </div>
            </div>
        </div>
    </div>

</div>





				</div>


	<script>
	// Fonction d'animation compteur
	function animateCountUp(element, start, end, duration) {
		let startTimestamp = null;
		const step = (timestamp) => {
		if (!startTimestamp) startTimestamp = timestamp;
		const progress = Math.min((timestamp - startTimestamp) / duration, 1);
		element.innerText = Math.floor(progress * (end - start) + start).toLocaleString();
		if (progress < 1) {
			window.requestAnimationFrame(step);
		} else {
			element.innerText = end.toLocaleString(); // Assure la valeur finale exacte
		}
		};
		window.requestAnimationFrame(step);
	}

	// Au chargement de la page, lance les animations sur tous les éléments avec classe .count-up
	document.addEventListener('DOMContentLoaded', () => {
		const counters = document.querySelectorAll('.count-up');
		counters.forEach(counter => {
		const endValue = parseInt(counter.getAttribute('data-end'), 10);
		animateCountUp(counter, 0, endValue, 1500); // 1500ms = 1.5s d'animation
		});
	});
	</script>


	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <!-- JS Sheet Pour le graphique du personnel -->
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			fetch('/statistiques-personnel')
			.then(response => response.json())
			.then(data => {
				const ctx = document.getElementById('courbePersonnel').getContext('2d');
				new Chart(ctx, {
					type: 'line',
					data: {
						labels: data.mois, // ["Jan", "Fév", ...]
						datasets: [
							{
								label: 'Personnel Total',
								data: data.total,
								borderColor: '#434343',
								backgroundColor: 'rgba(67, 67, 67, 0.2)',
								fill: true,
								tension: 0.3
							},
							{
								label: 'Personnel Enseignant',
								data: data.enseignants,
								borderColor: '#2948ff',
								backgroundColor: 'rgba(41, 72, 255, 0.2)',
								fill: true,
								tension: 0.3
							},
							{
								label: 'Personnel Administratif',
								data: data.administratifs,
								borderColor: '#1d976c',
								backgroundColor: 'rgba(29, 151, 108, 0.2)',
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
								text: 'Évolution du personnel actif (6 derniers mois)'
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
				console.error('Erreur lors du chargement des statistiques personnel :', error);
			});
		});
	</script>


<!-- JS Sheet pour le graphique du pointage -->
<script>
	document.addEventListener("DOMContentLoaded", function () {
		fetch('/statistiques-presence-30-jours')
			.then(response => response.json())
			.then(data => {
				const ctx = document.getElementById('graphPresence30Jours').getContext('2d');

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
								text: 'Évolution des présences, retards et absences (30 jours ouvrables)'
							}
						},
						scales: {
							x: {
								ticks: {
									callback: function (value, index) {
										return index % 3 === 0 ? this.getLabelForValue(value) : '';
									},
									maxRotation: 45,
									minRotation: 45,
									font: {
										size: 10
									}
								}
							},
							y: {
								beginAtZero: true,
								ticks: {
									stepSize: 5, // ← 1 cm = 5 unités, si proportions écran le permettent
									font: {
										size: 11
									}
								}
							}
						}
					}
				});
			})
			.catch(error => {
				console.error('Erreur chargement statistiques :', error);
			});
	});
</script>







