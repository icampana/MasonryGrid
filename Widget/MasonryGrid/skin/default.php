<?php

$image_options = array(
					   'type' => 'width',
					   'width' => ($options['columnWidth'] - 10)
		);

$container_id = "masonry_wd_{$widgetId}";
?>
<div id="<?php echo $container_id ?>" class='masonry_container'
			   data-columnWidth='<?php echo $options['columnWidth'] ?>' 
			   data-gutter='<?php echo $options['gutter'] ?>' 
			   data-isFitWidth='<?php echo $options['isFitWidth'] ?>'>
<?php foreach($items as $item) {
	
	$link = ($item['url'] != '') ? ipFileUrl($item['url']) : '#';
	
	?>
	<div class="item">
		<img src="<?php echo ipFileUrl( ipReflection($item['image'], $image_options) ) ?>" />
		<div class='caption align-center'>
			<a href='<?php echo $link ?>'><strong class='image-title'><?php echo esc($item['title']) ?></strong></a>
			<span><?php echo $item['description'] ?></span>
		</div>
	</div>
<?php } ?>
	<div class='clearfix' style='clear:both'></div>
</div>