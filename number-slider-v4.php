<?php

class acf_field_number_slider extends acf_field
{
	// vars
	var 
		$settings       // will hold info such as dir / path
		, $defaults     // will hold default field options
		, $domain       // holds the language domain
		, $lang         // language
		, $units;       // unit description
        
	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	function __construct()
	{
                
		// vars
		$this->name = 'number_slider';
		$this->label = __('Number Slider');
		$this->category = __( "jQuery", $this->domain ); // Basic, Content, Choice, etc
		$this->domain = 'advanced-custom-fields-number-slider';
		$this->defaults = array (
			'label'                 => __( 'Choose a Number', $this->domain )
			, 'units'                => 'Minutes'
			, 'min_value'            => '0'
			, 'max_value'            => '500'
			, 'increment_value'      => '10'
		);

		// do not delete!
		parent::__construct();

		// settings
		$this->settings = array(
			'path'      => apply_filters('acf/helpers/get_path', __FILE__)
			, 'dir'     => apply_filters('acf/helpers/get_dir', __FILE__)
			, 'version' => '2.0.9'
		);
            
	}


	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	function create_options( $field )
	{
		$field = array_merge( $this->defaults, $field );
		$key = $field['name'];
?>
		<tr class="field_option field_option_<?php esc_attr_e( $this->name ); ?> slider_units">
			<td class="label">
				<label><?php _e( "Units", $this->domain ); ?></label>
				<p class="description"><?php printf( __("Enter the units to measure by", $this->domain ) );?></p>
			</td>
			<td>
<?php
				do_action('acf/create_field', array(
					'type'    => 'text'
					, 'name'  => 'fields[' . $key . '][units]'
					, 'value' => $field['units']
				) );

?>
			</td>
		</tr>
		<tr class="field_option field_option_<?php esc_attr_e( $this->name ); ?> slider_min_value">
			<td class="label">
				<label><?php _e( "Minimum Value", $this->domain ); ?></label>
				<p class="description"><?php printf( __("Enter the minimum value to allow", $this->domain ) );?></p>
			</td>
			<td>
<?php
				do_action('acf/create_field', array(
					'type'    => 'text'
					, 'name'  => 'fields[' . $key . '][min_value]'
					, 'value' => $field['min_value']
				) );

?>
			</td>
		</tr>
		<tr class="field_option field_option_<?php esc_attr_e( $this->name ); ?> slider_max_value">
			<td class="label">
				<label><?php _e( "Maximum Value", $this->domain ); ?></label>
				<p class="description"><?php printf( __("Enter the maximum value to allow", $this->domain ) );?></p>
			</td>
			<td>
<?php
				do_action('acf/create_field', array(
					'type'    => 'text'
					, 'name'  => 'fields[' . $key . '][max_value]'
					, 'value' => $field['max_value']
				) );

?>
			</td>
		</tr>
		<tr class="field_option field_option_<?php esc_attr_e( $this->name ); ?> slider_increment_value">
			<td class="label">
				<label><?php _e( "Increment Value", $this->domain ); ?></label>
				<p class="description"><?php printf( __("Enter the value to increment by", $this->domain ) );?></p>
			</td>
			<td>
<?php
				do_action('acf/create_field', array(
					'type'    => 'text'
					, 'name'  => 'fields[' . $key . '][increment_value]'
					, 'value' => $field['increment_value']
				) );

?>
			</td>
		</tr>
<?php
	}

	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	function create_field( $field ) 
	{
		
		// create a random ID ## 
		$this->id = mt_rand( 1, 50 );
		
		// echo the field html ##
		echo esc_html( '<input type="text" value="' . $field['value'] . '" name="' . $field['name'] . '" class="simple_slider" title="' . $field['label'] . '" data-slider="true" data-slider-id="'.$this->id.'" data-slider-highlight="true" data-slider-range="'.$field['min_value'].','.$field['max_value'].'" data-slider-step="'.$field['increment_value'].'" data-slider-snap="true" />' );
	
		// for later use ##
		$this->units = $field['units'];
        
?>
<script>
jQuery(document).ready( function($) {
    
    $('*[data-slider-id="<?php echo $this->id; ?>"]').each(function() {
        
        // get slider ID ##
        $slider_id = $(this).data("slider-id");
        
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
        
        
	//function load_field_defaults( $field ) { return $field; }
	function format_value( $value, $post_id, $field )
	{
		return (int)$value;
	}

	function format_value_for_api($value, $post_id, $field) 
	{
		return (int)$value;
	}

	/*
	*  update_value()
	*
	*  This filter is appied to the $value before it is updated in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value - the value which will be saved in the database
	*  @param	$post_id - the $post_id of which the value will be saved
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$value - the modified value
	*/
	function update_value( $value, $post_id, $field ) 
	{
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
	function input_admin_enqueue_scripts() 
	{
		
		// add JS ##
		wp_enqueue_script( 'jquery-simple-slider', $this->settings['dir'] . 'js/simple-slider.js', array( 'jquery' ), $this->settings['version'], false );

		// add CSS ##
		wp_enqueue_style( 'simple-slider', $this->settings['dir'] . 'css/simple-slider.css', '', $this->settings['version'] );
			
	}

}

// create field
new acf_field_number_slider();
