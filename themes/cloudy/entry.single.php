<?php $theme->display ('header'); ?>	
    <article id="post-<?php echo $post->id; ?>" class="hentry entry <?php echo $post->statusname , ' ' , $post->tags_class; ?>">
		<time class="entry-date"><a href="<?php echo $post->pubdate->text_format('{Y}/{m}'); ?>" title="View all posts written in <?php echo $post->pubdate->text_format('{M} {Y}'); ?>"><?php echo $post->pubdate->text_format('<span>{M}</span> <span class="day">{d}</span>, <span>{Y}</span>'); ?></a></time>
		<h2 class="entry-title"><?php echo $post->title_out; ?></h2>
		<cite class="entry-meta">
			<?php if ( $user ) { ?>
			        <span class="edit-link"><a href="<?php echo $post->editlink; ?>" title="<?php _e('Edit post'); ?>"><?php _e('Edit'); ?></a></span>
					<span class="meta-sep">|</span>
			<?php } ?>
			<?php if ( is_array( $post->tags ) ) { ?>
			        <span class="tag-links"><?php _e('Tagged:'); ?> <?php echo $post->tags_out; ?></span>
					<span class="meta-sep">|</span>
			<?php } ?>
			<span class="comments-link"><a href="#comments" title="<?php _e('Comments to this post'); ?>"><?php echo $post->comments->approved->count; ?>
			<?php echo _n( 'Comment', 'Comments', $post->comments->approved->count ); ?></a></span>
		</cite>
		<div class="entry-content">
			<?php echo $post->content_out; ?>
		</div>
    </article>
    <?php if ( Plugins::is_loaded('RelatedPosts') ){ ?>
	<section id="related-post" class="entry-related">
		<h3><span>Related Posts</span></h3>
		<?php echo $related_posts; ?>
	</section>
	<?php } ?>
	<nav id="nav-below" class="navigation">
		<?php if ( $previous= $post->descend() ): ?>
		<a class="nav-previous" href="<?php echo $previous->permalink ?>" title="<?php echo $previous->slug ?>">&laquo; <?php echo $previous->title ?></a>
		<?php endif; ?>
		<?php if ( $next= $post->ascend() ): ?>
		<a class="nav-next" href="<?php echo $next->permalink ?>" title="<?php echo $next->slug ?>"><?php echo $next->title ?> &raquo;</a>
		<?php endif; ?>
	</nav>
<?php $theme->display ('comments'); ?>
<?php $theme->display ('sidebar'); ?>
<?php $theme->display ('footer'); ?>
