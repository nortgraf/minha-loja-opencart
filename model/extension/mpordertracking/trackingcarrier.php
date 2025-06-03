<?php
class ModelExtensionMpordertrackingTrackingCarrier extends \Mpordertracking\Model {
	public function addTrackingCarrier($data) {

		$this->db->query("INSERT INTO `" . DB_PREFIX . "mptracking_carrier` SET `name` = '" . $this->db->escape($data['name']) . "', `image` = '" . $this->db->escape($data['image']) . "', url = '" .  $this->db->escape($data['url']) . "', tracking_url = '" .  $this->db->escape($data['tracking_url']) . "'");

		$mptracking_carrier_id = $this->db->getLastId();

		return $mptracking_carrier_id;
	}

	public function editTrackingCarrier($mptracking_carrier_id, $data) {

		$this->db->query("UPDATE `" . DB_PREFIX . "mptracking_carrier` SET `name` = '" . $this->db->escape($data['name']) . "', `image` = '" . $this->db->escape($data['image']) . "', url = '" .  $this->db->escape($data['url']) . "', tracking_url = '" .  $this->db->escape($data['tracking_url']) . "' WHERE mptracking_carrier_id = '" . (int)$mptracking_carrier_id . "'");
	}

	public function deleteTrackingCarrier($mptracking_carrier_id) {

		$this->db->query("DELETE FROM `" . DB_PREFIX . "mptracking_carrier` WHERE mptracking_carrier_id = '" . (int)$mptracking_carrier_id . "'");
	}

	public function getTrackingCarrier($mptracking_carrier_id) {

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mptracking_carrier` WHERE mptracking_carrier_id = '" . (int)$mptracking_carrier_id . "'");

		return $query->row;
	}

	public function getTrackingCarriers($data=[]) {

		$sql = "SELECT * FROM `" . DB_PREFIX . "mptracking_carrier` WHERE mptracking_carrier_id > 0 ";

		if (isset($data['name']) && $data['name']) {
			$sql .= " AND `name` LIKE '". $this->db->escape($data['name']) ."%'";
		}
		if (isset($data['url']) && $data['url']) {
			$sql .= " AND `url` = '". $this->db->escape($data['url']) ."'";
		}
		if (isset($data['tracking_url']) && $data['tracking_url']) {
			$sql .= " AND `tracking_url` = '". $this->db->escape($data['tracking_url']) ."'";
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
}
