<?php

/*
*
* Diplomacy Engine
* majortopio
*
*/

namespace majortopio\diplomacy\acp;

class diplomacy_entity_info
{
  public function module()
  {
    return array(
      'filename'  => '\majortopio\diplomacy\acp\diplomacy_entity_module',
      'title'     => 'ACP_DIPLOMACY_ENTITY_TITLE',
      'modes'     => array(
        'view'  => array(
          'title' => 'ACP_DIPLOMACY_ENTITY_VIEW_TITLE',
          'auth'  => 'ext_majortopio/diplomacy && acl_a_board',
          'cat'   => array('ACP_DIPLOMACY_ENTITY_TITLE'),
        ),
      ),
    );
  }
}
