<?php

/*
 * Plugin Name:    		Advanced Custom Fields: Number Slider
 * Plugin URI:     		https://qstudio.us
 * Description:    		Number Slider field for Advanced Custom Fields
 * Version:        		0.6.0
 * Author:         		Q Studio
 * Author URI:     		https://qstudio.us
 * License:       	 	GPLv3 or later
 * License URI:    		http://www.gnu.org/licenses/gpl-2.0.html
 * GitHub Plugin URI: 	qstudio/advanced-custom-fields-number-slider
*/

/*
 * This plugin uses the Simpler Slider jQuery library by James Smith - http://loopj.com/jquery-simple-slider/
 * Version 5 compatibiltity added by chrisgoddard
 */

class acf_field_number_slider_plugin{
	
    /*
	*  Construct
	*
	*  @description:
	*  @since: 0.1
	*/
    public function __construct(){
        
        // set text domain
        $mo_file = trailingslashit( dirname(__FILE__)) . 'lang/' . 'acf-number_slider' . '-' . get_locale() . '.mo';
        load_textdomain( 'acf-number_slider', $mo_file );

        // version 4+
        add_action( 'acf/register_fields', array( $this, 'register_fields' ) );

        // version 3- REMOVED
        // add_action( 'init', array( $this, 'init' ));
		
		// add config ##
        add_action('acf/include_field_types', array($this, 'include_field_types_number_slider'));	
        
    }

    /*
    *  register_fields
    *
    *  @description:
    *  @since: 3.6
    *  @created: 1/04/13
    */
	public function register_fields(){

		include_once('number-slider-v4.php');
		
    }
    
    public function include_field_types_number_slider( $version ) {
	
        include_once('number-slider-v5.php');
		
    }

}

new acf_field_number_slider_plugin();
