<?php

/*
Plugin Name:    Advanced Custom Fields: Number Slider
Plugin URI:     http://www.qstudio.us/plugins/
Description:    Number Slider field for Advanced Custom Fields
Version:        0.4.2
Author:         Q Studio
Author URI:     http://www.qstudio.us
License:        GPLv2 or later
License URI:    http://www.gnu.org/licenses/gpl-2.0.html
*/

/*
 * This plugin uses the Simpler Slider jQuery library by James Smith - http://loopj.com/jquery-simple-slider/
 * Version 5 compatibiltity added by chrisgoddard
 */

class acf_field_number_slider_plugin
{
	
    /*
	*  Construct
	*
	*  @description:
	*  @since: 0.1
	*/
    function __construct()
    {
        
        // set text domain
        $domain = 'acf-number_slider';
        $mofile = trailingslashit( dirname(__FILE__)) . 'lang/' . $domain . '-' . get_locale() . '.mo';
        load_textdomain( $domain, $mofile );

        // version 4+
        add_action( 'acf/register_fields', array( $this, 'register_fields' ) );

        // version 3-
        add_action( 'init', array( $this, 'init' ));
        
        add_action('acf/include_field_types', array($this, 'include_field_types_number_slider'));	
        
    }


    /*
    *  Init
    *
    *  @description:
    *  @since: 3.6
    *  @created: 1/04/13
    */
    function init()
    {
        if ( function_exists('register_field') ) {
            
            register_field( 'acf_field_number_slider', dirname(__FILE__) . '/number-slider-v3.php' );

        }

    }

    /*
    *  register_fields
    *
    *  @description:
    *  @since: 3.6
    *  @created: 1/04/13
    */
    function register_fields()
    {
        include_once('number-slider-v4.php');
    }
    
    function include_field_types_number_slider( $version ) {
	
        include_once('number-slider-v5.php');
		
    }


}

new acf_field_number_slider_plugin();
