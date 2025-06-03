<?php
class ModelExtensionShippingMelhorEnvio extends Model {
    public function install() {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "melhor_envio` (
                `melhor_envio_id` INT(11) NOT NULL AUTO_INCREMENT,
                `order_id` INT(11) NOT NULL,
                `id` VARCHAR(36) NOT NULL,
                `status` VARCHAR(15) NOT NULL,
                PRIMARY KEY (`melhor_envio_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
        ");
    }

    public function update() {
        $this->install();

        $table = DB_PREFIX . 'melhor_envio';
        $column_primary = 'melhor_envio_id';
        $columns = array(
            'melhor_envio_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            'order_id' => 'INT(11) NOT NULL',
            'id' => 'VARCHAR(36) NOT NULL',
            'status' => 'VARCHAR(15) NOT NULL',
        );
        $this->upgrade($table, $columns, $column_primary);
    }

    private function upgrade($table, $columns_reference, $column_primary) {
        $query = $this->db->query("SHOW COLUMNS FROM `" . $table . "`");
        if (!$query->num_rows) { return; }

        $current_columns = array();
        foreach ($query->rows as $column) {
            $current_columns[$column['Field']] = $column['Type'];
        }

        foreach ($current_columns as $column => $type) {
            if (!array_key_exists($column, $columns_reference) && $column != $column_primary) {
                $this->db->query("ALTER TABLE `" . $table . "` DROP COLUMN `" . $column . "`");
            }
        }

        $this->session->data['after_column'] = $column_primary;

        foreach ($columns_reference as $column => $type) {
            if (!array_key_exists($column, $current_columns)) {
                if ($column == $column_primary) {
                    $this->db->query("ALTER TABLE `" . $table . "` ADD `" . $column . "` " . $type . " FIRST, add PRIMARY KEY (`" . $column . "`)");
                } else {
                    $this->db->query("ALTER TABLE `" . $table . "` ADD `" . $column . "` " . $type . " AFTER `" . $this->session->data['after_column'] . "`");
                }
            } else {
                $this->db->query("ALTER TABLE `" . $table . "` CHANGE COLUMN `" . $column . "` `" . $column . "` " . $type . "");
            }

            $this->session->data['after_column'] = $column;
        }

        unset($this->session->data['after_column']);
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "melhor_envio`;");
    }
}
