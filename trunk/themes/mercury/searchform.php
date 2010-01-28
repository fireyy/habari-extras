	<section id="widget-search" class="widget">
		<h3><span><?php _e('Search'); ?></span></h3>
		<?php Plugins::act( 'theme_searchform_before' ); ?>
			<fieldset>
		     <form method="get" id="searchform" class="formcontrol" action="<?php URL::out('display_search'); ?>">
		      <input type="text" id="criteria" name="criteria" value="<?php if ( isset( $criteria ) ) { echo htmlentities($criteria, ENT_COMPAT, 'UTF-8'); } ?>" /><input type="submit" id="searchsubmit" class="button" value="<?php _e('Search'); ?>" />
		     </form>
			</fieldset>
		<?php Plugins::act( 'theme_searchform_after' ); ?>
	</section>
