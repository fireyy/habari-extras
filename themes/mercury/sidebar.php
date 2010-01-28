	</div>
	<aside id="primary" class="sidebar">
		<?php Plugins::act( 'theme_sidebar_top' ); ?>
		<?php if ( Plugins::is_loaded('TwitterLitte') ) $theme->twitterlitte(); ?>
		<?php $theme->display ('searchform' ); ?>
		<?php if ( Plugins::is_loaded('FreshComments') ) $theme->freshcomments(); ?>
		<?php if ( Plugins::is_loaded('Blogroll') ) $theme->show_blogroll(); ?>
		<?php //if ( $this->request->display_entry ) { ?>
		<?php //if ( Plugins::is_loaded('RelatedPosts') ) $theme->display('relatedposts.widget'); ?>
		<?php //if ( Plugins::is_loaded('RelatedTags') ) $theme->display('relatedtags.widget'); ?>
		<?php //} ?>
		<?php Plugins::act( 'theme_sidebar_bottom' ); ?>
	</aside>