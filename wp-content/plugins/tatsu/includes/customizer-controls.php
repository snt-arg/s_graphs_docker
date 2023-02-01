<?php

if ( class_exists( 'WP_Customize_Control' ) ) {

    class Tatsu_Dropdown_Custom_Control extends WP_Customize_Control {

		public $type = 'tatsu_dropdown';
        private $placeholder = 'Please select...';
        
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			if ( !empty( $this->input_attrs['placeholder'] ) ) {
				$this->placeholder = $this->input_attrs['placeholder'];
			}
		}

		public function enqueue() {
			wp_enqueue_script( 'tatsu-admin-semantic', TATSU_PLUGIN_URL . '/admin/js/semantic-dropdown.js', array( 'jquery' ), TATSU_VERSION, true );
			wp_enqueue_script( 'tatsu-admin-customizer-controls', TATSU_PLUGIN_URL . '/admin/js/customizer.js', array( 'tatsu-admin-semantic' ), TATSU_VERSION, true );
			wp_enqueue_style( 'tatsu-admin-semantic', TATSU_PLUGIN_URL . '/admin/css/semantic-dropdown.css', array(), TATSU_VERSION, 'all' );
		}

		public function render_content() {
            $default_value = explode( ',', $this->value() );
		?>
			<div class="tatsu-semantic-dropdown">
				<?php if( !empty( $this->label ) ) : ?>
					<label for="<?php echo esc_attr( $this->id ); ?>" class="customize-control-title">
						<?php echo esc_html( $this->label ); ?>
					</label>
                <?php endif; ?>
				<?php if( !empty( $this->description ) ) : ?>
					<span class="customize-control-description">
                        <?php echo esc_html( $this->description ); ?>
                    </span>
                <?php endif; ?>
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" class="customize-control-dropdown-semantic" value="<?php echo esc_attr( $this->value() ); ?>" name="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); ?> />
				<select data-placeholder = "<?php echo $this->placeholder; ?>" name="semantic-list-multi" class="customize-control-semantic" multiple = "multiple" >
					<?php foreach ( $this->choices as $key => $value ) : ?>
                        <option value = "<?php echo esc_attr( $key ); ?>" <?php echo in_array( $key, $default_value ) ? 'selected = "selected"' : ''; ?> ><?php echo esc_attr( $value ); ?></option>
                    <?php endforeach; ?>
				</select>
			</div>
		<?php
		}        
    }
}