<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */
 
if(!defined('ABSPATH')) exit();

class RevSliderWidget extends WP_Widget {
	
    public function __construct(){
        //actual widget process
        parent::__construct('rev-slider-widget', __('Slider Revolution', 'revslider'), array('classname' => 'widget_revslider', 'description' => __('Displays a Slider Revolution Module on the page', 'revslider')));
    }
	
	public static function register_widget(){
		register_widget('RevSliderWidget');
	}
 
    /**
     * the form
     */
    public function form($instance){
		$sliders = array();
		$_slider = new RevSliderSlider();
		
		try {
            $sliders = $_slider->get_sliders_short();
        }catch(Exception $e){}            
          
		if(empty($sliders)){
			echo __('No Sliders found, Please create a Slider first', 'revslider');
		}else{
	    	$sliderID	= $_slider->get_val($instance, 'rev_slider');
	    	$homepage	= $_slider->get_val($instance, 'rev_slider_homepage');
	    	$pagesValue	= $_slider->get_val($instance, 'rev_slider_pages');
	    	$title		= $_slider->get_val($instance, 'rev_slider_title');
			$checked	= ($homepage == 'on') ? "checked='checked'" : '';
	    	
			$fieldID_check	 = $this->get_field_id('rev_slider_homepage');
			$fieldName_check = $this->get_field_name('rev_slider_homepage');

			$fieldPages_ID	 = $this->get_field_id('rev_slider_pages');
			$fieldPages_Name = $this->get_field_name('rev_slider_pages');
			
			$fieldTitle_ID	 = $this->get_field_id('rev_slider_title');
			$fieldTitle_Name = $this->get_field_name('rev_slider_title');
			?>
			<p>
				<span style="display: inline-block; width: 130px"><label for="<?php echo $fieldTitle_ID; ?>"><?php _e('Title', 'revslider')?>:</label></span>
				<input type="text" style="display: inline-block; width: auto;" name="<?php echo $fieldTitle_Name; ?>" id="<?php echo $fieldTitle_ID; ?>" value="<?php echo $title; ?>" class="widefat">
			</p>
			<p>
				<span style="display: inline-block; width: 130px"><?php _e('Choose Slider', 'revslider'); ?>:</span>
				<select name="<?php echo $this->get_field_name('rev_slider'); ?>" id="<?php echo $this->get_field_id('rev_slider'); ?>">
					<?php
					foreach($sliders as $key => $item){
						$selected = (trim($key) == trim($sliderID)) ? ' selected ' : '';
						echo '<option '.$selected.' value="'.$key.'">'.$item.'</option>';
					}
					?>
				</select>
			</p>
			<p>
				<span style="display: inline-block; width: 130px"><label for="<?php echo $fieldID_check; ?>"><?php _e('Home Page Only', 'revslider'); ?>:</label></span>
				<input type="checkbox" name="<?php echo $fieldName_check; ?>" id="<?php echo $fieldID_check; ?>" <?php echo $checked; ?>>
			</p>
			<p>
				<span style="display: inline-block; width: 130px"><label for="<?php echo $fieldPages_ID; ?>"><?php _e('Pages (example: 2,10):', 'revslider'); ?></label></span>
				<input type="text" name="<?php echo $fieldPages_Name; ?>" id="<?php echo $fieldPages_ID; ?>" value="<?php echo $pagesValue; ?>">
			</p>
			<?php
		}	//else
    }
 
 
    /**
     * update
     */
    public function update($new_instance, $old_instance){
        return $new_instance;
    }

    
    /**
     * widget output
     */
    public function widget($args, $instance){
		try {
			$_slider = new RevSliderSlider();
			
			$sid = $_slider->get_val($instance, 'rev_slider');
			
			if(empty($sid)) return(false);
			
			$output = new RevSliderOutput();
			
			$title		= $_slider->get_val($instance, 'rev_slider_title');
			$homepage	= ($_slider->get_val($instance, 'rev_slider_homepage') == 'on') ? 'homepage' : '';
			$pages		= $_slider->get_val($instance, 'rev_slider_pages');
			
			if(!empty($pages)){
				$homepage .= (!empty($homepage)) ? ',' : '';
				$homepage .= $pages;
			}
			
			$_slider->init_by_id($sid);
			if($_slider->get_param(array('general', 'disableOnMobile'), false) == true && wp_is_mobile()) return false;
			
			//widget output
			echo $_slider->get_val($args, 'before_widget');
			
			if(!empty($title)){
				echo $_slider->get_val($args, 'before_title');
				echo $title;
				echo $_slider->get_val($args, 'after_title');
			}
			
			$output->set_add_to($homepage);
			$slider = $output->add_slider_to_stage($sid);
			
			add_action('wp_head', array($this, 'write_css'));
			
			echo $_slider->get_val($args, 'after_widget');
		}catch(Exception $e){
			$message = $e->getMessage();
			
			$output->print_error_message($message);
		}
    }

    public function write_css(){
		
	}

}

/**
 * old classname extends new one (old classnames will be obsolete soon)
 * @since: 5.0
 **/
class RevSlider_Widget extends RevSliderWidget {}