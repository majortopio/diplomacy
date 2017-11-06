<?php
/*
* Diplomacy Engine
* majortopio
*
*/

namespace majortopio\diplomacy\controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

//Entity controller
class entity_controller
{
  /** @var \phpbb\auth\auth */
  protected $auth;

  /** @var \phpbb\config\config */
  protected $config;

  /** @var \phpbb\controller\helper */
  protected $helper;

  /** @var \phpbb\template\template */
  protected $template;

  /** @var \phpbb\user */
  protected $user;

  /** @var \phpbb\db\driver\driver_interface */
  protected $db;

  /** @var string dip_entities_table */
  protected $dip_entities_table;

  /** Constructor
    * @param \phpbb\config\config     $config
    * @param \phpbb\controller\helper $helper
    * @param \phpbb\template\template $template
    * @param \phpbb\user              $user
    * @param string                   $dip_entities_table
    */
  public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, $dip_entities_table)
  {
    $this->config   = $config;
    $this->helper   = $helper;
    $this->template = $template;
    $this->user     = $user;
    $this->db       = $db;
    $this->dip_entities_table = $dip_entities_table;
  }

  public function display()
  {
    $sql = 'SELECT *
      FROM ' . $this->dip_entities_table . '
      ORDER BY entity_name ASC';
    $result = $this->db->sql_query($sql);

    $bg_counter = 1;

    while($row = $this->db->sql_fetchrow($result))
    {
      $bg_counter = $bg_counter == 1 ? 2 : 1;
      $entities = array(
        'ENTITY_NAME'         => $row['entity_name'],
        'ENTITY_DESCRIPTION'  => $row['entity_desc'],
        'GROSS_DOMESTIC'      => $this->number_shorten($row['gross_domestic']),
        'BG_COLOR'            => 'bg' . $bg_counter,
        'U_VIEW_LINK'         => $this->helper->route('majortopio_diplomacy_entity_controller_view', array("entity_id" => $row['entity_id'])),
      );
      $this->template->assign_block_vars('entities', $entities);
    }
    $this->db->sql_freeresult($result);
    return $this->helper->render('entity_view.html');
  }

  public function show_entity($entity_id)
  {
    $sql = 'SELECT *
      FROM ' . $this->dip_entities_table . '
      WHERE entity_id = ' . $entity_id;

      $entity = $this->db->sql_fetchrow($this->db->sql_query($sql));

      $this->template->assign_vars(array(
        'U_HEADER'  => $entity['entity_name'],
      ));

      return $this->helper->render('single_entity_view.html');
  }

  public function number_shorten($number)
  {
      $numlength = strlen((string)$number);
      if ($numlength > 6 && $numlength < 10)
      {
          if($numlength == 7) {
              return substr((string)$number, 0, 1) . '.' . substr((string)$number, 1, 1) . ' million';
          }
          elseif($numlength == 8) {
              return substr((string)$number, 0, 2) . '.' . substr((string)$number, 2, 1) . ' million';
          }
          elseif($numlength == 9)
          {
              return substr((string)$number, 0, 3) . '.' . substr((string)$number, 3, 2) . ' million';
          }
      }
      elseif ($numlength > 9 && $numlength < 13)
      {
          if($numlength == 10) {
              return substr((string)$number, 0, 1) . '.' . substr((string)$number, 1, 1) . ' billion';
          }
          elseif($numlength == 11) {
              return substr((string)$number, 0, 2) . '.' . substr((string)$number, 2, 1) . ' billion';
          }
          elseif($numlength == 12)
          {
              return substr((string)$number, 0, 3) . '.' . substr((string)$number, 3, 2) . ' billion';
          }
      }
      elseif ($numlength > 12 && $numlength < 16)
      {
          if($numlength == 13) {
              return substr((string)$number, 0, 1) . '.' . substr((string)$number, 1, 1) . ' trillion';
          }
          elseif($numlength == 14) {
              return substr((string)$number, 0, 2) . '.' . substr((string)$number, 2, 1) . ' trillion';
          }
          elseif($numlength == 15)
          {
              return substr((string)$number, 0, 3) . '.' . substr((string)$number, 3, 2) . ' trillion';
          }
      }

      return $number;
  }

}
