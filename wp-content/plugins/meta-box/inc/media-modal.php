<?php
/**
 * Add support for editing attachment custom fields in the media modal.
 */
class RWMB_Media_Modal {
	/**
	 * List of custom fields.
	 *
	 * @var array
	 */
	protected $fields = [];

	public function init() {
		// Meta boxes are registered at priority 20, so we use 30 to capture them all.
		add_action( 'init', [ $this, 'get_fields' ], 30 );

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );

		add_filter( 'attachment_fields_to_edit', [ $this, 'add_fields' ], 11, 2 );
		add_filter( 'attachment_fields_to_save', [ $this, 'save_fields' ], 11, 2 );

		add_filter( 'rwmb_show', [ $this, 'is_in_normal_mode' ], 10, 2 );
	}

	public function enqueue() {
		if ( get_current_screen()->post_type === 'attachment' ) {
			wp_enqueue_style( 'rwmb', RWMB_CSS_URL . 'media-modal.css', [], RWMB_VER );
		}
	}

	public function get_fields() {
		$meta_boxes = rwmb_get_registry( 'meta_box' )->all();
		foreach ( $meta_boxes as $meta_box ) {
			if ( $this->is_in_modal( $meta_box->meta_box ) ) {
				$this->fields = array_merge( $this->fields, array_values( $meta_box->fields ) );
			}
		}
	}

	/**
	 * Add fields to the attachment edit popup.
	 *
	 * @param array   $form_fields An array of attachment form fields.
	 * @param WP_Post $post The WP_Post attachment object.
	 *
	 * @return mixed
	 */
	public function add_fields( $form_fields, WP_Post $post ) {
		foreach ( $this->fields as $field ) {
			$form_field          = $field;
			$form_field['label'] = $field['name'];
			$form_field['input'] = 'html';

			// Just ignore the field 'std' because there's no way to check it.
			$meta                = RWMB_Field::call( $field, 'meta', $post->ID, true );
			$form_field['value'] = $meta;

			$field['field_name'] = 'attachments[' . $post->ID . '][' . $field['field_name'] . ']';

			ob_start();
			$field['name'] = ''; // Don't show field label as it's already handled by WordPress.

			RWMB_Field::call( 'show', $field, true, $post->ID );
			$form_field['html'] = ob_get_clean();

			$form_fields[ $field['id'] ] = $form_field;
		}

		return $form_fields;
	}

	/**
	 * Save custom fields.
	 *
	 * @param array $post An array of post data.
	 * @param array $attachment An array of attachment metadata.
	 *
	 * @return array
	 */
	public function save_fields( $post, $attachment ) {
		foreach ( $this->fields as $field ) {
			$key = $field['id'];

			$old = RWMB_Field::call( $field, 'raw_meta', $post['ID'] );
			$new = isset( $attachment[ $key ] ) ? $attachment[ $key ] : '';

			$new = RWMB_Field::process_value( $new, $post['ID'], $field );

			// Call defined method to save meta value, if there's no methods, call common one.
			RWMB_Field::call( $field, 'save', $new, $old, $post['ID'] );
		}

		return $post;
	}

	public function is_in_normal_mode( bool $show, array $meta_box ) : bool {
		if ( ! $show ) {
			return $show;
		}

		// Show the meta box in the modal on Media screen.
		global $hook_suffix;
		if ( $hook_suffix === 'upload.php' ) {
			return $this->is_in_modal( $meta_box );
		}

		// Show the meta box only if not in the modal on the post edit screen.
		return ! $this->is_in_modal( $meta_box );
	}

	private function is_in_modal( array $meta_box ) : bool {
		return in_array( 'attachment', $meta_box['post_types'], true ) && ! empty( $meta_box['media_modal'] );
	}
}
