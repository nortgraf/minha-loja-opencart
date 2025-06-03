<?php
class ControllerEmticketArticle extends Controller {
	private $error = array();

	public function index() {
		
		$this->install();
		$this->load->language('emticket/article');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('emticket/knowledgebase');
		$this->getList();
		
	}
	
	
	public function add() {
		$this->load->language('emticket/article');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('emticket/knowledgebase');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {			

		//	print_r($this->request->post);die();
			
			$this->model_emticket_knowledgebase->addArticle($this->request->post);
			
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
			$this->response->redirect($this->url->link('emticket/article', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}
	
	
	public function edit() {
		$this->load->language('emticket/article');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('emticket/knowledgebase');

		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {				
			
			$this->model_emticket_knowledgebase->editArticle($this->request->get['article_id'],$this->request->post);	
			
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

			$this->response->redirect($this->url->link('emticket/article', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}
	
	
	
	
	protected function getForm() {
	
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['mmfaqcat_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');		
		$data['text_select'] = $this->language->get('text_select');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');		
		
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_answer'] = $this->language->get('entry_answer');
		$data['entry_order'] = $this->language->get('entry_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_section'] = $this->language->get('entry_section');
		

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		
		
		$data['sections'] = $this->model_emticket_knowledgebase->getSectionz();		
		
		
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
		
		if (isset($this->error['section_id'])) {
			$data['error_section_id'] = $this->error['section_id'];
		} else {
			$data['error_section_id'] = "";
		}
		
		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = "";
		}
		
		if (isset($this->error['sort'])) {
			$data['error_sort'] = $this->error['sort'];
		} else {
			$data['error_sort'] = "";
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
			'href' => $this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);
		
		
		if (!isset($this->request->get['article_id'])) {
			$data['action'] = $this->url->link('emticket/article/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} 
		else {
			$data['action'] = $this->url->link('emticket/article/edit', 'user_token=' . $this->session->data['user_token'] . '&article_id=' . $this->request->get['article_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('emticket/article', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['article_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {		
			$faq_info = $this->model_emticket_knowledgebase->getArticle($this->request->get['article_id']);			
		}
		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['article_description'])) {
			$data['article_description'] = $this->request->post['article_description'];
		} elseif (isset($this->request->get['article_id'])) {
			$data['article_description'] = $this->model_emticket_knowledgebase->getArticleDescriptions($this->request->get['article_id']);
		} else {
			$data['article_description'] = array();
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($faq_info)) {
			$data['sort_order'] = $faq_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['section_id'])) {
			$data['section_id'] = $this->request->post['section_id'];
		} elseif (!empty($faq_info)) {
			$data['section_id'] = $faq_info['section_id'];
		} else {
			$data['section_id'] = '';
		}

				
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($faq_info)) {
			$data['status'] = $faq_info['status'];
		} else {
			$data['status'] = '';
		}
		
		$data['emlogo'] = "view/image/em-logo.png";

		$data['header'] = $this->load->controller('common/header');
		$data['commonhead'] = $this->load->controller('emticket/commonhead');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('emticket/article_form', $data));
	}
	
	
	public function delete() {
		$this->load->language('emticket/article');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('emticket/knowledgebase');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $article_id) {
				$this->model_emticket_knowledgebase->deleteArticle($article_id);
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

			$this->response->redirect($this->url->link('emticket/article', 'user_token=' . $this->session->data['user_token'] . $url, true));
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
			'href' => $this->url->link('emticket/article', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('emticket/article/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('emticket/article/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['contacts'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$getTotalArticles=$this->model_emticket_knowledgebase->getTotalArticles();
		$results = $this->model_emticket_knowledgebase->getArticles($filter_data);
		
	
		 foreach ($results as $result) {
				$category_name = $this->model_emticket_knowledgebase->getSecNameBySectionId($result['section_id']);
			$data['articles'][] = array(
				'article_id' => $result['article_id'],
				
				'name'            => $result['name'],						
				'section'            => $category_name,
				'status'            => $result['status'],
				'sort'            => $result['sort_order'],
				'date_added'            => $result['date_added'],
				'edit'            => $this->url->link('emticket/article/edit', 'user_token=' . $this->session->data['user_token'] . '&article_id=' . $result['article_id'] . $url, true)
			);
		} 

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		

		$data['column_quename'] = $this->language->get('column_quename');
		$data['column_faqcat'] = $this->language->get('column_faqcat');
		$data['column_faqstatus'] = $this->language->get('column_faqstatus');
		$data['column_faqsort'] = $this->language->get('column_faqsort');
		$data['column_faqaction'] = $this->language->get('column_faqaction');
		$data['column_date_added'] = $this->language->get('column_date_added');
		
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

		$data['sort_name'] = $this->url->link('emticket/article', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
		$data['sort_status'] = $this->url->link('emticket/article', 'user_token=' . $this->session->data['user_token'] . '&sort=status' . $url, true);
		$data['sort_date_added'] = $this->url->link('emticket/article', 'user_token=' . $this->session->data['user_token'] . '&sort=date_added' . $url, true);
		$data['sort_sort_order'] = $this->url->link('emticket/article', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $getTotalArticles;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('emticket/article', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($getTotalArticles) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($getTotalArticles - $this->config->get('config_limit_admin'))) ? $getTotalArticles : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $getTotalArticles, ceil($getTotalArticles / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;
		
		$data['emlogo'] = "view/image/em-logo.png";

		$data['header'] = $this->load->controller('common/header');
		$data['commonhead'] = $this->load->controller('emticket/commonhead');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('emticket/article_list', $data));
	}

	

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'emticket/article')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}	

		return !$this->error;
	}
	
	protected function validateForm() {
		 if (!$this->user->hasPermission('modify', 'emticket/article')) {
			$this->error['warning'] = $this->language->get('error_permission');
		 }
		 
		 foreach ($this->request->post['article_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
			
			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
			
			
		}

		
			if (($this->request->post['section_id']=="")) {
				$this->error['section_id'] = $this->language->get('error_section_id');
			}
		

		/* if (isset($this->request->get['category_id']) && $this->request->post['parent_id']) {
			$results = $this->model_catalog_category->getCategoryPath($this->request->post['parent_id']);
			
			foreach ($results as $result) {
				if ($result['path_id'] == $this->request->get['category_id']) {
					$this->error['parent'] = $this->language->get('error_parent');
					
					break;
				}
			}
		} */

		/* if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['category_id']) && $url_alias_info['query'] != 'category_id=' . $this->request->get['category_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['category_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		} */
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}
	
	
	protected function install(){
        $this->load->model('emticket/knowledgebase');
        $this->model_emticket_knowledgebase->install();
    }
    
   

}