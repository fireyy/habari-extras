<?php $theme->display ('header'); ?>
	<article id="post-<?php echo $post->id; ?>" class="hentry page <?php echo $post->statusname , ' ' , $post->tags_class; ?>">
		<h2 class="entry-title"><?php echo $post->title_out; ?></h2>
		<div class="entry-content">
			<?php echo $post->content_out; ?>
			<?php $theme->monthly_archives(); ?>
			<h3>Tags</h3>
			<?php $theme->show_tags(); ?>
		</div>
		<cite class="entry-meta">
			<?php if ( $user ) { ?>
				<a href="<?php URL::out( 'admin', 'page=publish&slug=' . $post->slug); ?>" title="<?php _e('Edit post'); ?>"><?php _e('Edit'); ?></a>
			<?php } ?>
		</cite>
    </article>
<?php $theme->display ( 'comments' ); ?>
<?php $theme->display ('sidebar'); ?>
<?php $theme->display ('footer'); ?>
