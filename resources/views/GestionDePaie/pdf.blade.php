<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Bulletin de Solde</title>
  
</head>
<body>
    <div class="a4-page">
   
    <div class="bulletin">
    

    <!-- EN-TÊTE -->
            <div id="header">
                <div class="header-section" id="ministere">
                    <h3>ECOLE INTERNATIONALE MARIAM</h3>
                    <hr>
                </div>

                <div class="header-section" id="logo">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('admin/images/logo_mariam.png'))) }}" alt="Logo">
                    <h4>BULLETIN DE PAIE</h4>
                </div>

                <div class="header-section" id="republique">
                    <h3>REPUBLIQUE TOGOLAISE</h3>
                    <h4>Travail - Liberté - Patrie</h4>
                    <hr>
                </div>
            </div>


    <!-- AFFECTATION -->

                    <h4>Référence : {{ $bulletin->reference }} </h4>
            
     <div id="info_annee">
        <div class="bulletin-section" id="eleve">
            <h2>Employé : <span>{{ $bulletin->nom  . ' ' . $bulletin->prenom }}</span></h2>
        </div>

        <div class="bulletin-section" id="tab_annee">
            <table>
                <tr>
                    <th>EMPLOYÉ</th>
                    <th>PERIODE</th>
                    <th>NET PAYÉ</th>
                    <th>POSTE</th>
                </tr>
                <tr>
                    <td>{{ $bulletin->nom  . ' ' . $bulletin->prenom }}</td>
                    <td class="periode-cell" data-periode="{{ $bulletin->periode }}"></td>


                    <td>{{ number_format($bulletin->salaire_net, 0, ',', ' ') }} FCFA </td>
                    <td>{{ $bulletin->poste }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="background-logo"></div>

        <div class="section">
             
               
                <h3>Salaire de base et horaire</h3>
                <table>
                    <tr><th>Salaire de base</th><td>{{ number_format($bulletin->salaire_base, 2) }}</td></tr>
                    <tr><th>Salaire horaire</th><td>{{ number_format($bulletin->salaire_horaire, 2) }}</td></tr>
                </table>

                <h3>Indemnités et primes</h3>
                <table>
                    <tr><th>Heures supp.</th><td>{{ number_format($bulletin->heures_supp, 2) }}</td></tr>
                    <tr><th>Logement</th><td>{{ number_format($bulletin->logement, 2) }}</td></tr>
                    <tr><th>Commission</th><td>{{ number_format($bulletin->commission, 2) }}</td></tr>
                    <tr><th>Transport</th><td>{{ number_format($bulletin->transport, 2) }}</td></tr>
                    <tr><th>Congés</th><td>{{ number_format($bulletin->conges, 2) }}</td></tr>
                    <tr><th>Prime de repos</th><td>{{ number_format($bulletin->prime_repos, 2) }}</td></tr>
                    
                </table>

                <h3>Retenues</h3>
                <table>
                    <tr><th>CNSS</th><td>{{ number_format($bulletin->cnss, 2) }}</td></tr>
                    <tr><th>INS</th><td>{{ number_format($bulletin->ins, 2) }}</td></tr>
                    <tr><th>IRPP</th><td>{{ number_format($bulletin->irpp, 2) }}</td></tr>
                    <tr><th>TCS</th><td>{{ number_format($bulletin->tcs, 2) }}</td></tr>
                    <tr><th>Crédit</th><td>{{ number_format($bulletin->credit, 2) }}</td></tr>
                    <tr><th>Absences</th><td>{{ number_format($bulletin->absences, 2) }}</td></tr>
                    <tr><th>Avance sur salaire</th><td>{{ number_format($bulletin->avance_salaire, 2) }}</td></tr>
                    <tr><th>Acompte</th><td>{{ number_format($bulletin->acompte, 2) }}</td></tr>
                    
                </table>

               

                
        </div>
  
    <!-- MONTANT NET -->
    <div class="section">
  <h3>MONTANT NET À PAYER</h3>
  <div class="net">
    *** {{ number_format($bulletin->salaire_net, 0, ',', ' ') }} FCFA ***
  </div>
</div>

    
   
  </div>
  </div>
</body>
</html>


<style>body {
  font-family: "Arial", sans-serif;
  background: #fdfdfd;
  padding: 20px;
  margin: 0;
}

.a4-page {
  width: 210mm;
  height: 297mm;
  position: relative; /* ← important */
  margin: auto;
  page-break-after: always;
  background: white;
  overflow: hidden;
}

.background-logo {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 600px;
  height: 600px;
  transform: translate(-50%, -50%);
  background-image: url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path('admin/images/logo_mariam.png'))) }}');
  background-repeat: no-repeat;
  background-size: contain;
  opacity: 0.09;
  pointer-events: none;
  z-index: 0;
}

.bulletin {
  position: relative;
  z-index: 1;
  background-color: #fff;
  padding: 20px;
  border: 2px solid #000;
  max-width: 900px;
  margin: auto;
}



.section {
  border: 1px solid #000;
  padding: 10px;
  margin-bottom: 15px;
}

.section h3 {
  margin-top: 0;
  text-align: center;
  font-size: 16px;
  text-transform: uppercase;
}

.table-noborder {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
  font-size: 14px;
}

.table-noborder td {
  padding: 4px 8px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
  font-size: 14px;
}

table th, table td {
  border: 1px solid #000;
  padding: 6px;
  text-align: left;
}

tfoot td {
  font-weight: bold;
}

.net {
  font-size: 22px;
  text-align: center;
  color: darkgreen;
  font-weight: bold;
  border: 1px solid #000;
  padding: 10px;
  margin-top: 10px;
}

.message {
  font-size: 13px;
  color: red;
  text-align: center;
}

.print {
  text-align: right;
  font-size: 12px;
  margin-top: 10px;
  color: #555;
}

#header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #000;
    padding: 20px 0;
    margin-bottom: 20px;
    font-family: Arial, sans-serif;
}

.header-section {
    width: 30%;
    text-align: center;
    font-size: 13px;
}

#logo {
    width: 35%;
}

#logo img {
    height: 80px;
    display: block;
    margin: 0 auto 10px;
}

#logo h4 {
    font-size: 1.2em;
    font-weight: bold;
    text-align: center;
    color: #333;
}

#ministere h3,
#republique h3 {
    font-size: 1em;
    margin-bottom: 5px;
}

#republique h4 {
    margin: 5px 0;
    font-size: 0.95em;
}

hr {
    border: none;
    border-top: 1px dashed #444;
    margin-top: 5px;
    margin-bottom: 0;
}

          
#info_annee {
    display: flex;
    justify-content: space-between;
    align-items: flex-start; /* aligne le haut des deux colonnes */
    padding: 0 20px;
    margin-top: 10px;
}

#bulletin,
#tab_annee {
    display: inline-block;
    vertical-align: top;
}

#bulletin {
    width: 48%;
}

#bulletin h2 {
    padding: 0;
    margin: 0;
    line-height: 1.2em;
    font-weight: bold;
    font-size: 1.4em;
    text-transform: uppercase;
    text-align: left;
}

#eleve h2 {
    padding: 0;
    margin: 0;
    font-weight: bold;
    font-size: 1.1em;
    text-transform: uppercase;
    margin-left: 20px;
}

#eleve h2 span {
    color: red;
    font-weight: 900;
}

#tab_annee {
    width: 48%;
    margin-top: 0;
    padding-top: 0;
}

#tab_annee table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 0;
    font-size: 14px;
}

#tab_annee table th {
    font-weight: 600;
    padding: 6px;
    border: 1px solid grey;
    background-color: #f8f8f8;
    text-align: center;
}

#tab_annee table td {
    padding: 6px;
    text-align: center;
    font-weight: 500;
    border: 1px solid grey;
}


/* Impression */
@media print {
  .background-logo {
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }

  body {
    margin: 0;
    padding: 0;
  }
}



</style>


<script>
        window.onload = () => window.print();
        window.onafterprint = () => window.close();
    </script>

    <script>
    document.querySelectorAll('.periode-cell').forEach(function (cell) {
        const dateStr = cell.dataset.periode; // ex: "2025-04-01"
        const date = new Date(dateStr);

        // Options pour le format français
        const options = { year: 'numeric', month: 'long' };

        // Formatage
        const formatted = date.toLocaleDateString('fr-FR', options);

        // Majuscule initiale (facultatif)
        cell.textContent = formatted.charAt(0).toUpperCase() + formatted.slice(1);
    });
</script>
