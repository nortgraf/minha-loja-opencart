<?php
class ControllerExtensionModuleCompraExpress extends Controller
{
    private $error = array();
    public function install()
    {
        $custom = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "custom_field` LIKE 'mascara'");
        if ($custom->num_rows == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "custom_field` ADD `mascara` VARCHAR(255) NOT NULL DEFAULT '';");
        }
    }
    private function metodos_pagamento()
    {
        $metodos = array();
        $files = glob(DIR_APPLICATION . "controller/extension/payment/*.php");
        if ($files) {
            foreach ($files as $file) {
                $extension = basename($file, ".php");
                $this->load->language("extension/payment/" . $extension);
                if ($this->config->get("payment_" . $extension . "_status")) {
                    $metodos[$extension] = substr($extension,0,2) === "d5" ? $this->language->get("heading_title") : strip_tags($this->language->get("heading_title"));
                }
            }
        }
        return $metodos;
    }
    public function index()
    {
        $this->load->language("extension/module/compraexpress");
        $this->document->setTitle($this->language->get("heading_title"));
        $this->load->model("setting/setting");
        $this->load->model("setting/extension");
        if ($this->request->server["REQUEST_METHOD"] == "POST" && $this->validate()) {
            $this->model_setting_setting->editSetting("module_compraexpress", $this->request->post);
            $this->response->redirect($this->url->link("extension/module/compraexpress", "salvos=true&user_token=" . $this->session->data["user_token"], "SSL"));
        }
        $data["heading_title"] = $this->language->get("heading_title");
        $data["text_edit"] = $this->language->get("text_edit");
        $data["text_enabled"] = $this->language->get("text_enabled");
        $data["text_disabled"] = $this->language->get("text_disabled");
        $data["entry_status"] = $this->language->get("entry_status");
        if (isset($_GET["salvo"])) {
            $data["salvo"] = true;
        } else {
            $data["salvo"] = false;
        }
        $data["button_save"] = $this->language->get("button_save");
        $data["button_cancel"] = $this->language->get("button_cancel");
        $data["campos"] = $this->campos_extras();
        $data["token"] = $this->session->data["user_token"];
        if (isset($this->error["warning"])) {
            $data["error_warning"] = $this->error["warning"];
        } else {
            $data["error_warning"] = "";
        }
        $data["breadcrumbs"] = array();
        $data["breadcrumbs"][] = array("text" => $this->language->get("text_home"), "href" => $this->url->link("common/dashboard", "user_token=" . $this->session->data["user_token"], "SSL"));
        $data["breadcrumbs"][] = array("text" => $this->language->get("text_module"), "href" => $this->url->link("marketplace/extension", "type=module&user_token=" . $this->session->data["user_token"], "SSL"));
        $data["breadcrumbs"][] = array("text" => $this->language->get("heading_title"), "href" => $this->url->link("extension/module/compraexpress", "user_token=" . $this->session->data["user_token"], "SSL"));
        $data["action"] = $this->url->link("extension/module/compraexpress", "user_token=" . $this->session->data["user_token"], "SSL");
        $data["cancel"] = $this->url->link("marketplace/extension", "type=module&user_token=" . $this->session->data["user_token"], "SSL");
        $data["salvos"] = isset($_GET["salvos"]) ? true : false;
            if (isset($this->request->post["module_compraexpress_status"])) {
                $data["module_compraexpress_status"] = $this->request->post["module_compraexpress_status"];
            } else {
                $data["module_compraexpress_status"] = $this->config->get("module_compraexpress_status");
            }
            $data["catalogo"] = HTTPS_CATALOG;
            if (isset($this->request->post["module_compraexpress_redirecionar"])) {
                $data["module_compraexpress_redirecionar"] = $this->request->post["module_compraexpress_redirecionar"];
            } else {
                $data["module_compraexpress_redirecionar"] = $this->config->get("module_compraexpress_redirecionar");
            }
            if (isset($this->request->post["module_compraexpress_fiscal"])) {
                $data["module_compraexpress_fiscal"] = $this->request->post["module_compraexpress_fiscal"];
            } else {
                $data["module_compraexpress_fiscal"] = $this->config->get("module_compraexpress_fiscal");
            }
            if (isset($this->request->post["module_compraexpress_fiscal2"])) {
                $data["module_compraexpress_fiscal2"] = $this->request->post["module_compraexpress_fiscal2"];
            } else {
                $data["module_compraexpress_fiscal2"] = $this->config->get("module_compraexpress_fiscal2");
            }
            if (isset($this->request->post["module_compraexpress_fiscal_unico"])) {
                $data["module_compraexpress_fiscal_unico"] = $this->request->post["module_compraexpress_fiscal_unico"];
            } else {
                $data["module_compraexpress_fiscal_unico"] = $this->config->get("module_compraexpress_fiscal_unico");
            }
            if (isset($this->request->post["module_compraexpress_resumido"])) {
                $data["module_compraexpress_resumido"] = $this->request->post["module_compraexpress_resumido"];
            } else {
                $data["module_compraexpress_resumido"] = $this->config->get("module_compraexpress_resumido");
            }
            if (isset($this->request->post["module_compraexpress_erro"])) {
                $data["module_compraexpress_erro"] = $this->request->post["module_compraexpress_erro"];
            } else {
                $data["module_compraexpress_erro"] = $this->config->get("module_compraexpress_erro");
            }
            if (isset($this->request->post["module_compraexpress_complemento"])) {
                $data["module_compraexpress_complemento"] = $this->request->post["module_compraexpress_complemento"];
            } else {
                $data["module_compraexpress_complemento"] = $this->config->get("module_compraexpress_complemento");
            }
            if (isset($this->request->post["module_compraexpress_numero"])) {
                $data["module_compraexpress_numero"] = $this->request->post["module_compraexpress_numero"];
            } else {
                $data["module_compraexpress_numero"] = $this->config->get("module_compraexpress_numero");
            }
            if (isset($this->request->post["module_compraexpress_log"])) {
                $data["module_compraexpress_log"] = $this->request->post["module_compraexpress_log"];
            } else {
                $data["module_compraexpress_log"] = $this->config->get("module_compraexpress_log");
            }
            if (isset($this->request->post["module_compraexpress_fb"])) {
                $data["module_compraexpress_fb"] = $this->request->post["module_compraexpress_fb"];
            } else {
                $data["module_compraexpress_fb"] = $this->config->get("module_compraexpress_fb");
            }
            if (isset($this->request->post["module_compraexpress_fbid"])) {
                $data["module_compraexpress_fbid"] = $this->request->post["module_compraexpress_fbid"];
            } else {
                $data["module_compraexpress_fbid"] = $this->config->get("module_compraexpress_fbid");
            }
            if (isset($this->request->post["module_compraexpress_fbsec"])) {
                $data["module_compraexpress_fbsec"] = $this->request->post["module_compraexpress_fbsec"];
            } else {
                $data["module_compraexpress_fbsec"] = $this->config->get("module_compraexpress_fbsec");
            }
            if (isset($this->request->post["module_compraexpress_css"])) {
                $data["module_compraexpress_css"] = $this->request->post["module_compraexpress_css"];
            } else {
                $data["module_compraexpress_css"] = $this->config->get("module_compraexpress_css");
            }
            if (isset($this->request->post["module_compraexpress_tema"])) {
                $data["module_compraexpress_tema"] = $this->request->post["module_compraexpress_tema"];
            } else {
                $data["module_compraexpress_tema"] = $this->config->get("module_compraexpress_tema");
            }
            if (isset($this->request->post["module_compraexpress_com"])) {
                $data["module_compraexpress_com"] = $this->request->post["module_compraexpress_com"];
            } else {
                $data["module_compraexpress_com"] = $this->config->get("module_compraexpress_com");
            }
            if (isset($this->request->post["module_compraexpress_selos"])) {
                $data["module_compraexpress_selos"] = $this->request->post["module_compraexpress_selos"];
            } else {
                $data["module_compraexpress_selos"] = $this->config->get("module_compraexpress_selos");
            }
            if (isset($this->request->post["module_compraexpress_pag"])) {
                $data["module_compraexpress_pag"] = $this->request->post["module_compraexpress_pag"];
            } else {
                $data["module_compraexpress_pag"] = $this->config->get("module_compraexpress_pag");
            }
            if (isset($this->request->post["module_compraexpress_js"])) {
                $data["module_compraexpress_js"] = $this->request->post["module_compraexpress_js"];
            } else {
                $data["module_compraexpress_js"] = $this->config->get("module_compraexpress_js");
            }
            if (isset($this->request->post["module_compraexpress_te"])) {
                $data["module_compraexpress_te"] = $this->request->post["module_compraexpress_te"];
            } else {
                $data["module_compraexpress_te"] = $this->config->get("module_compraexpress_te");
            }
            if (isset($this->request->post["module_compraexpress_modelo"])) {
                $data["module_compraexpress_modelo"] = $this->request->post["module_compraexpress_modelo"];
            } else {
                $data["module_compraexpress_modelo"] = $this->config->get("module_compraexpress_modelo");
            }
            if (isset($this->request->post["module_compraexpress_pagamentos"])) {
                $data["module_compraexpress_pagamentos"] = $this->request->post["module_compraexpress_pagamentos"];
            } else {
                $data["module_compraexpress_pagamentos"] = $this->config->get("module_compraexpress_pagamentos");
            }
            if (isset($this->request->post["module_compraexpress_captchar"])) {
                $data["module_compraexpress_captchar"] = $this->request->post["module_compraexpress_captchar"];
            } else {
                $data["module_compraexpress_captchar"] = $this->config->get("module_compraexpress_captchar");
            }
            $tema = "extension/module/compraexpress";
        $data["grupos"] = $this->grupos_clientes();
        $data["meios"] = $this->metodos_pagamento();
        $data["header"] = $this->load->controller("common/header");
        $data["column_left"] = $this->load->controller("common/column_left");
        $data["footer"] = $this->load->controller("common/footer");
        $this->response->setOutput($this->load->view($tema, $data));
    }
    private function grupos_clientes($data = array())
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int) $this->config->get("config_language_id") . "'";
        $sort_data = array("cgd.name", "cg.sort_order");
        if (isset($data["sort"]) && in_array($data["sort"], $sort_data)) {
            $sql .= " ORDER BY " . $data["sort"];
        } else {
            $sql .= " ORDER BY cgd.name";
        }
        if (isset($data["order"]) && $data["order"] == "DESC") {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }
        if (isset($data["start"]) || isset($data["limit"])) {
            if ($data["start"] < 0) {
                $data["start"] = 0;
            }
            if ($data["limit"] < 1) {
                $data["limit"] = 20;
            }
            $sql .= " LIMIT " . (int) $data["start"] . "," . (int) $data["limit"];
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }
    private function campos_extras($data = array())
    {
        if (empty($data["filter_customer_group_id"])) {
            $sql = "SELECT * FROM `" . DB_PREFIX . "custom_field` cf LEFT JOIN " . DB_PREFIX . "custom_field_description cfd ON (cf.custom_field_id = cfd.custom_field_id) WHERE cfd.language_id = '" . (int) $this->config->get("config_language_id") . "'";
        } else {
            $sql = "SELECT * FROM " . DB_PREFIX . "custom_field_customer_group cfcg LEFT JOIN `" . DB_PREFIX . "custom_field` cf ON (cfcg.custom_field_id = cf.custom_field_id) LEFT JOIN " . DB_PREFIX . "custom_field_description cfd ON (cf.custom_field_id = cfd.custom_field_id) WHERE cfd.language_id = '" . (int) $this->config->get("config_language_id") . "'";
        }
        if (!empty($data["filter_name"])) {
            $sql .= " AND cfd.name LIKE '" . $this->db->escape($data["filter_name"]) . "%'";
        }
        if (!empty($data["filter_customer_group_id"])) {
            $sql .= " AND cfcg.customer_group_id = '" . (int) $data["filter_customer_group_id"] . "'";
        }
        $sort_data = array("cfd.name", "cf.type", "cf.location", "cf.status", "cf.sort_order");
        if (isset($data["sort"]) && in_array($data["sort"], $sort_data)) {
            $sql .= " ORDER BY " . $data["sort"];
        } else {
            $sql .= " ORDER BY cfd.name";
        }
        if (isset($data["order"]) && $data["order"] == "DESC") {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }
        if (isset($data["start"]) || isset($data["limit"])) {
            if ($data["start"] < 0) {
                $data["start"] = 0;
            }
            if ($data["limit"] < 1) {
                $data["limit"] = 20;
            }
            $sql .= " LIMIT " . (int) $data["start"] . "," . (int) $data["limit"];
        }
        $query = $this->db->query($sql);
        return $query->rows;
    }
    protected function validate()
    {
        return true;
    }
}
?>