(function ($) {
	function initialize_field($el) {
		var allowedValues, settings, x;
		var slider = $el.find('.simple_slider');
		var units = slider.data('units');
		settings = {};
		allowedValues = slider.data("slider-values");
		if (allowedValues) {
			settings.allowedValues = (function () {
				var _i, _len, _ref, _results;
				_ref = allowedValues.split(",");
				_results = [];
				for (_i = 0, _len = _ref.length; _i < _len; _i++) {
					x = _ref[_i];
					_results.push(parseFloat(x));
				}
				return _results;
			})();
		}
		if (slider.data("slider-range")) {
			settings.range = slider.data("slider-range").split(",");
		}
		if (slider.data("slider-step")) {
			settings.step = slider.data("slider-step");
		}
		settings.snap = slider.data("slider-snap");
		settings.equalSteps = slider.data("slider-equal-steps");
		if (slider.data("slider-theme")) {
			settings.theme = slider.data("slider-theme");
		}
		if (slider.attr("data-slider-highlight")) {
			settings.highlight = slider.data("slider-highlight");
		}
		if (slider.data("slider-animate") != null) {
			settings.animate = slider.data("slider-animate");
		}
		slider.simpleSlider(settings);
		slider.on({
			'slider:ready': function () {},
			'slider:changed': function (event, data) {
				slider.next(".description.slide").text(data.value.toFixed(0) + ' ' + units);
			}
		});
	}
	if (typeof acf.add_action !== 'undefined') {
		/*
		 *  ready append (ACF5)
		 *
		 *  These are 2 events which are fired during the page load
		 *  ready = on page load similar to $(document).ready()
		 *  append = on new DOM elements appended via repeater field
		 *
		 *  @type	event
		 *  @date	20/07/13
		 *
		 *  @param	$el (jQuery selection) the jQuery element which contains the ACF fields
		 *  @return	n/a
		 */
		acf.add_action('ready append', function ($el) {
			// search $el for fields of type 'FIELD_NAME'
			acf.get_fields({
				type: 'number_slider'
			}, $el).each(function () {
				initialize_field($(this));
			});
		});
		// set value on tab load ##
		acf.add_action('show_field', function( $field, context ){
    
			let $slider = $field.find('.simple_slider');

			$slider.simpleSlider( "setValue", $slider.val() );

		});
	} else {
		/*
		 *  acf/setup_fields (ACF4)
		 *
		 *  This event is triggered when ACF adds any new elements to the DOM.
		 *
		 *  @type	function
		 *  @since	1.0.0
		 *  @date	01/01/12
		 *
		 *  @param	event		e: an event object. This can be ignored
		 *  @param	Element		postbox: An element which contains the new HTML
		 *
		 *  @return	n/a
		 */
		$(document).live('acf/setup_fields', function (e, postbox) {
			$(postbox).find('.field[data-field_type="number_slider"]').each(function () {
				initialize_field($(this));
			});
		});
	}
})(jQuery);
