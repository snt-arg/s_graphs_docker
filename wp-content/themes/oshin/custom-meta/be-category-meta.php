<?php
/**
 * Add Custom Meta to Category Taxonomy
 */
function be_add_custom_field_to_category( $taxonomy ) {

  ?>

    <div class="form-field term-colorpicker-wrap">
        <label for="for_be_catg_bg_color">Category Background Color</label>
        <input name="be_catg_bg_color" value="#000000" class="colorpicker" id="for_be_catg_bg_color" />
        <p>Color Applied as Background to Category on Masonry and Metro Style Blog post.</p>
    </div>

    <div class="form-field term-colorpicker-wrap">
        <label for="for_be_catg_color">Category Color</label>
        <input name="be_catg_color" value="#ffffff" class="colorpicker" id="for_be_catg_color" />
        <p>Color Applied to Category on Masonry and Metro Style Blog post.</p>
    </div>

  <?php

}
add_action( 'category_add_form_fields', 'be_add_custom_field_to_category' );  // Variable Hook Name

/**
 * Add Custom Meta to Edit Category Page
 */
function be_add_custom_field_to_edit_category( $term ) {

    $color = get_term_meta( $term->term_id, 'be_catg_bg_color', true );
    $color = ( ! empty( $color ) ) ? "#{$color}" : '#000000';

    $text_color = get_term_meta( $term->term_id, 'be_catg_color', true );
    $text_color = ( ! empty( $text_color ) ) ? "#{$text_color}" : '#ffffff';

  ?>

    <tr class="form-field term-colorpicker-wrap">
        <th scope="row"><label for="for_be_catg_bg_color">Category BG Color</label></th>
        <td>
            <input name="be_catg_bg_color" value="<?php echo $color; ?>" class="colorpicker" id="for_be_catg_bg_color" />
            <p class="description">Color Applied as Background to Category on Masonry and Metro Style Blog post.</p>
        </td>
    </tr>
    <tr class="form-field term-colorpicker-wrap">
        <th scope="row"><label for="for_be_catg_color">Category Color</label></th>
         <td>
            <input name="be_catg_color" value="<?php echo $text_color; ?>" class="colorpicker" id="for_be_catg_color" />
            <p class="description">Color Applied to Category on Masonry and Metro Style Blog post.</p>
        </td>
    </tr>

  <?php


}
add_action( 'category_edit_form_fields', 'be_add_custom_field_to_edit_category' );   // Variable Hook Name

/**
 * Save Custom Meta
 */
function be_save_custom_meta( $term_id ) {

    if( isset( $_POST['be_catg_bg_color'] ) && ! empty( $_POST['be_catg_bg_color'] ) ) {
        update_term_meta( $term_id, 'be_catg_bg_color', sanitize_hex_color_no_hash( $_POST['be_catg_bg_color'] ) );
    } else {
        delete_term_meta( $term_id, 'be_catg_bg_color' );
    }

    if( isset( $_POST['be_catg_color'] ) && ! empty( $_POST['be_catg_color'] ) ) {
        update_term_meta( $term_id, 'be_catg_color', sanitize_hex_color_no_hash( $_POST['be_catg_color'] ) );
    } else {
        delete_term_meta( $term_id, 'be_catg_color' );
    }

}
add_action( 'created_category', 'be_save_custom_meta' );  // Variable Hook Name
add_action( 'edited_category',  'be_save_custom_meta' );  // Variable Hook Name

/**
 * Enqueue colorpicker styles and scripts.
 */
function be_category_colorpicker_enqueue( $taxonomy ) {

    if( null !== ( $screen = get_current_screen() ) && 'edit-category' !== $screen->id ) {
        return;
    }
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_style( 'wp-color-picker' );
    
}
add_action( 'admin_enqueue_scripts', 'be_category_colorpicker_enqueue' );

/**
 * Initialize color picker
 */
function be_category_colorpicker_init() {

    if( null !== ( $screen = get_current_screen() ) && 'edit-category' !== $screen->id ) {
        return;
    }

  ?>
    <script>
        jQuery( document ).ready( function( $ ) {
            $( '.colorpicker' ).wpColorPicker();
        } ); // End Document Ready JQuery
    </script>
  <?php
}
add_action( 'admin_print_scripts', 'be_category_colorpicker_init', 20 );

?>