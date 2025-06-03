<?php
class ControllerExtensionModuleD5MinhaConta extends Controller {
    private $error = array();

    public function index() {
        $this->load->language("extension/module/d5minhaconta");
        $this->document->setTitle($this->language->get("heading_title"));
        $this->load->model("setting/setting");
        if (($this->request->server["REQUEST_METHOD"] == "POST")) {
            $this->model_setting_setting->editSetting("module_d5minhaconta", $this->request->post);
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
			'href' => $this->url->link('extension/module/d5minhaconta', 'user_token=' . $this->session->data['user_token'], true)
		);
		$data['action'] = $this->url->link('extension/module/d5minhaconta', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        $this->load->model("setting /extension");
		
        $data["meios"] = $this->model_setting_extension->getInstalled("payment");
		
        $data["user_token"] = $this->session->data["user_token"];
        $this->load->model("localisation/order_status");
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $fields = $this->getAllFields();

        $data["module_d5minhaconta_status"] = isset($this->request->post["module_d5minhaconta_status"]) ? $this->request->post["module_d5minhaconta_status"] : $this->config->get("module_d5minhaconta_status");
        $data["module_d5minhaconta_exibirstatus"] = isset($this->request->post["module_d5minhaconta_exibirstatus"]) ? $this->request->post["module_d5minhaconta_exibirstatus"] : $this->config->get("module_d5minhaconta_exibirstatus");
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
        $this->response->setOutput($this->load->view('extension/module/d5minhaconta', $data));
    }
    private function getAllFields() {
        return array(
            "module_d5minhaconta_aguardando",
            "module_d5minhaconta_pago",
            "module_d5minhaconta_preparando",
            "module_d5minhaconta_enviado",
            "module_d5minhaconta_cancelado",
            "module_d5minhaconta_entregue"

        );
    }
}