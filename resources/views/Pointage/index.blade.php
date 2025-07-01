<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Pointage du personnel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <style>
      /* RESET */
      * {
        box-sizing: border-box;
      }

      body {
        background: #f0f4ff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
      }

      .form-container {
        background: #fff;
        padding: 40px 35px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        width: 100%;
        max-width: 420px;
        transition: box-shadow 0.3s ease;
      }

      .form-container:hover {
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.18);
      }

      .header-container {
        text-align: center;
        margin-bottom: 40px;
        color: #af1e31; /* Bleu foncé */
      }

      .header-container h4 {
        font-size: 2.8rem;
        margin-bottom: 10px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        text-shadow: 1px 1px 3px #1e40af;
      }

      .header-container h4 {
        font-size: 1.8rem;
        font-weight: 500;
        color: #374151; /* Gris foncé */
      }

      .form-group {
        position: relative;
        margin-bottom: 28px;
      }

      label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #334155;
        user-select: none;
      }

      input[type='text'],
      input[type='password'],
      select {
        width: 100%;
        padding: 14px 48px 14px 14px;
        border: 2px solid #cbd5e1;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        outline-offset: 2px;
        outline-color: transparent;
      }

      input[type='text']:focus,
      input[type='password']:focus,
      select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 6px #2563ebaa;
        outline-color: #2563eb;
      }

      /* Icône œil */
      .toggle-password {
        position: absolute;
        right: 14px;
        top: 42px;
        font-size: 1.2rem;
        color: #64748b;
        cursor: pointer;
        user-select: none;
        transition: color 0.3s ease;
      }

      .toggle-password:hover {
        color: #2563eb;
      }

      /* Bouton */
      button[type='submit'] {
        width: 100%;
        padding: 15px 0;
        background-color: #2563eb;
        border: none;
        border-radius: 8px;
        color: white;
        font-weight: 700;
        font-size: 1.15rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        user-select: none;
      }

      button[type='submit']:hover {
        background-color: #1e40af;
      }

      /* Placeholder style */
      ::placeholder {
        color: #94a3b8;
        font-style: italic;
      }

      .date {
        font-size: 1.3rem;
        margin-bottom: 30px;
        text-align: center;
        color: #333;
        font-weight: 600;
      }
      .date {
        font-size: 1.4rem;
        font-weight: 600;
        color: #2563eb; /* bleu vif */
        background-color: #dbeafe; /* bleu très clair */
        padding: 12px 25px;
        border-radius: 30px;
        box-shadow: 0 4px 8px rgb(37 99 235 / 0.3);
        max-width: fit-content;
        margin: 0 auto 40px auto;
        user-select: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        align-items: center;
        gap: 10px;
        }
        .date::before {
        
        font-size: 1.6rem;
        }

    </style>
</head>
<body>

  

  <div class="form-container">
    <div class="header-container">
        <div class="date" id="currentDate"></div>
      <h3>Ecole Internationale Mariam</h3>
      <h4>Pointage du personnel</h4>
    </div>

    <form method="POST" action="/pointage">
         @csrf


      <div class="form-group">
        <label for="matricule">Matricule</label>
        <input
          type="text"
          id="matricule"
          name="matricule"
          placeholder="Entrez votre matricule"
          required
          autocomplete="off"
        />
      </div>

      <div class="form-group">
        <label for="mot_de_passe">Mot de passe</label>
        <input
          type="password"
          id="mot_de_passe"
          name="mot_de_passe"
          placeholder="Entrez votre mot de passe"
          required
          autocomplete="off"
        />
        <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
      </div>

      <div class="form-group">
        <label for="type_pointage">Type de pointage</label>
        <select id="type_pointage" name="type_pointage" required>
          <option value="" disabled selected>-- Choisir le type --</option>
          <option value="arrivee">Arrivée</option>
          <option value="depart">Départ</option>
        </select>
      </div>

      <button type="submit">Valider le pointage</button>
    </form>
  </div>

  <script>
    // Date en français
    const dateElement = document.getElementById("currentDate");
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const date = new Date().toLocaleDateString('fr-FR', options);
    dateElement.textContent = `📅 ${date.charAt(0).toUpperCase() + date.slice(1)}`;

    // Voir/masquer mot de passe
    function togglePassword() {
      const pwdInput = document.getElementById("mot_de_passe");
      const icon = document.querySelector(".toggle-password");
      if (pwdInput.type === "password") {
        pwdInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        pwdInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  </script>
  <!-- SweetAlert2 CDN -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: {!! json_encode(session('error')) !!}
    });
@endif

@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Succès',
        text: {!! json_encode(session('success')) !!}
    });
@endif
</script>



</body>
</html>
