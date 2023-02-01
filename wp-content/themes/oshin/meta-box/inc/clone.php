<?php
/**
 * The clone module, allowing users to clone (duplicate) fields.
 *
 * @package Meta Box
 */

/**
 * The clone class.
 */
class RWMB_Clone {
	/**
	 * Get clone field HTML.
	 *
	 * @param mixed $meta  The meta value.
	 * @param array $field The field parameters.
	 *
	 * @return string
	 */
	public static function html( $meta, $field ) {
		$field_html = '';

		/**
		 * Note: $meta must contain value so that the foreach loop runs!
		 *
		 * @see meta()
		 */
		foreach ( $meta as $index => $sub_meta ) {
			$sub_field               = $field;
			$sub_field['field_name'] = $field['field_name'] . "[{$index}]";
			if ( $index > 0 ) {
				if ( isset( $sub_field['address_field'] ) ) {
					$sub_field['address_field'] = $field['address_field'] . "_{$index}";
				}
				$sub_field['id'] = $field['id'] . "_{$index}";

				if ( ! empty( $sub_field['attributes']['id'] ) ) {
					$sub_field['attributes']['id'] = $sub_field['attributes']['id'] . "_{$index}";
				}
			}

			if ( in_array( $sub_field['type'], array( 'file', 'image' ), true ) ) {
				$sub_field['input_name']  = '_file_' . uniqid();
				$sub_field['index_name'] .= "[{$index}]";
			} elseif ( $field['multiple'] ) {
				$sub_field['field_name'] .= '[]';
			}

			// Wrap field HTML in a div with class="rwmb-clone" if needed.
			$class     = "rwmb-clone rwmb-{$field['type']}-clone";
			$sort_icon = '';
			if ( $field['sort_clone'] ) {
				$class    .= ' rwmb-sort-clone';
				$sort_icon = "<a href='javascript:;' class='rwmb-clone-icon'></a>";
			}
			$input_html = "<div class='$class'>" . $sort_icon;

			// Call separated methods for displaying each type of field.
			$input_html .= RWMB_Field::call( $sub_field, 'html', $sub_meta );
			$input_html  = RWMB_Field::filter( 'html', $input_html, $sub_field, $sub_meta );

			// Remove clone button.
			$input_html .= self::remove_clone_button( $sub_field );
			$input_html .= '</div>';

			$field_html .= $input_html;
		}

		return $field_html;
	}

	/**
	 * Set value of meta before saving into database
	 *
	 * @param mixed $new       The submitted meta value.
	 * @param mixed $old       The existing meta value.
	 * @param int   $object_id The object ID.
	 * @param array $field     The field parameters.
	 *
	 * @return mixed
	 */
	public static function value( $new, $old, $object_id, $field ) {
		if ( ! is_array( $new ) ) {
			$new = array();
		}

		if ( in_array( $field['type'], array( 'file', 'image' ), true ) ) {
			$new = RWMB_File_Field::clone_value( $new, $old, $object_id, $field );
		} else {
			foreach ( $new as $key => $value ) {
				$old_value   = isset( $old[ $key ] ) ? $old[ $key ] : null;
				$value       = RWMB_Field::call( $field, 'value', $value, $old_value, $object_id );
				$new[ $key ] = RWMB_Field::filter( 'sanitize', $value, $field, $old_value, $object_id );
			}
		}

		// Remove empty clones.
		$new = array_filter( $new, 'RWMB_Helpers_Value::is_valid_for_field' );

		// Reset indexes.
		$new = array_values( $new );

		return $new;
	}

	/**
	 * Add clone button.
	 *
	 * @param array $field Field parameters.
	 * @return string $html
	 */
	public static function add_clone_button( $field ) {
		if ( ! $field['clone'] ) {
			return '';
		}
		$text = RWMB_Field::filter( 'add_clone_button_text', $field['add_button'], $field );
		return '<a href="#" class="rwmb-button button-primary add-clone">' . esc_html( $text ) . '</a>';
	}

	/**
	 * Remove clone button.
	 *
	 * @param array $field Field parameters.
	 * @return string $html
	 */
	public static function remove_clone_button( $field ) {
		$text = RWMB_Field::filter( 'remove_clone_button_text', '<span class="dashicons dashicons-dismiss"></span>', $field );
		return '<a href="#" class="rwmb-button remove-clone">' . $text . '</a>';
	}
}
