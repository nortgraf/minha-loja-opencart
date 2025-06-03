<?php

class ControllerExtensionModuleMpordertracking extends \Mpordertracking\Controller {
	use Mpordertracking\trait_ordertracking;

	private $error = array();

	public function __construct($registry) {
		parent :: __construct($registry);
		$this->igniteTraitOrderTracking($registry);
	}

	public function install() {
		// create table and other installation stuff like add additional files into permissions list

		$this->createDbTables();
	}

	public function isInstall() {
		$this->load->model($this->model_file['extension/extension']['path']);
		return in_array('mpordertracking', $this->{$this->model_file['extension/extension']['obj']}->getInstalled('module'));
	}

	public function getMenu() {
		$this->load->language('extension/mpordertracking/ordertracking_menu');
		$menu = [];
		if ($this->user->hasPermission('access', 'extension/module/mpordertracking')) {
			$menu = [
				'name'     => $this->language->get('text_ordertracking_config'),
				'href'     => $this->url->link('extension/module/mpordertracking', $this->token.'=' . $this->session->data[$this->token], true),
				'children' => []
			];
		}

		// || !$this->config->get('module_mpordertracking_status')
		if (!$this->isInstall()) {
			return [];
		}
		// make system to show alter message if extension files has no permissions, check if user has modify permissions
		return $menu;
	}

	public function index() {
		$this->load->language('extension/module/mpordertracking');

		$this->document->setTitle($this->language->get('heading_title'));

		// assests starts
		$this->document->addStyle('view/stylesheet/mpordertracking/stylesheet.css');
		// assests ends

		$this->load->model('setting/setting');
		$this->load->model('extension/mpordertracking/trackingcarrier');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_mpordertracking', $this->request->post);
			if (!empty($this->request->post['tracking_carriers'])) {
				foreach ($this->request->post['tracking_carriers'] as $tracking_carrier) {
					$trackingcarrier_info = $this->model_extension_mpordertracking_trackingcarrier->getTrackingCarrier($tracking_carrier['mptracking_carrier_id']);
					if ($trackingcarrier_info) {
						$this->model_extension_mpordertracking_trackingcarrier->editTrackingCarrier($tracking_carrier['mptracking_carrier_id'], $tracking_carrier);
					} else {
						$this->model_extension_mpordertracking_trackingcarrier->addTrackingCarrier($tracking_carrier);
					}
				}
			}

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['stay_here']) && $this->request->post['stay_here'] == 1) {
				$this->response->redirect($this->url->link($this->extension_path.'module/mpordertracking', $this->token.'=' . $this->session->data[$this->token] . '&type=module', true));
			}

			$this->response->redirect($this->url->link($this->extension_page_path, $this->token.'=' . $this->session->data[$this->token] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');

		// Short Codes start
		$data['text_sc_firstname'] = $this->language->get('text_sc_firstname');
		$data['text_sc_lastname'] = $this->language->get('text_sc_lastname');
		$data['text_sc_order_id'] = $this->language->get('text_sc_order_id');
		$data['text_sc_tracking_no'] = $this->language->get('text_sc_tracking_no');
		$data['text_sc_order_status'] = $this->language->get('text_sc_order_status');
		$data['text_sc_order_date_added'] = $this->language->get('text_sc_order_date_added');
		$data['text_sc_tracking_carrier_image'] = $this->language->get('text_sc_tracking_carrier_image');
		$data['text_sc_tracking_carrier_name'] = $this->language->get('text_sc_tracking_carrier_name');
		$data['text_sc_tracking_carrier_url'] = $this->language->get('text_sc_tracking_carrier_url');
		$data['text_sc_tracking_carrier_trackingurl'] = $this->language->get('text_sc_tracking_carrier_trackingurl');
		// Short Codes end

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_url'] = $this->language->get('entry_url');
		$data['entry_tracking_url'] = $this->language->get('entry_tracking_url');
		$data['entry_update_order_status'] = $this->language->get('entry_update_order_status');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_notify'] = $this->language->get('entry_notify');
		$data['entry_override'] = $this->language->get('entry_override');
		$data['entry_comment'] = $this->language->get('entry_comment');
		$data['entry_edit_trackingcode'] = $this->language->get('entry_edit_trackingcode');

		$data['help_override'] = $this->language->get('help_override');
		$data['help_update_order_status'] = $this->language->get('help_update_order_status');
		$data['help_edit_trackingcode'] = $this->language->get('help_edit_trackingcode');
		$data['help_tracking_url'] = $this->language->get('help_tracking_url');

		$data['legend_carriers'] = $this->language->get('legend_carriers');
		$data['legend_order_status'] = $this->language->get('legend_order_status');

		$data['button_stay_here'] = $this->language->get('button_stay_here');
		$data['button_carrier_add'] = $this->language->get('button_carrier_add');
		$data['button_short_codes'] = $this->language->get('button_short_codes');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_support'] = $this->language->get('tab_support');

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
			'href' => $this->url->link('common/dashboard', $this->token.'=' . $this->session->data[$this->token], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link($this->extension_page_path, $this->token.'=' . $this->session->data[$this->token] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/mpordertracking', $this->token.'=' . $this->session->data[$this->token], true)
		);

		$data['token'] = $this->session->data[$this->token];
		$data['get_token'] = $this->token;

		$data['action'] = $this->url->link('extension/module/mpordertracking', $this->token.'=' . $this->session->data[$this->token], true);

		$data['cancel'] = $this->url->link($this->extension_page_path, $this->token.'=' . $this->session->data[$this->token] . '&type=module', true);

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['module_mpordertracking_status'])) {
			$data['module_mpordertracking_status'] = $this->request->post['module_mpordertracking_status'];
		} else {
			$data['module_mpordertracking_status'] = $this->config->get('module_mpordertracking_status');
		}
		if (isset($this->request->post['module_mpordertracking_edit_trackingcode'])) {
			$data['module_mpordertracking_edit_trackingcode'] = $this->request->post['module_mpordertracking_edit_trackingcode'];
		} else {
			$data['module_mpordertracking_edit_trackingcode'] = $this->config->get('module_mpordertracking_edit_trackingcode');
		}

		if (isset($this->request->post['module_mpordertracking_update_order_status'])) {
			$data['module_mpordertracking_update_order_status'] = $this->request->post['module_mpordertracking_update_order_status'];
		} else {
			$data['module_mpordertracking_update_order_status'] = $this->config->get('module_mpordertracking_update_order_status');
		}

		if (isset($this->request->post['module_mpordertracking_order_status_id'])) {
			$data['module_mpordertracking_order_status_id'] = $this->request->post['module_mpordertracking_order_status_id'];
		} else {
			$data['module_mpordertracking_order_status_id'] = $this->config->get('module_mpordertracking_order_status_id');
		}
		if (isset($this->request->post['module_mpordertracking_override'])) {
			$data['module_mpordertracking_override'] = $this->request->post['module_mpordertracking_override'];
		} else {
			$data['module_mpordertracking_override'] = $this->config->get('module_mpordertracking_override');
		}
		if (isset($this->request->post['module_mpordertracking_notify'])) {
			$data['module_mpordertracking_notify'] = $this->request->post['module_mpordertracking_notify'];
		} else {
			$data['module_mpordertracking_notify'] = $this->config->get('module_mpordertracking_notify');
		}
		if (isset($this->request->post['module_mpordertracking_comment'])) {
			$data['module_mpordertracking_comment'] = $this->request->post['module_mpordertracking_comment'];
		} else {
			$data['module_mpordertracking_comment'] = $this->config->get('module_mpordertracking_comment');
		}

		if (isset($this->request->post['tracking_carriers'])) {
			$tracking_carriers = $this->request->post['tracking_carriers'];
		} else {
			$tracking_carriers = $this->model_extension_mpordertracking_trackingcarrier->getTrackingCarriers();
		}

		$this->load->model('tool/image');

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['carriers'] = [];

		foreach ($tracking_carriers as $carrier) {
			if (!empty($carrier['image']) && is_file(DIR_IMAGE . $carrier['image'])) {
				$carrier['thumb'] = $this->model_tool_image->resize($carrier['image'], 100, 100);
			} else {
				$carrier['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			}
			$data['carriers'][] = $carrier;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->viewLoad('extension/module/mpordertracking', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/mpordertracking')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function quickOrderTrackingNoIndex($arg) {

		if (!$this->config->get('module_mpordertracking_status')) {
			return '';
		}

		if (VERSION >= '3.0.0.0') {
			$data['api_token'] = $arg['odata']['api_token'];
		} else {
			$data['api_id'] = $arg['odata']['api_id'];
			$data['api_key'] = $arg['odata']['api_key'];
			$data['api_ip'] = $arg['odata']['api_ip'];
		}

		$this->load->language('extension/mpordertracking/order_trackingno');

		$data['text_loading'] = $this->language->get('text_loading');

		$data['text_quick_addtracking'] = $this->language->get('text_quick_addtracking');

		$data['entry_tracking_no'] = $this->language->get('entry_tracking_no');
		$data['entry_tracking_carrier'] = $this->language->get('entry_tracking_carrier');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_add_tracking'] = $this->language->get('button_add_tracking');
		$data['button_close'] = $this->language->get('button_close');

		$data['token'] = $this->session->data[$this->token];
		$data['get_token'] = $this->token;

		$this->load->model('tool/image');

		$data['tracking_carriers'] = [];

		$this->load->model('extension/mpordertracking/trackingcarrier');
		$tracking_carriers = $this->model_extension_mpordertracking_trackingcarrier->getTrackingCarriers();
		foreach ($tracking_carriers as $tracking_carrier) {
			if ($tracking_carrier['image'] && is_file(DIR_IMAGE . $tracking_carrier['image'])) {
				$tracking_carrier['thumb'] = $this->model_tool_image->resize($tracking_carrier['image'], 50, 50);
			} else {
				$tracking_carrier['thumb'] = $this->model_tool_image->resize('no_image.png', 50, 50);
			}

			$data['tracking_carriers'][] = $tracking_carrier;
		}

		// The URL we send API requests to
		$data['catalog'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

		return $this->viewLoad('extension/mpordertracking/order_trackingno', $data);
	}

	public function getOrderTrackingInfo() {
		$json = [];

		if (isset($this->request->get['get']) && $this->request->get['get'] == 1 && isset($this->request->get['order_id']) && (int)$this->request->get['order_id']) {
			$this->load->language('extension/mpordertracking/order_trackingno');
			$this->load->model('extension/mpordertracking/order');
			$json['order_id'] = $this->request->get['order_id'];
			// ['tracking_no' => '', 'mptracking_carrier_id' => '']
			$json['tracking_info'] = $this->model_extension_mpordertracking_order->getTrackingInfo($this->request->get['order_id']);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function quickTrackingNo() {
		$json = [];
		if (isset($this->request->get['get']) && $this->request->get['get'] == 1) {
			$this->load->language('extension/mpordertracking/order_trackingno');
			$this->load->model('extension/mpordertracking/order');
			if (!$this->user->hasPermission('modify', 'extension/module/mpordertracking')) {
				$json['error']['warning'] = $this->language->get('error_permission');
			}

			if (!isset($json['error'])) {
				if (!isset($this->request->post['order_id']) || (isset($this->request->post['order_id']) && !(int)$this->request->post['order_id'])) {
					$json['error']['warning'] = $this->language->get('error_missing_order_id');
				}
				if (empty($this->request->post['ompt_tracking_no'])) {
					$json['error']['tracking_no'] = $this->language->get('error_missing_tracking_no');
				}
			}
			if (!isset($json['error'])) {
				$tracking_info = $this->model_extension_mpordertracking_order->getTrackingInfo($this->request->post['order_id']);

				$post =	['tracking_no' => $this->request->post['ompt_tracking_no'], 'mptracking_carrier_id' => $this->request->post['ompt_tracking_carrier_id']];

				if ($tracking_info) {
					$this->model_extension_mpordertracking_order->editTrackingNo($this->request->post['order_id'], $post);

				} else {
					$this->model_extension_mpordertracking_order->addTrackingNo($this->request->post['order_id'], $post);
					$json['order_history'] = $this->orderHistoryOnTracking($this->request->post['order_id']);
				}

				$json['success'] = $this->language->get('text_success_tracking_no');
				$json['tracking_no'] = $this->request->post['ompt_tracking_no'];
			}


		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function orderHistoryOnTracking($order_id) {

		if (!$this->config->get('module_mpordertracking_update_order_status')) {
			return [];
		}

		$this->load->model('tool/image');

		$thumb = $this->model_tool_image->resize('no_image.png', 100, 100);
		$mptracking_carrier_id = 0;
		$ompt_tracking_no = '';

		$comment = '';
		$store_id = 0;
		$language_id = (int)$this->config->get('config_language_id');


		$carrier_info = [
			'thumb' => $thumb,
			'image' => '',
			'name' => '',
			'url' => '',
			'tracking_url' => ''
		];

		$this->load->model('extension/mpordertracking/order');
		$tracking_info = $this->model_extension_mpordertracking_order->getTrackingInfo($order_id);
		if ($tracking_info) {
			$ompt_tracking_no = $tracking_info['tracking_no'];
			$mptracking_carrier_id = $tracking_info['mptracking_carrier_id'];
		}


		$this->load->model('extension/mpordertracking/trackingcarrier');
		$mptracking_carrier_info = $this->model_extension_mpordertracking_trackingcarrier->getTrackingCarrier($mptracking_carrier_id);
		if ($mptracking_carrier_info) {
			if ($mptracking_carrier_info['image'] && DIR_IMAGE . $mptracking_carrier_info['image']) {

			$thumb = $this->model_tool_image->resize($mptracking_carrier_info['image'], 100, 100);
			}

			$carrier_info = [
				'thumb' => $thumb,
				'image' => $mptracking_carrier_info['image'],
				'name' => $mptracking_carrier_info['name'],
				'url' => $mptracking_carrier_info['url'],
				'tracking_url' => str_replace('{tracking_no}', $ompt_tracking_no, $mptracking_carrier_info['tracking_url'])
			];

		}

		$order_status = [
			'order_status_id' => '0',
			'language_id' => '0',
			'name' => '',
		];

		$this->load->model('localisation/order_status');
		$order_status_info = $this->model_localisation_order_status->getOrderStatus($this->config->get('module_mpordertracking_order_status_id'));
		if ($order_status_info) {
			$order_status = $order_status_info;
		}

		$this->load->model('sale/order');
		$order_info = $this->model_sale_order->getOrder($order_id);

		$history_post = [];

		if ($order_info) {

			$store_id = $order_info['store_id'];
			$language_id = $order_info['language_id'];

			// $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int)$this->config->get('module_mpordertracking_order_status_id') . "' AND language_id = '" . (int)$order_info['language_id'] . "'");

			// if ($order_status_query->row) {
			// 	$order_status = $order_status_info;
			// }

			$find = [
				'{firstname}',
				'{lastname}',
				'{order_id}',
				'{tracking_no}',
				'{order_status}',
				'{order_date_added}',
				'{tracking_carrier_image}',
				'{tracking_carrier_name}',
				'{tracking_carrier_url}',
				'{tracking_carrier_trackingurl}',
			];

			$replace = [
				'firstname' => $order_info['firstname'],
				'lastname}'  => $order_info['lastname'],
				'order_id' => $order_info['order_id'],
				'tracking_no' => isset($order_info['ompt_tracking_no']) ? $order_info['ompt_tracking_no'] : '',
				'order_status' => $order_status['name'],
				'order_date_added' => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
				'tracking_carrier_image' => $carrier_info['image'] ? '<img src="'. $carrier_info['thumb'] .'" />' : '',
				'tracking_carrier_name' => $carrier_info['name'],
				'tracking_carrier_url' => $carrier_info['url'],
				'tracking_carrier_trackingurl' => $carrier_info['tracking_url'],
			];
			// $comment = str_replace(array("\r\n", "\r", "\n"), "\n", preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), "\n", trim(str_replace($find, $replace, $this->config->get('module_mpordertracking_comment')))));
			$comment = str_replace($find, $replace, $this->config->get('module_mpordertracking_comment'));

			// The URL we send API requests to
			$catalog = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

			$history_post = [
				'order_status_id' => $this->config->get('module_mpordertracking_order_status_id'),
				'notify' => $this->config->get('module_mpordertracking_notify') ? 1 : 0,
				'override' => $this->config->get('module_mpordertracking_override') ? 1 : 0,
				'append' => 0,
				'comment' => $comment,
				'store_id' => $order_info['store_id'],
			];

		}

		return $history_post;


	}
}