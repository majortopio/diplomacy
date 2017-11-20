<?php
/*
 *
 * Diplomacy Engine for phpBB
 * majortopio
 *
 */

namespace majortopio\diplomacy\migrations\v00x;

use \phpbb\db\migration\migration;

class version_0_0_1 extends \phpbb\db\migration\migration
{
  // Add dependency for latest phpBB version
  static public function depends_on()
  {
    return array('\phpbb\db\migration\data\v320\v320');
  }

  //Add tables to DB
  public function update_schema(){
    return array(
      'add_tables'  => array(
        //Entities
        $this->table_prefix . 'dip_entities' => array(
          'COLUMNS' => array(
            'entity_id' => array('UINT', NULL, 'auto_increment'),
            'entity_name' => array('VCHAR_UNI:255', ''),
            'entity_desc' => array('MTEXT_UNI', ''),
            'gross_domestic'  => array('BINT', 0),
            'gross_domestic_growth' => array('TINT:3', 0),
            'population'  => array('BINT', 0),
            'capital'     => array('VCHAR_UNI:255', ''),
            'ethnicities' => array('MTEXT_UNI', ''),
          ),
          'PRIMARY_KEY' => 'entity_id',
        ),

        //Organizations
        $this->table_prefix . 'dip_organizations' => array(
          'COLUMNS' => array(
            'organization_id' => array('UINT', NULL, 'auto_increment'),
            'organization_name' => array('VCHAR_UNI:255', ''),
            'treay'           => array('MTEXT_UNI', ''),
          ),
          'PRIMARY_KEY' => 'organization_id',
        ),

        $this->table_prefix . 'dip_modifiers' => array(
          'COLUMNS' => array(
              'modifier_id' => array('UINT', NULL, 'auto_increment'),
              'modifier_name' => array('VCHAR_UNI:255', ''),
              'modifier_desc' => array('MTEXT_UNI', ''),
              'modifier_stat' => array('VCHAR_UNI:255', ''),
              'modifier_effect' => array('BINT', 0),
          ),
          'PRIMARY_KEY' => 'modifier_id',
        ),

        //Aspect join table
        $this->table_prefix . 'dip_modifiers_join' => array(
            'COLUMNS' => array(
                'aspect_id' => array('UINT', 0),
                'entity_id' => array('UINT', 0),
                'organization_id' => array('UINT', 0),
            ),
        ),

        //Entity and organization join table
        $this->table_prefix . 'dip_entity_organization' => array(
          'COLUMNS' => array(
            'entity_id' => array('UINT', 0),
            'organization_id' => array('UINT', 0),
          ),
        ),

        //Entity and player join table
        $this->table_prefix . 'dip_entity_player' => array(
            'COLUMNS' => array(
                'entity_id' => array('UINT', 0),
                'player_id' => array('UINT', 0),
            ),
        ),
      ),
    );
  }


  /**
	 * Add or update data in the database
	 * Set some config and add the modules
	 * @return void
	 * @access public
	 */
  public function update_data()
  {
    return array(
      //config
      array('config.add', array('diplomacy_goodbye', '0')),

      array('module.add', array(
        'acp',
        'ACP_CAT_DOT_MODS',
        'ACP_DIPLOMACY'
      )),

      array('module.add', array(
        'acp',
        'ACP_DIPLOMACY',
        array(
          'module_basename' => '\majortopio\diplomacy\acp\diplomacy_main_module',
          'modes'           =>  array('settings'),
        ),
      )),

      array('module.add', array(
        'acp',
        'ACP_DIPLOMACY',
        array(
          'module_basename' => '\majortopio\diplomacy\acp\diplomacy_entity_module',
          'modes'           =>  array('view'),
        ),
      )),
    );
  }

  //Drop the tables
  public function revert_schema()
  {
    return array(
      'drop_tables'	=> array(
        $this->table_prefix . 'dip_entities',
        $this->table_prefix . 'dip_organizations',
        $this->table_prefix . 'dip_entity_organization',
      ),
    );
  }

}
