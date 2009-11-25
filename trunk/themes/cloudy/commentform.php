<!-- commentsform -->
<?php // Do not delete these lines
if ( ! defined('HABARI_PATH' ) ) { die( _t('Please do not load this page directly. Thanks!') ); }
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