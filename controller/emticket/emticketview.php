<?php
class ControllerEmticketEmticketview extends Controller {
	private $error = array();	
	
	public function index() {		
		
		$this->load->language('emticket/tickets');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('emticket/tickets');
		$this->load->model('customer/customer');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['department_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_submitted'] = $this->language->get('text_submitted');
		$data['text_last_updated'] = $this->language->get('text_last_updated');
		$data['text_customer'] = $this->language->get('text_customer');
		$data['text_attachment'] = $this->language->get('text_attachment');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_client'] = $this->language->get('text_client');
		
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['entry_ticket_id'] = $this->language->get('entry_ticket_id');
		$data['entry_registered_customer'] = $this->language->get('entry_registered_customer');
		$data['entry_client_info'] = $this->language->get('entry_client_info');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_ticket_info'] = $this->language->get('entry_ticket_info');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_subject'] = $this->language->get('entry_subject');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_department'] = $this->language->get('entry_department');
		$data['entry_priority'] = $this->language->get('entry_priority');
		$data['entry_ticket_status'] = $this->language->get('entry_ticket_status');
		$data['entry_ip'] = $this->language->get('entry_ip');
		$data['entry_message'] = $this->language->get('entry_message');
		$data['entry_attachment'] = $this->language->get('entry_attachment');

		$data['help_keyword'] = $this->language->get('help_keyword');

		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_reply'] = $this->language->get('button_reply');
		$data['button_submit'] = $this->language->get('button_submit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_upload'] = $this->language->get('button_upload');		
		
		$data['emlogo'] = "view/image/em-logo.png";
		
		// fetching priority, status, department
		
		$language_id =	(int)$this->config->get('config_language_id');
		
			$this->load->model('emticket/empriority');
			$this->load->model('emticket/emstatus');
			$this->load->model('emticket/emdepartment');
			
			$priority_total = $this->model_emticket_empriority->getTotalPrioritys();

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
		
		if (isset($this->error['message'])) {
			$data['error_message'] = $this->error['message'];
		} else {
			$data['error_message'] = '';
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

		
		$data['action'] = $this->url->link('emticket/emticketview/addreply', 'user_token=' . $this->session->data['user_token'] . '&ticket_id=' . $this->request->get['ticket_id'] . $url, true);
		

		$data['edit'] = $this->url->link('emticket/tickets/edit', 'user_token=' . $this->session->data['user_token'] .'&ticket_id=' . $this->request->get['ticket_id'] . $url, true);
		$data['cancel'] = $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'] . $url, true);
		
		$data['user_token'] = $this->session->data['user_token'];
		
		
		
		
	//	setting data
		
			$this->load->model('tool/image');
			
			if (is_file(DIR_IMAGE . 'sgimages/customer.png')) {
				$data['customer_image'] = $this->model_tool_image->resize('sgimages/customer.png', 60, 60);
			} else {
				$data['customer_image'] =  $this->model_tool_image->resize('no_image.png', 60, 60);
			}
	
	//	setting data		
		
		// Fetching Data
		
		// attachments
		
		$this->load->model('tool/upload');
		$attachments = $this->model_emticket_tickets->getTicketAttachments($this->request->get['ticket_id']);
		 $data['attachments'] = array();
		 
			
		
			foreach($attachments as $attachment){
				
							
				$file_info = $this->model_tool_upload->getUploadByCode($attachment['code']);
				
				
				$data['attachments'][] = array(
					 'upload_id' => $file_info['upload_id'],
					 'name'            => $file_info['name'],
					 'code'      => $file_info['code'],
					 'filename'      => $file_info['filename'],
					 'date_added'      => $file_info['date_added'],
					'download'   => $this->url->link('emticket/emticketview/download', 'user_token=' . $this->session->data['user_token'] . '&id=' . $file_info['upload_id'] . $url, true)
				);
				
			}
		
		// attachments
		
		$tickets_info = $this->model_emticket_tickets->getTicket($this->request->get['ticket_id']);		
		
		if (!empty($tickets_info)) {
			
			$data['ticket_id'] = $tickets_info['ticket_id'];
			$data['customer_id'] = $tickets_info['customer_id'];
			$data['firstname'] = $tickets_info['firstname'];
			$data['lastname'] = $tickets_info['lastname'];
			$data['message'] = $tickets_info['message'];
			$data['email'] = $tickets_info['email'];
			$data['telephone'] = $tickets_info['telephone'];
			$data['ip'] = $tickets_info['ip'];
			$data['subject'] = $tickets_info['subject'];
			$data['priority'] = $this->model_emticket_tickets->getPriorityNameById($tickets_info['priority']);
			$data['department'] = $this->model_emticket_tickets->getDepartmentNameById($tickets_info['department']);
			$data['ticket_status'] = $this->model_emticket_tickets->getTicketstatusNameById($tickets_info['ticket_status']);
			$data['date_added'] = date_format(date_create($tickets_info['date_added']),'d/m/Y');
			$data['mdate_added'] = date_format(date_create($tickets_info['date_added']),'d/m/Y H:i:s');		
			$data['date_modified'] = date_format(date_create($tickets_info['date_modified']),'d/m/Y');
			
			$data['fticket_status'] = $tickets_info['ticket_status'];
			$data['fdepartment'] = $tickets_info['department'];
			$data['fpriority'] = $tickets_info['priority'];
			
			$customer_registered = $this->model_customer_customer->getCustomerByEmail($data['email']);	
			
			if($customer_registered){
				$data['customer_registered'] = 1;
			} else {
				$data['customer_registered'] = 0;
			}

			
			
		} else {
			$data['customer_id'] = '';
			$data['firstname'] = '';
			$data['lastname'] = '';			
			$data['message'] = '';
			$data['email'] = '';		
			$data['telephone'] = '';		
			$data['ip'] = '';		
			$data['subject'] = '';	
			$data['priority'] = 'setting left';		
			$data['department'] = 'setting left';
			$data['ticket_status'] = 'setting left';
			$data['date_added'] = '';
			$data['date_modified'] = '';
			$data['customer_registered'] = 0;
			
		}
		
		if (isset($this->request->post['message'])) {
			$data['messager'] = $this->request->post['message'];		
		} else {
			$data['messager'] = '';
		}
		
		if (isset($this->request->post['ticket_status'])) {
			$data['fticket_status'] = $this->request->post['ticket_status'];		
		}
		
		 // attachments in post (case of other errors)
		 $rattachments = array();
		  $data['rattachments'] = array();
			 if (isset($this->request->post['attachments'])) {		
				print_r($this->request->post['attachments']);
				$rattachments = array();
				foreach($this->request->post['attachments'] as $atatchss){
					$rattachments[] = array(				
						'code' => $atatchss				
					);
				}
			} else if($this->request->post){
				$rattachments = array();
			}
			
			foreach($rattachments as $rattachment){
				
							
				$rfile_info = $this->model_tool_upload->getUploadByCode($rattachment['code']);
				
				
				  $data['rattachments'][] = array(
					 'upload_id' => $rfile_info['upload_id'],
					 'name'            => $rfile_info['name'],
					 'code'      => $rfile_info['code'],
					 'filename'      => $rfile_info['filename'],
					 'date_added'      => $rfile_info['date_added'],
					'download'   => $this->url->link('emticket/emticketview/download', 'user_token=' . $this->session->data['user_token'] . '&id=' . $rfile_info['upload_id'] . $url, true)
				 );
				
			}
			 // attachments in post (case of other errors)
		
		
		// Replies conversation
		
		$ticketsreply_info = $this->model_emticket_tickets->getTicketReply($this->request->get['ticket_id']);
		$data['replies'] = array();
		
		
			foreach ($ticketsreply_info as $reply) {
				
				$this->load->model('user/user');
				
				$image =  $this->model_tool_image->resize('no_image.png', 60, 60);
				
				$admin_info = array();
				if($reply['admin_id']!=0){
				
				$admin_info = $this->model_user_user->getUser($reply['admin_id']);
				
				// image 
				
				if (is_file(DIR_IMAGE . $admin_info['image']) && $admin_info['image']!="") {
					$image = $this->model_tool_image->resize($admin_info['image'], 60, 60);
				} else {
					$image =  $this->model_tool_image->resize('no_image.png', 60, 60);
				}
				}
				// reply attachments
				
					$reply_attachs = $this->model_emticket_tickets->getReplyAttachments($reply['reply_id']);
					
					
					
					// attachments
		
					$this->load->model('tool/upload');
					
					 $data['reply_attachs'] = array();
					
						foreach($reply_attachs as $reply_attach){
							
										
							$rfile_info = $this->model_tool_upload->getUploadByCode($reply_attach['code']);
							
							
							  $data['reply_attachs'][] = array(
								 'upload_id' => $rfile_info['upload_id'],
								 'name'            => $rfile_info['name'],
								 'code'      => $rfile_info['code'],
								 'filename'      => $rfile_info['filename'],
								 'date_added'      => $rfile_info['date_added'],
								'download'   => $this->url->link('emticket/emticketview/download', 'user_token=' . $this->session->data['user_token'] . '&id=' . $rfile_info['upload_id'] . $url, true)
							 );
							
						}
					
					// attachments
				
				// reply attachments
				
				
			
				 $data['replies'][] = array(
					 'reply_id' => $reply['reply_id'],
					 'ticket_id' => $reply['ticket_id'],
					 'reply_attachs' => $data['reply_attachs'],
					 
					 'user_identity' => $reply['user_identity'],
					 'admin' => $admin_info,
					 'image' => $image,
					 
					 'client_id' => $reply['client_id'],
					 'message' => $reply['message'],
					  'delete'            => $this->url->link('emticket/emticketview/deletereply', 'user_token=' . $this->session->data['user_token'] . '&reply_id=' . $reply['reply_id']. '&ticket_id=' . $reply['ticket_id'] , true),
					 'date_added' => date_format(date_create($reply['date_added']),'d/m/Y H:i:s'),
					
				 );
			 }
		
		// Fetching Data End


		$data['header'] = $this->load->controller('common/header');
		$data['commonhead'] = $this->load->controller('emticket/commonhead');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('emticket/tickets_view', $data));
	}
	
	public function download() {
		
		$this->load->model('tool/upload');

		if (isset($this->request->get['id'])) {
			$id = $this->request->get['id'];
		} else {
			$id = 0;
		}

		$upload_info = $this->model_tool_upload->getUpload($id);

		if ($upload_info) {
			$file = DIR_UPLOAD . $upload_info['filename'];
			$mask = basename($upload_info['name']);

			if (!headers_sent()) {
				if (is_file($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					readfile($file, 'rb');
					exit;
				} else {
					exit('Error: Could not find file ' . $file . '!');
				}
			} else {
				exit('Error: Headers already sent out!');
			}
		} else {
			$this->load->language('error/not_found');

			$this->document->setTitle($this->language->get('heading_title'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_not_found'] = $this->language->get('text_not_found');

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('error/not_found', 'user_token=' . $this->session->data['user_token'], true)
			);

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}
	
	public function upload() {
		$this->load->language('tool/upload');

		$json = array();

		if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
			// Sanitize the filename
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));

			// Validate the filename length
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
				$json['error'] = $this->language->get('error_filename');
			}

			// Allowed file extension types
			$allowed = array();

			$extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));

			$filetypes = explode("\n", $extension_allowed);

			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}

			if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Allowed file mime types
			$allowed = array();

			$mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));

			$filetypes = explode("\n", $mime_allowed);

			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}

			if (!in_array($this->request->files['file']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Check to see if any PHP files are trying to be uploaded
			$content = file_get_contents($this->request->files['file']['tmp_name']);

			if (preg_match('/\<\?php/i', $content)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Return any upload error
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}

		if (!$json) {
			$file = $filename . '.' . token(32);

			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_UPLOAD . $file);

			// Hide the uploaded file name so people can not link to it directly.
			$this->load->model('tool/upload');

			$json['code'] = $this->model_tool_upload->addUpload($filename, $file);
			$json['filename'] = $filename;

			$json['success'] = 'Your file was successfully uploaded!';
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function addreply() {
		$this->load->language('emticket/tickets');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('emticket/tickets');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateReplyForm()) {

			
				
			$this->model_emticket_tickets->addReply($this->request->get['ticket_id'],$this->request->post);

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

			$this->response->redirect($this->url->link('emticket/emticketview', 'user_token=' . $this->session->data['user_token'] . '&ticket_id=' . $this->request->get['ticket_id'] . $url, true));
		}

		$this->index();
	}

	
		
	public function deletereply() {
		$this->load->language('emticket/tickets');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('emticket/tickets');

		if (isset($this->request->get['reply_id']) && $this->validateDelete()) {
			
				$this->model_emticket_tickets->deleteReply($this->request->get['reply_id']);
			

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

			$this->response->redirect($this->url->link('emticket/emticketview', 'user_token=' . $this->session->data['user_token'] .'&ticket_id=' . $this->request->get['ticket_id'] . $url, true));
		}

		$this->getList();
	}
	
	protected function validateReplyForm() {
		if (!$this->user->hasPermission('modify', 'emticket/emticketview')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen(trim($this->request->post['message'])) < 10) || (utf8_strlen(trim($this->request->post['message'])) > 2000)) {
			$this->error['message'] = $this->language->get('error_message');
		}
		
		return !$this->error;	

	}
	
		protected function validateDelete() {
		
		if (!$this->user->hasPermission('modify', 'emticket/emticketview')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	
	
}