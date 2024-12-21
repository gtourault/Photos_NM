<?php
/*
Template Name: Modale Contact Form
*/

?>

<div id="contactModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-image">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/Contact_header.png" alt="image du mot contact">
        </div>
        <div class="modal-form">
            <!-- Contact Form 7 shortcode -->
            <?php echo do_shortcode('[contact-form-7 id="cb8bc03" title="Formulaire de contact"]'); ?>
        </div>
    </div>
</div>