<?php
class ControllerEmticketSetting extends Controller {
	private $error = array();

	public function index() {
		$this->install();
		$this->load->language('emticket/setting');
		$this->load->model('setting/setting');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$post_data =  $this->request->post;		

			foreach($post_data as $key => $postdatas){			
				$insert_data['emticketsetting_status'][$key]=$postdatas;				
			}
			
			$this->model_setting_setting->editSetting('emticketsetting', $insert_data);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('emticket/setting', 'user_token=' . $this->session->data['user_token'] , true));
		}
		
		$data['emlogo'] = "view/image/em-logo.png";
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_form'] = $this->language->get('text_add');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');	
		$data['text_left'] = $this->language->get('text_left');	
		$data['text_center'] = $this->language->get('text_center');	
		$data['text_right'] = $this->language->get('text_right');	
		$data['text_select'] = $this->language->get('text_select');
		$data['text_search_filter'] = $this->language->get('text_search_filter');
		$data['text_color_setting'] = $this->language->get('text_color_setting');
		$data['text_article_setting'] = $this->language->get('text_article_setting');
		$data['text_guest'] = $this->language->get('text_guest');
		$data['text_customer'] = $this->language->get('text_customer');
				
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_who_create_ticket'] = $this->language->get('entry_who_create_ticket');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_logo'] = $this->language->get('entry_logo');
		$data['entry_banner'] = $this->language->get('entry_banner');
		$data['entry_tstatus'] = $this->language->get('entry_tstatus');
		$data['entry_priority'] = $this->language->get('entry_priority');
		$data['entry_heading'] = $this->language->get('entry_heading');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_ticket_limit'] = $this->language->get('entry_ticket_limit');
		$data['entry_user_newticket_alert'] = $this->language->get('entry_user_newticket_alert');
		$data['entry_admin_newticket_alert'] = $this->language->get('entry_admin_newticket_alert');
		$data['entry_customer_reply_alert_admin'] = $this->language->get('entry_customer_reply_alert_admin');
		$data['entry_admin_reply_alert_customer'] = $this->language->get('entry_admin_reply_alert_customer');
		
		$data['entry_ticket_close_status'] = $this->language->get('entry_ticket_close_status');
		$data['entry_ticket_waiting_status'] = $this->language->get('entry_ticket_waiting_status');
		
		$data['entry_heading_clr'] = $this->language->get('entry_heading_clr');
		$data['entry_heading_bg'] = $this->language->get('entry_heading_bg');
		$data['entry_list_item_clr'] = $this->language->get('entry_list_item_clr');
		$data['entry_list_item_bg'] = $this->language->get('entry_list_item_bg');
		$data['entry_knowledge_box_clr'] = $this->language->get('entry_knowledge_box_clr');
		$data['entry_knowledge_box_bg'] = $this->language->get('entry_knowledge_box_bg');
		$data['entry_my_ticket_box_bg'] = $this->language->get('entry_my_ticket_box_bg');
		$data['entry_my_ticket_box_clr'] = $this->language->get('entry_my_ticket_box_clr');
		$data['entry_create_ticket_box_bg'] = $this->language->get('entry_create_ticket_box_bg');
		$data['entry_create_ticket_box_clr'] = $this->language->get('entry_create_ticket_box_clr');
		$data['entry_tab_active_bg'] = $this->language->get('entry_tab_active_bg');
		$data['entry_tab_bg'] = $this->language->get('entry_tab_bg');
		$data['entry_tab_active_clr'] = $this->language->get('entry_tab_active_clr');
		$data['entry_tab_clr'] = $this->language->get('entry_tab_clr');
		$data['entry_knowledge_title_clr'] = $this->language->get('entry_knowledge_title_clr');
		$data['entry_knowledge_border'] = $this->language->get('entry_knowledge_border');
		$data['entry_section_clr'] = $this->language->get('entry_section_clr');
		$data['entry_article_clr'] = $this->language->get('entry_article_clr');
		$data['entry_articledate_clr'] = $this->language->get('entry_articledate_clr');
		$data['entry_panelhead_clr'] = $this->language->get('entry_panelhead_clr');
		$data['entry_panelhead_bg'] = $this->language->get('entry_panelhead_bg');
		$data['entry_panelcusthead_clr'] = $this->language->get('entry_panelcusthead_clr');
		$data['entry_panelcusthead_bg'] = $this->language->get('entry_panelcusthead_bg');
		$data['entry_paneladminhead_clr'] = $this->language->get('entry_paneladminhead_clr');
		$data['entry_paneladminhead_bg'] = $this->language->get('entry_paneladminhead_bg');
		$data['entry_panelreplyhead_clr'] = $this->language->get('entry_panelreplyhead_clr');
		$data['entry_panelreplyhead_bg'] = $this->language->get('entry_panelreplyhead_bg');
		
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_language'] = $this->language->get('tab_language');
		$data['tab_support'] = $this->language->get('tab_support');
		$data['tab_email_notify'] = $this->language->get('tab_email_notify');
		$data['tab_mytickets'] = $this->language->get('tab_mytickets');
		$data['tab_supportpage'] = $this->language->get('tab_supportpage');
		$data['tab_submitpage'] = $this->language->get('tab_submitpage');
		$data['tab_successpage'] = $this->language->get('tab_successpage');
		$data['tab_page_setup'] = $this->language->get('tab_page_setup');
		$data['tab_tickethome'] = $this->language->get('tab_tickethome');
		$data['tab_knowledge'] = $this->language->get('tab_knowledge');
		$data['tab_viewticket'] = $this->language->get('tab_viewticket');
		$data['tab_createticket'] = $this->language->get('tab_createticket');
		$data['tab_emailtemp'] = $this->language->get('tab_emailtemp');
	
	
		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_category'] = $this->language->get('help_category');
		$data['help_ticket_close_status'] = $this->language->get('help_ticket_close_status');
		$data['help_ticket_answered_status'] = $this->language->get('help_ticket_answered_status');
		$data['help_ticket_waiting_status'] = $this->language->get('help_ticket_waiting_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_remove'] = $this->language->get('button_remove');
		
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		
			

		// fetching data for form
		
		$this->load->model('emticket/emstatus');
		$this->load->model('emticket/empriority');
		
		$language_id =	(int)$this->config->get('config_language_id');	
		
		$statuss = $this->model_emticket_emstatus->getStatuss();

			foreach ($statuss as $stats) {
				
				$info =	json_decode($stats['info'], true);		
				
				$data['statuss'][] = array(
					'id' => $stats['id'],
					'name'            => $info[$language_id]['name'],
					'sort_order'      => $stats['sort_order'],				
					'edit'            => $this->url->link('emticket/emstatus/edit', 'user_token=' . $this->session->data['user_token'] . '&id=' . $stats['id'] , true)
				);
			}
		
		
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
		
			
		
		// fetching data for form

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
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
			'href' => $this->url->link('emticket/setting', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);
		
		$data['action'] = $this->url->link('emticket/setting', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['cancel'] = $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'] . $url, true);	
	
	
		if($this->request->server['REQUEST_METHOD'] != 'POST'){
			$ticket_setting = $this->config->get('emticketsetting_status'); 
		}		
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($ticket_setting)) {
			$data['name'] = $ticket_setting['name'];
		} else {
			$data['name'] = '';
		}	
		
		if (isset($this->request->post['priority'])) {
			$data['priority'] = $this->request->post['priority'];
		} elseif (!empty($ticket_setting)) {
			$data['priority'] = $ticket_setting['priority'];
		} else {
			$data['priority'] = '';
		}	
	
		if (isset($this->request->post['tstatus'])) {
			$data['tstatus'] = $this->request->post['tstatus'];
		} elseif (!empty($ticket_setting)) {
			$data['tstatus'] = $ticket_setting['tstatus'];
		} else {
			$data['tstatus'] = '';
		}
		
	
		if (isset($this->request->post['who_create_ticket'])) {
			$data['who_create_ticket'] = $this->request->post['who_create_ticket'];
		} elseif (!empty($ticket_setting) && isset($ticket_setting['who_create_ticket'])) {
			$data['who_create_ticket'] = $ticket_setting['who_create_ticket'];
		} else {
			$data['who_create_ticket'] = '';
		}
		
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($ticket_setting)) {
			$data['status'] = $ticket_setting['status'];
		} else {
			$data['status'] = '';
		}
		
		// Ticket Statuses
		
		if (isset($this->request->post['ticket_close_status'])) {
			$data['ticket_close_status'] = $this->request->post['ticket_close_status'];
		} elseif (!empty($ticket_setting)) {
			$data['ticket_close_status'] = $ticket_setting['ticket_close_status'];
		} else {
			$data['ticket_close_status'] = '';
		}
		
		if (isset($this->request->post['ticket_waiting_status'])) {
			$data['ticket_waiting_status'] = $this->request->post['ticket_waiting_status'];
		} elseif (!empty($ticket_setting)) {
			$data['ticket_waiting_status'] = $ticket_setting['ticket_waiting_status'];
		} else {
			$data['ticket_waiting_status'] = '';
		}
		
		
		// Ticket Statuses end
			
		if (isset($this->request->post['supportpage_description'])) {
			$data['supportpage_description'] = $this->request->post['supportpage_description'];
		} elseif (!empty($ticket_setting)) {
			$data['supportpage_description'] = $ticket_setting['supportpage_description'];
		} else {
			$data['supportpage_description'] = array();
		}
			
		if (isset($this->request->post['tickethome_description'])) {
			$data['tickethome_description'] = $this->request->post['tickethome_description'];
		} elseif (!empty($ticket_setting)) {
			$data['tickethome_description'] = $ticket_setting['tickethome_description'];
		} else {
			$data['tickethome_description'] = array();
		}
		
		if (isset($this->request->post['createticket_description'])) {
			$data['createticket_description'] = $this->request->post['createticket_description'];
		} elseif (!empty($ticket_setting)) {
			$data['createticket_description'] = $ticket_setting['createticket_description'];
		} else {
			$data['createticket_description'] = array();
		}
		
		if (isset($this->request->post['myticket_description'])) {
			$data['myticket_description'] = $this->request->post['myticket_description'];
		} elseif (!empty($ticket_setting)) {
			$data['myticket_description'] = $ticket_setting['myticket_description'];
		} else {
			$data['myticket_description'] = array();
		}
		
		if (isset($this->request->post['knowledgebase_description'])) {
			$data['knowledgebase_description'] = $this->request->post['knowledgebase_description'];
		} elseif (!empty($ticket_setting)) {
			$data['knowledgebase_description'] = $ticket_setting['knowledgebase_description'];
		} else {
			$data['knowledgebase_description'] = array();
		}		
		
		if (isset($this->request->post['emailtemp_description'])) {
			$data['emailtemp_description'] = $this->request->post['emailtemp_description'];
		} elseif (!empty($ticket_setting)) {
			$data['emailtemp_description'] = $ticket_setting['emailtemp_description'];
		} else {
			$data['emailtemp_description'] = array();
		}
		
		if (isset($this->request->post['ticket_limit'])) {
			$data['ticket_limit'] = $this->request->post['ticket_limit'];
		} elseif (!empty($ticket_setting)) {
			$data['ticket_limit'] = $ticket_setting['ticket_limit'];
		} else {
			$data['ticket_limit'] = '';
		}
		
		if (isset($this->request->post['user_newticket_alert'])) {
			$data['user_newticket_alert'] = $this->request->post['user_newticket_alert'];
		} elseif (!empty($ticket_setting) && isset($ticket_setting['user_newticket_alert'])) {
			$data['user_newticket_alert'] = $ticket_setting['user_newticket_alert'];
		} else {
			$data['user_newticket_alert'] = '';
		}		
		
		if (isset($this->request->post['admin_newticket_alert'])) {
			$data['admin_newticket_alert'] = $this->request->post['admin_newticket_alert'];
		} elseif (!empty($ticket_setting) && isset($ticket_setting['admin_newticket_alert'])) {
			$data['admin_newticket_alert'] = $ticket_setting['admin_newticket_alert'];
		} else {
			$data['admin_newticket_alert'] = '';
		}
		
		if (isset($this->request->post['customer_reply_alert_admin'])) {
			$data['customer_reply_alert_admin'] = $this->request->post['customer_reply_alert_admin'];
		} elseif (!empty($ticket_setting) && isset($ticket_setting['customer_reply_alert_admin'])) {
			$data['customer_reply_alert_admin'] = $ticket_setting['customer_reply_alert_admin'];
		} else {
			$data['customer_reply_alert_admin'] = '';
		}
	
		if (isset($this->request->post['admin_reply_alert_customer'])) {
			$data['admin_reply_alert_customer'] = $this->request->post['admin_reply_alert_customer'];
		} elseif (!empty($ticket_setting) && isset($ticket_setting['admin_reply_alert_customer'])) {
			$data['admin_reply_alert_customer'] = $ticket_setting['admin_reply_alert_customer'];
		} else {
			$data['admin_reply_alert_customer'] = '';
		}
		
		// image, banner
			
		/* if (isset($this->request->post['logo'])) {
			$data['logo'] = $this->request->post['logo'];
		} elseif (!empty($ticket_setting)) {
			$data['logo'] = $ticket_setting['logo'];
		} else {
			$data['logo'] = '';
		}	 */
		if (isset($this->request->post['banner'])) {
			$data['banner'] = $this->request->post['banner'];
		} elseif (!empty($ticket_setting)) {
			$data['banner'] = $ticket_setting['banner'];
		} else {
			$data['banner'] = '';
		}

		$this->load->model('tool/image');

		/* if (isset($this->request->post['logo']) && is_file(DIR_IMAGE . $this->request->post['logo'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['logo'], 100, 100);
		} elseif (!empty($ticket_setting) && is_file(DIR_IMAGE . $ticket_setting['logo'])) {
			$data['thumb'] = $this->model_tool_image->resize($ticket_setting['logo'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		} */

		if (isset($this->request->post['banner']) && is_file(DIR_IMAGE . $this->request->post['banner'])) {
			$data['bannerthumb'] = $this->model_tool_image->resize($this->request->post['banner'], 100, 100);
		} elseif (!empty($ticket_setting) && is_file(DIR_IMAGE . $ticket_setting['banner'])) {
			$data['bannerthumb'] = $this->model_tool_image->resize($ticket_setting['banner'], 100, 100);
		} else {
			$data['bannerthumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);		
		
		if (isset($this->request->post['ticket_heading_clr'])) {
			$data['ticket_heading_clr'] = $this->request->post['ticket_heading_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['ticket_heading_clr'] = $ticket_setting['ticket_heading_clr'];
		} else {
			$data['ticket_heading_clr'] = '';
		}		
		
		if (isset($this->request->post['heading_clr'])) {
			$data['heading_clr'] = $this->request->post['heading_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['heading_clr'] = $ticket_setting['heading_clr'];
		} else {
			$data['heading_clr'] = '';
		}
		
		if (isset($this->request->post['heading_bg'])) {
			$data['heading_bg'] = $this->request->post['heading_bg'];
		} elseif (!empty($ticket_setting)) {
			$data['heading_bg'] = $ticket_setting['heading_bg'];
		} else {
			$data['heading_bg'] = '';
		}
		
		if (isset($this->request->post['list_item_clr'])) {
			$data['list_item_clr'] = $this->request->post['list_item_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['list_item_clr'] = $ticket_setting['list_item_clr'];
		} else {
			$data['list_item_clr'] = '';
		}
		
		if (isset($this->request->post['list_item_bg'])) {
			$data['list_item_bg'] = $this->request->post['list_item_bg'];
		} elseif (!empty($ticket_setting)) {
			$data['list_item_bg'] = $ticket_setting['list_item_bg'];
		} else {
			$data['list_item_bg'] = '';
		}
		
		if (isset($this->request->post['create_ticket_box_clr'])) {
			$data['create_ticket_box_clr'] = $this->request->post['create_ticket_box_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['create_ticket_box_clr'] = $ticket_setting['create_ticket_box_clr'];
		} else {
			$data['create_ticket_box_clr'] = '';
		}
		
		if (isset($this->request->post['create_ticket_box_bg'])) {
			$data['create_ticket_box_bg'] = $this->request->post['create_ticket_box_bg'];
		} elseif (!empty($ticket_setting)) {
			$data['create_ticket_box_bg'] = $ticket_setting['create_ticket_box_bg'];
		} else {
			$data['create_ticket_box_bg'] = '';
		}
		
		if (isset($this->request->post['my_ticket_box_clr'])) {
			$data['my_ticket_box_clr'] = $this->request->post['my_ticket_box_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['my_ticket_box_clr'] = $ticket_setting['my_ticket_box_clr'];
		} else {
			$data['my_ticket_box_clr'] = '';
		}
		
		if (isset($this->request->post['my_ticket_box_bg'])) {
			$data['my_ticket_box_bg'] = $this->request->post['my_ticket_box_bg'];
		} elseif (!empty($ticket_setting)) {
			$data['my_ticket_box_bg'] = $ticket_setting['my_ticket_box_bg'];
		} else {
			$data['my_ticket_box_bg'] = '';
		}
		
		if (isset($this->request->post['knowledge_box_bg'])) {
			$data['knowledge_box_bg'] = $this->request->post['knowledge_box_bg'];
		} elseif (!empty($ticket_setting)) {
			$data['knowledge_box_bg'] = $ticket_setting['knowledge_box_bg'];
		} else {
			$data['knowledge_box_bg'] = '';
		}
		
		if (isset($this->request->post['knowledge_box_clr'])) {
			$data['knowledge_box_clr'] = $this->request->post['knowledge_box_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['knowledge_box_clr'] = $ticket_setting['knowledge_box_clr'];
		} else {
			$data['knowledge_box_clr'] = '';
		}		
		
		if (isset($this->request->post['knowledge_title_clr'])) {
			$data['knowledge_title_clr'] = $this->request->post['knowledge_title_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['knowledge_title_clr'] = $ticket_setting['knowledge_title_clr'];
		} else {
			$data['knowledge_title_clr'] = '';
		}
		
		if (isset($this->request->post['knowledge_border'])) {
			$data['knowledge_border'] = $this->request->post['knowledge_border'];
		} elseif (!empty($ticket_setting)) {
			$data['knowledge_border'] = $ticket_setting['knowledge_border'];
		} else {
			$data['knowledge_border'] = '';
		}
				
		if (isset($this->request->post['tab_clr'])) {
			$data['tab_clr'] = $this->request->post['tab_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['tab_clr'] = $ticket_setting['tab_clr'];
		} else {
			$data['tab_clr'] = '';
		}
		
		if (isset($this->request->post['tab_bg'])) {
			$data['tab_bg'] = $this->request->post['tab_bg'];
		} elseif (!empty($ticket_setting)) {
			$data['tab_bg'] = $ticket_setting['tab_bg'];
		} else {
			$data['tab_bg'] = '';
		}
		
		if (isset($this->request->post['tab_active_clr'])) {
			$data['tab_active_clr'] = $this->request->post['tab_active_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['tab_active_clr'] = $ticket_setting['tab_active_clr'];
		} else {
			$data['tab_active_clr'] = '';
		}
		
		if (isset($this->request->post['tab_active_bg'])) {
			$data['tab_active_bg'] = $this->request->post['tab_active_bg'];
		} elseif (!empty($ticket_setting)) {
			$data['tab_active_bg'] = $ticket_setting['tab_active_bg'];
		} else {
			$data['tab_active_bg'] = '';
		}
		
		if (isset($this->request->post['articledate_clr'])) {
			$data['articledate_clr'] = $this->request->post['articledate_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['articledate_clr'] = $ticket_setting['articledate_clr'];
		} else {
			$data['articledate_clr'] = '';
		}
		
		if (isset($this->request->post['article_clr'])) {
			$data['article_clr'] = $this->request->post['article_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['article_clr'] = $ticket_setting['article_clr'];
		} else {
			$data['article_clr'] = '';
		}
		
		if (isset($this->request->post['section_clr'])) {
			$data['section_clr'] = $this->request->post['section_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['section_clr'] = $ticket_setting['section_clr'];
		} else {
			$data['section_clr'] = '';
		}
		
		if (isset($this->request->post['panelhead_bg'])) {
			$data['panelhead_bg'] = $this->request->post['panelhead_bg'];
		} elseif (!empty($ticket_setting)) {
			$data['panelhead_bg'] = $ticket_setting['panelhead_bg'];
		} else {
			$data['panelhead_bg'] = '';
		}
		
		if (isset($this->request->post['panelhead_clr'])) {
			$data['panelhead_clr'] = $this->request->post['panelhead_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['panelhead_clr'] = $ticket_setting['panelhead_clr'];
		} else {
			$data['panelhead_clr'] = '';
		}
		
			
		if (isset($this->request->post['paneladminhead_bg'])) {
			$data['paneladminhead_bg'] = $this->request->post['paneladminhead_bg'];
		} elseif (!empty($ticket_setting)) {
			$data['paneladminhead_bg'] = $ticket_setting['paneladminhead_bg'];
		} else {
			$data['paneladminhead_bg'] = '';
		}
		
		if (isset($this->request->post['paneladminhead_clr'])) {
			$data['paneladminhead_clr'] = $this->request->post['paneladminhead_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['paneladminhead_clr'] = $ticket_setting['paneladminhead_clr'];
		} else {
			$data['paneladminhead_clr'] = '';
		}		

		if (isset($this->request->post['panelcusthead_bg'])) {
			$data['panelcusthead_bg'] = $this->request->post['panelcusthead_bg'];
		} elseif (!empty($ticket_setting)) {
			$data['panelcusthead_bg'] = $ticket_setting['panelcusthead_bg'];
		} else {
			$data['panelcusthead_bg'] = '';
		}
		
		if (isset($this->request->post['panelcusthead_clr'])) {
			$data['panelcusthead_clr'] = $this->request->post['panelcusthead_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['panelcusthead_clr'] = $ticket_setting['panelcusthead_clr'];
		} else {
			$data['panelcusthead_clr'] = '';
		}		
		
		if (isset($this->request->post['panelreplyhead_bg'])) {
			$data['panelreplyhead_bg'] = $this->request->post['panelreplyhead_bg'];
		} elseif (!empty($ticket_setting)) {
			$data['panelreplyhead_bg'] = $ticket_setting['panelreplyhead_bg'];
		} else {
			$data['panelreplyhead_bg'] = '';
		}
		
		if (isset($this->request->post['panelreplyhead_clr'])) {
			$data['panelreplyhead_clr'] = $this->request->post['panelreplyhead_clr'];
		} elseif (!empty($ticket_setting)) {
			$data['panelreplyhead_clr'] = $ticket_setting['panelreplyhead_clr'];
		} else {
			$data['panelreplyhead_clr'] = '';
		}
		
		// image, banner 
	
	
		$data['header'] = $this->load->controller('common/header');
		$data['commonhead'] = $this->load->controller('emticket/commonhead');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('emticket/setting', $data));
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
	
	
	protected function install(){
        $this->load->model('emticket/install');
        $this->model_emticket_install->install();
    }
	
}