	</div>
<?php if ( !$this->request->display_entry && !$this->request->display_page ) { ?>
	<aside id="primary" class="sidebar">
		<?php Plugins::act( 'theme_sidebar_top' ); ?>
		<?php $theme->display('moreposts.widget'); ?>
		<?php //if ( Plugins::is_loaded('FreshComments') ) $theme->freshcomments(); ?>
		<?php //if ( Plugins::is_loaded('Blogroll') ) $theme->show_blogroll(); ?>
		<?php //if ( Plugins::is_loaded('TagCloud') ) $theme->display('tagcloud.widget'); ?>
		<?php Plugins::act( 'theme_sidebar_bottom' ); ?>
	</aside>
<?php } ?>