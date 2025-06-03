<?php
class ModelExtensionMelhorEnvioShipment extends Model {
    public function getOrderByOrderId($order_id) {
        $query = $this->db->query("
            SELECT
                o.store_id,
                o.currency_code,
                o.telephone,
                o.email,
                o.custom_field,
                o.shipping_firstname,
                o.shipping_lastname,
                o.shipping_postcode,
                o.shipping_address_1,
                o.shipping_address_2,
                o.shipping_city,
                o.shipping_zone_id,
                o.shipping_custom_field,
                o.shipping_code
            FROM
                `" . DB_PREFIX . "order` o
            WHERE
                o.`order_id` = '" . (int) $order_id . "';
        ");

        if ($query->num_rows) {
            $zone_query = $this->db->query("
                SELECT
                    code
                FROM
                    `" . DB_PREFIX . "zone`
                WHERE
                    `zone_id` = '" . (int)$query->row['shipping_zone_id'] . "'
            ");

            if ($zone_query->num_rows) {
                $shipping_zone_code = $zone_query->row['code'];
            } else {
                $shipping_zone_code = '';
            }

            $query->row['shipping_zone_code'] = $shipping_zone_code;

            return $query->row;
        }

        return array();
    }

    public function getOrderProductByOrderId($order_id) {
        $query = $this->db->query("
            SELECT
                op.product_id,
                op.name,
                op.model,
                op.quantity,
                op.price,
                op.tax,
                p.shipping,
                p.width,
                p.height,
                p.length,
                p.weight,
                p.length_class_id,
                p.weight_class_id
            FROM
                `" . DB_PREFIX . "order_product` op
            INNER JOIN
                `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id)
            WHERE
                op.`order_id` = '" . (int) $order_id . "';
        ");

        if ($query->num_rows) {
            return $query->rows;
        }

        return array();
    }

    public function getMelhorEnvioByOrderId($order_id) {
        $query = $this->db->query("
            SELECT
                *
            FROM
                `" . DB_PREFIX . "melhor_envio`
            WHERE
                `order_id` = '" . (int) $order_id . "';
        ");

        if ($query->num_rows) {
            return $query->row;
        }

        return array();
    }

    public function getMelhorEnvioByMelhorEnvioId($melhor_envio_id) {
        $query = $this->db->query("
            SELECT
                me.order_id,
                me.id,
                o.store_id
            FROM
                `" . DB_PREFIX . "melhor_envio` me
            INNER JOIN
                `" . DB_PREFIX . "order` o ON (me.order_id = o.order_id)
            WHERE
                me.`melhor_envio_id` = '" . (int) $melhor_envio_id . "';
        ");

        if ($query->num_rows) {
            return $query->row;
        }

        return array();
    }

    public function addMelhorEnvio($data) {
        $this->db->query("
            INSERT INTO
                `" . DB_PREFIX . "melhor_envio`
            SET
                `order_id` = '" . (int) $data['order_id'] . "',
                `id` = '" . $this->db->escape($data['id']) . "',
                `status` = '" . $this->db->escape($data['status']) . "'
        ");

        return $this->db->getLastId();
    }

    public function editMelhorEnvio($data) {
        $this->db->query("
            UPDATE
                `" . DB_PREFIX . "melhor_envio`
            SET
                `status` = '" . $this->db->escape($data['status']) . "'
            WHERE
                `melhor_envio_id` = '" . (int) $data['melhor_envio_id'] . "'
        ");

        return $this->db->getLastId();
    }

    public function delMelhorEnvio($melhor_envio_id) {
        $this->db->query("
            DELETE FROM
                `" . DB_PREFIX . "melhor_envio`
            WHERE
                `melhor_envio_id` = '" . (int) $melhor_envio_id . "'
        ");
    }
}
