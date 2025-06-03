<?php
/**
 * Módulo Plano de Parcelamento
 * 
 * @author  Cuispi
 * @version 2.4.4
 * @license Commercial License
 * @package admin
 * @subpackage  admin.controller.extension.module
 */

use PlanoDeParcelamento\PlanoDeParcelamento;

class ControllerExtensionModulePlanoDeParcelamento extends Controller {

  /**
   * Development Mode
   *
   * @var boolean True or false
   */
  private $dev = false;

  /**
   * List of validation errors.
   *
   * @var array
   */
	private $error = array();

  /**
   * The code of this extension.
   *
   * @var string
   */  
  protected $code;

  /**
   * The short code of this extension.
   *
   * @var string
   */  
  protected $_code;
  
  /**
   * The partial path to the file of this extension.
   *
   * @var string
   */  
  protected $extension_path;
  
  /**
   * The instantiated model class name of this extension.
   *
   * @var string
   */  
  protected $model_name;
  
  /**
   * The key of the user token 
   *
   * @var string
   */  
  protected $user_token_key;
  
  /**
   * The value of the user token 
   *
   * @var string
   */  
  protected $user_token_value;
  
  /**
   * The partial path to the module model.
   *
   * @var string
   */  
  protected $module_model_path;  
  
  /**
   * The instantiated model class name of the module model.
   *
   * @var string
   */  
  protected $module_model_name;  

  /**
   * Hold error messages regarding the extension core library initialization.
   *
   * @var mixed Array or false  Defaults to false.
   */  
  protected $initialization_errors = false;  
  
  /**
   * Variable for the Logger class instance.
   *
   * @var object
   */
  protected $logger;
  
  /**
   * Constructor.
   *
   * @param object $registry
   * @return void
   */
	public function __construct($registry) {
    parent::__construct($registry);
    
    if ($this->dev === true && function_exists('ini_set')) {
      ini_set('display_errors', 1);
    }

    $class_name = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', __CLASS__));
    
    if (strpos($class_name, '_module_') !== false) {
      list(, $code) = explode('_module_', $class_name);
    } else {
      $code = null;
    }    
    
    if (version_compare(VERSION, '3.0.0.0', '<')) { // OpenCart 2.3.0.2 or earlier.
      $this->code = $code;
      $this->_code = $code;
    } else { // OpenCart 3.0.0.0 or later.
      $this->code = 'module_' . $code;
      $this->_code = $code;
    } 
    
    if (version_compare(VERSION, '2.3.0.0', '<')) { // for OpenCart 2.2.0.0 or earlier.
      $this->extension_path = 'module/' . $this->_code;
      $this->model_name = 'model_module_' . $this->_code;
    } else {
      $this->extension_path = 'extension/module/' . $this->_code;
      $this->model_name = 'model_extension_module_' . $this->_code;
    }	  
    
    if (version_compare(VERSION, '3.0.0.0', '<')) { // OpenCart 2.3.0.2 or earlier.
      $this->user_token_key = 'token';
      $this->user_token_value = $this->session->data['token'];
      
      $this->module_model_path = 'extension/module';
      $this->module_model_name = 'model_extension_module';
      
    } else { // OpenCart 3.0.0.0 or later.
      $this->user_token_key = 'user_token';
      $this->user_token_value = $this->session->data['user_token'];
      
      $this->module_model_path = 'setting/module';
      $this->module_model_name = 'model_setting_module';
    }
    
    $this->logger = new Log($this->code . '.log');
	}
  
  /**
   * index method
   *
   * @param void
   * @return void
   */     
	public function index() {
    
		$this->load->language($this->extension_path);
    
    try {
      if (!class_exists('PlanoDeParcelamento\PlanoDeParcelamento')) {
        throw new Exception($this->language->get('error_modification_not_loaded')); 
      }      
    }
    catch (Exception $e) {
      $this->logger->write('The class PlanoDeParcelamento does not exist in ' . __FILE__ . ' line ' . __LINE__ . ': ' . $e->getMessage());
      $this->initialization_errors['error_modification_not_loaded'] = $e->getMessage();
    }    
    
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model($this->module_model_path);

    $this->document->addScript('view/javascript/' . $this->_code . '/es6-promise/4.1.1/es6-promise.min.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/es6-promise/4.1.1/es6-promise.auto.min.js');  
    
    $this->document->addScript('view/javascript/' . $this->_code . '/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js');
    $this->document->addStyle('view/javascript/' . $this->_code . '/bootstrap-switch/3.3.2/css/bootstrap-switch.min.css');
    
    $this->document->addScript('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/ui/core.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/ui/widget.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/ui/mouse.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/ui/position.js'); 
    $this->document->addScript('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/ui/menu.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/ui/autocomplete.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/ui/sortable.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/ui/resizable.js');
    
    $this->document->addStyle('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/themes/base/core.css');
    $this->document->addStyle('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/themes/base/autocomplete.css');
    $this->document->addStyle('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/themes/base/sortable.css');
    $this->document->addStyle('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/themes/base/resizable.css');
    $this->document->addStyle('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/themes/base/menu.css');
    $this->document->addStyle('view/javascript/' . $this->_code . '/jquery-ui/1.11.4/themes/base/theme.css');
    
    // CodeMirror
    $this->document->addScript('view/javascript/' . $this->_code . '/codemirror/5.19.0/lib/codemirror.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/codemirror/5.19.0/addon/edit/matchbrackets.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/codemirror/5.19.0/addon/edit/matchtags.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/codemirror/5.19.0/addon/fold/xml-fold.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/codemirror/5.19.0/addon/hint/show-hint.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/codemirror/5.19.0/addon/hint/xml-hint.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/codemirror/5.19.0/addon/hint/html-hint.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/codemirror/5.19.0/mode/xml/xml.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/codemirror/5.19.0/mode/javascript/javascript.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/codemirror/5.19.0/mode/css/css.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/codemirror/5.19.0/mode/htmlmixed/htmlmixed.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/codemirror/5.19.0/mode/clike/clike.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/codemirror/5.19.0/mode/php/php.js');
    
    $this->document->addStyle('view/javascript/' . $this->_code . '/codemirror/5.19.0/lib/codemirror.css');
    $this->document->addStyle('view/javascript/' . $this->_code . '/codemirror/5.19.0/addon/hint/show-hint.css');    
    
    // Summernote
    $this->document->addStyle('view/javascript/summernote/summernote.css');    
    $this->document->addScript('view/javascript/summernote/summernote.js');
    
    if (is_file(DIR_APPLICATION . 'view/stylesheet/' . $this->_code . '/summernote.css')) {
      $this->document->addStyle('view/stylesheet/' . $this->_code . '/summernote.css');
    }  
    
    $this->document->addScript('view/javascript/' . $this->_code . '/jquery.ba-resize.min.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/jquery.kh-cookie.min.js');
    $this->document->addScript('view/javascript/' . $this->_code . '/jquery.number.min.js');
    
    $this->document->addStyle('view/stylesheet/' . $this->_code . '/' . $this->_code . '.css');
    
    if (is_file(DIR_APPLICATION . 'view/javascript/' . $this->_code . '/' . $this->_code . (!$this->dev ? '.min' : '') . '.js')) {
      $this->document->addScript('view/javascript/' . $this->_code . '/' . $this->_code . (!$this->dev ? '.min' : '') . '.js' . ($this->dev ? '?'.  time() : ''));
    } else {
      $this->initialization_errors['error_admin_js_not_loaded'] = $this->language->get('error_admin_js_not_loaded');
    }    
    
    
    $this->load->model($this->extension_path); 
    
    
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
      
       // Run the before_save callback
      $this->request->post = $this->before_save($this->request->post);
      
      $submission_type = $this->request->post['submission_type'];
      unset($this->request->post['submission_type']);      

      // Set module version
      $this->request->post['config'][$this->code . '_version'] = PlanoDeParcelamento::version(); 
      
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting($this->code, $this->request->post['config']);
      
      unset($this->request->post['config']);
      
			if (!isset($this->request->get['module_id'])) {
				$this->{$this->module_model_name}->addModule($this->_code, $this->request->post[$this->_code]);
			} else {
				$this->{$this->module_model_name}->editModule($this->request->get['module_id'], $this->request->post[$this->_code]);
			}

			$this->session->data['success'] = $this->language->get('text_success');

      
      // The following line decides if it is a "Save" or "Save and close"
      $url = '';

      // Submit form and stay on same page
      if ($submission_type == 'save') {
        if (!isset($this->request->get['module_id'])) { // New entry
          $last_inserted_module_id = $this->{$this->model_name}->getLastInsertedModuleIdByCode($this->_code);
          $url = $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value. '&module_id=' . $last_inserted_module_id, true);
        } else {
          $url = $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value. '&module_id=' . $this->request->get['module_id'], true);
        }
      } elseif ($submission_type == 'save-and-close') {
        if (version_compare(VERSION, '2.3.0.0', '<')) { // OpenCart 2.2.0.0 or earlier.
          $url = $this->url->link('extension/module', $this->user_token_key . '=' . $this->user_token_value, true);
        } elseif (version_compare(VERSION, '3.0.0.0', '<')) { // OpenCart 2.3.0.2 or earlier.
          $url = $this->url->link('extension/extension', $this->user_token_key . '=' . $this->user_token_value . '&type=module', true);
        } else { // OpenCart 3.0.0.0 or later.
          $url = $this->url->link('marketplace/extension', $this->user_token_key . '=' . $this->user_token_value . '&type=module', true);
        }
      } else {
        if (!isset($this->request->get['module_id'])) { // New entry
          $last_inserted_module_id = $this->{$this->model_name}->getLastInsertedModuleIdByCode($this->_code);
          $url = $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value. '&module_id=' . $last_inserted_module_id, true);
        } else {
          $url = $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value. '&module_id=' . $this->request->get['module_id'], true);
        }
      }
      
      $this->response->redirect($url);
		}
 

    $data = array();
 
    
    // Heading
		$data['heading_title'] = $this->language->get('heading_title');  

    // Version
    if (is_callable(array('PlanoDeParcelamento\PlanoDeParcelamento', 'version'), false)) {
      $data['version'] = PlanoDeParcelamento::version();
    } else {
      $data['version'] = false;
    }
    
    // Text
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_new'] = $this->language->get('text_new');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_general'] = $this->language->get('text_general');
		$data['text_editor'] = $this->language->get('text_editor');
		$data['text_hide_on_selected_pages'] = $this->language->get('text_hide_on_selected_pages');
		$data['text_show_on_selected_pages'] = $this->language->get('text_show_on_selected_pages');
		$data['text_product_select_no_results'] = $this->language->get('text_product_select_no_results');
		$data['text_check_all'] = $this->language->get('text_check_all');
		$data['text_uncheck_all'] = $this->language->get('text_uncheck_all');
		$data['text_guest_users'] = $this->language->get('text_guest_users');
		$data['text_expand_all'] = $this->language->get('text_expand_all');
		$data['text_collapse_all'] = $this->language->get('text_collapse_all');
		$data['text_confirm_delete'] = $this->language->get('text_confirm_delete');
		$data['text_confirm_changes_will_be_lost'] = $this->language->get('text_confirm_changes_will_be_lost');
		$data['text_on'] = $this->language->get('text_on');
		$data['text_off'] = $this->language->get('text_off');
    $data['text_percent'] = $this->language->get('text_percent');
    $data['text_times_sign'] = $this->language->get('text_times_sign');
    $data['text_up_to'] = $this->language->get('text_up_to');
    $data['text_template_include_code_shown_later'] = $this->language->get('text_template_include_code_shown_later');  
    $data['text_no_data'] = $this->language->get('text_no_data');    
    $data['text_heading_general'] = $this->language->get('text_heading_general');
    $data['text_heading_display_conditions'] = $this->language->get('text_heading_display_conditions');
    $data['text_heading_template'] = $this->language->get('text_heading_template');
    $data['text_heading_scripts_and_styles'] = $this->language->get('text_heading_scripts_and_styles');
    $data['text_heading_misc'] = $this->language->get('text_heading_misc');
		$data['text_usage_template_include_oc2x_1'] = $this->language->get('text_usage_template_include_oc2x_1');
		$data['text_usage_template_include_oc2x_2'] = $this->language->get('text_usage_template_include_oc2x_2');
		$data['text_usage_template_include_1'] = $this->language->get('text_usage_template_include_1');
		$data['text_usage_template_include_2'] = $this->language->get('text_usage_template_include_2');    
		$data['text_template_include_usage_3x_1'] = $this->language->get('text_template_include_usage_3x_1');    
		$data['text_template_include_usage_3x_2'] = $this->language->get('text_template_include_usage_3x_2');    
    
    // Column
		$data['column_image'] = $this->language->get('column_image');
		$data['column_max_term'] = $this->language->get('column_max_term');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_status'] = $this->language->get('column_status');
    
    // Entry
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_title_link'] = $this->language->get('entry_title_link');
		$data['entry_html_content'] = $this->language->get('entry_html_content');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');    
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_stores'] = $this->language->get('entry_stores');
		$data['entry_customer_groups'] = $this->language->get('entry_customer_groups');
		$data['entry_categories'] = $this->language->get('entry_categories');
		$data['entry_products'] = $this->language->get('entry_products');
		$data['entry_max_instal_amt'] = $this->language->get('entry_max_instal_amt');
		$data['entry_min_instal_amt'] = $this->language->get('entry_min_instal_amt');
		$data['entry_min_price'] = $this->language->get('entry_min_price');    
		$data['entry_template'] = $this->language->get('entry_template');
		$data['entry_use_custom_template'] = $this->language->get('entry_use_custom_template');
		$data['entry_external_css'] = $this->language->get('entry_external_css');
		$data['entry_external_js'] = $this->language->get('entry_external_js');
		$data['entry_use_default_stylesheet'] = $this->language->get('entry_use_default_stylesheet');
		$data['entry_internal_css'] = $this->language->get('entry_internal_css');
		$data['entry_use_default_javascript'] = $this->language->get('entry_use_default_javascript');
		$data['entry_internal_js'] = $this->language->get('entry_internal_js');
		$data['entry_params'] = $this->language->get('entry_params');
		$data['entry_installment_plan_provider'] = $this->language->get('entry_installment_plan_provider');
		$data['entry_installment_plan_plan'] = $this->language->get('entry_installment_plan_plan');
		$data['entry_installment_plan_direct_debit_pay_fee'] = $this->language->get('entry_installment_plan_direct_debit_pay_fee');
		$data['entry_installment_plan_lump_sum_pay_fee'] = $this->language->get('entry_installment_plan_lump_sum_pay_fee');
		$data['entry_installment_plan_instal_pay_fee'] = $this->language->get('entry_installment_plan_instal_pay_fee');
		$data['entry_installment_plan_fee_per_instal'] = $this->language->get('entry_installment_plan_fee_per_instal');
		$data['entry_installment_plan_ar_collection'] = $this->language->get('entry_installment_plan_ar_collection');
		$data['entry_installment_plan_anticipation_fee'] = $this->language->get('entry_installment_plan_anticipation_fee');
		$data['entry_installment_plan_discount_rate'] = $this->language->get('entry_installment_plan_discount_rate');
		$data['entry_installment_plan_fixed_fee'] = $this->language->get('entry_installment_plan_fixed_fee');
		$data['entry_installment_plan_comment'] = $this->language->get('entry_installment_plan_comment');
		$data['entry_installment_plan_promo_message'] = $this->language->get('entry_installment_plan_promo_message');
		$data['entry_installment_plan_link'] = $this->language->get('entry_installment_plan_link');
		$data['entry_installment_plan_params'] = $this->language->get('entry_installment_plan_params');
		$data['entry_installment_plan_status'] = $this->language->get('entry_installment_plan_status');
		$data['entry_cc_icon_width_and_height'] = $this->language->get('entry_cc_icon_width_and_height');
		$data['entry_cc_icon_width'] = $this->language->get('entry_cc_icon_width');
		$data['entry_cc_icon_height'] = $this->language->get('entry_cc_icon_height');   
    $data['entry_config_status'] = $this->language->get('entry_config_status');
    $data['entry_config_number_format'] = $this->language->get('entry_config_number_format');
    $data['entry_config_js_debug'] = $this->language->get('entry_config_js_debug');
		$data['entry_config_editor_status'] = $this->language->get('entry_config_editor_status');
		$data['entry_config_editor_lang'] = $this->language->get('entry_config_editor_lang');
		$data['entry_config_editor_height'] = $this->language->get('entry_config_editor_height');
		$data['entry_config_editor_tabsize'] = $this->language->get('entry_config_editor_tabsize');
		$data['entry_config_editor_codemirror_theme'] = $this->language->get('entry_config_editor_codemirror_theme');
		$data['entry_template_include_usage'] = $this->language->get('entry_template_include_usage');
    
    // Help
		$data['help_title'] = $this->language->get('help_title');
		$data['help_title_link'] = $this->language->get('help_title_link');
		$data['help_html_content'] = $this->language->get('help_html_content');
		$data['help_status'] = $this->language->get('help_status');
		$data['help_stores'] = $this->language->get('help_stores');
		$data['help_customer_groups'] = $this->language->get('help_customer_groups');
		$data['help_categories'] = $this->language->get('help_categories');
		$data['help_products'] = $this->language->get('help_products');
		$data['help_product_select_autocomplete'] = $this->language->get('help_product_select_autocomplete');
		$data['help_min_instal_amt'] = $this->language->get('help_min_instal_amt');
		$data['help_max_instal_amt'] = $this->language->get('help_max_instal_amt');
		$data['help_min_price'] = $this->language->get('help_min_price');    
		$data['help_template'] = $this->language->get('help_template');
		$data['help_template_include_usage'] = $this->language->get('help_template_include_usage');
		$data['help_external_css'] = $this->language->get('help_external_css');
		$data['help_use_default_stylesheet'] = $this->language->get('help_use_default_stylesheet');
		$data['help_external_js'] = $this->language->get('help_external_js');
		$data['help_use_default_javascript'] = $this->language->get('help_use_default_javascript');
		$data['help_internal_css'] = $this->language->get('help_internal_css');
		$data['help_internal_js'] = $this->language->get('help_internal_js');
		$data['help_params'] = $this->language->get('help_params');
		$data['help_installment_plan_provider'] = $this->language->get('help_installment_plan_provider');
    $data['help_installment_plan_plan'] = $this->language->get('help_installment_plan_plan');
    $data['help_installment_plan_direct_debit_pay_fee'] = $this->language->get('help_installment_plan_direct_debit_pay_fee');
    $data['help_installment_plan_lump_sum_pay_fee'] = $this->language->get('help_installment_plan_lump_sum_pay_fee');
    $data['help_installment_plan_instal_pay_fee'] = $this->language->get('help_installment_plan_instal_pay_fee');
    $data['help_installment_plan_fee_per_instal'] = $this->language->get('help_installment_plan_fee_per_instal');
    $data['help_installment_plan_ar_collection'] = $this->language->get('help_installment_plan_ar_collection');
    $data['help_installment_plan_anticipation_fee'] = $this->language->get('help_installment_plan_anticipation_fee');
    $data['help_installment_plan_discount_rate'] = $this->language->get('help_installment_plan_discount_rate');
    $data['help_installment_plan_fixed_fee'] = $this->language->get('help_installment_plan_fixed_fee');
    $data['help_installment_plan_comment'] = $this->language->get('help_installment_plan_comment');
    $data['help_installment_plan_promo_message'] = $this->language->get('help_installment_plan_promo_message');
    
		$data['help_installment_plan_title'] = $this->language->get('help_installment_plan_title');   
		$data['help_installment_plan_button'] = $this->language->get('help_installment_plan_button');   
		$data['help_installment_plan_link'] = $this->language->get('help_installment_plan_link');    
		$data['help_installment_plan_desc'] = $this->language->get('help_installment_plan_desc');    
		$data['help_installment_plan_images'] = $this->language->get('help_installment_plan_images');    
		$data['help_installment_plan_params'] = $this->language->get('help_installment_plan_params'); 
    
		$data['help_config_status'] = $this->language->get('help_config_status');
    $data['help_config_js_debug'] = $this->language->get('help_config_js_debug');  
    
    // Tab
    $data['tab_modules'] = $this->language->get('tab_modules');
    $data['tab_config'] = $this->language->get('tab_config');
		$data['tab_layouts'] = $this->language->get('tab_layouts');
    $data['tab_help'] = $this->language->get('tab_help');
    $data['tab_general'] = $this->language->get('tab_general');
    $data['tab_installment_plans'] = $this->language->get('tab_installment_plans');
    $data['tab_cards'] = $this->language->get('tab_cards');

    // Button
    $data['button_add_new'] = $this->language->get('button_add_new');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_save_and_close'] = $this->language->get('button_save_and_close');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_move_down'] = $this->language->get('button_move_down');
		$data['button_move_up'] = $this->language->get('button_move_up');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_add_new_autofill'] = $this->language->get('button_add_new_autofill');
    
    
		// Success
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

    // Warning
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
    
		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}
		
		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}
    
		if (isset($this->error['cc_icon_width'])) {
			$data['error_cc_icon_width'] = $this->error['cc_icon_width'];
		} else {
			$data['error_cc_icon_width'] = '';
		}
		
		if (isset($this->error['cc_icon_height'])) {
			$data['error_cc_icon_height'] = $this->error['cc_icon_height'];
		} else {
			$data['error_cc_icon_height'] = '';
		}
    
	// Initialization errors
    if ($this->initialization_errors) {
      $data['initialization_errors'] = $this->initialization_errors;
    } else {
      $data['initialization_errors'] = false;
    }     

    
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $this->user_token_key . '=' . $this->user_token_value, true)
		);

    if (version_compare(VERSION, '2.3.0.0', '<')) { // OpenCart 2.2.0.0 or earlier.
      $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_module'),
        'href' => $this->url->link('extension/module', $this->user_token_key . '=' . $this->user_token_value, true)
      );
    } elseif (version_compare(VERSION, '3.0.0.0', '<')) { // OpenCart 2.3.0.2 or earlier.
      $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_extension'),
        'href' => $this->url->link('extension/extension', $this->user_token_key . '=' . $this->user_token_value . '&type=module', true)
      );    
    } else { // OpenCart 3.0.0.0 or later.
      $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_extension'),
        'href' => $this->url->link('marketplace/extension', $this->user_token_key . '=' . $this->user_token_value . '&type=module', true)
      );    
    }    

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value, true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value . '&module_id=' . $this->request->get['module_id'], true)
			);			
		}
    
    // Action
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value, true);
		} else {
			$data['action'] = $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value . '&module_id=' . $this->request->get['module_id'], true);
		}
		
    // Cancel
    if (version_compare(VERSION, '2.3.0.0', '<')) { // OpenCart 2.2.0.0 or earlier.
      $data['cancel'] = $this->url->link('extension/module', $this->user_token_key . '=' . $this->user_token_value, true);
    } elseif (version_compare(VERSION, '3.0.0.0', '<')) { // OpenCart 2.3.0.2 or earlier.
      $data['cancel'] = $this->url->link('extension/extension', $this->user_token_key . '=' . $this->user_token_value . '&type=module', true);
    } else { // OpenCart 3.0.0.0 or later.
      $data['cancel'] = $this->url->link('marketplace/extension', $this->user_token_key . '=' . $this->user_token_value . '&type=module', true);
    }
    
    // Module id
    if (isset($this->request->get['module_id']) && $this->request->get['module_id']) {
      $data['module_id'] = (int) $this->request->get['module_id'];
    } else {
      $data['module_id'] = null;
    }
    
    // Token
		$data['user_token_key'] = $this->user_token_key;
		$data['user_token_value'] = $this->user_token_value;

    //
    // Languages
    // --------------------------------------------------      

    $this->load->model('localisation/language');
    $languages = $this->model_localisation_language->getLanguages();
    
    if ($languages) {
      foreach ($languages as $code => $language) {
        if (version_compare(VERSION, '2.2.0.0', '<')) { // for OpenCart 2.1.0.2 or earlier.
          $languages[$code]['image'] = "view/image/flags/{$language['image']}";
        } else {
          $languages[$code]['image'] = "language/{$language['code']}/{$language['code']}.png";
        }
      }
    }
    
    $data['languages'] = $languages;
    
    $data['primary_language'] = reset($languages);

    //
    // Stores
    // --------------------------------------------------       

		$this->load->model('setting/store');
    
		$data['stores'] = array();
		
    $data['stores'][] = array(
			'store_id' => 0,
			'name' => $this->config->get('config_name')
		);
		
    $stores = array_merge($data['stores'], $this->model_setting_store->getStores());    
		$data['stores'] = $stores;
    
    //
    // Customer groups for access levels
    // --------------------------------------------------  

    if ($this->isOC2031orEarlier()) { // for OpenCart 2.0.3.1 or earlier.
      $this->load->model('sale/customer_group');
      $customer_groups = $this->model_sale_customer_group->getCustomerGroups();
      
    } else { // for OpenCart 2.1.0.0 or later.
      $this->load->model('customer/customer_group');
      $customer_groups = $this->model_customer_customer_group->getCustomerGroups();
    }    

    foreach ($customer_groups as $key => $customer_group) {
      if ($customer_group['customer_group_id'] == $this->config->get('config_customer_group_id')) {
        $customer_groups[$key]['name'] = $customer_group['name'] . ' ' . $this->language->get('text_default');
        $customer_groups[$key]['customer_group_default'] = 1;
        
      } else {
        $customer_groups[$key]['customer_group_default'] = 0;
      }
    }

    $formatted_customer_groups = array_merge(array(array(
        'customer_group_id' => 0,
        'name' => $this->language->get('text_guest_users'),
        'customer_group_default' => 0
    )), $customer_groups);
    
    $data['customer_groups'] = $formatted_customer_groups;
    
    //
    // Show on Category pages
    // --------------------------------------------------      

    $this->load->model('catalog/category');
    
    $data['categories'] = $this->model_catalog_category->getCategories(array('sort' => 'name', 'order' => 'ASC'));

    //
    // Currencies
    // --------------------------------------------------      

    $this->load->model('localisation/currency');
    
    $currencies = $this->model_localisation_currency->getCurrencies();
    
    $data['currencies'] = $currencies;
    
    if (array_key_exists($this->config->get('config_currency'), (array)$currencies)) {
      $data['primary_currency'] = $currencies[$this->config->get('config_currency')]; 
    } else {
      $data['primary_currency'] = reset($currencies); 
    }

    //
    // Payment service providers
    // --------------------------------------------------      

    try {
      if (!is_callable(array('PlanoDeParcelamento\PlanoDeParcelamento', 'getPaymentServiceProviders'), false)) {
        throw new Exception($this->language->get('error_library_not_loaded')); 
      }

      $providers = PlanoDeParcelamento::getPaymentServiceProviders();
      $data['error_library_not_loaded'] = false;
    }
    catch (Exception $e) {
      $providers = array();
      $this->logger->write('The method PlanoDeParcelamento::getPaymentServiceProviders() is not callable on line ' . __LINE__ . ' in ' . __FILE__ . '.');  
      $data['error_library_not_loaded'] = $e->getMessage();
    }    
    
    $data['providers'] = $providers;

    //
    // Cards
    // --------------------------------------------------      
    
    if (is_dir(DIR_SYSTEM. 'library/' . $this->_code . '/image') && !is_dir(DIR_IMAGE . $this->_code)) {
      rename(DIR_SYSTEM. 'library/' . $this->_code . '/image', DIR_IMAGE . $this->_code );
    }
    
    $data['cards'] = array();
    
    $cards = $this->language->get('cards');
    
    $this->load->model('tool/image');
    
    foreach ($cards as $key => $name) {
      if (file_exists(DIR_IMAGE . $this->_code . DIRECTORY_SEPARATOR . 'cards' . DIRECTORY_SEPARATOR . $key . '.png')) {
        $image = $this->model_tool_image->resize($this->_code . DIRECTORY_SEPARATOR . 'cards' . DIRECTORY_SEPARATOR .  $key . '.png', 48, 30, 'w');
      } else {
        $image = $this->model_tool_image->resize($this->_code . DIRECTORY_SEPARATOR . 'cards' . DIRECTORY_SEPARATOR . 'no_image.png', 48, 30, 'w');
      }
      
      $data['cards'][$key] = array(
          'name' => $name,
          'thumb' => $image
      );
    }

    //
    // Module data
    // --------------------------------------------------     
  
    $module_data = array(
        'name' => '',
        'title' => array(),
        'title_link' => '',
        'html_content' => '',
        'image' => '',
        'thumb' => '',
        'width' => '',
        'height' => '',         
        'status' => '',
        'stores' => array(),
        'customer_groups' => array(),
        'on_selected_categories' => array(),
        'categories' => array(),
        'on_selected_products' => array(),
        'products' => array(),
        'min_instal_amt' => array(),
        'max_instal_amt' => array(),
        'min_price' => array(),
        'use_custom_template' => false,
        'template' => '',
        'use_default_stylesheet' => true,
        'external_css' => '',
        'internal_css' => '',
        'use_default_javascript' => true,
        'external_js' => '',
        'internal_js' => '',
        'params' => '',
        'installment_plans' => array(),       
        'cards' => array(),
        'cc_icon_width' => 48,
        'cc_icon_height' => 30,
    );
    
    // Get current module
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->{$this->module_model_name}->getModule($this->request->get['module_id']);
		}    
    
		if (count($this->request->post)) {

      // Run the before_save callback
      $this->request->post = $this->before_save($this->request->post);
      
			$module_data = array_merge($module_data, $this->request->post[$this->_code]);
    
    } elseif (isset($this->request->get['module_id']) && empty($module_info)) {
      $this->response->redirect($this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value, true));
      
    } elseif (!empty($module_info)) {
      $module_data = array_merge($module_data, $module_info);
      
		} else { // Perform CREATE operation.
      // Auto-select the default store checkbox in the Stores field.
      $module_data['stores'] = array(0);
      
      // Auto-select the "Guest Users" checkbox in the Customer Groups field.
      $module_data['customer_groups'] = array(0);
    }
    
    // Image
		$this->load->model('tool/image');

		if (isset($module_data['image']) && is_file(DIR_IMAGE . $module_data['image'])) {
			$module_data['thumb'] = $this->model_tool_image->resize($module_data['image'], 100, 100);
		} else {
			$module_data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$module_data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);     

    // Installment plans
    $this->load->model('tool/image');

    foreach($module_data['installment_plans'] as $installment_plan_key => $installment_plan) {
      $module_data['installment_plans'][$installment_plan_key] = array(
          'provider' => $installment_plan['provider'],
          'plan' => $installment_plan['plan'],
          'direct_debit_pay_fee' => $installment_plan['direct_debit_pay_fee'],
          'lump_sum_pay_fee' => $installment_plan['lump_sum_pay_fee'],
          'instal_pay_fee' => $installment_plan['instal_pay_fee'],
          'fee_per_instal' => $installment_plan['fee_per_instal'],
          'ar_collection' => $installment_plan['ar_collection'],
          'anticipation_fee' => $installment_plan['anticipation_fee'],
          'discount_rate' => $installment_plan['discount_rate'],
          'fixed_fee' => $installment_plan['fixed_fee'],
          'comment' => $installment_plan['comment'],
          'promo_message' => $installment_plan['promo_message'],
          'params' => $installment_plan['params'],
          'status' => (bool)$installment_plan['status'],
      );
    }
    
    $data[$this->_code] = $module_data;    
    
    //
    // Display conditions: Products
    // --------------------------------------------------      
    
    $data['products'] = array();
    
    $this->load->model('catalog/product');
 
    foreach ($module_data['products'] as $product_id) {
      $data['products'][] = $this->model_catalog_product->getProduct((int)$product_id);    
    }
    
    //
    // Config
    // --------------------------------------------------

    $config_data = array(
        $this->code . '_status' => false,
        $this->code . '_config' => array(
            'number_format' => 1,
            'js_debug' => false,
            'editor' => array(
                'status' => true,
                'lang' => 'en-US',
                'direction' => 'ltr',
                'height' => 200,
                'tabsize' => 4,
                'codemirror' => array(
                    'theme' => 'monokai'
                )
            ),
        ),
    );
    
    $extension_status = (bool)$this->config->get($this->code . '_status');
    $config_info = (array)$this->config->get($this->code . '_config');

		if (count($this->request->post)) {
			$config_data = array_merge($config_data, $this->request->post['config']);
      
    } elseif (!empty($config_info)) {
      $config_data = array_replace_recursive($config_data, array_merge(array(
          $this->code . '_status' => $extension_status,
          $this->code . '_config' => $config_info
      )));
    }
       
    $data['config'] = $config_data;

    
    // Number formatting rules
    if (is_callable(array('PlanoDeParcelamento\PlanoDeParcelamento', 'getNumberFormattingRules'), false)) {
      $number_formatting_rules = PlanoDeParcelamento::getNumberFormattingRules();
      
      if (isset($number_formatting_rules[$config_data[$this->code . '_config']['number_format']])) {
        $number_formatting_rule = $number_formatting_rules[$config_data[$this->code . '_config']['number_format']];
      } else {
        $number_formatting_rule = $number_formatting_rules[1];
      }
      
      $data['dec_point'] = $number_formatting_rule['dec_point'];
      $data['thousands_sep'] = $number_formatting_rule['thousands_sep'];

    } else {
      $data['dec_point'] = '.';
      $data['thousands_sep'] = ',';
    }   
    
    
    // Editor
    $editor_settings = $config_data[$this->code . '_config']['editor'];
    
    if (is_file(DIR_APPLICATION . 'view/javascript/' . $this->_code . '/codemirror/5.19.0/theme/' . $editor_settings['codemirror']['theme'] . '.css')) {
      $this->document->addStyle('view/javascript/' . $this->_code . '/codemirror/5.19.0/theme/' . $editor_settings['codemirror']['theme'] . '.css');   
    }
    
    // Get codemirror themes for the "Code View Theme" select box.
    $codemirror_themes = array();
    
    $css_files = glob(DIR_APPLICATION . 'view/javascript/' . $this->_code . '/codemirror/5.19.0/theme/*');
		
    foreach ($css_files as $css_file) {
      $name = basename($css_file, '.css');
      $codemirror_themes[$name] = ucfirst($name);
		}
    
    $data['codemirror_themes'] = $codemirror_themes;
    unset($codemirror_themes, $css_files, $css_file, $name);
    
    // Try to include a summernote language file other than the default.
    if ($editor_settings['lang'] != 'en-US') {
      if (is_file(DIR_APPLICATION . 'view/javascript/summernote/lang/summernote-' . $editor_settings['lang'] . '.js')) {
        $this->document->addScript('view/javascript/summernote/lang/summernote-' . $editor_settings['lang'] . '.js');
      }
    }
    
    // Get summernote languages for the "Editor > Language" select box.
    $summernote_languages = array('en-US' => 'en-US');

    $lang_files = glob(DIR_APPLICATION . 'view/javascript/summernote/lang/*.js');
    
		foreach ($lang_files as $lang_file) {
      $name = str_replace('summernote-', '', basename($lang_file, '.js'));
      $summernote_languages[$name] = $name;
		}
    
    natsort($summernote_languages);
    
    $data['summernote_languages'] = $summernote_languages;
    unset($summernote_languages, $lang_files, $lang_file, $name);
    
    //
    // Misc
    // --------------------------------------------------

    // Links
    $data['to_layouts'] = $this->url->link('design/layout', $this->user_token_key . '=' . $this->user_token_value, true);
    
    // Code
		$data['code'] = $this->code;
    $data['_code'] = $this->_code;
    
    // Path
		$data['extension_path'] = $this->extension_path;
    
    // Set the current module ID.
    if (!isset($this->request->get['module_id'])) {
      $data['current_module_id'] = null;
    } else {
      $data['current_module_id'] = $this->request->get['module_id'];
    }
    
    // Operation mode
    if (!isset($this->request->get['module_id'])) {
      $data['is_new'] = true;
    } else {
      $data['is_new'] = false;
    }
    
    // URL for the Add New button.
    $data['add_new_action'] = $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value, true);
    
    // Modules
    $modules = $this->{$this->module_model_name}->getModulesByCode($this->_code);
    
    foreach ($modules as $key => $module) {
      if ($this->isOC2031orEarlier()) { // for OpenCart 2.0.3.1 or earlier.
        $setting = unserialize($module['setting']);
      } else { // for OpenCart 2.1.0.0 or later.
        $setting = json_decode($module['setting'], true);
      }
      
      $modules[$key]['status'] = (bool)$setting['status'];
      
      $modules[$key]['actions']['edit'] = $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value . '&module_id=' . $module['module_id'], true);
      $modules[$key]['actions']['delete'] = $this->url->link($this->extension_path . '/delete', $this->user_token_key . '=' . $this->user_token_value . '&module_id=' . $module['module_id'], true);
    }
    
    $data['modules'] = $modules;

    
    if (version_compare(VERSION, '3.0.0.0', '<')) { // OpenCart 2.3.0.2 or earlier.
      $data['compatibility'] = '2x';
    } else {
      $data['compatibility'] = '3x';
    }
    

		if (isset($this->request->post['config'][$this->code . '_lic'])) {
			$lic_data = $this->request->post['config'][$this->code . '_lic'];
		} else {
      $lic_data = $this->config->get($this->code . '_lic');
		}
    
    $data['config'][$this->code . '_lic'] = $lic_data;
    
    $data['lic_key'] = $lic_data['key'];
    
    $data['server_name'] = $_SERVER['SERVER_NAME'] ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST'];
    $data['admin_language'] = $this->config->get('config_admin_language');
    $data['date_default_timezone'] = date_default_timezone_get();
    $data['server_addr'] = isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : $_SERVER['SERVER_ADDR'];
    
    $data['copyright_notice_year'] = call_user_func(function($y) {
      $c = date('Y');
      return $y . (($y != $c) ? '-' . $c : '');
    }, 2014);
    
    //
    // Template
    // --------------------------------------------------       

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
    
    if (version_compare(VERSION, '2.2.0.0', '<')) { // for OpenCart 2.1.0.2 or earlier.
      $this->response->setOutput($this->load->view($this->extension_path . '.tpl', $data));
    } else {
      $this->response->setOutput($this->load->view($this->extension_path, $data));    
    }  
	}
  
  /**
   * The before_save callback
   *
   * @param mixed $data
   * @return mixed 
   */ 
  protected function before_save($data) {
    
    // Reset the keys of each "installment plan" array to save the sort order.
    if (!empty($data[$this->_code]['installment_plans'])) {
      $data[$this->_code]['installment_plans'] = array_values($data[$this->_code]['installment_plans']);
    }
    
    //
    // Converting formatted numbers to floats
    // --------------------------------------------------      

    if (is_callable(array('PlanoDeParcelamento\PlanoDeParcelamento', 'getNumberFormattingRules'), false)) {
      $number_formatting_rules = PlanoDeParcelamento::getNumberFormattingRules();

      if (isset($number_formatting_rules[$this->request->post['config'][$this->code . '_config']['current_number_format']])) {
        $number_formatting_rule = $number_formatting_rules[$this->request->post['config'][$this->code . '_config']['current_number_format']];
      } else {
        $number_formatting_rule = $number_formatting_rules[1];
      }

      $dec_point = $number_formatting_rule['dec_point'];

      $this->load->model('localisation/currency');
      $currencies = $this->model_localisation_currency->getCurrencies();

      foreach ($currencies as $currency) {

        if (isset($data[$this->_code]['min_instal_amt'][$currency['code']])) {
          $data[$this->_code]['min_instal_amt'][$currency['code']] = PlanoDeParcelamento::toNumber($data[$this->_code]['min_instal_amt'][$currency['code']], $dec_point);
        }
        if (isset($data[$this->_code]['max_instal_amt'][$currency['code']])) {
          $data[$this->_code]['max_instal_amt'][$currency['code']] = PlanoDeParcelamento::toNumber($data[$this->_code]['max_instal_amt'][$currency['code']], $dec_point);
        }

        if (isset($data[$this->_code]['min_price'][$currency['code']])) {
          $data[$this->_code]['min_price'][$currency['code']] = PlanoDeParcelamento::toNumber($data[$this->_code]['min_price'][$currency['code']], $dec_point);
        }
      }

      if (!empty($data[$this->_code]['installment_plans'])) {

        // Convert the text formatted number to real number.
        foreach ($data[$this->_code]['installment_plans'] as $installment_plan_key => $installment_plan) {
          $data[$this->_code]['installment_plans'][$installment_plan_key]['direct_debit_pay_fee'] = PlanoDeParcelamento::toNumber($installment_plan['direct_debit_pay_fee'], $dec_point);
          $data[$this->_code]['installment_plans'][$installment_plan_key]['lump_sum_pay_fee'] = PlanoDeParcelamento::toNumber($installment_plan['lump_sum_pay_fee'], $dec_point);
          $data[$this->_code]['installment_plans'][$installment_plan_key]['instal_pay_fee'] = PlanoDeParcelamento::toNumber($installment_plan['instal_pay_fee'], $dec_point);
          $data[$this->_code]['installment_plans'][$installment_plan_key]['fee_per_instal'] = PlanoDeParcelamento::toNumber($installment_plan['fee_per_instal'], $dec_point);
          $data[$this->_code]['installment_plans'][$installment_plan_key]['anticipation_fee'] = PlanoDeParcelamento::toNumber($installment_plan['anticipation_fee'], $dec_point);
          $data[$this->_code]['installment_plans'][$installment_plan_key]['discount_rate'] = PlanoDeParcelamento::toNumber($installment_plan['discount_rate'], $dec_point);

          foreach ($currencies as $currency) {
            if (isset($data[$this->_code]['installment_plans'][$installment_plan_key]['fixed_fee'][$currency['code']])) {
              $data[$this->_code]['installment_plans'][$installment_plan_key]['fixed_fee'][$currency['code']] = PlanoDeParcelamento::toNumber($data[$this->_code]['installment_plans'][$installment_plan_key]['fixed_fee'][$currency['code']], $dec_point);
            }
          }        
        }
      }    
    }     
 
    return $data;
  }  
  
  /**
   * validate method
   *
   * @param void
   * @return boolean True or false
   */  
	protected function validate() {
		if (!$this->user->hasPermission('modify', $this->extension_path)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post[$this->_code]['name']) < 3) || (utf8_strlen($this->request->post[$this->_code]['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
    
    // The width and height fields are not required, but if the user does select an image and fill them in, we need to make sure that they are valid.
    if ($this->request->post[$this->_code]['image']) {
      if ($this->request->post[$this->_code]['width'] == '' || $this->request->post[$this->_code]['width'] <= 0) {
        $this->error['width'] = $this->language->get('error_width');
      }

      if ($this->request->post[$this->_code]['height'] == '' || $this->request->post[$this->_code]['height'] <= 0) {
        $this->error['height'] = $this->language->get('error_height');
      }    
    }
    
    // These fields are required, and we always need to make sure that they are valid.
		if ((int)$this->request->post[$this->_code]['cc_icon_width'] >= 0 || (int)$this->request->post[$this->_code]['cc_icon_height'] >= 0) {
      if ($this->request->post[$this->_code]['cc_icon_width'] <= 0) {
        $this->error['cc_icon_width'] = $this->language->get('error_cc_icon_width');
      }

      if ($this->request->post[$this->_code]['cc_icon_height'] <= 0) {
        $this->error['cc_icon_height'] = $this->language->get('error_cc_icon_height');
      }    
    }
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
    
		return !$this->error;
	}
  
  /**
   * Delete a module.
   *
   * @param void
   * @return Redirect or false
   */    
	public function delete() {
		$this->load->model($this->module_model_path);
    
    $this->load->language($this->extension_path);
    
    if (version_compare(VERSION, '2.3.0.0', '<')) { // OpenCart 2.2.0.0 or earlier
      $permission = $this->user->hasPermission('modify', 'extension/module');
    } else { // OpenCart 2.3.0.0 or later
      $permission = $this->user->hasPermission('modify', 'extension/extension/module');
    }
    
		if (isset($this->request->get['module_id']) && $permission) {
			$this->{$this->module_model_name}->deleteModule($this->request->get['module_id']);
      
      // Modules
      $modules = $this->{$this->module_model_name}->getModulesByCode($this->_code);

      if ($modules) {
        $url = $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value. '&module_id=' . $modules[0]['module_id'], true);
      } else {
        if (version_compare(VERSION, '2.3.0.0', '<')) { // OpenCart 2.2.0.0 or earlier.
          $url = $this->url->link('extension/module', $this->user_token_key . '=' . $this->user_token_value, true);
        } elseif (version_compare(VERSION, '3.0.0.0', '<')) { // OpenCart 2.3.0.2 or earlier.
          $url = $this->url->link('extension/extension', $this->user_token_key . '=' . $this->user_token_value . '&type=module', true);
        } else { // OpenCart 3.0.0.0 or later.
          $url = $this->url->link('marketplace/extension', $this->user_token_key . '=' . $this->user_token_value . '&type=module', true);
        }
      }
		} else {
      $url = $this->url->link($this->extension_path, $this->user_token_key . '=' . $this->user_token_value. '&module_id=' . $this->request->get['module_id'], true);
      $this->session->data['warning'] = $this->language->get('error_permission');
    }

    $this->response->redirect($url);
    
    return false;
	}
  
  /**
   * Checks if OpenCart 2.0.3.1 or earlier
   *
   * @param void
   * @return bool True or false
   */
  protected function isOC2031orEarlier() {
    return version_compare(str_replace('_rc1', '.RC.1', VERSION), '2.1.0.0.RC.1', '<');
  }
  
  /**
   * Get the lic data
   *
   * @param void
   * @return response
   */   
	public function get_lic() {
    if (!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
      $this->logger->write('Error: Invalid Ajax call: ' . __METHOD__ . ' on ' . __LINE__ . ' in ' . __FILE__);
      $this->logger->write($_SERVER);
      return false;
    }
    
    $data = $this->config->get($this->code . '_lic');
    
    if (!$data) {
      $this->logger->write('Error: Failed to fetch license data: ' . __METHOD__ . ' on ' . __LINE__ . ' in ' . __FILE__);
      $this->logger->write($_SERVER);
    }
    
    return $this->response->setOutput(json_encode($data));
  }
  
  /**
   * Save the lic data
   *
   * @param void
   * @return response
   */  
	public function save_lic() {
    if (!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
      $this->logger->write('Error: Invalid Ajax call: ' . __METHOD__ . ' on ' . __LINE__ . ' in ' . __FILE__);
      $this->logger->write($_SERVER);
      return false;
    }
    
    $value = array(
        'key' => $this->request->post['key'],
        'licensee' => array(
            'name' => $this->request->post['licensee']['name'],
        ),
        'server' => $this->request->post['server'],
        'purchased_at' => array(
            'raw' => $this->request->post['purchased_at']['raw'],
            'formatted' => $this->request->post['purchased_at']['formatted'],
        ),
        'expires_at' => array(
            'raw' => $this->request->post['expires_at']['raw'],
            'formatted' => $this->request->post['expires_at']['formatted'],
        ),
        'status' => array(
            'id' => $this->request->post['status']['id'],
            'name' => $this->request->post['status']['name'],
            'icon' => array(
                'name' => $this->request->post['status']['icon']['name'],
                'color' => $this->request->post['status']['icon']['color']
            ),
        ),
        'checked_at' => array(
            'raw' => $this->request->post['checked_at']['raw'],
            'formatted' => $this->request->post['checked_at']['formatted'],
        ),
        'urls' => array(
            'list' => $this->request->post['urls']['list'],
            'detail' => $this->request->post['urls']['detail'],
        ),
    );
    
    $this->load->model($this->extension_path); 
    $data = $this->{$this->model_name}->updateSettingValue($this->code, $this->code . '_lic', $value);

    if (!$data) {
      //$this->logger->write('Error: Failed to save license data: ' . __METHOD__ . ' on ' . __LINE__ . ' in ' . __FILE__);
      //$this->logger->write($_SERVER);
    }
    
    if (! $this->isOC2031orEarlier()) { // for OpenCart 2.1.0.0 or later.
      // Convert an object to an array
      $data = json_decode(json_encode($data), true);
    }  

		$this->response->setOutput(json_encode($data));
	}

}
