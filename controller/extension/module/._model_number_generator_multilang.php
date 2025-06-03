<?php
class ControllerExtensionModuleModelNumberGeneratorMultilang extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/model_number_generator_multilang');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        $data['time_zone_list'] = timezone_identifiers_list();

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('module_model_number_generator_multilang', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['module_model_number_generator_multilang_type'])) {
            $data['error_module_model_number_generator_multilang_type'] = $this->error['module_model_number_generator_multilang_type'];
        } else {
            $data['error_module_model_number_generator_multilang_type'] = '';
        }

        if (isset($this->error['module_model_number_generator_multilang_lenght'])) {
            $data['error_module_model_number_generator_multilang_lenght'] = $this->error['module_model_number_generator_multilang_lenght'];
        } else {
            $data['error_module_model_number_generator_multilang_lenght'] = '';
        }

        if (isset($this->error['module_model_number_generator_multilang_time_zone'])) {
            $data['error_module_model_number_generator_multilang_time_zone'] = $this->error['module_model_number_generator_multilang_time_zone'];
        } else {
            $data['error_module_model_number_generator_multilang_time_zone'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true),
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/model_number_generator_multilang', 'user_token=' . $this->session->data['user_token'], true),
        );

        $data['action'] = $this->url->link('extension/module/model_number_generator_multilang', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        if (isset($this->request->post['module_model_number_generator_multilang_prefix'])) {
            $data['module_model_number_generator_multilang_prefix'] = $this->request->post['module_model_number_generator_multilang_prefix'];
        } else {
            $data['module_model_number_generator_multilang_prefix'] = $this->config->get('module_model_number_generator_multilang_prefix');
        }

        if (isset($this->request->post['module_model_number_generator_multilang_suffix'])) {
            $data['module_model_number_generator_multilang_suffix'] = $this->request->post['module_model_number_generator_multilang_suffix'];
        } else {
            $data['module_model_number_generator_multilang_suffix'] = $this->config->get('module_model_number_generator_multilang_suffix');
        }

        if (isset($this->request->post['module_model_number_generator_multilang_type'])) {
            $data['module_model_number_generator_multilang_type'] = $this->request->post['module_model_number_generator_multilang_type'];
        } else {
            $data['module_model_number_generator_multilang_type'] = $this->config->get('module_model_number_generator_multilang_type');
        }

        if (isset($this->request->post['module_model_number_generator_multilang_lenght'])) {
            $data['module_model_number_generator_multilang_lenght'] = $this->request->post['module_model_number_generator_multilang_lenght'];
        } else {
            $data['module_model_number_generator_multilang_lenght'] = $this->config->get('module_model_number_generator_multilang_lenght');
        }

        if (isset($this->request->post['module_model_number_generator_multilang_time_zone'])) {
            $data['module_model_number_generator_multilang_time_zone'] = $this->request->post['module_model_number_generator_multilang_time_zone'];
        } else {
            $data['module_model_number_generator_multilang_time_zone'] = $this->config->get('module_model_number_generator_multilang_time_zone');
        }

        if (isset($this->request->post['module_model_number_generator_multilang_automatic'])) {
            $data['module_model_number_generator_multilang_automatic'] = $this->request->post['module_model_number_generator_multilang_automatic'];
        } else {
            $data['module_model_number_generator_multilang_automatic'] = $this->config->get('module_model_number_generator_multilang_automatic');
        }

        if (isset($this->request->post['module_model_number_generator_multilang_duplicate'])) {
            $data['module_model_number_generator_multilang_duplicate'] = $this->request->post['module_model_number_generator_multilang_duplicate'];
        } else {
            $data['module_model_number_generator_multilang_duplicate'] = $this->config->get('module_model_number_generator_multilang_duplicate');
        }

        if (isset($this->request->post['module_model_number_generator_multilang_status'])) {
            $data['module_model_number_generator_multilang_status'] = $this->request->post['module_model_number_generator_multilang_status'];
        } else {
            $data['module_model_number_generator_multilang_status'] = $this->config->get('module_model_number_generator_multilang_status');
        }

        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/model_number_generator_multilang', $data));
    }

    protected function validate() {
        if (isset($this->request->post['module_model_number_generator_multilang_type']) && $this->request->post['module_model_number_generator_multilang_type'] != '') {
            switch ($this->request->post['module_model_number_generator_multilang_type']) {
            case '0':
            case '1':
                if (!isset($this->request->post['module_model_number_generator_multilang_lenght']) || $this->request->post['module_model_number_generator_multilang_lenght'] < 1) {
                    $this->error['module_model_number_generator_multilang_lenght'] = $this->language->get('error_charactes_lenght_required');
                }
                $this->request->post['module_model_number_generator_multilang_time_zone'] = "";
                break;
            case '2':
                if (!isset($this->request->post['module_model_number_generator_multilang_time_zone'])) {
                    $this->error['module_model_number_generator_multilang_time_zone'] = $this->language->get('error_time_zone_required');
                }
                $this->request->post['module_model_number_generator_multilang_lenght'] = "";
                break;
            }
        } else {
            $this->error['module_model_number_generator_multilang_type'] = $this->language->get('error_required');
        }

        if (!$this->user->hasPermission('modify', 'extension/module/model_number_generator_multilang')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}