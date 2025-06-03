<?php
class ModelEmticketTickets extends Model {
	
	
	
	
	
	/* counter code */
	
	
	
	
	public function getTotalNotifiedtickets() {
		
		
		
		$ticket_setting = $this->config->get('emticketsetting_status');
		
		if (!empty($ticket_setting)) {
			$tstatus = $ticket_setting['tstatus'];
		} else {
			$tstatus = '';
		}	
		
		
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "emtickets  WHERE ticket_status = '" . (int)$tstatus . "'");

		return $query->row['total'];
	}
	
	
	
	
	
	
	
	/* counter code */
	
	public function addTicket($data) {
			
		$this->db->query("INSERT INTO " . DB_PREFIX . "emtickets SET 
		
		department = '" . (int)$data['department'] . "',
		priority = '" . (int)$data['priority'] . "',
		firstname = '" . $this->db->escape($data['firstname']) . "',
		lastname = '" . $this->db->escape($data['lastname']) . "',
		email = '" . $this->db->escape($data['email']) . "',
		ticket_status = '" . $this->db->escape($data['ticket_status']) . "',
		telephone = '" . $this->db->escape($data['telephone']) . "',		
		ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "',
		subject = '" . $this->db->escape($data['subject']) . "',
		message = '" . $this->db->escape($data['message']) . "',
		date_added = NOW()");

		$ticket_id = $this->db->getLastId();
		
		if(isset($data['attachments'])){
			foreach($data['attachments'] as $attach){
				$this->db->query("INSERT INTO " . DB_PREFIX . "emticket_attach SET 
		
					ticket_id = '" . (int)$ticket_id . "',
					code = '" . $this->db->escape($attach) . "'");
			}
		}
		
		//E-mail to customer
		$ticket_setting = $this->config->get('emticketsetting_status');
		if(isset($ticket_setting['user_newticket_alert'])){			
			
			if ($this->request->server['HTTPS']) {
				$server = HTTPS_SERVER;
			} else {
				$server = HTTP_SERVER;
			}						
			
			$this->load->language('emticket/mail');
				
			$message  = sprintf($this->language->get('text_ticket_request'),$ticket_id) . "\n\n";
			$message .= $this->language->get('text_staff_review') . "\n\n\n";
			$message .= $this->language->get('text_review_link') . "\n";
			$message .= $this->url->link('emticket/ticketview' . '&ticket_id=' .$ticket_id) . "\n\n\n";
			$message .= $this->language->get('text_ticket_id') . ' ' . $ticket_id . "\n";
			$message .= $this->language->get('text_telephone') . ' ' . $data['telephone'] . "\n\n";
			$message .= $data['message'] . "\n\n";
			
			
			// Email Template Customer Setting Start 30-1-19
			
			
			if($ticket_setting['emailtemp_description'][$this->config->get('config_language_id')]['user_newticket']){
				
				$format = html_entity_decode($ticket_setting['emailtemp_description'][$this->config->get('config_language_id')]['user_newticket']);
				
				$find = array(
					'{firstname}',
					'{lastname}',
					'{email}',
					'{telephone}',
					'{priority}',
					'{department}',
					'{ticketstatus}',
					'{subject}',
					'{customermessage}',
					'{ticketid}',
					'{link}'
				);
				
				$replace = array(
					'firstname' => $data['firstname'],
					'lastname'  => $data['lastname'],
					'email'   => $data['email'],
					'telephone' => $data['telephone'],					
					'priority' => $this->getPriorityNameById($data['priority']),
					'department'      => $this->getDepartmentNameById($data['department']),
					'ticketstatus'      => $this->getTicketstatusNameById($data['ticket_status']),					
					'subject'  => $data['subject'],
					'customermessage'      => $data['message'],
					'ticketid' => $ticket_id,
					'link'   => $this->url->link('emticket/ticketview' . '&ticket_id=' .$ticket_id)
				);
			
				$message  = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
				
			}
			
			
			// Email Template Customer Setting End
			
		
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($data['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode($data['subject'], ENT_QUOTES, 'UTF-8'));
			$mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
		}
		//E-mail to customer
	}
	
	public function editTicketoff($ticket_id,$data) {		
		
		$this->db->query("Update " . DB_PREFIX . "emtickets SET 

		department = '" . (int)$data['department'] . "',
		priority = '" . (int)$data['priority'] . "',
		firstname = '" . $this->db->escape($data['firstname']) . "',
		lastname = '" . $this->db->escape($data['lastname']) . "',
		email = '" . $this->db->escape($data['email']) . "',
		ticket_status = '" . $this->db->escape($data['ticket_status']) . "',
		telephone = '" . $this->db->escape($data['telephone']) . "',		
		ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "',
		subject = '" . $this->db->escape($data['subject']) . "',
		message = '" . $this->db->escape($data['message']) . "',
		date_modified = NOW() where ticket_id='".$ticket_id."'");
		
		if(isset($data['attachments'])){
			$this->db->query("DELETE FROM " . DB_PREFIX . "emticket_attach WHERE ticket_id = '" . (int)$ticket_id . "'");
			foreach($data['attachments'] as $attach){
				$this->db->query("INSERT INTO " . DB_PREFIX . "emticket_attach SET 
		
					ticket_id = '" . (int)$ticket_id . "',
					code = '" . $this->db->escape($attach) . "'");
			}
		}
	
	}	

	public function deleteTicket($ticket_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "emtickets WHERE ticket_id = '" . (int)$ticket_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "emtickets_reply WHERE ticket_id = '" . (int)$ticket_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "emticket_attach WHERE ticket_id = '" . (int)$ticket_id . "'");
		$this->cache->delete('emticket_priority');
	}

	public function getTicket($ticket_id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "emtickets WHERE ticket_id = '" . (int)$ticket_id . "'");

		return $query->row;
	}
	
	public function getTicketAttachments($ticket_id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "emticket_attach WHERE ticket_id = '" . (int)$ticket_id . "' and reply_id = 0");

		return $query->rows;
	}

	public function getTickets($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "emtickets where ticket_id<>0 ";		
		
		if (isset($data['filter_ticket_id']) && !is_null($data['filter_ticket_id'])) {
			$sql .= " AND ticket_id = '" . (int)$data['filter_ticket_id'] . "'";
		}
		
		if (isset($data['filter_priority']) && !is_null($data['filter_priority'])) {
			$sql .= " AND priority = '" . (int)$data['filter_priority'] . "'";
		}
		
		if (isset($data['filter_department']) && !is_null($data['filter_department'])) {
			$sql .= " AND department = '" . (int)$data['filter_department'] . "'";
		}
		
		if (isset($data['filter_ticket_status']) && !is_null($data['filter_ticket_status'])) {
			$sql .= " AND ticket_status = '" . (int)$data['filter_ticket_status'] . "'";
		}
		
		if (!empty($data['filter_email'])) {
			$sql .= " AND email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}
		
		if (!empty($data['filter_subject'])) {
			$sql .= " AND subject LIKE '" . $this->db->escape($data['filter_subject']) . "%'";
		}		
		
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if (isset($data['filter_date_modified']) && !is_null($data['filter_date_modified'])) {
			$sql .= " AND DATE(date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

	

		$sort_data = array(
			
			'ticket_id',
			'email',		
			'subject',
			'priority',
			'ticket_status',
			'department',
			'date_added',
			'date_modified'
			
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY firstname";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	

	public function getTotaltickets() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "emtickets");
		
		return $query->row['total'];
	}
	
	public function getPriorityNameById($id) {
		
		$query = $this->db->query("SELECT info  FROM " . DB_PREFIX . "emticket_priority  where priority_id='" .(int)$id . "'");
		if($query->row['info']){
			$info =	json_decode($query->row['info'], true);
			
			return '<span class="label label-default" style="background:'.$info['label_bg'].' ;color:'.$info['label_clr'].' ;">'.$info[(int)$this->config->get('config_language_id')]['name'].'</span>';
			
		} else {
			return 0;
		}
	}
	
	public function getTicketstatusNameById($id) {
		
		$query = $this->db->query("SELECT info  FROM " . DB_PREFIX . "emticket_status where id='" .(int)$id . "'");		
		if($query->row['info']){
			$info =	json_decode($query->row['info'], true);	
			
			return '<span class="label label-default" style="background:'.$info['label_bg'].' ;color:'.$info['label_clr'].' ;">'.$info[(int)$this->config->get('config_language_id')]['name'].'</span>';	
			
		} else {
			return 0;
		}
	}
	
	public function getDepartmentNameById($id) {
		
		$query = $this->db->query("SELECT name  FROM " . DB_PREFIX . "emticket_department_description where department_id='" .(int)$id . "' and language_id='".(int)$this->config->get('config_language_id')."'");		
		
		return $query->row['name'];
	}
	
	
	public function addReply($ticket_id,$data) {
		
		$this->load->model('user/user');
		
		
		$this->db->query("Update " . DB_PREFIX . "emtickets SET 	
		
			ticket_status = '" . (int)$data['ticket_status'] . "',
			department = '" . (int)$data['department'] . "',
			priority = '" . (int)$data['priority'] . "',
			date_modified = NOW()
			where ticket_id='".$ticket_id."'");
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "emtickets_reply SET 
		
		ticket_id = '" . (int)$ticket_id . "',
		admin_id = '" . (int)$this->user->getId() . "',
		user_identity = 2,
		message = '" . $this->db->escape($data['message']) . "',
		date_added = NOW()");
		$reply_id = $this->db->getLastId();
		
		if(isset($data['attachments'])){
			foreach($data['attachments'] as $attach){
				$this->db->query("INSERT INTO " . DB_PREFIX . "emticket_attach SET 
		
					reply_id = '" . (int)$reply_id . "',
					ticket_id = '" . (int)$ticket_id . "',
					code = '" . $this->db->escape($attach) . "'");
			}
		}
		
		$ticket_setting = $this->config->get('emticketsetting_status');
		//e-mail to customer
		if(isset($ticket_setting['admin_reply_alert_customer'])){	
			$user_info = $this->model_user_user->getUser($this->user->getId());
			
			
		

			if ($this->request->server['HTTPS']) {
				$server = HTTPS_CATALOG;
			} else {
				$server = HTTP_CATALOG;
			}
			
			$this->load->language('emticket/mail');	
			
			$name = $user_info['firstname']." ".$user_info['lastname'];
			
			$message  = sprintf($this->language->get('text_reply_submitted'),$name,$ticket_id) . "\n\n";
			$message .= $this->language->get('text_ticket_info') . "\n";								
			$message .= $server ."index.php?route=emticket/ticketview&ticket_id=".$ticket_id. "\n\n\n";
			
			$message .= $data['message'] . "\n\n\n";
			
			$message .=  $this->language->get('text_reply_link'). "\n\n";
			
		
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

			$mail->setTo($data['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode('Ticket Reply'.$this->config->get('config_name').')', ENT_QUOTES, 'UTF-8'));
			$mail->setHtml($message);
			$mail->send();
		}
		//E-mail to customer
		
		
	}
	
	public function getTicketReply($ticket_id) {
		
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "emtickets_reply	 WHERE ticket_id = '" . (int)$ticket_id . "'  ORDER BY date_added DESC");
		
		return $query->rows;
		
	}
	
	
	public function getReplyAttachments($reply_id) {
		$query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "emticket_attach WHERE reply_id = '" . (int)$reply_id . "'");

		return $query->rows;
	}

	
	public function deleteReply($reply_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "emtickets_reply WHERE reply_id = '" . (int)$reply_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "emticket_attach WHERE reply_id = '" . (int)$reply_id . "'");
		$this->cache->delete('emtickets_reply');
	}
	
	
}
