<?php if ( $this->request->display_home || $this->request->display_404 ) { ?>
<!-- sidebar -->
<?php Plugins::act( 'theme_sidebar_top' ); ?>

		<div id="search">
		<h2><?php _e('Search'); ?></h2>
<?php $theme->display ('searchform' ); ?>
		</div>

		<div class="sb-about">
		<h2><?php _e('About'); ?></h2>
		<p><?php Options::out('about'); ?></p>
		</div>

		<div class="sb-user">
		<h2><?php _e('User'); ?></h2>
<?php $theme->display ( 'loginform' ); ?>
		</div>

<?php Plugins::act( 'theme_sidebar_bottom' ); ?>
<!-- /sidebar -->
<?php } ?>
