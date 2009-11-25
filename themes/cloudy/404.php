<?php $theme->display ('header'); ?>
		<article class="hentry post error404">
			<h2 class="entry-title"><?php _e('Error!'); ?></h2>
			<div class="entry-content">
				<p><?php _e('The requested post was not found.'); ?></p>
				<p style="text-indent:0;text-align:center;"><img src="<?php Site::out_url( 'theme' ); ?>/i/404.jpg" width="435" height="220" alt="404 not found" class="noborder" /></p>
			</div>
			<cite class="entry-meta"></cite>
		</article>
<?php $theme->display ('sidebar'); ?>
<?php $theme->display ('footer'); ?>
