jQuery(document).ready(function() {

    // Ouvrir le modal d ' ajout de Niveau
    $("#lancerNiveau").click(function(event) {
        event.preventDefault();

        lancerNiveau()
    });

    // Fermer  le modal d ' ajout de Niveau
    $("#annulerNiveau").click(function(event) {
        event.preventDefault();

        annulerNiveau()
    });

    // Valider   l  ajout de Niveau
    $(document).on('click', '#ajouterNiveau', function(event) {

        event.preventDefault();


        validerNiveau()

    });






    //------------------------ Modification d' un Niveau
    $(document).on('click', '.modifierNiveau', function() {

        let id = $(this).data('id');
        let url = "/niveaux/modifier/" + id;


        $.get(url, function(niveau) {

            console.log(niveau);

            $('#defaultModalLabel').text('Modifier un niveau  ');

            let niveau_modal = $('#addNiveau');

            $(niveau_modal).find('form').find('input[name="libelle"]').val(niveau.libelle);
            $(niveau_modal).find('form').find('select[name="cycle_id"]').val(niveau.cycle_id);
            $(niveau_modal).find('form').find('textarea[name="description"]').val(niveau.description);



            $('#idNiveau').val(niveau.id);

            $("#ajouterNiveau").hide();
            $("#updateNiveau").show();

            $(niveau_modal).modal('toggle');

        }, 'json')



    });


    $(document).on('click', '.supprimerNiveau', function(event) {

        event.preventDefault();
        let id = $(this).data('id');

        deleteConfirmation(id)

    });




    $("#updateNiveau").click(function(event) {
        event.preventDefault();

        updateNiveau()
    });


    clearData();





});


//------------------------ Mise a niveau des champs
function clearData() {

    $('#libelle').val('');
    $('#description').val('');
    $('#cycle_id').val('');


    let form = document.getElementById('form');
    $(form).find('span.error-text').text('');

    $("#ajouterNiveau").show();
    $("#updateNiveau").hide();

}

//------------------------ Ouvrir le popup d' ajout
function lancerNiveau() {

    clearData();

    $('#defaultModalLabel').text('Ajouter  un niveau   ');

    $('#addNiveau').modal('toggle');
}



//------------------------ Fermer  le popup d' ajout
function annulerNiveau() {

    clearData();



    $('#addNiveau').modal('toggle');
}

//------------------------ Valider le Niveau

function validerNiveau() {

    let allValid = true;

    let libelle = $('#libelle').val().trim();

    let cycle_id = $('#cycle_id').val();

    if (!cycle_id || isNaN(cycle_id)) {
        $('.cycle_id_error').text("Le choix d un cycle     est obligatoire ");
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
            url: "/niveaux/save",
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

            success: function(niveau) {
                console.log(niveau)

                    Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Niveau ajouté avec succes ',
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


//------------------------ Update de Niveau
function updateNiveau() {



    let allValid = true;

    let libelle = $('#libelle').val().trim();

    let cycle_id = $('#cycle_id').val();

    if (!cycle_id || isNaN(cycle_id)) {
        $('.cycle_id_error').text("Le choix d un cycle     est obligatoire ");
        allValid = false;
    }

    if (libelle === '') {

        $('.libelle_error').text("Le libelle    est obligatoire ");
        allValid = false;

    }



    let id = $('#idNiveau').val();


    if (allValid) {

        let form = document.getElementById('form');
        let formData = new FormData(form);


        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: "/niveaux/update/" + id,
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

            success: function(Niveau) {

                console.log(Niveau)

                    Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Niveau modifié avec succes ',
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



//------------------------ fonction de suppression de Niveau

function deleteConfirmation(id) {
    Swal.fire({
        title: "Voulez vous supprimer ce Niveau    ?",
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
                url: "/niveaux/delete/" + id,
                data: {
                    _token: CSRF_TOKEN
                },
                dataType: 'JSON',
                success: function(reponse) {

                    console.log(reponse)
                    if (reponse.Niveau) {
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




