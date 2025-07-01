
    jQuery(document).ready(function() {





    $("#authentifier").click(function(event) {
        event.preventDefault();


        authentifier()
    });



    clearData()

});

    function clearData() {


    $('#login').val('');
    $('#mot_passe').val('');



        let form = document.getElementById('form');
        $(form).find('span.error-text').text('');





    }



    //------------------------ fonction d' authentification
    function authentifier() {

    let allValid = true;

    let login = $('#login').val();
    let mot_passe = $('#mot_passe').val();

    $('#erreurAjax').html(''); // Réinitialiser l'erreur


        if (login === '') {

            $('.login_error').text("Le login    est obligatoire ");
            allValid = false;

        }

        if (mot_passe === '') {

            $('.mot_passe_error').text("Le mot de passe     est obligatoire ");
            allValid = false;

        }


        if (allValid) {



            let form = document.getElementById('form');
            let formData = new FormData(form);


            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: "/utilisateurs/login",
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

                    location.href = '/'






                },

                error: function(xhr) {

                    console.log(xhr);

                    if (xhr.status === 401) {
                        // Erreur personnalisée renvoyée depuis Laravel
                        $('#erreurAjax').html(xhr.responseJSON.message);
                    } else if (xhr.status === 422) {
                        // Erreurs de validation du FormRequest
                        let erreurs = xhr.responseJSON.errors;
                        let messages = '';
                        for (let champ in erreurs) {
                            messages += erreurs[champ][0] + '<br>';
                        }
                        $('#erreurAjax').html(messages);
                    } else {
                        $('#erreurAjax').html('Une erreur inattendue est survenue.');
                    }


                }



            });



        }
}

