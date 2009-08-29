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

  public function filter_plugin_config ($actions, $plugin_id) {
    if ( $plugin_id == $this->plugin_id ) { 
      $actions[] = 'Configure';
    }
    
    return $actions;
  }

  public function action_plugin_ui ($plugin_id, $action) {
    if ($plugin_id == $this->plugin_id) {
      switch ($action) {
        case 'Configure':
          $theme_datas = Themes::get_all_data ();

          $ithemes = array ();
          $themes = array ();
          foreach ($theme_datas as $name => $data) {
            if (isset ($data['info']->compatible)) {
              $ithemes[$name] = $name;
            } else {
              $themes[$name] = $name;
            }
          }

          $ui = new FormUI ('iphonetheme');
          $iphone_t = $ui->append ('select', 'selected_themes', 'iphonetheme__selected_themes', 'Select themes for iphone:');
          $iphone_t->options = array_merge ($ithemes,
                                            array ("separator" => "-- PC Compatible --"),
                                            $themes);
          $ui->selected_themes->add_validator (array ($this, 'validate_selection'));
          $ui->append ('submit', 'save', 'Save');
          $ui->out ();
          break;
      }
    }
  }

  public function filter_rewrite_rules( $db_rules )
  {
    $rules = array();
    foreach ($db_rules as $rule) {
      if (preg_match ('/^display_/', $rule->name)) {
        $rules[]= new RewriteRule (array (
         'name' => 'iHabari_' . $rule->name,
         'parse_regex' => $rule->parse_regex,
         'build_str' => $rule->build_str,
         'priority' => $rule->priority > 0 ? $rule->priority - 1 : 0,
         'handler' => 'iHabariHandler',
         'rule_class' => RewriteRule::RULE_CUSTOM,
         'action' => $rule->action,
         'is_active' => 1,
         'parameters' => serialize (array ('require_match' => array ('iHabari', 'check_user_agent'))),
        ));
      }
    }

    $db_rules = array_merge ($db_rules, $rules);

    return $db_rules;
  }

  public static function check_user_agent ($rule, $stub, $pattern) {
    if (preg_match (self::MOBILE_AGENT_REGEX, $_SERVER['HTTP_USER_AGENT'])) {
      return true;
    } else {
      return false;
    }
  }

  public function validate_selection ($value, $control, $form) {
    if ("separator" == $value) {
      return array (_t("Please select a valid theme"));
    }

    return array ();
  }
}
?>
