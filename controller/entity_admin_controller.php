<?php
/**
 *
 * Diplomacy Engine
 * majortopio
 *
 */

namespace majortopio\diplomacy\controller;

use Symfony\Component\DependencyInjection\ContainerInterface;

class entity_admin_controller
{
  /** @var \phpbb\cache\driver\driver_interface */
  protected $cache;

  /** @var \phpbb\config\config */
  protected $config;

  /** @var ContainerInterface */
  protected $container;

  /** @var \phpbb\controller\helper */
  protected $helper;

  /** @var \phpbb\db\driver\driver_interface */
  protected $db;

  /** @var \phpbb\language\language */
  protected $lang;

  /** @var \phpbb\log\log */
  protected $log;

  /** @var \phpbb\request\request */
  protected $request;

  /** @var \phpbb\template\template */
  protected $template;

  /** @var \phpbb\user */
  protected $user;

  /** @var string phpBB root path */
  protected $root_path;

  /** @var string */
  protected $dip_entities_table;

  /** @var string Custom form action */
  protected $u_action;

  /**
   * Constructor
   *
   * @param \phpbb\cache\driver\driver_interface  $cache
   * @param \phpbb\config\config                  $config
   * @param ContainerInterface                    $container
   * @param \phpbb\controller\helper              $helper
   * @param \phpbb\db\driver\driver_interface     $db
   * @param \phpbb\language\language              $lang
   * @param \phpbb\log\log                        $log
   * @param \phpbb\request\request                $request
   * @param \phpbb\template\template              $template
   * @param \phpbb\user                           $user
   * @param string                                $root_path
   * @param string                                $dip_entities_table
   */
	public function __construct(\phpbb\cache\driver\driver_interface $cache, \phpbb\config\config $config, ContainerInterface $container, \phpbb\controller\helper $helper, \phpbb\db\driver\driver_interface $db, \phpbb\language\language $lang, \phpbb\log\log $log, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, $root_path, $dip_entities_table)
	{
    $this->cache = $cache;
		$this->config = $config;
		$this->container = $container;
		$this->helper = $helper;
		$this->db = $db;
		$this->lang = $lang;
		$this->log = $log;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
    $this->dip_entities_table = $dip_entities_table;
  }

  public function display_entities()
  {
    $sql_array = array(
      'SELECT'    => '*',
      'FROM'      => array($this->dip_entities_table => 'dip'),
      'ORDER_BY'  => 'dip.entity_name ASC',
    );
    $result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_array));

    //Creating a key
    add_form_key('diplomacy_entity_view');

    while ($row = $this->db->sql_fetchrow($result))
    {
      $entity_id = (int) $row['entity_id'];

      $entities = array(
        'ENTITY_NAME'         => $row['entity_name'],
        'ENTITY_DESCRIPTION'  => $row['entity_desc'],
        'GROSS_DOMESTIC'      => $row['gross_domestic'],
        'U_ACTION_EDIT'       => "{$this->u_action}&amp;action=edit&amp;entity_id=" . $entity_id,
        'U_ACTION_DELETE'     => "{$this->u_action}&amp;action=delete&amp;entity_id=" . $entity_id,
      );

      $this->template->assign_block_vars('entities', $entities);
    }

    $this->db->sql_freeresult($result);
    $this->template->assign_vars(array(
      'U_ACTION'          => "{$this->u_action}",
      'S_VIEW_ENTITIES'   => 1,
    ));
  }

  public function add_edit_entity()
  {
    //Output-array for user showing
    $errors = array();

    $entity_id = $this->request->variable('entity_id_edit', '');

    if($this->request->is_set_post('submit'))
    {
      if(!check_form_key('diplomacy_entity_view'))
      {
        trigger_error('FORM_INVALID');
      }

      $data = array(
        'entity_name' => $this->request->variable('entity_name', '', true),
        'entity_desc' => $this->request->variable('entity_desc', '', true),
        'gross_domestic' => $this->request->variable('gross_domestic',0,true),
        'gross_domestic_growth' => $this->request->variable('gross_domestic_growth',0, true),
        'population'    => $this->request->variable('population',0,true),
        'capital'    => $this->request->variable('capital','',true),
        'ethnicities'   => $this->request->variable('ethnicities', '', true),
      );

      if($entity_id)
      {
        $sql = 'UPDATE ' . $this->dip_entities_table . '
        SET ' . $this->db->sql_build_array('UPDATE', $data) . '
        WHERE entity_id = ' . (int) $entity_id;
        $this->db->sql_query($sql);
      }
      else
      {
        $sql = 'INSERT INTO ' . $this->dip_entities_table . '
          ' . $this->db->sql_build_array('INSERT', $data);

        try {
          $this->db->sql_query($sql);
        } catch (\Exception $e) {
          trigger_error($e->get_message($this->lang) . adm_back_link($this->u_action), E_USER_WARNING);
        }
      }

      $this->log->add('admin', $this->user->data['user_id'], $this->user->data['user_ip'], 'ACP_DIPLOMACY_ENTITY_ADD_EDIT_LOG', time(), array($entity_id));

      redirect($this->u_action);
    }
  }

  public function edit_entity($entity_id)
  {
    //Creating a key
    add_form_key('diplomacy_entity_view');

    $sql_array = array(
      'SELECT'    => '*',
      'FROM'      => array($this->dip_entities_table => 'dip'),
      'WHERE'  => 'dip.entity_id =' . (int) $entity_id,
    );
    $result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_array));
    $this->data = $this->db->sql_fetchrow($result);
    $this->db->sql_freeresult($result);

    $this->template->assign_vars(array(
      'S_EDIT_ENTITY'   => 1,
      'ENTITY_NAME'     => $this->data['entity_name'],
      'ENTITY_DESC'     => $this->data['entity_desc'],
      'GROSS_DOMESTIC'  => $this->data['gross_domestic'],
      'U_ACTION'        => "{$this->u_action}&amp;action=add&amp;entity_id_edit=" . $entity_id,
    ));
  }

  public function delete_entity($entity_id)
  {
    $sql = 'DELETE FROM ' . $this->dip_entities_table . '
      WHERE entity_id = ' . (int) $entity_id;
    $this->db->sql_query($sql);

    $this->log->add('admin', $this->user->data['user_id'], $this->user->data['user_ip'], 'ACP_DIPLOMACY_ENTITY_DELETE_LOG', time(), array($entity_id));
  }

  public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}

}
