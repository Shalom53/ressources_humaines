jQuery(document).ready(function() {





    // Ouvrir le modal d ' ajout de Inscription
    $("#lancerInscription").click(function(event) {
        event.preventDefault();

        lancerInscription()
    });

    // Fermer  le modal d ' ajout de Inscription
    $("#annulerInscription").click(function(event) {
        event.preventDefault();

        annulerInscription()
    });

    // Valider   l  ajout de Inscription
    $(document).on('click', '#ajouterInscription', function(event) {

        event.preventDefault();


        validerInscription()

    });






    //------------------------ Modification d' un Inscription
    $(document).on('click', '.modifierInscription', function() {

        let id = $(this).data('id');
        let url = "/inscriptions/modifier/" + id;


        $.get(url, function(inscription) {

            console.log(inscription);


            $('#defaultModalLabel').text('Modifier ses informations   ');

            let inscription_modal = $('#data_eleve');



            $("#ajouterInscription").hide();
            $("#updateInscription").show();

            $(inscription_modal).modal('toggle');

        }, 'json')



    });


    $(document).on('click', '.supprimerInscription', function(event) {

        event.preventDefault();
        let id = $(this).data('id');

        deleteConfirmation(id)

    });




    $("#updateInscription").click(function(event) {
        event.preventDefault();

        updateInscription()
    });


    clearData();





});


//------------------------ Mise a Inscription des champs
function clearData() {

    $('#libelle').val('');
    $('#emplacement').val('');
    $('#cycle_id').val('');
    $('#niveau_id').val('');


    let form = document.getElementById('form');
    $(form).find('span.error-text').text('');

    $("#ajouterInscription").show();
    $("#updateInscription").hide();

}

//------------------------ Ouvrir le popup d' ajout
function lancerInscription() {

    clearData();

    $('#defaultModalLabel').text('Ajouter  une Inscription   ');

    $('#addInscription').modal('toggle');
}



//------------------------ Fermer  le popup d' ajout
function annulerInscription() {

    clearData();



    $('#addInscription').modal('toggle');
}

//------------------------ Valider le Inscription

function validerInscription() {

    let allValid = true;

    let libelle = $('#libelle').val().trim();

    let cycle_id = $('#cycle_id').val();
    let niveau_id = $('#niveau_id').val();

    if (!cycle_id || isNaN(cycle_id)) {
        $('.cycle_id_error').text("Le choix d un cycle     est obligatoire ");
        allValid = false;
    }

    if (!niveau_id || isNaN(niveau_id)) {
        $('.niveau_id_error').text("Le choix d un niveau      est obligatoire ");
        allValid = false;
    }

    if (libelle === '') {

        $('.libelle_error').text("Le libelle    est obligatoire ");
        allValid = false;

    }




    if (allValid) {



        let form = document.getElementById('form');
        let formData = new FormData(form);


        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: "/inscriptions/save",
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

            success: function(Inscription) {
                console.log(Inscription)

                    Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Inscription ajouté avec succes ',
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
                    alert("Une erreur inconnue est survenue.");
                }



            }



        });



    }
}


//------------------------ Update de Inscription
function updateInscription() {



    let allValid = true;

    let libelle = $('#libelle').val().trim();

    let cycle_id = $('#cycle_id').val();
    let niveau_id = $('#niveau_id').val();

    if (!cycle_id || isNaN(cycle_id)) {
        $('.cycle_id_error').text("Le choix d un cycle     est obligatoire ");
        allValid = false;
    }

    if (!niveau_id || isNaN(niveau_id)) {
        $('.niveau_id_error').text("Le choix d un niveau      est obligatoire ");
        allValid = false;
    }

    if (libelle === '') {

        $('.libelle_error').text("Le libelle    est obligatoire ");
        allValid = false;

    }



    let id = $('#idInscription').val();


    if (allValid) {

        let form = document.getElementById('form');
        let formData = new FormData(form);


        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: "/inscriptions/update/" + id,
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

            success: function(Inscription) {

                console.log(Inscription)

                    Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Inscription modifié avec succes ',
                            showConfirmButton: false,


                        },

                        setTimeout(function() {
                            location.reload();
                        }, 2000));




            },

            error: function(xhr) {

                console.log(xhr);

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
                    alert("Une erreur inconnue est survenue.");
                }



            }



        });

    }


}



//------------------------ fonction de suppression de Inscription

function deleteConfirmation(id) {
    Swal.fire({
        title: "Voulez vous supprimer cette Inscription    ?",
        icon: 'question',
        text: "",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Valider",
        cancelButtonText: "Annuler",
        reverseButtons: !0
    }).then(function(e) {

        if (e.value === true) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: "/inscriptions/delete/" + id,
                data: {
                    _token: CSRF_TOKEN
                },
                dataType: 'JSON',
                success: function(reponse) {

                    console.log(reponse)
                    if (reponse.Inscription) {
                        Swal.fire("Succès", reponse.message, "success");
                        // refresh page after 2 seconds
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire("Erreur!", reponse.message, "error");
                    }
                }
            });

        } else {
            e.dismiss;
        }

    }, function(dismiss) {
        return false;
    })
}




