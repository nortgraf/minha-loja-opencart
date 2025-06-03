<?php
class ControllerExtensionModuleSmartpopup extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/smart_popup');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_smart_popup', $this->request->post);

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
			'href' => $this->url->link('extension/module/smart_popup', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/smart_popup', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_smart_popup_status'])) {
			$data['module_smart_popup_status'] = $this->request->post['module_smart_popup_status'];
		} else {
			$data['module_smart_popup_status'] = $this->config->get('module_smart_popup_status');
		}
		
		if (isset($this->request->post['module_smart_popup_content'])) {
			$data['module_smart_popup_content'] = $this->request->post['module_smart_popup_content'];
		} else {
			$data['module_smart_popup_content'] = $this->config->get('module_smart_popup_content');
		}

		if (isset($this->request->post['module_smart_popup_checkbox'])) {
			$data['module_smart_popup_checkbox'] = $this->request->post['module_smart_popup_checkbox'];
		} else {
			$data['module_smart_popup_checkbox'] = $this->config->get('module_smart_popup_checkbox');
		}

		if (isset($this->request->post['module_smart_popup_days'])) {
			$data['module_smart_popup_days'] = $this->request->post['module_smart_popup_days'];
		} else {
			$data['module_smart_popup_days'] = $this->config->get('module_smart_popup_days');
		}
		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/smart_popup', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/account')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}