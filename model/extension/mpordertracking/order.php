<?php
class ModelExtensionMpordertrackingOrder extends \Mpordertracking\Model {

	public function getTrackingNo($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_mptracking` WHERE `order_id` = '" . (int)$order_id . "'");
		$tracking_no = '';
		if ($query->num_rows) {
			$tracking_no = $query->row['tracking_no'];
		}
		return $tracking_no;
	}
	public function getTrackingInfo($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_mptracking` WHERE `order_id` = '" . (int)$order_id . "'");
		return $query->row;
	}
	public function addTrackingNo($order_id, $data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "order_mptracking` SET `order_id` = '" . (int)$order_id . "', `tracking_no` = '" . $this->db->escape($data['tracking_no']) . "', `mptracking_carrier_id` = '" . $this->db->escape($data['mptracking_carrier_id']) . "'");
	}
	public function editTrackingNo($order_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "order_mptracking` SET `tracking_no` = '" . $this->db->escape($data['tracking_no']) . "', `mptracking_carrier_id` = '" . $this->db->escape($data['mptracking_carrier_id']) . "' WHERE `order_id` = '" . (int)$order_id . "'");
	}
}
