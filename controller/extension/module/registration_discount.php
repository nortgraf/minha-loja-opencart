<?php
class ControllerExtensionModuleRegistrationdiscount extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/registration_discount');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_registration_discount', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/registration_discount', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/registration_discount', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_registration_discount_status'])) {
			$data['module_registration_discount_status'] = $this->request->post['module_registration_discount_status'];
		} else {
			$data['module_registration_discount_status'] = $this->config->get('module_registration_discount_status');
		}
		if (isset($this->request->post['module_registration_discount_code'])) {
			$data['module_registration_discount_code'] = $this->request->post['module_registration_discount_code'];
		} else {
			$data['module_registration_discount_code'] = $this->config->get('module_registration_discount_code');
		}
		if (isset($this->request->post['module_registration_discount_email'])) {
			$data['module_registration_discount_email'] = $this->request->post['module_registration_discount_email'];
		} else {
			$data['module_registration_discount_email'] = $this->config->get('module_registration_discount_email');
		}
		$this->load->model('marketing/coupon');
		$filter_data = '';
		$coupons = $this->model_marketing_coupon->getCoupons($filter_data);
		foreach($coupons as $coupon)
		{
			if($coupon['status'] == 1){
				$data['coupons'][]=array(
					'code' =>$coupon['code'],
					'name' =>$coupon['name']
				);

			}
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/registration_discount', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/account')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}