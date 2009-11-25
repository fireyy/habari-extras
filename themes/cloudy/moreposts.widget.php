<section id="widget-moreposts" class="widget">
	<h3><span><?php _e('More Posts'); ?></span></h3>
	<ul>
	<?php foreach($more_posts as $post): ?>
	<?php
		echo '<li>';
		echo '<a href="' . $post->permalink .'" title="'.$post->title.'">' . $post->title_out . '</a>';
		echo '</li>';
	?>
	<?php endforeach; ?>
	</ul>
</section>
