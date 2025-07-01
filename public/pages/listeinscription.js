jQuery(document).ready(function() {


// Charger les inscritions a chaque fois q u on change de filtre
    $('.filtre').on('change', function () {


        chargerInscriptions();
    });


    clearData();


});




//------------------------ Mise a Inscription des champs
function clearData() {

    $('#cycle_id').val(0);
    $('#niveau_id').val(0);
    $('#classe_id').val(0);
    $('#type_inscription').val(0);
    $('#sexe').val(0);




}

function chargerInscriptions() {


    $.ajax({
        url: '/inscriptions/index',
        type: 'GET',
        data: {
            cycle_id: $('#cycle_id').val(),
            niveau_id: $('#niveau_id').val(),
            classe_id: $('#classe_id').val(),
            type_inscription: $('#type_inscription').val(),
            sexe: $('#sexe').val(),

        },


        success: function (data) {

            console.log(data)
            // MAJ des totaux
            $('#totalEleves').text(data.total.toLocaleString());
            $('#totalFilles').text(data.filles.toLocaleString());
            $('#totalGarcons').text(data.garcons.toLocaleString());
            $('#totalNouveaux').text(data.nouveaux.toLocaleString());

            // MAJ de la liste


        },
        error: function (xhr) {
            console.error('Erreur AJAX', xhr);
            alert("Une erreur est survenue.");
        }
    });
}


