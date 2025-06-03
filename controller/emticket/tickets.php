<?php
class ControllerEmticketTickets extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('emticket/tickets');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('emticket/tickets');

		$this->getList();
	}
	
	public function add() {
		$this->load->language('emticket/tickets');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('emticket/tickets');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			//echo "<pre>";
			//print_r($this->request->post);die();
		
			$this->model_emticket_tickets->addTicket($this->request->post);

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

			$this->response->redirect($this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	
	public function edit() {
		$this->load->language('emticket/tickets');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('emticket/tickets');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			
			//print_r($this->request->post);die();
			
			$this->model_emticket_tickets->editTicket($this->request->get['ticket_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}	

	public function delete() {
		$this->load->language('emticket/tickets');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('emticket/tickets');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $department_id) {
				$this->model_emticket_tickets->deleteTicket($department_id);
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

			$this->response->redirect($this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		
		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}

		if (isset($this->request->get['filter_ticket_id'])) {
			$filter_ticket_id = $this->request->get['filter_ticket_id'];
		} else {
			$filter_ticket_id = null;
		}

		if (isset($this->request->get['filter_subject'])) {
			$filter_subject = $this->request->get['filter_subject'];
		} else {
			$filter_subject = null;
		}

		if (isset($this->request->get['filter_priority'])) {
			$filter_priority = $this->request->get['filter_priority'];
		} else {
			$filter_priority = null;
		}

		if (isset($this->request->get['filter_department'])) {
			$filter_department = $this->request->get['filter_department'];
		} else {
			$filter_department = null;
		}

		if (isset($this->request->get['filter_ticket_status'])) {
			$filter_ticket_status = $this->request->get['filter_ticket_status'];
		} else {
			$filter_ticket_status = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}

		
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
		
		
		if (isset($this->request->get['filter_ticket_id'])) {
			$url .= '&filter_ticket_id=' . urlencode(html_entity_decode($this->request->get['filter_ticket_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_subject'])) {
			$url .= '&filter_subject=' . urlencode(html_entity_decode($this->request->get['filter_subject'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_priority'])) {
			$url .= '&filter_priority=' . urlencode(html_entity_decode($this->request->get['filter_priority'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_department'])) {
			$url .= '&filter_department=' . urlencode(html_entity_decode($this->request->get['filter_department'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_ticket_status'])) {
			$url .= '&filter_ticket_status=' . urlencode(html_entity_decode($this->request->get['filter_ticket_status'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . urlencode(html_entity_decode($this->request->get['filter_date_modified'], ENT_QUOTES, 'UTF-8'));
		}

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
			'href' => $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('emticket/tickets/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('emticket/tickets/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['tickets'] = array();

		$filter_data = array(
			'filter_ticket_id'              => $filter_ticket_id,
			'filter_email'             => $filter_email,
			'filter_subject' => $filter_subject,
			'filter_priority'            => $filter_priority,
			'filter_department'          => $filter_department,
			'filter_ticket_status'        => $filter_ticket_status,
			'filter_date_added'                => $filter_date_added,
			'filter_date_modified'                => $filter_date_modified,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		$language_id =	(int)$this->config->get('config_language_id');
		$ticket_total = $this->model_emticket_tickets->getTotaltickets();

		$results = $this->model_emticket_tickets->getTickets($filter_data);
		
			/* echo "<pre>";	
		print_r($results); */

		  foreach ($results as $result) {
			
				$priority = $this->model_emticket_tickets->getPriorityNameById($result['priority']);
				$department = $this->model_emticket_tickets->getDepartmentNameById($result['department']);
				$ticket_status = $this->model_emticket_tickets->getTicketstatusNameById($result['ticket_status']);
			
			 $data['tickets'][] = array(
				 'ticket_id' => $result['ticket_id'],
				 'name' =>		$result['firstname']." ".$result['lastname'],
				 'email'      => $result['email'],
				 'subject'      => $result['subject'],
				 'priority'      => $priority,
				 'department'      => $department,
				 'ticket_status'      => $ticket_status,
				 'date_added'      => $result['date_added'],
				 'date_modified'      => $result['date_modified'],
				 
				 'edit'            => $this->url->link('emticket/tickets/edit', 'user_token=' . $this->session->data['user_token'] . '&ticket_id=' . $result['ticket_id'] . $url, true),
				 'view'            => $this->url->link('emticket/emticketview', 'user_token=' . $this->session->data['user_token'] . '&ticket_id=' . $result['ticket_id'] . $url, true)
			 );
		 } 
		 
		 
		 
		// fetching priority, status, department
		
			$this->load->model('emticket/empriority');
			$this->load->model('emticket/emstatus');
			$this->load->model('emticket/emdepartment');
			
			$priority_total = $this->model_emticket_empriority->getTotalPrioritys();

			$prioritys = $this->model_emticket_empriority->getPrioritys($filter_data);

				foreach ($prioritys as $priorit) {

				$info =	json_decode($priorit['info'], true);			

				 $data['prioritys'][] = array(
					 'priority_id' => $priorit['priority_id'],
					 'name'            => $info[$language_id]['name'],
					 'sort_order'      => $priorit['sort_order'],
					 'edit'            => $this->url->link('emticket/empriority/edit', 'user_token=' . $this->session->data['user_token'] . '&priority_id=' . $priorit['priority_id'] . $url, true),
					 
				 );
			} 
			
			
			$statuss = $this->model_emticket_emstatus->getStatuss($filter_data);
				
				
			  foreach ($statuss as $stat) {
				
				$info =	json_decode($stat['info'], true);
				
				$label_bg = "transparent";
				$label_clr = "";
				if(isset($info['label_bg'])){
					$label_bg = $info['label_bg'];
				}
				if(isset($info['label_clr'])){
					$label_clr = $info['label_clr'];
				}
				
				
				 $getToalTichetByStatus = $this->model_emticket_emstatus->getToalTichetByStatus($stat['id']);
				
				 $data['statuss'][] = array(
					 'id' => $stat['id'],
					 'name'            => $info[$language_id]['name'],
					 'sort_order'      => $stat['sort_order'],
					 'getToalTichetByStatus'      => $getToalTichetByStatus,
					 'label_clr'      => $label_clr,
					 'label_bg'      => $label_bg,
					 'edit'            => $this->url->link('emticket/emstatus/edit', 'user_token=' . $this->session->data['user_token'] . '&id=' . $stat['id'] . $url, true)
				 );
			 }
			 
			/*  echo "<pre>";
			print_r($data['statuss']);	 */
			 
			 $departments = $this->model_emticket_emdepartment->getDepartments($filter_data);

			 foreach ($departments as $departmen) {
				
				$department_description	=	$this->model_emticket_emdepartment->getDepartmentDescriptions($departmen['department_id']);	
				
				 $data['departments'][] = array(
					 'department_id' => $departmen['department_id'],
					 'name'            => $department_description[$language_id]['name'],
					 'sort_order'      => $departmen['sort_order'],
					 'edit'            => $this->url->link('emticket/emdepartment/edit', 'user_token=' . $this->session->data['user_token'] . '&department_id=' . $departmen['department_id'] . $url, true)
				 );
			 }
		
		
		
		// fetching priority, status, department end

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_id'] = $this->language->get('column_id');
		$data['column_subject'] = $this->language->get('column_subject');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_priority'] = $this->language->get('column_priority');
		$data['column_ticket_status'] = $this->language->get('column_ticket_status');
		$data['column_department'] = $this->language->get('column_department');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_action'] = $this->language->get('column_action');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_ticket_id'] = $this->language->get('entry_ticket_id');
		$data['entry_subject'] = $this->language->get('entry_subject');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_priority'] = $this->language->get('entry_priority');
		$data['entry_ticket_status'] = $this->language->get('entry_ticket_status');
		$data['entry_department'] = $this->language->get('entry_department');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_date_modified'] = $this->language->get('entry_date_modified');
		$data['entry_action'] = $this->language->get('entry_action');
		$data['entry_attachment'] = $this->language->get('entry_attachment');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_upload'] = $this->language->get('button_upload');

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
		
		
		if (isset($this->request->get['filter_ticket_id'])) {
			$url .= '&filter_ticket_id=' . urlencode(html_entity_decode($this->request->get['filter_ticket_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_subject'])) {
			$url .= '&filter_subject=' . urlencode(html_entity_decode($this->request->get['filter_subject'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_priority'])) {
			$url .= '&filter_priority=' . urlencode(html_entity_decode($this->request->get['filter_priority'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_department'])) {
			$url .= '&filter_department=' . urlencode(html_entity_decode($this->request->get['filter_department'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_ticket_status'])) {
			$url .= '&filter_ticket_status=' . urlencode(html_entity_decode($this->request->get['filter_ticket_status'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . urlencode(html_entity_decode($this->request->get['filter_date_modified'], ENT_QUOTES, 'UTF-8'));
		}



		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		
		$data['sort_id'] = $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . '&sort=ticket_id' . $url, true);
		$data['customer'] = $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . '&sort=customer' . $url, true);
		$data['sort_subject'] = $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . '&sort=subject' . $url, true);
		$data['sort_email'] = $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . '&sort=email' . $url, true);
		$data['sort_priority'] = $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . '&sort=priority' . $url, true);
		$data['sort_ticket_status'] = $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . '&sort=ticket_status' . $url, true);
		$data['sort_department'] = $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . '&sort=department' . $url, true);
		$data['sort_date_added'] = $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . '&sort=date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . '&sort=date_modified' . $url, true);

		$url = '';
		
		
		if (isset($this->request->get['filter_ticket_id'])) {
			$url .= '&filter_ticket_id=' . urlencode(html_entity_decode($this->request->get['filter_ticket_id'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_subject'])) {
			$url .= '&filter_subject=' . urlencode(html_entity_decode($this->request->get['filter_subject'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_priority'])) {
			$url .= '&filter_priority=' . urlencode(html_entity_decode($this->request->get['filter_priority'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_department'])) {
			$url .= '&filter_department=' . urlencode(html_entity_decode($this->request->get['filter_department'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_ticket_status'])) {
			$url .= '&filter_ticket_status=' . urlencode(html_entity_decode($this->request->get['filter_ticket_status'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . urlencode(html_entity_decode($this->request->get['filter_date_added'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . urlencode(html_entity_decode($this->request->get['filter_date_modified'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		$data['user_token']  = $this->session->data['user_token'];

		$pagination = new Pagination();
		$pagination->total = $ticket_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($ticket_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($ticket_total - $this->config->get('config_limit_admin'))) ? $ticket_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $ticket_total, ceil($ticket_total / $this->config->get('config_limit_admin')));
		
		$data['filter_ticket_id'] = $filter_ticket_id;
		$data['filter_subject'] = $filter_subject;
		$data['filter_email'] = $filter_email;
		$data['filter_priority'] = $filter_priority;
		$data['filter_department'] = $filter_department;
		$data['filter_ticket_status'] = $filter_ticket_status;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_date_modified'] = $filter_date_modified;

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['emlogo'] = "view/image/em-logo.png";
		$data['header'] = $this->load->controller('common/header');
		$data['commonhead'] = $this->load->controller('emticket/commonhead');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		
		//echo "<pre>";	
		//print_r($data);
		
		$this->response->setOutput($this->load->view('emticket/tickets_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['ticket_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_attachment'] = $this->language->get('text_attachment');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_subject'] = $this->language->get('entry_subject');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_department'] = $this->language->get('entry_department');
		$data['entry_priority'] = $this->language->get('entry_priority');
		$data['entry_ticket_status'] = $this->language->get('entry_ticket_status');
		$data['entry_attachment'] = $this->language->get('entry_attachment');

		$data['help_keyword'] = $this->language->get('help_keyword');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_upload'] = $this->language->get('button_upload');
		
		// fetching priority, status, department
		
		$language_id =	(int)$this->config->get('config_language_id');
		
			$this->load->model('emticket/empriority');
			$this->load->model('emticket/emstatus');
			$this->load->model('emticket/emdepartment');
			
			$ticket_total = $this->model_emticket_empriority->getTotalPrioritys();

			$prioritys = $this->model_emticket_empriority->getPrioritys();

				foreach ($prioritys as $priorit) {

				$info =	json_decode($priorit['info'], true);			

				 $data['prioritys'][] = array(
					 'priority_id' => $priorit['priority_id'],
					 'name'            => $info[$language_id]['name'],
					 'sort_order'      => $priorit['sort_order'],
					 'edit'            => $this->url->link('emticket/empriority/edit', 'user_token=' . $this->session->data['user_token'] . '&priority_id=' . $priorit['priority_id'] , true)
				 );
			} 
			
			
			$statuss = $this->model_emticket_emstatus->getStatuss();

			  foreach ($statuss as $stat) {
				
				$info =	json_decode($stat['info'], true);
				
				$label_bg = "transparent";
				$label_clr = "";
				if(isset($info['label_bg'])){
					$label_bg = $info['label_bg'];
				}
				if(isset($info['label_clr'])){
					$label_clr = $info['label_clr'];
				}
				
				 $data['statuss'][] = array(
					 'id' => $stat['id'],
					 'name'            => $info[$language_id]['name'],
					 'sort_order'      => $stat['sort_order'],
					 'label_clr'      => $label_clr,
					 'label_bg'      => $label_bg,
					 'edit'            => $this->url->link('emticket/emstatus/edit', 'user_token=' . $this->session->data['user_token'] . '&id=' . $stat['id'] , true)
				 );
			 }
			 
			 // attachments
			 
		
		
		$this->load->model('tool/upload');
		
		if (isset($this->request->get['ticket_id'])){		
			$attachments = $this->model_emticket_tickets->getTicketAttachments($this->request->get['ticket_id']);
		} else {
			$attachments = array();
		}
		
		 $data['attachments'] = array();
		 
			 // attachments in post (case of other errors)
			 if (isset($this->request->post['attachments'])) {		
				
				$attachments = array();
				foreach($this->request->post['attachments'] as $atatchss){
					$attachments[] = array(				
						'code' => $atatchss				
					);
				}
			} else if($this->request->post){
				$attachments = array();
			}
			 // attachments in post (case of other errors)
		
			foreach($attachments as $attachment){
				
							
				$file_info = $this->model_tool_upload->getUploadByCode($attachment['code']);
				
				
				  $data['attachments'][] = array(
					 'upload_id' => $file_info['upload_id'],
					 'name'            => $file_info['name'],
					 'code'      => $file_info['code'],
					 'filename'      => $file_info['filename'],
					 'date_added'      => $file_info['date_added'],
					'download'   => $this->url->link('emticket/emticketview/download', 'user_token=' . $this->session->data['user_token'] . '&id=' . $file_info['upload_id'] , true)
				 );
				
			}
		
		// attachments
			 
			 $departments = $this->model_emticket_emdepartment->getDepartments();

			 foreach ($departments as $departmen) {
				
				$department_description	=	$this->model_emticket_emdepartment->getDepartmentDescriptions($departmen['department_id']);	
				
				 $data['departments'][] = array(
					 'department_id' => $departmen['department_id'],
					 'name'            => $department_description[$language_id]['name'],
					 'sort_order'      => $departmen['sort_order'],
					 'edit'            => $this->url->link('emticket/emdepartment/edit', 'user_token=' . $this->session->data['user_token'] . '&department_id=' . $departmen['department_id'] , true)
				 );
			 }
		
		
		
		// fetching priority, status, department end

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		if (isset($this->error['message'])) {
			$data['error_message'] = $this->error['message'];
		} else {
			$data['error_message'] = '';
		}

		if (isset($this->error['subject'])) {
			$data['error_subject'] = $this->error['subject'];
		} else {
			$data['error_subject'] = '';
		}	

		if (isset($this->error['ticket_status'])) {
			$data['error_ticket_status'] = $this->error['ticket_status'];
		} else {
			$data['error_ticket_status'] = '';
		}	

		if (isset($this->error['department'])) {
			$data['error_department'] = $this->error['department'];
		} else {
			$data['error_department'] = '';
		}	

		if (isset($this->error['priority'])) {
			$data['error_priority'] = $this->error['priority'];
		} else {
			$data['error_priority'] = '';
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
			'href' => $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (!isset($this->request->get['ticket_id'])) {
			$data['action'] = $this->url->link('emticket/tickets/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('emticket/tickets/edit', 'user_token=' . $this->session->data['user_token'] . '&ticket_id=' . $this->request->get['ticket_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['ticket_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			
			//$tickets_info = $this->model_emticket_tickets->getTicket($this->request->get['ticket_id']);
			$this->response->redirect($this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}	
		
		
		
		
		$data['user_token'] = $this->session->data['user_token'];
		

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($tickets_info)) {
			$data['firstname'] = $tickets_info['firstname'];
		} else {
			$data['firstname'] = '';
		}


		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($tickets_info)) {
			$data['lastname'] = $tickets_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['message'])) {
			$data['message'] = $this->request->post['message'];
		} elseif (!empty($tickets_info)) {
			$data['message'] = $tickets_info['message'];
		} else {
			$data['message'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($tickets_info)) {
			$data['email'] = $tickets_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($tickets_info)) {
			$data['telephone'] = $tickets_info['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['subject'])) {
			$data['subject'] = $this->request->post['subject'];
		} elseif (!empty($tickets_info)) {
			$data['subject'] = $tickets_info['subject'];
		} else {
			$data['subject'] = '';
		}
		
		if (isset($this->request->post['priority'])) {
			$data['priority'] = $this->request->post['priority'];
		} elseif (!empty($tickets_info)) {
			$data['priority'] = $tickets_info['priority'];
		} else {
			$data['priority'] = '';
		}

		if (isset($this->request->post['department'])) {
			$data['department'] = $this->request->post['department'];
		} elseif (!empty($tickets_info)) {
			$data['department'] = $tickets_info['department'];
		} else {
			$data['department'] = '';
		}

		if (isset($this->request->post['ticket_status'])) {
			$data['ticket_status'] = $this->request->post['ticket_status'];
		} elseif (!empty($tickets_info)) {
			$data['ticket_status'] = $tickets_info['ticket_status'];
		} else {
			$data['ticket_status'] = '';
		}

		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('emticket/tickets_form', $data));
	}
	

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'emticket/tickets')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		
		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if ((utf8_strlen(trim($this->request->post['message'])) < 10) || (utf8_strlen(trim($this->request->post['message'])) > 2000)) {
			$this->error['message'] = $this->language->get('error_message');
		}
		
		if ((utf8_strlen(trim($this->request->post['subject'])) < 5) || (utf8_strlen(trim($this->request->post['subject'])) > 128)) {
			$this->error['subject'] = $this->language->get('error_subject');
		}	
		
		if ((utf8_strlen(trim($this->request->post['priority'])) =="")) {
			$this->error['priority'] = $this->language->get('error_priority');
		}	
		
		if ((utf8_strlen(trim($this->request->post['department'])) =="")) {
			$this->error['department'] = $this->language->get('error_department');
		}	
		
		if ((utf8_strlen(trim($this->request->post['ticket_status'])) =="")) {
			$this->error['ticket_status'] = $this->language->get('error_ticket_status');
		}		

		return !$this->error;
	}

	protected function validateDelete() {
		
		if (!$this->user->hasPermission('modify', 'emticket/tickets')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}