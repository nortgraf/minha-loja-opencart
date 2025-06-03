<?php
class ControllerExtensionShippingFreteCustomizado extends Controller {
    private $route = 'extension/shipping/frete_customizado';
    private $key_prefix = 'shipping_frete_customizado';

	public function index() {
		$data = $this->load->language($this->route);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate($data)) {
			$this->model_setting_setting->editSetting($this->key_prefix, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($this->route, 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link($this->route, 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true);


        $data[$this->key_prefix .'_status'] = $this->request->post[$this->key_prefix . '_status'] ?? $this->config->get($this->key_prefix . '_status');
        $data[$this->key_prefix .'_sort_order'] = $this->request->post[$this->key_prefix .'_sort_order'] ??  $this->config->get($this->key_prefix .'_sort_order');
        $data[$this->key_prefix .'_shipping_title'] = $this->request->post[$this->key_prefix .'_shipping_title'] ??  $this->config->get($this->key_prefix .'_shipping_title');

        $data[$this->key_prefix .'_fretes'] = $this->request->post[$this->key_prefix .'_fretes'] ??  $this->config->get($this->key_prefix .'_fretes');


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->route, $data));
	}

    /**
     * @param $data
     * @return bool
     */
    protected function validate(&$data) {
        $data['errors'] = false;

		if (!$this->user->hasPermission('modify', $this->route)) {
            $data['warning'] = $this->language->get('error_permission_message');
            return false;
		}

		if (!empty($this->request->post[$this->key_prefix . '_fretes'])) {
		    foreach ($this->request->post[$this->key_prefix . '_fretes'] as $key => $value) {
                $error = $this->validarFrete($value, $key, $data);

                if($error) {
                    return !$error;
                }
            }
        }

        if (empty($this->request->post[$this->key_prefix . '_shipping_title'])) {
            $data['error_shipping_title'] = $this->language->get('error_title_message');
            return false;
        }

        return true;
	}

    /**
     * @param array $frete
     * @param int $index
     * @param array $data
     * @return bool
     */
    private function validarFrete($frete, $index, &$data) {
        $hasError = false;

        if (empty($frete['title'])) {
            $data['error_input_title'][$index] = $this->language->get('error_title_message');
            $hasError = true;
        }

        if (!empty($frete['total']) && intval($frete['total']) < 0) {
            $data['error_input_total'][$index] = $this->language->get('error_total_message');
            $hasError = true;
        }

        if (!empty($frete['minimum']) && intval($frete['minimum']) < 0) {
            $data['error_input_minimum'][$index] = $this->language->get('error_minimum_message');
            $hasError = true;
        }

        if (strlen(preg_replace('/[^0-9]/', '', $frete['start_zipcode'])) !== 8) {
            $data['error_input_start_zipcode'][$index] = $this->language->get('error_start_zipcode_message');
            $hasError = true;
        }

        if (strlen(preg_replace('/[^0-9]/', '', $frete['end_zipcode'])) !== 8) {
            $data['error_input_end_zipcode'][$index] = $this->language->get('error_end_zipcode_message');
            $hasError = true;
        }

        return $hasError;
    }
}
