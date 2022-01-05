<?php

// version 5

class acf_field_number_slider extends acf_field {
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	function __construct() {
		
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		$this->name = 'number_slider';
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		$this->label = __('Number Slider', 'acf-number_slider');
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		$this->category = 'jquery';
		
		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		$this->defaults = array(
			'slider_min_value'	=> 0,
			'slider_max_value' => 100,
			'increment_value' => 1,
			'slider_units' => "%",
			'slider_append' => "",
			'default_value' => 0,
		);
		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('number_slider', 'error');
		*/
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'acf-number_slider'),
		);
		
		$this->version = '2.9';
				
		// do not delete!
    	parent::__construct();
    	
	}
	
	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	function render_field_settings( $field ) {
		
		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/
		acf_render_field_setting( $field, array(
			'label'			=> __('Units','acf-number_slider'),
			'instructions'	=> __('Enter the units to measure by','acf-number_slider'),
			'type'			=> 'text',
			'name'			=> 'slider_units',
		));
		
		acf_render_field_setting( $field, array(
			'label'			=> __('Default Value','acf-number_slider'),
			'instructions'	=> __('Enter the default value','acf-number_slider'),
			'type'			=> 'number',
			'name'			=> 'default_value',
		));
		
		acf_render_field_setting( $field, array(
			'label'			=> __('Minimum Value','acf-number_slider'),
			'instructions'	=> __('Enter the minimum value to allow','acf-number_slider'),
			'type'			=> 'number',
			'name'			=> 'slider_min_value',
		));
		
		acf_render_field_setting( $field, array(
			'label'			=> __('Maximum Value','acf-number_slider'),
			'instructions'	=> __('Enter the maximum value to allow','acf-number_slider'),
			'type'			=> 'number',
			'name'			=> 'slider_max_value',
		));
		
		acf_render_field_setting( $field, array(
			'label'			=> __('Increment Value','acf-number_slider'),
			'instructions'	=> __('Enter the value to increment by','acf-number_slider'),
			'type'			=> 'number',
			'name'			=> 'increment_value',
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Append','acf-number_slider'),
			'instructions'	=> __('Appears after the input','acf-number_slider'),
			'type'			=> 'text',
			'name'			=> 'slider_append',
		));
		

	}
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	function render_field( $field ) {
            
		$default = ( 
			intval($field['default_value'] ) < intval($field['slider_min_value'] ) ) ? 
			intval($field['slider_min_value']) : 
			intval($field['default_value']
		);

		$value = ( 
			isset($field['value']) ) && intval($field['value']) >= intval($field['slider_min_value'] )? 
			intval( $field['value'] ) : 
			$default;

		?>
		<input type="text" value="<?php esc_html_e( $value ); ?>" name="<?php esc_html_e( $field['name'] ); ?> " class="simple_slider" title="<?php esc_html_e( $field['label'] ); ?>" data-slider="true" data-slider-highlight="true" data-slider-range="<?php esc_html_e( $field['slider_min_value'] ); ?>,<?php echo $field['slider_max_value']; ?>" data-slider-step="<?php esc_html_e( $field['increment_value'] ); ?>" data-slider-snap="true" data-units="<?php esc_html_e( $field['slider_units'] ); ?>"/>
		
		<div class="description slide" style="padding: 6px 0 0;">
			<?php esc_html_e( $value ); ?> <?php esc_html_e( $field['slider_units'] ); ?>
		</div>
		<?php
        
	}
		
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/
	function input_admin_enqueue_scripts() {
		
		// get plugin directory ##
		$dir = plugin_dir_url( __FILE__ );
		
	  	// add ACF JS ##
	  	wp_enqueue_script( 'ss-input', $dir . 'js/input.js', array( 'jquery' ), $this->version, false );
	  	
		// add simple slider ##
        wp_enqueue_script( 'jquery-simple-slider', $dir . 'js/simple-slider.js', array( 'jquery' ), $this->version, false );

        // add CSS ##
        wp_enqueue_style( 'simple-slider', $dir . 'css/simple-slider.css', '', $this->version );
		
	}

	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	function load_value( $value, $post_id, $field ) {
		
		return (int)$value;
		
	}
	
	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	function update_value( $value, $post_id, $field ) {

		#logger($field['name']);
		#logger($value);

		return (int)$value;

	}
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
	function format_value( $value, $post_id, $field ) {

		// check if we need to append a value ##
		$append = isset( $field['slider_append'] ) ? '&nbsp;'.$field['slider_append'] : '&nbsp;';

		// kick back value, with append – if set ##
		return (int) $value.'&nbsp;'.$append;

	}
	
	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0	
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	function load_field( $field ) {

		return $field;
		
	}	
	
}

// create field
new acf_field_number_slider();
