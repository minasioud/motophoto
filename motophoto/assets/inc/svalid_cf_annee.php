<?php
//********************************************* DEBUT FCT sous le menu "Photos" ************************************************* */
// Fonction de validation JavaScript pour l'entrée (Annee)
function scf_annee_validation_script($hook) {
    // Charger uniquement sur les pages d'édition ou d'ajout
    if ('post.php' === $hook || 'post-new.php' === $hook) {
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const anneeField = document.querySelector('[name="annee"]');
                if (anneeField) {
                    anneeField.addEventListener('input', function () {
                        // Permet uniquement 4 chiffres
                        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 4);
                    });
                }
            });
        </script>
        <?php
    }
}
add_action('admin_enqueue_scripts', 'scf_annee_validation_script');
function valider_champ_annee($value, $field, $args) {
    // Vérifiez si la valeur est un nombre à 4 chiffres
    if (!preg_match('/^\d{4}$/', $value)) {
        return 'Veuillez entrer une année valide (format : YYYY).';
    }
    return $value; // Retournez la valeur si elle est valide
}
add_filter('scf_validate_value_annee', 'valider_champ_annee', 10, 3);

/********************************************************************************************************************************** */
?>