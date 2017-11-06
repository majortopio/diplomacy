<?php

/*
*
* Diplomacy Engine
* majortopio
*
*/

namespace majortopio\diplomacy\acp;

class diplomacy_main_module
{
  public $u_action;
  public $tpl_name;
  public $page_title;

  public function main($id, $mode)
  {
    global $user, $template, $request, $config;

    $this->tpl_name = 'diplomacy_body';
    $this->page_title = $user->lang('ACP_DIPLOMACY_SETTINGS_TITLE');

    add_form_key('diplomacy_settings');

    if($request->is_set_post('submit'))
    {
      if(!check_form_key('diplomacy_settings'))
      {
        trigger_error('FORM_INVALID');
      }

      $config->set('diplomacy_goodbye', $request->variable('diplomacy_goodbye', 0));
      trigger_error($user->lang('ACP_DEMO_SETTING_SAVED') . adm_back_link($this->u_action));
    }

    $template->assign_vars(array(
      'DIPLOMACY_GOODBYE' => $config['diplomacy_goodbye'],
      'U_ACTION'          => $this->u_action,
    ));
  }
}
