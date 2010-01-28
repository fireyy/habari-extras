<?php

/**
 * bambooTheme is a custom Theme class for the Habari.
 *
 * @package Habari
 */

// We must tell Habari to use bambooTheme as the custom theme class:
define( 'THEME_CLASS', 'bambooTheme' );

/**
 * A custom theme for bambooTheme output
 */
class bambooTheme extends Theme
{
	
	/**
	 * Execute on theme init to apply these filters to output
	 */
	public function action_init_theme()
	{
		// Apply Format::autop() to comment content...
		Format::apply( 'autop', 'comment_content_out' );
		// Apply Format::tag_and_list() to post tags...
		Format::apply( 'tag_and_list', 'post_tags_out' );
		// Truncate content excerpt at "more" or 100 characters...
		//Format::apply_with_hook_params( 'more', 'post_content_excerpt', '', 100, 1 );
		//Format::apply_with_hook_params( 'more', 'post_content_out', 'more' );
		//Format::apply_with_hook_params( 'more', 'post_content_out', 'more', 100, 1 );
	}
	
	public function add_template_vars()
	{
	
		$this->add_template( 'cloudy_text', dirname(__FILE__) . '/formcontrol_text.php' );
		if( !$this->template_engine->assigned( 'pages' ) ) {
			$this->assign('pages', Posts::get( array( 'content_type' => 'page', 'status' => Post::status('published'), 'nolimit' => 1 ) ) );
		}

		parent::add_template_vars();
	}
	
	/**
	 * Customize comment form layout. Needs thorough commenting.
	 */
	public function action_form_comment( $form ) {
	
		$form->append('static','cf_email_not', _t( '<p class="comment-note"><a id="cancel_reply" class="button" href="javascript:void(0)" onclick="movecfm(null,0,1,null);" style="display:none;">X</a>Email address is not published</p>') );
		$form->move_before( $form->cf_email_not, $form->cf_commenter );
		$form->cf_commenter->caption = _t('Name') . '<span class="required">' . ( Options::get('comments_require_id') == 1 ? ' *' : '' ) . '</span>';
		$form->cf_commenter->template = 'cloudy_text';
		$form->cf_email->caption = _t('Mail') . '<span class="required">' . ( Options::get('comments_require_id') == 1 ? ' *' : '' ) . '</span>';
		$form->cf_email->template = 'cloudy_text';
		$form->cf_url->caption = _t('Website');
		$form->cf_url->template = 'cloudy_text';
		if ( Plugins::is_loaded('CJKPlease') ){
			$form->append('static','cf_cjkplease_text', _t( '<p class="comment-note">'.Options::get('cjkplease_text').'</p>') );
			$form->move_before( $form->cf_cjkplease_text, $form->cf_content );
		}
	    $form->cf_content->caption = '';
		$form->cf_submit->caption = _t( 'Submit' );
		$form->cf_submit->class = 'formcontrol';
		if ( Plugins::is_loaded('ThreadedComment') ) {
			$form->append('static','cf_emailnotify', _t( '<div id="emailnotify-control" class="formcontrol"><label for="emailnotify"><input type="checkbox" name="emailnotify" id="emailnotify" checked="true" /> '._t('Receive Email Notify').'</label><input type="hidden" value="" name="commentparent" id="commentparent"/></div>') );
		}
	}

}

?>
