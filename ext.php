<?php
/*
 *
 * Diplomacy Engine for phpBB
 * majortopio
 *
 */

 namespace majortopio\diplomacy;

 class ext extends \phpbb\extension\base
 {
   public function is_enableable()
   {
     $config = $this->container->get('config');

     return phpbb_version_compare($config['version'], '3.2.0', '>=') && version_compare(PHP_VERSION, '5.4.0', '>=');
   }
 }
