jQuery(document).ready(function() {

    // Ouvrir le modal d ' ajout de Classe
    $("#lancerClasse").click(function(event) {
        event.preventDefault();

        lancerClasse()
    });

    // Fermer  le modal d ' ajout de Classe
    $("#annulerClasse").click(function(event) {
        event.preventDefault();

        annulerClasse()
    });

    // Valider   l  ajout de Classe
    $(document).on('click', '#ajouterClasse', function(event) {

        event.preventDefault();


        validerClasse()

    });






    //------------------------ Modification d' un Classe
    $(document).on('click', '.modifierClasse', function() {

        let id = $(this).data('id');
        let url = "/classes/modifier/" + id;


        $.get(url, function(classe) {

            console.log(classe);

            $('#defaultModalLabel').text('Modifier une  classe  ');

            let classe_modal = $('#addClasse');

            $(classe_modal).find('form').find('input[name="libelle"]').val(classe.libelle);
            $(classe_modal).find('form').find('select[name="cycle_id"]').val(classe.cycle_id);
            $(classe_modal).find('form').find('select[name="niveau_id"]').val(classe.niveau_id);
            $(classe_modal).find('form').find('textarea[name="emplacement"]').val(classe.emplacement);



            $('#idClasse').val(classe.id);

            $("#ajouterClasse").hide();
            $("#updateClasse").show();

            $(classe_modal).modal('toggle');

        }, 'json')



    });


    $(document).on('click', '.supprimerClasse', function(event) {

        event.preventDefault();
        let id = $(this).data('id');

        deleteConfirmation(id)

    });




    $("#updateClasse").click(function(event) {
        event.preventDefault();

        updateClasse()
    });


    clearData();





});


//------------------------ Mise a Classe des champs
function clearData() {

    $('#libelle').val('');
    $('#emplacement').val('');
    $('#cycle_id').val('');
    $('#niveau_id').val('');


    let form = document.getElementById('form');
    $(form).find('span.error-text').text('');

    $("#ajouterClasse").show();
    $("#updateClasse").hide();

}

//------------------------ Ouvrir le popup d' ajout
function lancerClasse() {

    clearData();

    $('#defaultModalLabel').text('Ajouter  une classe   ');

    $('#addClasse').modal('toggle');
}



//------------------------ Fermer  le popup d' ajout
function annulerClasse() {

    clearData();



    $('#addClasse').modal('toggle');
}

//------------------------ Valider le Classe

function validerClasse() {

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
            url: "/classes/save",
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

            success: function(Classe) {
                console.log(Classe)

                    Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Classe ajouté avec succes ',
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


//------------------------ Update de Classe
function updateClasse() {



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



    let id = $('#idClasse').val();


    if (allValid) {

        let form = document.getElementById('form');
        let formData = new FormData(form);


        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: "/classes/update/" + id,
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

            success: function(Classe) {

                console.log(Classe)

                    Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Classe modifié avec succes ',
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



//------------------------ fonction de suppression de Classe

function deleteConfirmation(id) {
    Swal.fire({
        title: "Voulez vous supprimer cette classe    ?",
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
                url: "/classes/delete/" + id,
                data: {
                    _token: CSRF_TOKEN
                },
                dataType: 'JSON',
                success: function(reponse) {

                    console.log(reponse)
                    if (reponse.Classe) {
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




