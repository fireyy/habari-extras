<?php
class CJKPlease extends Plugin
{
  public function action_plugin_activation ($file) {
    if (realpath ($file) == __FILE__) {
      EventLog::register_type ('CJKPlese');
      if (!(Options::get ('cjkplease_text'))) {
        Options::set ('cjkplease_text', 'You should say a Chinese word to pass spam check. If you can not input Chinese, just copy 你好 and paste them into comment text box.');
      }
    }
  }

  public function action_plugin_deactivation ($file) {
    if (realpath ($file) == __FILE__) {
      EventLog::unregister_type ('CJKPlease');
      Options::delete ('cjkplease_text');
    }
  }


  public function filter_plugin_config ($actions, $plugin_id) {
    if ($plugin_id == $this->plugin_id ()) {
      $actions[]= _t('Configure');
    }

    return $actions;
  }

  public function action_plugin_ui ($plugin_id, $action) {
    if ($plugin_id == $this->plugin_id ()) {
      switch ($action) {
        case _t('Configure'):
          $form = new FormUI ('cjkplease');
          $form->append ('textarea', 'cjkplease', 'option:cjkplease_text', _t('Notification:'));
          $form->append ('submit', 'save', _t('Save'));
          $form->set_option ('success_message', _t('Configuration saved'));
          $form->out ();
        break;
      }
    }
  }

  function filter_spam_filter ($spam_rating, $comment, $handlervars) {
    /*
     *  4E00 - 9FC3     CJK Unified Ideographs
     *  F900 - FAD9     CJK Compatibility Ideographs
     * 2F800 - 2FA1D    CJK Compatibility Ideographs Supplement
     * 20000 - 2A6D6    CJK Unified Ideographs Extension B
     *  2E80 - 2EF3     CJK Radicals Supplement
     *  2F00 - 2FD5     Kangxi Radicals
     *  3041 - 309F     Hiragana
     *  30A0 - 30FF     Katakana
     *  31F0 - 31FF     Katakana Phonetic Extensions
     */
    if (!preg_match ("/[\x{4E00}-\x{9FC3}\x{F900}-\x{FAD9}\x{2F800}-\x{2FA1D}\x{20000}-\x{2A6D6}\x{2E80}-\x{2EF3}\x{2F00}-\x{2FD5}\x{3041}-\x{309F}\x{30A0}-\x{30FF}\x{31F0}-\x{31FF}]/u", $comment->content)) {
      $post = Post::get (array ('id' => $comment->post_id));
			Session::error (Options::get('cjkplease_text'));
			Session::add_to_set ('comment', $handlervars['name'], 'name');
			Session::add_to_set ('comment', $handlervars['email'], 'email');
			Session::add_to_set ('comment', $handlervars['url'], 'url');
			Session::add_to_set ('comment', $comment->content, 'content');
			Utils::redirect ($post->permalink . '#respond');
    }

    return $spam_rating;
  }
}
?>
