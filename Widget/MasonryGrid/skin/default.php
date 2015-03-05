<div id="<?php echo $container_id ?>" class='masonry_container'
			   data-columnWidth='<?php echo $options['columnWidth'] ?>' 
			   data-gutter='<?php echo $options['gutter'] ?>' 
			   data-isFitWidth='<?php echo $options['isFitWidth'] ?>' 
			   data-isOriginLeft='<?php echo $options['isOriginLeft'] ?>'>
<?php foreach($items as $item) : ?>
	<div class="item">
		<img src="<?php echo $item['image_url'] ?>" />
		<div class='caption align-center'>
			<a href='<?php echo $item['clean_url'] ?>' target='<?php echo $item['link_target'] ?>'><strong class='image-title'><?php echo esc($item['title']) ?></strong></a>
			<span><?php echo $item['description'] ?></span>
		</div>
	</div>
<?php endforeach ?>
	<div class='clearfix' style='clear:both'></div>
</div>
