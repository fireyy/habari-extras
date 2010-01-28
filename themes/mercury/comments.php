<!-- comments -->
<?php // Do not delete these lines
if ( ! defined('HABARI_PATH' ) ) { die( _t('Please do not load this page directly. Thanks!') ); }
?>
<?php if ( Plugins::is_loaded('ThreadedComment') ) { ?>
	<?php
	function outputReplyLink ($comment) {
	  echo "<a href='#' class='reply-link' onclick='movecfm (event, " . $comment->id . ", 1, \"" . $comment->name  . "\"); return false;'>" . _t('Reply') . "</a>";
	}

	function outputComment ($post, $comment, $level, $max_depth, $count) {
		if ($comment->url_out == '') {
			$comment_url = $comment->name_out;
		} else {
			$comment_url = '<a href="' . $comment->url_out . '" rel="external">' . $comment->name_out . '</a>';
		}

		$class = 'class="comment';
		if ( $comment->status == Comment::STATUS_UNAPPROVED ) {
			$class .= '-unapproved';
		}

		/* check to see if the comment is by a registered user
		if ($u = User::get($comment->email)) {
			$class .= ' byuser comment-author-' . Utils::slugify ($u->displayname);
		}*/

		if ($comment->email == $post->author->email) {
			$class .= ' bypostauthor';
		}

		if ($level > 1) {
			$class .= ' comment-child';
		}

		if ($count % 2) {
			$class .= ' odd';
		} else {
			$class .= ' even';
		}

		$class.= '"';
	?>
	      <<?php echo $level == 1 ? 'li' : 'div'; ?> id="comment-<?php echo $comment->id; ?>" <?php echo $class; ?> >
		<p class="comment-info">
			<?php if ( Plugins::is_loaded('Gravatar') ) { ?>
				<img src="<?php echo $comment->gravatar; ?>" width="32" height="32" class="gravatar" alt="gravatar" />
			<?php } else { ?>
				<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo md5( $comment->email ); ?>&amp;size=32&amp;rating=G" width="32" height="32" alt="gravatar" class="gravatar" />
			<?php } ?>
	       <span class="comment-author vcard"><a href="<?php echo $comment->url; ?>" rel="external"><?php echo $comment->name; ?></a><?php
			if ($level < $max_depth) {
				outputReplyLink ($comment);
			}
			?></span><span class="comment-meta"><cite class="comment-date"><?php echo $comment->date->out('M d, G:i'); ?></cite></span>
		</p>
	       <div class="comment-content">
	        <?php echo $comment->content_out; ?>
			<?php if ( $comment->status == Comment::STATUS_UNAPPROVED ) : ?> <em class="unapproved"><?php _e('Your comment is awaiting moderation'); ?></em><?php endif; ?>
	       </div>
	      <?php
		if (isset ($comment->children)) {
			foreach ($comment->children as $c) {
				outputComment ($post, $c, $level + 1, $max_depth, $level + 1);
			}
		}
		?>
		<?php echo $level == 1 ? '</li>' : '</div>'; ?>	
	<?php
		
	}
	?>
<?php } ?>
<div id="comments">
<?php
if ( ! $post->info->comments_disabled || $post->comments->moderated->count ) {
?>
    <div id="comments-list" class="comments">
     <h3 class="comments-count"><span><strong><?php echo $post->comments->moderated->count; ?></strong> <?php _e('Responses to'); ?> <?php echo $post->title; ?></span></h3>
	<div class="metalinks">
      <span class="commentsrsslink"><a href="<?php echo $post->comment_feed_link; ?>"><?php _e('Feed for this Entry'); ?></a></span>
     </div>

     <ol id="commentlist">
<?php
if ( $post->comments->moderated->count ) {
	if ( Plugins::is_loaded('ThreadedComment') ) {
		$count= 0;
		foreach ($post->threadedComments as $comment) {
			$count++;
			outputComment ($post, $comment, 1, $theme->commentThreadMaxDepth,$count);
		}
	}else{
		$count= 0;
		foreach ( $post->comments->moderated as $comment ) {
			$count++;
			if ( 0 == ( $count % 2 ) ) {
				$class= ' odd';
			} else {
				$class= ' odd';
			}
			if( $comment->email == $post->author->email ) {
				$class .= ' comment-author-admin';
			}
			if ( $comment->status == Comment::STATUS_UNAPPROVED ) {
				$class .= ' unapproved';
			}
		?>
			<li id="comment-<?php echo $comment->id; ?>" class="comment<?php echo $class; ?>">
				<div class="comment-info">
					<?php if ( Plugins::is_loaded('Gravatar') ) { ?>
						<img src="<?php echo $comment->gravatar; ?>" width="32" height="32" class="gravatar" alt="gravatar" />
					<?php } else { ?>
						<img src="http://www.gravatar.com/avatar.php?gravatar_id=<?php echo md5( $comment->email ); ?>&amp;size=32&amp;rating=G" width="32" height="32" alt="gravatar" class="gravatar" />
					<?php } ?>
					<span class="comment-author vcard"><a href="<?php echo $comment->url; ?>" rel="external"><?php echo $comment->name; ?></a></span><span class="comment-meta"><a href="#comment-<?php echo $comment->id; ?>" title="<?php _e('Time of this Comment'); ?>"><?php echo $comment->date->out('Y-m-d g:ia'); ?></a></span>
				</div>
		       <div class="comment-content">
		        <?php echo $comment->content_out; ?>
		        <?php if ( $comment->status == Comment::STATUS_UNAPPROVED ) : ?> <em class="unapproved"><?php _e('Your comment is awaiting moderation'); ?></em><?php endif; ?>
		       </div>
		      </li>
		<?php			
		}
	}
}
?>
     </ol>
	</div>
<?php } else if($post->info->comments_disabled){ ?>
      <p class="nocomment"><?php _e('Comments are closed for this post.'); ?></p>
<?php } else { ?>
	<p class="nocomment"><?php _e('There are currently no comments.'); ?></p>
<?php }
 if ( ! $post->info->comments_disabled ) { 
?>
<div id="respond">
    <h3 class="reply"><span><?php _e('Leave a Reply'); ?></span></h3>
	<div class="formcontainer">
		<?php
		if ( Session::has_messages() ) {
			Session::messages_out();
		}
		?>
		<?php $post->comment_form()->out(); ?>
	</div>
</div>
<?php
 } ?>
</div><!-- #comments -->