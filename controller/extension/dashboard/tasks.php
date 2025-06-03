<?php
class ControllerExtensionDashboardTasks extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/dashboard/tasks');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('extension/dashboard/tasks');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('dashboard_tasks', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/dashboard/tasks', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
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
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=dashboard', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/dashboard/tasks', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/dashboard/tasks', 'user_token=' . $this->session->data['user_token'], true);
		$data['add'] = $this->url->link('extension/dashboard/tasks/add', 'user_token=' . $this->session->data['user_token'], true);
		$data['edit'] = $this->url->link('extension/dashboard/tasks/edit', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=dashboard', true);

		if (isset($this->request->post['dashboard_tasks_width'])) {
			$data['dashboard_tasks_width'] = $this->request->post['dashboard_tasks_width'];
		} else {
			$data['dashboard_tasks_width'] = $this->config->get('dashboard_tasks_width');
		}

		$data['columns'] = array();
		
		for ($i = 3; $i <= 12; $i++) {
			$data['columns'][] = $i;
		}
				
		if (isset($this->request->post['dashboard_tasks_status'])) {
			$data['dashboard_tasks_status'] = $this->request->post['dashboard_tasks_status'];
		} else {
			$data['dashboard_tasks_status'] = $this->config->get('dashboard_tasks_status');
		}

		if (isset($this->request->post['dashboard_tasks_sort_order'])) {
			$data['dashboard_tasks_sort_order'] = $this->request->post['dashboard_tasks_sort_order'];
		} else {
			$data['dashboard_tasks_sort_order'] = $this->config->get('dashboard_tasks_sort_order');
		}

		$data['user_token'] = $this->session->data['user_token'];

		// List tasks
		$data['tasks'] = array();

		$filter = 'task_id';
		
		$results = $this->model_extension_dashboard_tasks->getTasks($filter);

		foreach ($results as $result) {
			$data['tasks'][] = array(
				'task_id'    				=> $result['task_id'],
				'task_description' 	=> $result['task_description'],
				'task_status' 			=> $result['task_status'],
				'task_deadline' 		=> $result['task_deadline'],
			);
		}

		$data['date_current'] = date("d-m-Y H:i:s");

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('extension/dashboard/tasks_form', $data));
	}
	
	public function dashboard() {
		$this->load->language('extension/dashboard/tasks');

		$this->load->model('extension/dashboard/tasks');

		$data['user_token'] = $this->session->data['user_token'];

		$data['check'] = $this->url->link('extension/dashboard/tasks/check', 'user_token=' . $this->session->data['user_token'], true);

		// List tasks
		$data['tasks'] = array();

		$filter = 'task_status';
		
		$results = $this->model_extension_dashboard_tasks->getTasks($filter);

		$data['date_current'] = date("d-m-Y H:i:s");

		foreach ($results as $result) {

			$data['tasks'][] = array(
				'task_id'    				=> $result['task_id'],
				'task_description' 	=> $result['task_description'],
				'task_status' 			=> $result['task_status'],
				'task_deadline' 		=> $result['task_deadline'],
			);
		}

		return $this->load->view('extension/dashboard/tasks_info', $data);
	}

	public function check() {
		$this->load->model('extension/dashboard/tasks');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$task_id = $this->request->post['dashboard_task_id'];

			$this->model_extension_dashboard_tasks->checkTask($task_id);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
	}

	public function add() {
		$this->load->model('extension/dashboard/tasks');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->post['dashboard_task_status_add'])) {
				$this->error['warning'] = $this->language->get('error_status');
			}

			if (!isset($this->request->post['dashboard_task_description_add'])) {
				$this->error['warning'] = $this->language->get('error_description');
			}

			if (!isset($this->request->post['dashboard_task_deadline_add'])) {
				$this->error['warning'] = $this->language->get('error_deadline');
			}

			$status = $this->request->post['dashboard_task_status_add'];
			$description = htmlentities($this->request->post['dashboard_task_description_add'], ENT_QUOTES);
			$deadline = $this->request->post['dashboard_task_deadline_add'];

			$this->model_extension_dashboard_tasks->addTask($status, $description, $deadline);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/dashboard/tasks', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
	}

	public function edit() {
		$this->load->model('extension/dashboard/tasks');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$task_id = $this->request->post['dashboard_task_id'];
			$status = $this->request->post['dashboard_task_status'];
			$description = htmlentities($this->request->post['dashboard_task_description'], ENT_QUOTES);
			$deadline = $this->request->post['dashboard_task_deadline'];

			if (isset($this->request->post['dashboard_task_delete'])) {
				$this->model_extension_dashboard_tasks->deleteTask($task_id);
			} else {
				$this->model_extension_dashboard_tasks->editTask($task_id, $status, $description, $deadline);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/dashboard/tasks', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/dashboard/tasks')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function install() {
		$this->load->model('extension/dashboard/tasks');
		$this->model_extension_dashboard_tasks->install();
	}

	public function uninstall() {
		$this->load->model('extension/dashboard/tasks');
		$this->model_extension_dashboard_tasks->uninstall();
	}
}
