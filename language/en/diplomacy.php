<?php
/*
*
* Diplomacy Engine
* majortopio
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
  'ENTITY' => 'Entity',
  'ENTITY_PL' => 'Entities',
	'ENTITY_LC'	=>	'entity',
	'ENTITY_PL_LC'	=> 'entities',
  'ENTITY_PAGE_TITLE' => 'List of Entities',
	'GDP'             => 'Gross Domestic Product',
	'NAME'            => 'Name',
	'POPULATION'      => 'Population',
	'REGION'          => 'Region',
	'CURRENCY_PL'     => 'cubits',
	'ACP_DIPLOMACY'         => 'Diplomacy',
	'ACP_DIPLOMACY_SETTINGS_TITLE'	=> 'Settings',
	'ACP_DIPLOMACY_ENTITY_TITLE'	=>	'Entity',
	'ACP_DIPLOMACY_ENTITY_VIEW_TITLE'	=> 'View Entities',
	'ACP_DIPLOMACY_ENTITY_EDIT_TITLE'	=> 'Edit Entity',
	'DIPLOMACY_GOODBYE'       => 'Should say goodbye?',
	'ACP_DEMO_SETTING_SAVED' => 'Settings have been saved successfully!',
	'ACP_DIPLOMACY_ENTITY_DELETE_LOG'	=> '<strong>Deleted an entity</strong>',
    'ACP_DIPLOMACY_ENTITY_ADD_EDIT_LOG' => '<strong>Added/edited an entity</strong>'
));
