<?php
/**
 *
 * @package   MasterSlider
 * @author    averta [averta.net]
 * @license   LICENSE.txt
 * @link      http://masterslider.com
 * @copyright Copyright © 2014 averta
 */

/*----------------------------------------------
 *  Master Core Widget Class
 * --------------------------------------------*/

if ( ! class_exists( 'MSP_Widget' ) ) :


class MSP_Widget extends WP_Widget {

    private $defaults = array();
    public  $fields   = array();


    /*--------------------------------------------------*/
    /* Constructor
    /*--------------------------------------------------*/

    /**
     * Specifies the classname and description, instantiates the widget,
     */
    function __construct( $id_base, $name, $widget_options = array(), $control_options = array() ) {

        parent::__construct( $id_base, $name, $widget_options, $control_options );

        $this->set_defaults();
    }

    /**
     * Sets fields data
     */
    function set_fields($fields){
        $this->fields = $fields;
    }

    /**
     * Generates default ids and values
     */
    protected function set_defaults(){
        // store fields id and values in $default var
        foreach ($this->fields as $field) {
            $this->defaults[$field["id"]] = $field["value"];
        }
    }


    /*--------------------------------------------------*/
    /* Widget API Functions
    /*--------------------------------------------------*/

    /**
     * Outputs the content of the widget.
     *
     * @param array args  The array of form elements
     * @param array instance The current instance of the widget
     */
    function widget( $args, $instance ) {

    }


    /**
     * Processes the widget's options to be saved.
     *
     * @param array new_instance The new instance of values to be generated via the update.
     * @param array old_instance The previous instance of values before the update.
     */
    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        foreach ($this->fields as $field) {
            $id = $field["id"];
            $instance[$id] = strip_tags($new_instance[$id]);
        }

        return $instance;
    }



    /**
     * Generates the administration form for the widget.
     *
     * @param array instance The array of keys and values for the widget.
     */
    function form( $instance ) {

        $instance = wp_parse_args( (array) $instance, $this->defaults );

        // get_field_id (string $field_name)
        // creates id attributes for fields to be saved by update()
        foreach ($this->fields as $field) {

            $id   = $field['id'];

            switch ($field['type']) {

                case 'textbox':

                    echo '<p>',
                        '<label for="'.esc_attr( $this->get_field_id($id) ).'" >'.esc_html( $field["name"] ).'</label>',
                        '<input class="widefat" id="'.esc_attr( $this->get_field_id($id) ).'" name="'.esc_attr( $this->get_field_name($id) ).'" type="text" value="'.esc_attr( $instance[$id] ).'" />',
                    '</p>';

                    break;

                case 'select':
                    echo '<p>',
                        '<label for="'.esc_attr( $this->get_field_id($id) ).'" >'.esc_html( $field['name'] ). '</label>',
                        '<select name="'.esc_attr( $this->get_field_name($id) ).'" id="'.esc_attr( $this->get_field_id($id) ).'" value="'.esc_attr( $instance[$id] ).'" style="width:100%;max-width:100%;" >';
                foreach ($field['options'] as $key => $value) {
                    echo    '<option value="'.esc_attr( $key ).'" '.(($instance[$id] == $key)?'selected="selected"':'' ).' >'. esc_html( $value ). '</option>';
                }

                    echo '</select>',
                    '</p>';
                    break;


                default:

                    break;
            }

        }

    }


} // end widget class

endif;
