<?php
class iHabariHandler extends UserThemeHandler
{
  public function setup_theme()
  {
    $theme_name = Plugins::filter( 'iHabari_theme_name' );
    $this->theme = Themes::create($theme_name, 'RawPHPEngine');
    $this->theme->assign('matched_rule', URL::get_matched_rule());
    $request = new StdClass();
    foreach(RewriteRules::get_active() as $rule) {
      $request->{$rule->name}= false;
    }
    $request->{$this->theme->matched_rule->name}= true;
    $this->theme->assign('request', $request);
  }
}
?>
