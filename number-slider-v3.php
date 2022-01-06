<?php

class acf_field_number_slider extends acf_Field 
{

    // vars
    var 
        $settings // will hold info such as dir / path
        , $defaults // will hold default field options
        , $domain // holds the language domain
        , $units; // unit description  

    /*--------------------------------------------------------------------------------------
    *
    *	Constructor
    *	- This function is called when the field class is initalized on each page.
    *	- Here you can add filters / actions and setup any other functionality for your field
    *
    *	@author Elliot Condon
    *	@since 2.2.0
    *
    *-------------------------------------------------------------------------------------*/

    function __construct( $parent ) 
    {
        
        // do not delete!
        parent::__construct( $parent );

        // set name / title
        $this->name = 'number_slider';
        $this->title = __('Number Slider');
        $this->domain = 'advanced-custom-fields-number-slider';
        $this->defaults = array (
            'label'                 => __( 'Choose a Number', $this->domain )
           , 'units'                => 'Minutes'
           , 'min_value'            => '0'
           , 'max_value'            => '500'
           , 'increment_value'      => '10'
        );

        $this->settings = array(
            'path'      => $this->helpers_get_path( __FILE__ )
            , 'dir'     => $this->helpers_get_dir( __FILE__ )
            , 'version' => '2.0.9'
        );
        
    }


    /*
    *  helpers_get_path
    *
    *  @description: calculates the path (works for plugin / theme folders)
    *  @since: 3.6
    *  @created: 30/01/13
    */
    function helpers_get_path( $file ) 
    {
        return trailingslashit(dirname($file));
    }


    /*
    *  helpers_get_dir
    *
    *  @description: calculates the directory (works for plugin / theme folders)
    *  @since: 3.6
    *  @created: 30/01/13
    */
    function helpers_get_dir( $file ) 
    {
        
        $dir = trailingslashit(dirname($file));
        $count = 0;

        // sanitize for Win32 installs
        $dir = str_replace('\\' ,'/', $dir);

        // if file is in plugins folder
        $wp_plugin_dir = str_replace('\\' ,'/', WP_PLUGIN_DIR);
        $dir = str_replace($wp_plugin_dir, WP_PLUGIN_URL, $dir, $count);

        if( $count < 1 )
        {
            // if file is in wp-content folder
            $wp_content_dir = str_replace('\\' ,'/', WP_CONTENT_DIR);
            $dir = str_replace($wp_content_dir, WP_CONTENT_URL, $dir, $count);
        }


        if( $count < 1 )
        {
            // if file is in ??? folder
            $wp_dir = str_replace('\\' ,'/', ABSPATH);
            $dir = str_replace($wp_dir, site_url('/'), $dir);
        }

        return $dir;
        
    }


    /*--------------------------------------------------------------------------------------
	*
	*	create_options
	*	- this function is called from core/field_meta_box.php to create extra options
	*	for your field
	*
	*	@params
	*	- $key (int) - the $_POST obejct key required to save the options to the field
	*	- $field (array) - the field object
	*
	*	@author Elliot Condon
	*	@since 2.2.0
	*
	*-------------------------------------------------------------------------------------*/
    function create_options( $key, $field ) 
    {

        $field = array_merge( $this->defaults, $field );
        
?>
        <tr class="field_option field_option_<?php echo $this->name; ?> timepicker_choice">
            <td class="label">
                <label><?php _e( "Units", $this->domain ); ?></label>
                <p class="description"><?php printf( __("Enter the units to measure by", $this->domain ) );?></p>
            </td>
            <td>
<?php

            $this->parent->create_field ( 
                array(
                    'type'    => 'text'
                    , 'name'  => 'fields[' . $key . '][units]'
                    , 'value' => $field['units']
                ) 
            );
                
?>
            </td>
        </tr>
        <tr class="field_option field_option_<?php echo $this->name; ?> timepicker_dateformat">
            <td class="label">
                <label><?php _e( "Minimum Value", $this->domain ); ?></label>
                <p class="description"><?php printf( __("Enter the minimum value to allow", $this->domain ) );?></p>
            </td>
            <td>
<?php

                $this->parent->create_field( 
                    array(
                        'type'    => 'text'
                        , 'name'  => 'fields[' . $key . '][min_value]'
                        , 'value' => $field['min_value']
                    ) 
                );

?>
            </td>
        </tr>
        <tr class="field_option field_option_<?php echo $this->name; ?> timepicker_timeformat">
            <td class="label">
                <label><?php _e( "Maximum Value", $this->domain ); ?></label>
                <p class="description"><?php printf( __("Enter the maximum value to allow", $this->domain ) );?></p>
            </td>
            <td>
<?php

                $this->parent->create_field( 
                    array(
                        'type'    => 'text'
                        , 'name'  => 'fields[' . $key . '][max_value]'
                        , 'value' => $field['max_value']
                    ) 
                );

?>
           </td>
        </tr>
        <tr class="field_option field_option_<?php echo $this->name; ?> timepicker_week_number">
            <td class="label">
                <label><?php _e( "Increment Value", $this->domain ); ?></label>
                <p class="description"><?php printf( __("Enter the value to increment by", $this->domain ) );?></p>
            </td>
            <td>
<?php

                $this->parent->create_field(
                    array(
                        'type'    => 'text'
                        , 'name'  => 'fields[' . $key . '][increment_value]'
                        , 'value' => $field['increment_value']
                    ) 
                );

?>
            </td>
        </tr>
<?php

    }


    /*--------------------------------------------------------------------------------------
    *
    *	create_field
    *	- this function is called on edit screens to produce the html for this field
    *
    *	@author Elliot Condon
    *	@since 2.2.0
    *
    *-------------------------------------------------------------------------------------*/
    function create_field( $field ) 
    {

        $field = array_merge( $this->defaults, $field );

        // create a random ID ## 
        $this->id = mt_rand( 1, 50 );

        // echo the field html ##
        echo '<input type="text" value="' . $field['value'] . '" name="' . $field['name'] . '" class="simple_slider" title="' . $field['label'] . '" data-slider="true" data-slider-id="'.$this->id.'" data-slider-highlight="true" data-slider-range="'.$field['min_value'].','.$field['max_value'].'" data-slider-step="'.$field['increment_value'].'" data-slider-snap="true" />';

        // for later use ##
        $this->units = $field['units'];

?>
<script>
jQuery(document).ready( function($) {

    $('*[data-slider-id="<?php echo $this->id; ?>"]').each(function() {
        
        // get slider ID ##
        $slider_id = $(this).data("slider-id");
        //console.log('slider id: '+$slider_id);
        
        // declare variables ##
        var $el, allowedValues, settings, x, input = $(this);
        
        // add the output <p> to each slider ##
        $("<p>")
            .addClass("description").addClass("slide")
            .html( $(this).val()+' <?php echo $this->units; ?>' ) // grab value ##
            .insertAfter( $(this) );
        
        $el = $(this);
        settings = {};
       
        // grab the slider settings ##
        if ($el.data("slider-range")) {
          settings.range = $el.data("slider-range").split(",");
        }
        if ($el.data("slider-step")) {
          settings.step = $el.data("slider-step");
        }
        settings.snap = $el.data("slider-snap");
        settings.equalSteps = $el.data("slider-equal-steps");
        if ($el.attr("data-slider-highlight")) {
          settings.highlight = $el.data("slider-highlight");
        }
        
        // call the simpleSlider function - passing our settings ##
        return $el.simpleSlider(settings);
    
    // event binding to update displayed value ##
    }).on("slider:ready slider:changed", function ( event, data ) {

        $(this)
            .nextAll(".description.slide:first")
            .html( data.value.toFixed(0)+' <?php echo $this->units; ?>' );

    });

});
</script>   
<?php

    }


    /*--------------------------------------------------------------------------------------
    *
    *	update_value
    *	- this function is called when saving a post object that your field is assigned to.
    *	the function will pass through the 3 parameters for you to use.
    *
    *	@params
    *	- $post_id (int) - usefull if you need to save extra data or manipulate the current
    *	post object
    *	- $field (array) - usefull if you need to manipulate the $value based on a field option
    *	- $value (mixed) - the new value of your field.
    *
    *	@author Elliot Condon
    *	@since 2.2.0
    *
    *-------------------------------------------------------------------------------------*/
    function update_value($post_id, $field, $value) 
    {
        parent::update_value($post_id, $field, $value);
    }


    /*--------------------------------------------------------------------------------------
    *
    *	get_value
    *	- called from the edit page to get the value of your field. This function is useful
    *	if your field needs to collect extra data for your create_field() function.
    *
    *	@params
    *	- $post_id (int) - the post ID which your value is attached to
    *	- $field (array) - the field object.
    *
    *	@author Elliot Condon
    *	@since 2.2.0
    *
    *-------------------------------------------------------------------------------------*/
    function get_value($post_id, $field)
    {
        
        $field = array_merge($this->defaults, $field);
        $value = parent::get_value($post_id, $field);
        
        return (int)$value;
        
    }

    
    function get_value_for_api( $post_id, $field )
    {   
        
        $field = array_merge( $this->defaults, $field );
        $value = parent::get_value( $post_id, $field );
        
        return (int)$value;
        
    }
    
    
    
    /*
    *  input_admin_enqueue_scripts()
    *
    *  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
    *  Use this action to add css + javascript to assist your create_field() action.
    *
    *  $info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
    *  @type	action
    *  @since	3.6
    *  @date	23/01/13
     * @link        http://loopj.com/jquery-simple-slider/
    */
    function admin_print_styles()
    {

        // add JS ##
        wp_enqueue_script( 'jquery-simple-slider', $this->settings['dir'] . 'js/simple-slider.js', array( 'jquery' ), $this->settings['version'], false );

        // add CSS ##
        wp_enqueue_style( 'simple-slider', $this->settings['dir'] . 'css/simple-slider.css', '', $this->settings['version'] );

    }
    
    
}