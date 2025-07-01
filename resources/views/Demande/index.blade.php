<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'emploi à l'école International Mariam</title>
    <link rel="icon" href="RessourcesHumaines/demande/img/logo.png" type="image/png">
   <link rel="stylesheet" href="RessourcesHumaines/demande/css/style.css">
   <script src="RessourcesHumaines/demande/js/demande.js"></script>	

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    
</head>
<body>
<div class="container">
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    
    <h3>Demande d'emploi à l'école International Mariam</h3>
    <img src="RessourcesHumaines/demande/img/logo.png" alt="Logo de l'école" class="logo">
    <form action="{{ route('demande.emploi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénoms</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <div class="row">
                <div>
                    <label for="telephone">Téléphone</label>
                    <input type="tel" id="telephone" name="telephone" required >
                </div>
            </div>
            
            <label for="experience" style="margin-top: 10px;">Expérience (années)</label>
            <input type="number" id="experience" name="experience" min="0" class="input-common">
            

        <label for="domaine">Poste</label>
        <select id="domaine" name="domaine">
            <option value="Agent de laboratoire">Agent de laboratoire</option>
            <option value="Agent de ménage">Agent de ménage</option>
            <option value="Agent de sécurité">Agent de sécurité</option>
            <option value="Assistant(e) d'éducation (Surveillant(e))">Assistant(e) d'éducation (Surveillant(e))</option>
            <option value="Bibliothécaire">Bibliothécaire</option>
            <option value="Caissier(ère)">Caissier(ère)</option>
            <option value="Censeur">Censeur</option>
            <option value="Chauffeur">Chauffeur</option>
            <option value="Comptable">Comptable</option>
            <option value="Conseiller(ère) principal(e) d'éducation (Surveillant(e) général(e))">Conseiller(ère) principal(e) d'éducation (Surveillant(e) général(e))</option>
            <option value="Cuisinier(ère)">Cuisinier(ère)</option>
            <option value="Directeur(trice) administratif(ve) et financier(ère)">Directeur(trice) administratif(ve) et financier(ère)</option>
            <option value="Enseignant(e)">Enseignant(e)</option>
            <option value="Infirmier(ère)">Infirmier(ère)</option>
            <option value="Informaticien(ne)">Informaticien(ne)</option>
            <option value="Principal(e)">Principal(e)</option>
            <option value="Proviseur">Proviseur</option>
            <option value="Proviseur adjoint(e)">Proviseur adjoint(e)</option>
            <option value="Responsable des ressources humaines">Responsable des ressources humaines</option>
            <option value="Secrétaire">Secrétaire</option>
        </select>


        <label for="cv">CV (PDF)</label>
        <input type="file" id="cv" name="cv" accept=".pdf" required>

        <label for="lettre_motivation">Lettre de motivation (PDF)</label>
        <input type="file" id="lettre_motivation" name="lettre_motivation" accept=".pdf" required>

        <button type="submit">Soumettre</button>
    </form>
</div>

</body>
</html>
