<?php

/*
*
* Diplomacy Engine
* majortopio
*
*/

namespace majortopio\diplomacy\acp;

class diplomacy_entity_module
{
  public $u_action;
  public $tpl_name;
  public $page_title;

  public function main()
  {
    global $phpbb_container, $user, $request;

    /** @var \phpbb\language\language $lang */
    $lang = $phpbb_container->get('language');

    /** @var \phpbb\request\request $request */
    $request = $phpbb_container->get('request');

    //Controller Grab
    $entity_admin_controller = $phpbb_container->get('majortopio.diplomacy.entity.admin.controller');

    $action = $request->variable('action', '');
    $entity_id = $request->variable('entity_id', '');
    $entity_admin_controller->set_page_url($this->u_action);

    $this->tpl_name = 'diplomacy_entity_body';
    $this->page_title = $lang->lang('ACP_DIPLOMACY_ENTITY_TITLE');

    //$entity_admin_controller->display_entities();

    switch ($action)
    {
      case 'add':
        $entity_admin_controller->add_edit_entity();
      break;
      case 'edit':
        $entity_admin_controller->edit_entity($entity_id);
      break;
      case 'delete':
        $entity_admin_controller->delete_entity($entity_id);
      default:
        $entity_admin_controller->display_entities();
      break;
    }

  }
}
