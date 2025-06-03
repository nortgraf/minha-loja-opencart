<?php
/**
 * Módulo Plano de Parcelamento
 * 
 * @author  Cuispi
 * @version 2.4.4
 * @license Commercial License
 * @package admin
 * @subpackage  admin.model.extension.module
 */
class ModelExtensionModulePlanoDeParcelamento extends Model {

/**
 * Constructor.
 *
 * @param object $registry
 * @return void
 */
	public function __construct($registry) {
		parent::__construct($registry);
	}
  
/**
 * Get the last inserted module ID by code.
 *
 * @param string $code
 * @return integer or null The last inserted module
 */
	public function getLastInsertedModuleIdByCode($code) {
		$query = $this->db->query("SELECT MAX(`module_id`) AS `last_inserted_module_id` FROM `" . DB_PREFIX . "module` WHERE `code` = '" . $this->db->escape($code) . "'");

		return $query->row['last_inserted_module_id'];
	}	

  
  /**
   * Update a single setting value.
   *
   * @param string $code
   * @param string $key
   * @param mixed $value
   * @param integer $store_id
   * @return void
   */ 
	public function updateSettingValue($code, $key, $value, $store_id = 0) {
    
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int)$store_id . "' AND `code` = '" . $this->db->escape($code) . "' AND `key` = '" . $this->db->escape($key) . "'");

    if (substr($key, 0, strlen($code)) == $code) {
      if (!is_array($value)) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape($value) . "'");
      } else {
        if ($this->isOC2031orEarlier()) { // for OpenCart 2.0.3.1 or earlier.
          $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(serialize($value)) . "', serialized = '1'");
        } else { // for OpenCart 2.1.0.0 or later.
          $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '" . (int)$store_id . "', `code` = '" . $this->db->escape($code) . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape(json_encode($value)) . "', serialized = '1'");
        }
      }
      
      $query = $this->db->query("SELECT value, serialized FROM `" . DB_PREFIX . "setting` WHERE `code` = '" . $this->db->escape($code) . "' AND `key` = '" . $this->db->escape($key) . "' AND store_id = '0'");

      if ($query->row) {
        if (!$query->row['serialized']) {
          $value = $query->row['value'];
        } else {
          if ($this->isOC2031orEarlier()) { // for OpenCart 2.0.3.1 or earlier.
            $value = unserialize($query->row['value']);
          } else { // for OpenCart 2.1.0.0 or later.
            $value = json_decode($query->row['value']);
          }
        }
        return $value;
      }
    }
    
    return null;
	}  

  /**
   * Checks if OpenCart 2.0.3.1 or earlier
   *
   * @param void
   * @return bool True or false
   */
  public function isOC2031orEarlier() {
    return version_compare(str_replace('_rc1', '.RC.1', VERSION), '2.1.0.0.RC.1', '<');
  }  
  
/**
 * install method 
 *
 * @param void
 * @return boolean True or false
 */ 
	public function install() {
    return true;
	}

/**
 * uninstall method 
 *
 * @param void
 * @return boolean True or false
 */ 
	public function uninstall() {
    return true;
	}
  
/**
 * upgrade method 
 *
 * @param void
 * @return boolean True or false
 */ 
	public function upgrade() {
    return false;
  }

}
