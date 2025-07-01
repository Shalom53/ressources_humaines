
        document.addEventListener("DOMContentLoaded", function() {
            var input = document.querySelector("#telephone");
            var iti = window.intlTelInput(input, {
                initialCountry: "tg", // Code du pays pour le Togo
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // Utilisé pour les validations et la mise en forme
            });

            input.addEventListener("blur", function() {
                if (!iti.isValidNumber()) {
                    input.setCustomValidity("Veuillez entrer un numéro de téléphone valide");
                } else {
                    input.setCustomValidity("");
                }
            });
        });

        function validateForm(event) {
            var cv = document.getElementById("cv").files[0];
            var lettre = document.getElementById("lettre_motivation").files[0];
            
            if (!cv || cv.type !== "application/pdf") {
                alert("Veuillez sélectionner un fichier PDF valide pour le CV.");
                event.preventDefault();
                return false;
            }
            
            if (!lettre || lettre.type !== "application/pdf") {
                alert("Veuillez sélectionner un fichier PDF valide pour la lettre de motivation.");
                event.preventDefault();
                return false;
            }
            
            return confirm("Voulez-vous vraiment soumettre cette demande ?");
        }
    