<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'RWMB_Sidebar_Select_Field' ) && class_exists('RWMB_Field') )
{
	class RWMB_Sidebar_Select_Field extends RWMB_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'rwmb-select', RWMB_CSS_URL . 'select.css', array(), RWMB_VER );
		}

		/**
		 * Get field HTML
		 *
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $meta, $field )
		{
			$html = sprintf(
				'<select class="rwmb-select" name="%s" id="%s" size="%s"%s>',
				$field['field_name'],
				$field['id'],
				$field['size'],
				$field['multiple'] ? ' multiple="multiple"' : ''
			);

			global $wp_registered_sidebars; 
			foreach ( $wp_registered_sidebars as $key => $value )
			{
				if( $key )
				{
					$selected	 = selected( in_array( $key, $meta ), true, false );
					$html		.= "<option value='{$key}'{$selected}>{$value['name']}</option>";
				}
			}

			$html .= '</select>';

			return $html;
		}

		/**
		 * Get meta value
		 * If field is cloneable, value is saved as a single entry in DB
		 * Otherwise value is saved as multiple entries (for backward compatibility)
		 *
		 * @see "save" method for better understanding
		 *
		 * TODO: A good way to ALWAYS save values in single entry in DB, while maintaining backward compatibility
		 *
		 * @param $post_id
		 * @param $saved
		 * @param $field
		 *
		 * @return array
		 */
		static function meta( $post_id, $saved, $field )
		{
			$single = $field['clone'] || !$field['multiple'];
			$meta = get_post_meta( $post_id, $field['id'], $single );
			$meta = ( !$saved && '' === $meta || array() === $meta ) ? $field['std'] : $meta;

			$meta = array_map( 'esc_attr', (array) $meta );

			return $meta;
		}

		/**
		 * Save meta value
		 * If field is cloneable, value is saved as a single entry in DB
		 * Otherwise value is saved as multiple entries (for backward compatibility)
		 *
		 * TODO: A good way to ALWAYS save values in single entry in DB, while maintaining backward compatibility
		 *
		 * @param $new
		 * @param $old
		 * @param $post_id
		 * @param $field
		 */
		static function save( $new, $old, $post_id, $field )
		{
			if ( !$field['clone'] )
			{
				parent::save( $new, $old, $post_id, $field );
				return;
			}

			if ( empty( $new ) )
				delete_post_meta( $post_id, $field['id'] );
			else
				update_post_meta( $post_id, $field['id'], $new );
		}

		/**
		 * Normalize parameters for field
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function normalize_field( $field )
		{
			$field = wp_parse_args( $field, array(
				'desc'        => '',
				'name'        => $field['id'],
				'size'        => $field['multiple'] ? 5 : 0,
				'placeholder' => '',
			) );
			if ( !$field['clone'] && $field['multiple'] )
				$field['field_name'] .= '[]';
			return $field;
		}

		/**
		 * Creates html for options
		 *
		 * @param array $field
		 * @param mixed $meta
		 *
		 * @return array
		 */
		static function options_html( $field, $meta )
		{
			$html = '';
			if ( $field['placeholder'] )
				$html = 'select' == $field['type'] ? "<option value=''>{$field['placeholder']}</option>" : '<option></option>';

			$option = '<option value="%s"%s>%s</option>';

			foreach ( $field['options'] as $value => $label )
			{
				$html .= sprintf(
					$option,
					$value,
					selected( in_array( $value, (array)$meta ), true, false ),
					$label
				);
			}

			return $html;
		}
	}
}