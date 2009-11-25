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
		//visiting page/2, /3 will offset to the next page of posts in the sidebar
		$page =Controller::get_var( 'page' );
		$pagination =Options::get('pagination');
		if ( $page == '' ) { $page = 1; }
		$this->assign( 'more_posts', Posts::get(array ( 'status' => 'published','content_type' => 'entry', 'offset' => ($pagination)*($page), 'limit' => 5,  ) ) );
	}

	/**
	 * Returns an unordered list of all used Tags
	 */
	public function theme_show_tags ( $theme )
	{
		$sql="
			SELECT t.tag_slug AS slug, t.tag_text AS text, count(tp.post_id) as ttl
			FROM {tags} t
			INNER JOIN {tag2post} tp
			ON t.id=tp.tag_id
			INNER JOIN {posts} p
			ON p.id=tp.post_id AND p.status = ?
			GROUP BY t.tag_slug
			ORDER BY t.tag_text
		";
		$tags= DB::get_results( $sql, array(Post::status('published')) );

		foreach ($tags as $index => $tag) {
			$tags[$index]->url = URL::get( 'display_entries_by_tag', array( 'tag' => $tag->slug ) );
		}
		$theme->taglist = $tags;
		
		return $theme->fetch( 'taglist' );
	}
	
	public function filter_post_tags_class( $tags )
	{
		if (! is_array($tags))
			$tags = array ($tags);
		return count($tags) > 0 ? 'tag-' . implode(' tag-', array_keys($tags)) : 'no-tags';
	}
	
	public function filter_post_tags_type( $tags )
	{
		$entry_type = array('post','link');
		$types = $entry_type[0];
		if ( ! is_array( $tags ) )
			$tags = array ( $tags );
		foreach ($tags as $key => $value) {
			if(array_search($key,$entry_type)) $types = $key;
		}
		return $types;
	}
	
	/**
	 * Customize comment form layout. Needs thorough commenting.
	 */
	public function action_form_comment( $form ) {
	
		$form->append('static','email_not', _t( '<p class="comment-note"><a id="cancel_reply" href="javascript:void(0)" onclick="movecfm(null,0,1,null);" style="display:none;">X</a>Email address is not published</p>') );
		$form->move_before( $form->email_not, $form->commenter );
		$form->commenter->caption = _t('Name') . '<span class="required">' . ( Options::get('comments_require_id') == 1 ? ' *' : '' ) . '</span>';
		$form->commenter->template = 'cloudy_text';
		$form->email->caption = _t('Mail') . '<span class="required">' . ( Options::get('comments_require_id') == 1 ? ' *' : '' ) . '</span>';
		$form->email->template = 'cloudy_text';
		$form->url->caption = _t('Website');
		$form->url->template = 'cloudy_text';
		if ( Plugins::is_loaded('CJKPlease') ){
			$form->append('static','cjkplease_text', _t( '<p class="comment-note">'.Options::get('cjkplease_text').'</p>') );
			$form->move_before( $form->cjkplease_text, $form->content );
		}
	    $form->content->caption = '';
	    if ( Plugins::is_loaded('ThreadedComment') ) {
			$form->append('static','emailnotify', _t( '<div id="emailnotify-control" class="formcontrol"><label for="emailnotify"><input type="checkbox" name="emailnotify" id="emailnotify" checked="true" /> '._t('Receive Email Notify').'</label><input type="hidden" value="" name="commentparent" id="commentparent"/></div>') );
			$form->move_before( $form->emailnotify, $form->submit );
		}
		$form->submit->caption = _t( 'Submit' );
		$form->submit->class = 'formcontrol';
	}

}

?>
