/**
 * Widget initialization and management script
 * If you rename the widget, replace MasonryGrid instance to the new name
 *
 */

var IpWidget_MasonryGrid;

(function ($) {
    "use strict";

	IpWidget_MasonryGrid = function () {

		this.widgetObject = null;
		this.widgetOverlay = null;
		this.data = {};
	
		/**
		 * Initialize widget management
		 * @param widgetObject jquery object of an widget div
		 * @param data widget's data
		 */
		this.init = function (widgetObject, data) {
			//store widgetObject variable to be accessible from other functions
			this.widgetObject = widgetObject;
			this.widgetObject.css('min-height', '30px'); //if widget is empty it could be impossible to click on.
	
			var context = this; // set this so $.proxy would work below. http://api.jquery.com/jquery.proxy/
			this.data = data;
	
			//put an overlay over the widget and open popup on mouse click event
			this.$widgetOverlay = $('<div></div>');
			this.widgetObject.prepend(this.$widgetOverlay);
			this.$widgetOverlay.on('click', $.proxy(context.openPopup, context));
			$.proxy(this.fixOverlay, context)();
	
			this.$itemsButton = this.widgetObject.find('.ipsWidgetSettings');
			this.$itemsButton.on('click', function (e) {
				$.proxy(context.openOptions(), context);
			});
			
			//fix overlay size when widget is resized / moved
			$(document).on('ipWidgetResized', function () {
				$.proxy(context.fixOverlay, context)();
			});
			$(window).on('resize', function () {
				$.proxy(context.fixOverlay, context)();
			});
	
		};
		
		this.onAdd = function () {
			$.proxy(this.openOptions, this);
		};
		
		this.openOptions = function () {
			var context = this;
			
			$('#ipWidgetMasonryPopup').remove();
						
			// load content
			var postdata = {
				sa: 'Content.widgetPost',
				securityToken: ip.securityToken,
				widgetId: this.data.widgetId
			}
	
			$.ajax({
				url: ip.baseUrl,
				data: postdata,
				dataType: 'json',
				type: 'POST',
				success: function (response) {
					// add recived html
					$('body').append($(response.popup));
					
					// find popup
					context.modal = $('#ipWidgetMasonryPopup')
					
					// open modal popup
					context.modal.modal(); 
	
					ipInitForms();
	
					var $confirmButton = context.modal.find('.ipsConfirm');
	
					$confirmButton.off(); // ensure we will not bind second time
					$confirmButton.on('click', $.proxy(context.save_options, context));
				},
				error: function (response) {
					alert('Error: ' + response.responseText);
				}
	
			});
		};
	
		this.save_options = function (e) {
			var formData = this.modal.find('form').serializeArray();
			var MasonryData = {};
			
			// extract the values
			$.each(formData, function (key, value) {
				if ($.inArray(value.name, ['columnWidth', 'gutter', 'isFitWidth']) > -1) {
					MasonryData[value.name] = value.value;
				}
			});
			
			this.data['options'] = MasonryData;
			
			var custom_data = this.data;
			
			// save widgetdata and reload
			this.widgetObject.save(custom_data, true, function(){
				// Restore masonry after reload
				load_masonry_containers();
				
			});
			
			// hide modal
			this.modal.modal('hide');
		};  
		
		/**
		 * Make the overlay div to cover the whole widget.
		 */
		this.fixOverlay = function () {
			this.$widgetOverlay
				.css('position', 'absolute')
				.css('z-index', 1000) // should be higher enough but lower than widget controls
				.width(this.widgetObject.width())
				.height(this.widgetObject.height());
		}
	
	
		/**
		 * Open widget management popup
		 */
		this.openPopup = function () {
			var context = this; // store current context for $.proxy bellow. http://api.jquery.com/jquery.proxy/
			$('#ipMasonryGridPopup').remove(); //remove any existing popup. This could happen if other widget is in management state right now.
	
			//get popup HTML using AJAX. See AdminController.php widgetPopupHtml function
			var data = {
				aa: 'MasonryGrid.widgetPopupHtml',
				securityToken: ip.securityToken,
				widgetId: this.widgetObject.data('widgetid')
			}
	
			$.ajax({
				url: ip.baseUrl,
				data: data,
				dataType: 'json',
				type: 'GET',
				success: function (response) {
					//create new popup
					var $popupHtml = $(response.popup);
					//console.log(response);return;
					$('body').append($popupHtml);
					var $popup = $('#ipMasonryGridPopup .ipsModal');
					$popup.modal();
					$popup.on('hidden.bs.modal', function () {
						$.proxy(context.save, context)();
					})
				},
				error: function (response) {
					alert('Error: ' + response.responseText);
				}
	
			});
	
		};
	
		/**
		 * Permanently store widget's data and destroy the popup
		 * @param e
		 * @param response
		 */
		this.save = function (e) {
			var context = this;
			
			this.widgetObject.save(context.data, 1, function(){
				// Restore masonry after reload
				load_masonry_containers();
				
			}); // save and reload widget
		};
	};
})(jQuery);

