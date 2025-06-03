<?php
class ControllerExtensionModuleD5StatusOrderProduct extends Controller {
    private $error = array();

    public function index() {
        $this->load->language("extension/module/d5statusorderproduct");
        $this->document->setTitle($this->language->get("heading_title"));
        $this->load->model("setting/setting");
        if (($this->request->server["REQUEST_METHOD"] == "POST")) {
            $this->model_setting_setting->editSetting("module_d5statusorderproduct", $this->request->post);
            $this->session->data["success"] = $this->language->get("text_success");
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }
        $data["breadcrumbs"] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_title'),
			'href' => $this->url->link('extension/module/d5statusorderproduct', 'user_token=' . $this->session->data['user_token'], true)
		);
		$data['action'] = $this->url->link('extension/module/d5statusorderproduct', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        $this->load->model("setting /extension");
		
        $data["meios"] = $this->model_setting_extension->getInstalled("payment");
		
        $data["user_token"] = $this->session->data["user_token"];
        $this->load->model("localisation/order_status");
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $fields = $this->getAllFields();

        $data["module_d5statusorderproduct_status"] = isset($this->request->post["module_d5statusorderproduct_status"]) ? $this->request->post["module_d5statusorderproduct_status"] : $this->config->get("module_d5statusorderproduct_status");
        foreach ($fields as $field) {
            if (isset($this->request->post[$field])) {
                $data[$field] = $this->request->post[$field];
            } elseif ($this->config->get($field)) {
                $data[$field] = $this->config->get($field);
            } else {
                $data[$field] = array();
            }
        }

        $data["header"] = $this->load->controller("common/header");
        $data["column_left"] = $this->load->controller("common/column_left");
        $data["footer"] = $this->load->controller("common/footer");
        $this->response->setOutput($this->load->view('extension/module/d5statusorderproduct', $data));
    }
    private function getAllFields() {
        return array(
            "module_d5statusorderproduct_aguardando",
            "module_d5statusorderproduct_pago",
            "module_d5statusorderproduct_problemas",
            "module_d5statusorderproduct_verificacao",
            "module_d5statusorderproduct_ok",
            "module_d5statusorderproduct_reenvio",
            "module_d5statusorderproduct_reupload",
            "module_d5statusorderproduct_preimpresao",
            "module_d5statusorderproduct_producao",
            "module_d5statusorderproduct_reproducao",
            "module_d5statusorderproduct_expedicao",
            "module_d5statusorderproduct_transporte",
            "module_d5statusorderproduct_saiu",
            "module_d5statusorderproduct_retirada",
            "module_d5statusorderproduct_concluido",
            "module_d5statusorderproduct_cancelado"

        );
    }
    public function install()
    {
        $this->db->query(
            "
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "order_status_product` (
			  `order_id` int(15) NOT NULL,
              `product_id` int(15) NOT NULL,
              `status_id` int(11) NOT NULL
			) ENGINE=InnoDB DEFAULT COLLATE=utf8_general_ci
		"
        );
    }
}