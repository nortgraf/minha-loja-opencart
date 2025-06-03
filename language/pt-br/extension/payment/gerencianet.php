<?php

$_['heading_title'] = 'Gerencianet';
$_['text_payment'] = 'Extensões';
$_['text_success'] = 'Informações salvas com sucesso';
$_['text_error'] = 'Erro ao salvar informações.';
$_['text_error_webhook'] = 'Erro ao Cadastrar Webhook. Por favor, verifique as informações.';
$_['text_error_https_webhook'] = 'Identificamos que o seu domínio não possui certificado de segurança HTTPS ou não é válido para registrar o Webhook!';
$_['payment_gerencianet_painel_header'] = 'Configuração';
$_['payment_gerencianet_pix'] = 'PIX';
$_['payment_gerencianet_about'] = 'Sobre';
$_['payment_gerencianet_empty_field'] = ' é um campo obrigatório';
$_['text_gerencianet']           = '<img class="logo_icon" src="view/image/icons/logo_gerencianet.webp" style="width: 113px;" />';
$_['text_d5gn_pix']           = '<img class="logo_icon" src="view/image/icons/logo_gerencianet.webp" style="width: 113px;" />';

// General options
$_['payment_gerencianet_prod_client_id'] = 'Client_ID Produção';
$_['payment_gerencianet_prod_client_secret'] = 'Client_Secret Produção';
$_['payment_gerencianet_dev_client_id'] = 'Client_ID Desenvolvimento';
$_['payment_gerencianet_dev_client_secret'] = 'Client_Secret Desenvolvimento';
$_['payment_gerencianet_payee_id'] = 'Código Identificador da Conta';
$_['payment_gerencianet_debug'] = 'Debug';

// Pix options
$_['payment_gerencianet_pix_key'] = 'Chave PIX';
$_['payment_gerencianet_certificate'] = 'Caminho do certificado';
$_['payment_gerencianet_certificate_info'] = 'Adicione o arquivo (.pem) em uma pasta privada no servidor e informe o caminho completo';
$_['payment_gerencianet_discount'] = 'Desconto no pagamento (%)';
$_['payment_gerencianet_discount_info'] = 'Valor do Percentual de Desconto. Ex.: 5';
$_['payment_gerencianet_due_date'] = 'Tempo de vencimento (horas)';
$_['payment_gerencianet_mtls'] = 'Validar mTLS';
$_['payment_gerencianet_mtls_info'] = 'Entenda os riscos de não configurar o mTLS acessando o link https://gnetbr.com/rke4baDVyd';
$_['payment_gerencianet_sandbox'] = 'Habilitar modo sandbox';
$_['payment_gerencianet_status'] = 'Ativo';
$_['payment_gerencianet_status_info'] = 'Habilitar ou Desabilitar a Extensão da Gerencianet';

// Order Status options
$_['payment_gerencianet_order_status'] = 'Status do Pedido';
$_['payment_gerencianet_status_new'] = 'Inicial';
$_['payment_gerencianet_status_paid'] = 'Completo';
$_['payment_gerencianet_status_refunded'] = 'Reembolso';