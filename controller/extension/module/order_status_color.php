<?php
class ControllerExtensionModuleOrderStatusColor extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/order_status_color');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('order_status_color', $this->request->post);

			$this->model_setting_setting->editSetting('module_order_status_color', array('module_order_status_color_status' => $this->request->post['order_status_color_status']));

			$this->session->data['success'] = $this->language->get('text_success');

			if(!empty($this->request->post['savetype']) && $this->request->post['savetype'] == 'savechanges') {
				$this->response->redirect($this->url->link('extension/module/order_status_color', 'user_token=' . $this->session->data['user_token'], 'SSL'));
			}else{
				$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
			}
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_color'] = $this->language->get('tab_color');
		$data['tab_support'] = $this->language->get('tab_support');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_front_list'] = $this->language->get('text_front_list');
		$data['text_checkbox'] = $this->language->get('text_checkbox');
		$data['text_admin_list'] = $this->language->get('text_admin_list');
		$data['text_dropdown'] = $this->language->get('text_dropdown');

		$data['placeholder_title'] = $this->language->get('placeholder_title');
		$data['placeholer_button'] = $this->language->get('placeholer_button');

		$data['entry_background_color'] = $this->language->get('entry_background_color');
		$data['entry_font_color'] = $this->language->get('entry_font_color');
		$data['entry_mstatus'] = $this->language->get('entry_mstatus');
		$data['entry_dstatus'] = $this->language->get('entry_dstatus');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_display'] = $this->language->get('entry_display');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_savechanges'] = $this->language->get('button_savechanges');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/order_status_color', 'user_token=' . $this->session->data['user_token'], 'SSL')
		);

		$data['action'] = $this->url->link('extension/module/order_status_color', 'user_token=' . $this->session->data['user_token'], 'SSL');

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['order_status_color_status'])) {
			$data['order_status_color_status'] = $this->request->post['order_status_color_status'];
		} else {
			$data['order_status_color_status'] = $this->config->get('order_status_color_status');
		}

		if (isset($this->request->post['order_status_color_picker'])) {
			$data['order_status_color_picker'] = $this->request->post['order_status_color_picker'];
		} else {
			$data['order_status_color_picker'] = $this->config->get('order_status_color_picker');
		}

		if (isset($this->request->post['order_status_color_display'])) {
			$data['order_status_color_display'] = $this->request->post['order_status_color_display'];
		} else {
			$data['order_status_color_display'] = ($this->config->get('order_status_color_display')) ? $this->config->get('order_status_color_display') : array();
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/order_status_color', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/order_status_color')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
}