<?php

/*
   ------------------------------------------------------------------------
   FusionInventory
   Copyright (C) 2010-2011 by the FusionInventory Development Team.

   http://www.fusioninventory.org/   http://forge.fusioninventory.org/
   ------------------------------------------------------------------------

   LICENSE

   This file is part of FusionInventory project.

   FusionInventory is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   FusionInventory is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with Behaviors. If not, see <http://www.gnu.org/licenses/>.

   ------------------------------------------------------------------------

   @package   FusionInventory
   @author    Vincent Mazzoni
   @co-author 
   @copyright Copyright (c) 2010-2011 FusionInventory team
   @license   AGPL License 3.0 or (at your option) any later version
              http://www.gnu.org/licenses/agpl-3.0-standalone.html
   @link      http://www.fusioninventory.org/
   @link      http://forge.fusioninventory.org/projects/fusioninventory-for-glpi/
   @since     2010
 
   ------------------------------------------------------------------------
 */

if (!defined('GLPI_ROOT')) {
	die("Sorry. You can't access directly to this file");
}

class PluginFusinvsnmpNetworkEquipmentIP extends PluginFusinvsnmpCommonDBTM {

   function __construct() {
      parent::__construct("glpi_plugin_fusinvsnmp_networkequipmentips");
   }



   /**
    * Add a new ip with the instance values
    *
    *@param $p_id Networking id
    *@return nothing
    **/
   function addDB($p_id) {
      if (count($this->ptcdUpdates)) {
         $this->ptcdUpdates['networkequipments_id']=$p_id;
         $this->add($this->ptcdUpdates);
      }
   }



   // Get all IP of the switch
   function getIP($items_id) {
      $a_ips = $this->find("`networkequipments_id`='".$items_id."'");
      $array = array();
      foreach ($a_ips as $ip) {
         $array[] = $ip['ip'];
      }
      return $array;
   }
   
   
   
   /**
    * Display IP list of a networkequipment
    * 
    * @param type $id id of the network equipment
    */
   static function showIP($id) {
      global $LANG;

      $networkequipmentip = new self;
      
      echo "<table class='tab_cadre' width='950'>";

		echo "<tr class='tab_bg_1'>";
      echo "<th colspan='8'>";
      echo $LANG['networking'][14];
      echo "</th>";
      echo "</tr>";

      $count = 0;

      $a_ip = $networkequipmentip->getIP($id);
      asort($a_ip);
      foreach ($a_ip as $ip) {
         if ($count == '0') {
            echo "<tr class='tab_bg_1'>";
         }
         echo "<td width='118' align='center'>";
         echo $ip;
         echo "</td>";
         $count++;
         if ($count == "8") {
            $count = 0;
            echo "</tr>";
         }
      }
      if (($count != "9") AND ($count != "0")) {
         for ($i=$count; $i < 8; $i++) {
            echo "<td>";
            echo "</td>";
         }
         echo "</tr>";
      }
      echo "</table>";
   }
   
}

?>