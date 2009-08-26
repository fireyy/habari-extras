<?php

require ('ihabarihandler.php');

class iHabari extends Plugin
{
  const MOBILE_AGENT_REGEX = '/iPhone/i';
  public function action_plugin_activation ($file) {
    if (realpath ($file) == __FILE__) {
      EventLog::register_type ('iHabari');
    }
  }

  public function action_plugin_deactivation ($file) {
    if (realpath ($file) == __FILE__) {
      EventLog::unregister_type ('iHabari');
    }
  }

	public function filter_rewrite_rules( $db_rules )
	{
/*
		$db_rules[]= new RewriteRule (array (
		 'name' => 'iHabari',
		 'parse_regex' => '^/*^',
		 'build_str' => '',
		 'handler' => 'iHabariHandler',
     'rule_class' => RewriteRule::RULE_CUSTOM,
		 'action' => 'start',
		 'is_active' => 1,
     'parameters' => serialize (array ('require_match' => array ('iHabari', 'user_agent_checker'))),
    ));
*/
    $rules = array();
    foreach ($db_rules as $rule) {
      if (preg_match ('/^display_/', $rule->name)) {
        $rules[]= new RewriteRule (array (
         'name' => 'iHabari_' . $rule->name,
         'parse_regex' => $rule->parse_regex,
         'build_str' => $rule->build_str,
         'handler' => 'iHabariHandler',
         'rule_class' => RewriteRule::RULE_CUSTOM,
         'action' => $rule->action,
         'is_active' => 1,
         'parameters' => serialize (array ('require_match' => array ('iHabari', 'user_agent_checker'))),
        ));
      }
    }

    $db_rules = array_merge ($db_rules, $rules);
  
		return $db_rules;
	}

  //public function action_plugins_loaded () {
  public static function user_agent_checker ($rule, $stub, $pattern) {
    if (preg_match (self::MOBILE_AGENT_REGEX, $_SERVER['HTTP_USER_AGENT'])) {
      return true;
    } else {
      return false;
    }
  }
}
?>
