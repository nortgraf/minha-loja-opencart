<?php
class ModelExtensionPaymentCielo extends Model {
    public function getColumns($data = array()) {
        $sql = "SHOW COLUMNS FROM `" . DB_PREFIX . "order`";

        $query = $this->db->query($sql);

        return $query->rows;
    }
}