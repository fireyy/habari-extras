<?php $theme->display ('header'); ?>
<?php if ( sizeof( $posts ) ){ ?>
<?php foreach ( $posts as $post ) { ?>
     <article id="post-<?php echo $post->id; ?>" class="hentry entry <?php echo $post->statusname; ?>">
     	<time class="entry-date"><a href="<?php echo $post->pubdate->text_format('{Y}/{m}'); ?>" title="View all posts written in <?php echo $post->pubdate->text_format('{M} {Y}'); ?>"><?php echo $post->pubdate->text_format('<span>{M}</span> <span class="day">{d}</span>, <span>{Y}</span>'); ?></a></time>
		<h2 class="entry-title"><a href="<?php echo $post->permalink; ?>" title="<?php echo $post->title; ?>"><?php echo $post->title_out; ?></a></h2>
		<cite class="entry-meta">
			<?php if ( $user ) { ?>
			        <span class="edit-link"><a href="<?php echo $post->editlink; ?>" title="<?php _e('Edit post'); ?>"><?php _e('Edit'); ?></a></span>
					<span class="meta-sep">|</span>
			<?php } ?>
			<?php if ( is_array( $post->tags ) ) { ?>
			        <span class="tag-links"><?php _e('Tagged:'); ?> <?php echo $post->tags_out; ?></span>
					<span class="meta-sep">|</span>
			<?php } ?>
			<span class="comments-link"><a href="<?php echo $post->permalink; ?>#comments" title="<?php _e('Comments to this post'); ?>"><?php echo $post->comments->approved->count; ?>
			<?php echo _n( 'Comment', 'Comments', $post->comments->approved->count ); ?></a></span>
		</cite>
		<div class="entry-content">
			<?php echo $post->content_out; ?>
		</div>
     </article>
<?php } ?>
	<nav class="pagebar">
		<?php $theme->prev_page_link("&laquo;"); ?> <?php $theme->page_selector( null, array( 'leftSide' => 2, 'rightSide' => 2 ) ); ?> <?php $theme->next_page_link("&raquo;"); ?>
	</nav>
<?php }else{ ?>
	<article class="hentry post error404">
		<div class="entry-content">
			<p><?php _e('The requested post was not found.'); ?></p>
		</div>
	</article>
<?php } ?>
<?php $theme->display ('sidebar'); ?>
<?php $theme->display ('footer'); ?>
