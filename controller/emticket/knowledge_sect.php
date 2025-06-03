<?php
class ControllerEmticketKnowledgesect extends Controller {
	private $error = array();

	public function index() {
		
		$this->install();
		$this->load->language('emticket/knowledge_sect');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('emticket/knowledgebase');
		$this->getList();
		
	}	
	
	public function add() {
		$this->load->language('emticket/knowledge_sect');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('emticket/knowledgebase');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			//print_r($this->request->post);die();
			
			$this->model_emticket_knowledgebase->add_Section($this->request->post);
			
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
			$this->response->redirect($this->url->link('emticket/knowledge_sect', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}
	
	
	public function edit() {
		$this->load->language('emticket/knowledge_sect');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('emticket/knowledgebase');

		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {			
						
			$this->model_emticket_knowledgebase->edit_Section($this->request->get['section_id'],$this->request->post);	
			
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

			$this->response->redirect($this->url->link('emticket/knowledge_sect', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}
	
		
	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['section_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_order'] = $this->language->get('entry_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		
		

		$data['help_filter'] = $this->language->get('help_filter');
		

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_design'] = $this->language->get('tab_design');

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
		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}
		if (isset($this->error['sort'])) {
			$data['error_sort'] = $this->error['sort'];
		} else {
			$data['error_sort'] = array();
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
			'href' => $this->url->link('emticket/knowledge_sect', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['section_id'])) {
			$data['action'] = $this->url->link('emticket/knowledge_sect/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} 
		else {
			$data['action'] = $this->url->link('emticket/knowledge_sect/edit', 'user_token=' . $this->session->data['user_token'] . '&section_id=' . $this->request->get['section_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('emticket/knowledge_sect', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['section_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			
			$category_info = $this->model_emticket_knowledgebase->getSection($this->request->get['section_id']);
			
		}

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($category_info)) {
			$data['sort_order'] = $category_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($category_info)) {
			$data['status'] = $category_info['status'];
		} else {
			$data['status'] = '';
		}
		
		if (isset($this->request->post['knowledge_section_description'])) {
			$data['knowledge_section_description'] = $this->request->post['knowledge_section_description'];
		} elseif (isset($this->request->get['section_id'])) {
			$data['knowledge_section_description'] = $this->model_emticket_knowledgebase->getSectiondescription($this->request->get['section_id']);
		} else {
			$data['knowledge_section_description'] = array();
		}
		
		// image
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($category_info)) {
			$data['image'] = $category_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($category_info) && is_file(DIR_IMAGE . $category_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($category_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		// image
		
		$data['emlogo'] = "view/image/em-logo.png";
		
		
		$data['header'] = $this->load->controller('common/header');
		$data['commonhead'] = $this->load->controller('emticket/commonhead');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('emticket/knowledge_sect_form', $data));
	
	}	
	
	public function delete() {
		$this->load->language('emticket/knowledge_sect');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('emticket/knowledgebase');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $section_id) {
				$this->model_emticket_knowledgebase->deleteSection($section_id);
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

			$this->response->redirect($this->url->link('emticket/knowledge_sect', 'user_token=' . $this->session->data['user_token'] . $url, true));
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
			'href' => $this->url->link('emticket/knowledge_sect', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('emticket/knowledge_sect/add', 'user_token=' . $this->session->data['user_token'] . $url, true);	
		$data['delete'] = $this->url->link('emticket/knowledge_sect/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['section'] = array();		

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$contact_total = $this->model_emticket_knowledgebase->getTotalContact();

		$results = $this->model_emticket_knowledgebase->getSections($filter_data);
	
		foreach ($results as $result) {
			$data['section'][] = array(
				'section_id' => $result['section_id'],
				'name'            => $result['name'],
				'sort_order'            => $result['sort_order'],
				'date_added'            => $result['date_added'],
				'status'            => $result['status'],
				'edit'            => $this->url->link('emticket/knowledge_sect/edit', 'user_token=' . $this->session->data['user_token'] . '&section_id=' . $result['section_id'] . $url, true)
			);
		}	
		
	
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_category'] = $this->language->get('column_category');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_status'] = $this->language->get('column_status');
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

		$data['sort_name'] = $this->url->link('emticket/knowledge_sect', 'user_token=' . $this->session->data['user_token'] . '&sort=mmcategory' . $url, true);
		$data['sort_sort_order'] = $this->url->link('emticket/knowledge_sect', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_order' . $url, true);
		$data['sort_date_added'] = $this->url->link('emticket/knowledge_sect', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $contact_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('emticket/knowledge_sect', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($contact_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($contact_total - $this->config->get('config_limit_admin'))) ? $contact_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $contact_total, ceil($contact_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;
		
		$data['emlogo'] = "view/image/em-logo.png";		
		
		$data['header'] = $this->load->controller('common/header');
		$data['commonhead'] = $this->load->controller('emticket/commonhead');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('emticket/knowledge_sect', $data));
	}
	
	protected function validateForm() {
		 if (!$this->user->hasPermission('modify', 'emticket/knowledge_sect')) {
			$this->error['warning'] = $this->language->get('error_permission');
		 }

		foreach ($this->request->post['knowledge_section_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
			
			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
			
			
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

	

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'emticket/knowledge_sect')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}		

		return !$this->error;
	}
	
	
	protected function install(){
        $this->load->model('emticket/knowledgebase');
        //$this->model_emticket_knowledgebase->install();
    }
    
   


}