<?php
class ModelExtensionPaymentItauShopline extends Model {
    public function install() {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "order_itaushopline` (
                `order_itaushopline_id` INT(11) NOT NULL AUTO_INCREMENT,
                `order_id` INT(11) NULL,
                `tippag` VARCHAR(2) NULL,
                `valor` DECIMAL(10,2) NULL,
                `dtpag` VARCHAR(8) NULL,
                `codaut` VARCHAR(6) NULL,
                `numid` VARCHAR(40) NULL,
                `compvend` VARCHAR(9) NULL,
                `tipcart` VARCHAR(1) NULL,
                `sitpag` VARCHAR(2) NULL,
                `dc` TEXT NULL,
                PRIMARY KEY (`order_itaushopline_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
        ");
    }

    public function update() {
        $this->install();

        $fields = array(
            'order_itaushopline_id' => 'int(11)',
            'order_id' => 'int(11)',
            'tippag' => 'varchar(2)',
            'valor' => 'decimal(10,2)',
            'dtpag' => 'varchar(8)',
            'codaut' => 'varchar(6)',
            'numid' => 'varchar(40)',
            'compvend' => 'varchar(9)',
            'tipcart' => 'varchar(1)',
            'sitpag' => 'varchar(2)',
            'dc' => 'text'
        );

        $table = DB_PREFIX . "order_itaushopline";

        $field_query = $this->db->query("SHOW COLUMNS FROM `" . $table . "`");
        foreach ($field_query->rows as $field) {
            $field_data[$field['Field']] = $field['Type'];
        }

        foreach ($field_data as $key => $value) {
            if (!array_key_exists($key, $fields)) {
                $this->db->query("ALTER TABLE `" . $table . "` DROP COLUMN `" . $key . "`");
            }
        }

        $this->session->data['after_column'] = 'order_itaushopline_id';
        foreach ($fields as $key => $value) {
            if (!array_key_exists($key, $field_data)) {
                $this->db->query("ALTER TABLE `" . $table . "` ADD `" . $key . "` " . $value . " AFTER `" . $this->session->data['after_column'] . "`");
            }
            $this->session->data['after_column'] = $key;
        }
        unset($this->session->data['after_column']);

        foreach ($fields as $key => $value) {
            if ($key == 'order_itaushopline_id') {
                $this->db->query("ALTER TABLE `" . $table . "` CHANGE COLUMN `" . $key . "` `" . $key . "` " . $value . " NOT NULL AUTO_INCREMENT");
            } else {
                $this->db->query("ALTER TABLE `" . $table . "` CHANGE COLUMN `" . $key . "` `" . $key . "` " . $value);
            }
        }
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "order_itaushopline`;");
    }

    public function getOrderColumns() {
        $query = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "order`");

        return $query->rows;
    }

    public function getTransactions() {
        $query = $this->db->query("
            SELECT oi.order_itaushopline_id, oi.order_id, o.date_added, CONCAT(o.firstname, ' ', o.lastname) as customer, oi.tippag, oi.sitpag, oi.dtpag, oi.valor, oi.codaut, oi.numid, oi.tipcart
            FROM `" . DB_PREFIX . "order_itaushopline` oi
            INNER JOIN `" . DB_PREFIX . "order` o ON (o.order_id = oi.order_id)
            WHERE oi.order_id > '0'
            ORDER BY oi.order_id DESC
            LIMIT 3000;
        ");

        return $query->rows;
    }

    public function getStoreID($order_id) {
        $query = $this->db->query("
            SELECT store_id
            FROM `" . DB_PREFIX . "order`
            WHERE `order_id` = '" . (int) $order_id . "';
        ");

        if ($query->num_rows) {
            return $query->row['store_id'];
        }

        return '0';
    }

    public function editTransaction($data) {
        $this->db->query("
            UPDATE " . DB_PREFIX . "order_itaushopline
            SET valor = '" . $this->db->escape($data['valor']) . "',
                tippag = '" . $this->db->escape($data['tippag']) . "',
                sitpag = '" . $this->db->escape($data['sitpag']) . "',
                dtpag = '" . $this->db->escape($data['dtpag']) . "',
                codaut = '" . $this->db->escape($data['codaut']) . "',
                numid = '" . $this->db->escape($data['numid']) . "',
                compvend = '" . $this->db->escape($data['compvend']) . "',
                tipcart = '" . $this->db->escape($data['tipcart']) . "'
            WHERE order_id = '" . (int) $data['order_id'] . "'
        ");
    }

    public function deleteTransaction($itaushopline_id) {
        $this->db->query("
            DELETE FROM `" . DB_PREFIX . "order_itaushopline`
            WHERE order_itaushopline_id = '" . (int) $itaushopline_id . "'
        ");
    }
}