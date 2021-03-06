function load_masonry_containers(){
	var ms_containers = $('.masonry_container');
	
	if (ms_containers.length > 0) {
		
		ms_containers.each(function( index ) {
			var _gutter = $(this).attr('data-gutter');
			var _columnWidth = $(this).attr('data-columnWidth');
			var _fitWidth = true;
			var _isOriginLeft = true;
			
			if ($(this).attr('data-isFitWidth') != 'on') {
				_fitWidth = false;
			}
			var origin_data = $(this).attr('data-isOriginLeft');
			
			if ( origin_data != 'left' && origin_data !='' ) {
				_isOriginLeft = false;
			}
			
			var $container = $(this).masonry();
			
			// layout Masonry again after all images have loaded
			$container.imagesLoaded( function() {
			  $container.masonry(
					{
						gutter: parseInt(_gutter),
						columnWidth: parseInt(_columnWidth),
						itemSelector: '.item',
						isFitWidth: _fitWidth,
						isOriginLeft: _isOriginLeft
					});
			});
		});
	}	
}

(function( $ ) {
    $(document).ready(function(){
		load_masonry_containers();
	});
})( jQuery );