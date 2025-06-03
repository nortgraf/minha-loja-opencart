<?php

class ControllerExtensionModuleEitsserverinformation extends Controller {
    
    public function index() {
        $data['lang_array'] = $this->load->language('extension/module/eitsserverinformation');
        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/eitsserverinformation', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['user_token'] = $this->session->data['user_token'];

        $this->load->model('localisation/language');
        $data['languages'] = $this->model_localisation_language->getLanguages();
        
        // Navigation Settings
        $data['default_tab_id'] = 1;
        if (isset($this->request->get['abandoned_faq'])) {
            $data['default_tab_id'] = 6;
            $data['current_active_faq'] = 'active';
        } elseif (isset($this->request->get['abandoned_support'])) {
            $data['default_tab_id'] = 7;
            $data['current_active_support'] = 'active';
        } else {
            $data['current_active_settings'] = 'active';
        }
        
        
        $data['get_admin_config'] = $this->_getAdminConfigInfo();
//        $data['get_config'] = $this->_getConfigInfo();
        $data['phpinfo'] = $this->_info();

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
        
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/eitsserverinformation', $data));
    }
    
    public function install() {
        $this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '0', `code` = 'module_eitsserverinformation', `key` = 'module_eitsserverinformation_status', `value` = '1'");
    }
    
    private function _getAdminConfigInfo() {
        $array[] = array(
            'name' => '<strong>Hosting</strong>',
            'value' => ''
        );
        $array[] = array(
            'name' => '',
            'value' => ''
        );
        $array[] = array(
            'name' => 'HTTP_SERVER',
            'value' => HTTP_SERVER
        );
        $array[] = array(
            'name' => 'HTTP_CATALOG',
            'value' => HTTP_CATALOG
        );
        $array[] = array(
            'name' => 'HTTPS_SERVER',
            'value' => HTTPS_SERVER
        );
        $array[] = array(
            'name' => 'HTTPS_CATALOG',
            'value' => HTTPS_CATALOG
        );
        $array[] = array(
            'name' => '<strong>Directories</strong>',
            'value' => ''
        );
        $array[] = array(
            'name' => '',
            'value' => ''
        );
        $array[] = array(
            'name' => 'DIR_APPLICATION',
            'value' => DIR_APPLICATION
        );
        $array[] = array(
            'name' => 'DIR_SYSTEM',
            'value' => DIR_SYSTEM
        );
        $array[] = array(
            'name' => 'DIR_IMAGE',
            'value' => DIR_IMAGE
        );
        $array[] = array(
            'name' => 'DIR_STORAGE',
            'value' => DIR_STORAGE
        );
        $array[] = array(
            'name' => 'DIR_CATALOG',
            'value' => DIR_CATALOG
        );
        $array[] = array(
            'name' => 'DIR_LANGUAGE',
            'value' => DIR_LANGUAGE
        );
        $array[] = array(
            'name' => 'DIR_TEMPLATE',
            'value' => DIR_TEMPLATE
        );
        $array[] = array(
            'name' => 'DIR_CONFIG',
            'value' => DIR_CONFIG
        );
        $array[] = array(
            'name' => 'DIR_CACHE',
            'value' => DIR_CACHE
        );
        $array[] = array(
            'name' => 'DIR_DOWNLOAD',
            'value' => DIR_DOWNLOAD
        );
        $array[] = array(
            'name' => 'DIR_LOGS',
            'value' => DIR_LOGS
        );
        $array[] = array(
            'name' => 'DIR_MODIFICATION',
            'value' => DIR_MODIFICATION
        );
        $array[] = array(
            'name' => 'DIR_SESSION',
            'value' => DIR_SESSION
        );
        $array[] = array(
            'name' => 'DIR_UPLOAD',
            'value' => DIR_UPLOAD
        );
        $array[] = array(
            'name' => '<strong>Database</strong>',
            'value' => ''
        );
        $array[] = array(
            'name' => 'DB_DRIVER',
            'value' => DB_DRIVER
        );
        $array[] = array(
            'name' => 'DB_HOSTNAME',
            'value' => DB_HOSTNAME
        );
        $array[] = array(
            'name' => 'DB_USERNAME',
            'value' => DB_USERNAME
        );
        $array[] = array(
            'name' => 'DB_PASSWORD',
            'value' => '-------------'
        );
        $array[] = array(
            'name' => 'DB_DATABASE',
            'value' => DB_DATABASE
        );
        $array[] = array(
            'name' => 'DB_PORT',
            'value' => DB_PORT
        );
        $array[] = array(
            'name' => 'DB_PREFIX',
            'value' => DB_PREFIX
        );
        
        return $array;
    }
    
    private function _info()
    {
        ob_start();
            phpinfo();
        $info = ob_get_clean();
       
        $info = preg_replace("/^.*?\<body\>/is", "", $info);
        $info = preg_replace("/<\/body\>.*?$/is", "", $info);
        
        return $info;
    }
}
