<?php

/*
*
* Diplomacy Engine
* majortopio
*
*/

namespace majortopio\diplomacy\acp;

class diplomacy_main_info
{
  public function module()
  {
    return array(
      'filename'  => '\majortopio\diplomacy\acp\diplomacy_main_module',
      'title'     => 'ACP_DIPLOMACY_SETTINGS_TITLE',
      'modes'     => array(
        'settings'  => array(
          'title' => 'ACP_DIPLOMACY_SETTINGS_TITLE',
          'auth'  => 'ext_majortopio/diplomacy && acl_a_board',
          'cat'   => array('ACP_DIPLOMACY_SETTINGS_TITLE'),
        ),
      ),
    );
  }
}
