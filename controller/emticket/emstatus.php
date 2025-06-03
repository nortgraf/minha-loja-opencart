<?php
class ControllerEmticketEmstatus extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('emticket/emstatus');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('emticket/emstatus');

		$this->getList();
	}

	public function add() {
		$this->load->language('emticket/emstatus');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('emticket/emstatus');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->model_emticket_emstatus->addStatus($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('emticket/emstatus', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('emticket/emstatus');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('emticket/emstatus');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_emticket_emstatus->editStatus($this->request->get['id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('emticket/emstatus', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('emticket/emstatus');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('emticket/emstatus');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $department_id) {
				$this->model_emticket_emstatus->deleteStatus($department_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('emticket/emstatus', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('emticket/emstatus', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('emticket/emstatus/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('emticket/emstatus/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['statuss'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		$language_id =	(int)$this->config->get('config_language_id');
		$status_total = $this->model_emticket_emstatus->getTotalStatuss();

		$results = $this->model_emticket_emstatus->getStatuss($filter_data);

		  foreach ($results as $result) {
			
			$info =	json_decode($result['info'], true);
			
			$label_bg = "transparent";
			$label_clr = "#000";
			if(isset($info['label_bg'])){
				$label_bg = $info['label_bg'];
			}
			if(isset($info['label_clr'])){
				$label_clr = $info['label_clr'];
			}
			
			 $data['statuss'][] = array(
				 'id' => $result['id'],
				 'name'            => $info[$language_id]['name'],
				 'sort_order'      => $result['sort_order'],
				 'label_clr'      => $label_clr,
				 'label_bg'      => $label_bg,
				 'edit'            => $this->url->link('emticket/emstatus/edit', 'user_token=' . $this->session->data['user_token'] . '&id=' . $result['id'] . $url, true)
			 );
		 } 

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

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

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('emticket/emstatus', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('emticket/emstatus', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $status_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('emticket/emstatus', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($status_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($status_total - $this->config->get('config_limit_admin'))) ? $status_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $status_total, ceil($status_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;
		
		
		$data['emlogo'] = "view/image/em-logo.png";

		$data['header'] = $this->load->controller('common/header');
		$data['commonhead'] = $this->load->controller('emticket/commonhead');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('emticket/emstatus_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['department_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_small_desc'] = $this->language->get('entry_small_desc');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_label_bg'] = $this->language->get('entry_label_bg');
		$data['entry_label_clr'] = $this->language->get('entry_label_clr');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');

		$data['help_keyword'] = $this->language->get('help_keyword');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('emticket/emstatus', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (!isset($this->request->get['id'])) {
			$data['action'] = $this->url->link('emticket/emstatus/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('emticket/emstatus/edit', 'user_token=' . $this->session->data['user_token'] . '&id=' . $this->request->get['id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('emticket/emstatus', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$status_info = $this->model_emticket_emstatus->getStatus($this->request->get['id']);
		}
		
		$data['user_token'] = $this->session->data['user_token'];
		
		
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($status_info)) {
			$data['sort_order'] = $status_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
					
		
		if (isset($this->request->post['info'])) {
			$data['info'] = $this->request->post['info'];
		} elseif (isset($this->request->get['id'])) {
			$data['info'] = json_decode($status_info['info'], true);
		} else {
			$data['info'] = array();
			$data['info']['label_bg'] = "";
			$data['info']['label_clr'] = "";
		}
	

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($status_info)) {
			$data['status'] = $status_info['status'];
		} else {
			$data['status'] = '';
		}
		
		$data['emlogo'] = "view/image/em-logo.png";

		$data['header'] = $this->load->controller('common/header');
		$data['commonhead'] = $this->load->controller('emticket/commonhead');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('emticket/emstatus_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'emticket/emstatus')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		foreach ($this->request->post['info'] as $language_id => $value) {
			if(is_array($value)):
				if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
					$this->error['name'][$language_id] = $this->language->get('error_name');
				}
			endif;
		}

		return !$this->error;
	}

	protected function validateDelete() {
		
		if (!$this->user->hasPermission('modify', 'emticket/emstatus')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

}