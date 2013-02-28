<?php 	$boxes = get_field( 'sidebar', 'options' ); ?>

		<section id="sidebar">
<?php 		foreach( $boxes as $box ) :
				$box_icon = get_field( 'box_icon '); ?>
				<article>
					<img src="<?php echo $box['box_icon']['url']; ?>" />
					<h1><?php echo $box['box_title']; ?></h1>
					<p class="box-text"><?php echo $box['box_text']; ?></p>
					<p class="box-link"><a href="http://<?php echo $box['box_link']; ?>">Read More</a></p>
				</article>
<?php 		endforeach; ?>
		</section>