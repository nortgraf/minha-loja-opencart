<?php
class ControllerExtensionTotalAVista extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/total/avista');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('total_avista', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=total', true));
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
 			'text' => $this->language->get('text_total'),
 			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=total', true)
 		);

 		$data['breadcrumbs'][] = array(
     	'text' => $this->language->get('heading_title'),
     	'href' => $this->url->link('extension/total/avista', 'user_token=' . $this->session->data['user_token'], true)
 		);

		$data['action'] = $this->url->link('extension/total/avista', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=total', true);

		if (isset($this->request->post['total_avista_status'])) {
			$data['total_avista_status'] = $this->request->post['total_avista_status'];
		} else {
			$data['total_avista_status'] = $this->config->get('total_avista_status');
		}

		if (isset($this->request->post['total_avista_sort_order'])) {
			$data['total_avista_sort_order'] = $this->request->post['total_avista_sort_order'];
		} else {
			$data['total_avista_sort_order'] = $this->config->get('total_avista_sort_order');
		}

		if (isset($this->request->post['total_avista_total'])) {
			$data['total_avista_total'] = $this->request->post['total_avista_total'];
		} else {
			$data['total_avista_total'] = $this->config->get('total_avista_total');
		}

		if (isset($this->request->post['total_avista_methods'])) {
			$data['total_avista_methods'] = $this->request->post['total_avista_methods'];
		} else {
			$data['total_avista_methods'] = $this->config->get('total_avista_methods');
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_methods'] = $this->language->get('entry_methods');
		$data['help_methods'] = $this->language->get('help_methods');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/total/avista', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/total/avista')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
?>
