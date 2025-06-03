<?php
class ControllerEmticketCommonhead extends Controller {
	public function index() {
		
			

		$this->load->language('emticket/commonhead');

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_setting'] = $this->language->get('text_setting');
		$data['text_tickets'] = $this->language->get('text_tickets');
		$data['text_priority'] = $this->language->get('text_priority');
		$data['text_ticket_status'] = $this->language->get('text_ticket_status');
		$data['text_department'] = $this->language->get('text_department');
		$data['text_knowledge_section'] = $this->language->get('text_knowledge_section');
		$data['text_knowledge_article'] = $this->language->get('text_knowledge_article');
		
		// Menu Links
		
		$data['setting'] =  $this->url->link('emticket/setting', 'user_token=' . $this->session->data['user_token'], true);
		$data['tickets'] =  $this->url->link('emticket/tickets', 'user_token=' . $this->session->data['user_token'], true);
		$data['priority'] =  $this->url->link('emticket/empriority', 'user_token=' . $this->session->data['user_token'], true);
		$data['ticket_status'] =  $this->url->link('emticket/emstatus', 'user_token=' . $this->session->data['user_token'], true);
		$data['department'] =  $this->url->link('emticket/emdepartment', 'user_token=' . $this->session->data['user_token'], true);
		$data['section'] =  $this->url->link('emticket/knowledge_sect', 'user_token=' . $this->session->data['user_token'], true);
		$data['article'] =  $this->url->link('emticket/article', 'user_token=' . $this->session->data['user_token'], true);
		
		$data['route'] =  substr($this->request->get['route'], 0, 16);
		
		
		
	
		
		
		
		
		

	


		return $this->load->view('emticket/commonhead', $data);
	}
}
