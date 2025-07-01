jQuery(document).ready(function() {

    // Ouvrir le modal d ' ajout de cycle
    $("#lancerCycle").click(function(event) {
        event.preventDefault();

        lancerCycle()
    });

    // Fermer  le modal d ' ajout de cycle
    $("#annulerCycle").click(function(event) {
        event.preventDefault();

        annulerCycle()
    });

    // Valider   l  ajout de cycle
    $(document).on('click', '#ajouterCycle', function(event) {

        event.preventDefault();


        validerCycle()

    });






    //------------------------ Modification d' un cycle
    $(document).on('click', '.modifierCycle', function() {

        let id = $(this).data('id');
        let url = "/cycles/modifier/" + id;


        $.get(url, function(cycle) {

            console.log(cycle);

            $('#defaultModalLabel').text('Modifier un cycle  ');

            let cycle_modal = $('#addCycle');

            $(cycle_modal).find('form').find('input[name="libelle"]').val(cycle.libelle);


            $('#idCycle').val(cycle.id);

            $("#ajouterCycle").hide();
            $("#updateCycle").show();

            $(cycle_modal).modal('toggle');

        }, 'json')



    });


    $(document).on('click', '.supprimerCycle', function(event) {

        event.preventDefault();
        let id = $(this).data('id');

        deleteConfirmation(id)

    });




    $("#updateCycle").click(function(event) {
        event.preventDefault();

        updateCycle()
    });


    clearData();





});


//------------------------ Mise a niveau des champs
function clearData() {

    $('#libelle').val('');


    let form = document.getElementById('form');
    $(form).find('span.error-text').text('');

    $("#ajouterCycle").show();
    $("#updateCycle").hide();

}

//------------------------ Ouvrir le popup d' ajout
function lancerCycle() {

    clearData();

    $('#defaultModalLabel').text('Ajouter  un cycle   ');

    $('#addCycle').modal('toggle');
}



//------------------------ Fermer  le popup d' ajout
function annulerCycle() {

    clearData();



    $('#addCycle').modal('toggle');
}

//------------------------ Valider le cycle

function validerCycle() {

    let allValid = true;

    let libelle = $('#libelle').val().trim();

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
            url: "/cycles/save",
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

            success: function(cycle) {
                console.log(cycle)

                    Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Cycle ajouté avec succes ',
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


//------------------------ Update de Cycle
function updateCycle() {



    let allValid = true;

    let libelle = $('#libelle').val().trim();


    if (libelle === '') {
        $('.libelle_error').text("Le libelle    est obligatoire ");
        allValid = false;

    }



    let id = $('#idCycle').val();


    if (allValid) {

        let form = document.getElementById('form');
        let formData = new FormData(form);


        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: "/cycles/update/" + id,
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

            success: function(cycle) {

                console.log(cycle)

                    Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Cycle modifié avec succes ',
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



//------------------------ fonction de suppression de Cycle

function deleteConfirmation(id) {
    Swal.fire({
        title: "Voulez vous supprimer ce cycle    ?",
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
                url: "/cycles/delete/" + id,
                data: {
                    _token: CSRF_TOKEN
                },
                dataType: 'JSON',
                success: function(reponse) {

                    console.log(reponse)
                    if (reponse.cycle) {
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




