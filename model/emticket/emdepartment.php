<?php
class ModelEmticketEmdepartment extends Model {
	
	
	public function addDepartment($data) {	
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "emticket_department SET  sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");

		$department_id = $this->db->getLastId();		

		foreach ($data['department_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "emticket_department_description SET department_id = '" . (int)$department_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', small_desc = '" . $this->db->escape($value['small_desc']) . "'");
		}		
	}
	
	public function editDepartment($department_id,$data) {
		
		$this->db->query("Update " . DB_PREFIX . "emticket_department SET  sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE department_id = '" . (int)$department_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "emticket_department_description WHERE department_id = '" . (int)$department_id . "'");

		foreach ($data['department_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "emticket_department_description SET department_id = '" . (int)$department_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', small_desc = '" . $this->db->escape($value['small_desc']) . "'");
		}		
	}	

	public function deleteDepartment($department_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "emticket_department WHERE department_id = '" . (int)$department_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "emticket_department_description WHERE department_id = '" . (int)$department_id . "'");		

		$this->cache->delete('emticket_department');
	}

	public function getDepartment($department_id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "emticket_department WHERE department_id = '" . (int)$department_id . "'");

		return $query->row;
	}

	public function getDepartments($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "emticket_department";
	

		$sort_data = array(
			
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function getDepartmentDescriptions($department_id) {
		$department_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "emticket_department_description WHERE department_id = '" . (int)$department_id . "'");

		foreach ($query->rows as $result) {
			$department_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'small_desc'       => $result['small_desc'],
			);
		}

		return $department_description_data;
	}	

	public function getTotalDepartments() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "emticket_department");

		return $query->row['total'];
	}
}
