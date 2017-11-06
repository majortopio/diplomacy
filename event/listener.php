<?php

/*
*
* Diplomacy Engine
* majortopio
*
*/

namespace majortopio\diplomacy\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
  /** @var \phpbb\controller\helper */
  protected $helper;

  /** @var \phpbb\template\template */
  protected $template;

  /** Constructor
   * @param \phpbb\controller\helper $helper
   * @param \phpbb\template\template $template
   */
  public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template)
  {
    $this->helper   = $helper;
    $this->template = $template;
  }

  static public function getSubscribedEvents()
  {
    return array(
      'core.user_setup' => 'load_language_on_setup',
      'core.page_header'  => 'add_page_header_link',
    );
  }

  /** Load our language file
  * @param \phpbb\event\data $event The event object */

  public function load_language_on_setup($event)
  {
    $lang_set_ext = $event['lang_set_ext'];
    $lang_set_ext[] = array(
      'ext_name'  => 'majortopio/diplomacy',
      'lang_set'  => 'diplomacy',
    );
    $event['lang_set_ext'] = $lang_set_ext;
  }

  /** Load our language file
  * @param \phpbb\event\data $event The event object */
  public function add_page_header_link($event)
  {
    $this->template->assign_vars(array(
      'U_ENTITY_VIEW' => $this->helper->route('majortopio_diplomacy_entity_controller'),
    ));
  }
}
