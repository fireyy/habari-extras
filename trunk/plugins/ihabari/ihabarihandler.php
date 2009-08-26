<?php
class iHabariHandler extends UserThemeHandler
{
  public function setup_theme()
  {
    $theme_name = Options::get ('iphonetheme__selected_themes' );
    if ($theme_name) {
      $this->theme = Themes::create ($theme_name, 'RawPHPEngine');
    } else {
      $this->theme = Themes::create ();
    }

    $this->theme->assign ('matched_rule', URL::get_matched_rule());
    $request = new StdClass ();
    foreach (RewriteRules::get_active () as $rule) {
      $request->{$rule->name}= false;
    }
    $request->{$this->theme->matched_rule->name}= true;
    $this->theme->assign ('request', $request);
  }
}
?>
