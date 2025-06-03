<?php
class ModelEmticketEmstatus extends Model {
	
	
	public function addStatus($data) {
				
		$this->db->query("INSERT INTO " . DB_PREFIX . "emticket_status SET  sort_order = '" . (int)$data['sort_order'] . "',info = '" . json_encode($data['info']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW(), date_added = NOW()");
	}
	
	public function editStatus($id,$data) {		
		
		$this->db->query("Update " . DB_PREFIX . "emticket_status SET  sort_order = '" . (int)$data['sort_order'] . "',info = '" . json_encode($data['info']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE id = '" . (int)$id . "'");
	
	}	

	public function deleteStatus($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "emticket_status WHERE id = '" . (int)$id . "'");
		$this->cache->delete('emticket_status');
	}

	public function getToalTichetByStatus($status) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "emtickets  WHERE ticket_status = '" . (int)$status . "'");

		return $query->row['total'];
	}

	public function getStatus($id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "emticket_status WHERE id = '" . (int)$id . "'");

		return $query->row;
	}

	public function getStatuss($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "emticket_status";
	

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
	

	public function getTotalStatuss() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "emticket_status");

		return $query->row['total'];
	}
}
