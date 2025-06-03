<?php
class ModelEmticketEmpriority extends Model {
	
	
	public function addPriority($data) {
				
		$this->db->query("INSERT INTO " . DB_PREFIX . "emticket_priority SET  sort_order = '" . (int)$data['sort_order'] . "',info = '" . json_encode($data['info']) . "', status = '" . (int)$data['status'] . "'");
	}
	
	public function editPriority($id,$data) {		
		
		$this->db->query("Update " . DB_PREFIX . "emticket_priority SET  sort_order = '" . (int)$data['sort_order'] . "',info = '" . json_encode($data['info']) . "', status = '" . (int)$data['status'] . "' WHERE priority_id = '" . (int)$id . "'");
	
	}	

	public function deletePriority($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "emticket_priority WHERE priority_id = '" . (int)$id . "'");
		$this->cache->delete('emticket_priority');
	}

	public function getPriority($id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "emticket_priority WHERE priority_id = '" . (int)$id . "'");

		return $query->row;
	}

	public function getPrioritys($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "emticket_priority";
	

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
	

	public function getTotalPrioritys() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "emticket_priority");

		return $query->row['total'];
	}
}
