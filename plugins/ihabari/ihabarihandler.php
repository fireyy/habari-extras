<?php
class iHabariHandler extends UserThemeHandler
{
	public function setup_theme()
	{
		$this->theme = Themes::create('ihabari', 'RawPHPEngine');
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
