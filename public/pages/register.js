
    jQuery(document).ready(function() {





    $("#validerRegister").click(function(event) {
        event.preventDefault();


        register()
    });



    clearData()

});

    function clearData() {


    $('#nom').val('');
    $('#prenom').val('');
    $('#login').val('');
    $('#mot_passe').val('');
    $('#role').val('');



        let form = document.getElementById('form');
        $(form).find('span.error-text').text('');





    }



    //------------------------ fonction d' enregistrement de l utilisateur
    function register() {

    let allValid = true;

    let login = $('#login').val().trim();
    let mot_passe = $('#mot_passe').val().trim();
    let mot_passe_confirmed = $('#mot_passe_confirmed').val().trim();
    let nom = $('#nom').val().trim();
    let prenom = $('#prenom').val().trim();
    let role = $('#role').val();


    $('#erreurAjax').html(''); // Réinitialiser l'erreur


        if (login === '') {

            $('.login_error').text("Le login    est obligatoire ");
            allValid = false;

        }

        if (mot_passe === '') {

            $('.mot_passe_error').text("Le mot de passe     est obligatoire ");
            allValid = false;

        }

        if (nom === '') {

            $('.nom_error').text("Le nom    est obligatoire ");
            allValid = false;

        }

        if (prenom === '') {

            $('.prenom_error').text("Le prenom     est obligatoire ");
            allValid = false;

        }

        if (!role || isNaN(role)) {
            $('.role_error').text("Le choix d un role     est obligatoire ");
            allValid = false;
        }


        if (mot_passe !== mot_passe_confirmed) {
            e.preventDefault(); // Empêche l’envoi du formulaire
            $('.mot_passe_confirmed_error').text('Les mots de passe ne correspondent pas.');
        }


        if (allValid) {



            let form = document.getElementById('form');
            let formData = new FormData(form);


            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: "/register/save",
                method: $(form).attr('method'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    // setting a timeout
                    $(form).find('span.error-text').text('');

                },

                success: function(utilisateur) {
                    console.log(utilisateur)

                    Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Utilisateur  ajouté avec succes ',
                            showConfirmButton: false,


                        },

                        setTimeout(function() {
                            location.reload();
                        }, 2000));






                },

                error: function(xhr) {

                    console.log(xhr);

                    if (xhr.status === 422) {
                        let erreurs = xhr.responseJSON.errors;

                        // Réinitialiser les messages d'erreurs
                        $('.error-text').text('');

                        // Afficher chaque erreur dans le bon span
                        $.each(erreurs, function(champ, messages) {
                            // Exemple : champ = 'libelle' → span = '.libelle_error'
                            $(`.${champ}_error`).text(messages[0]);
                        });
                    } else {


                        $('#erreurAjax').html('Une erreur inattendue est survenue.');
                    }


                }



            });



        }
}

