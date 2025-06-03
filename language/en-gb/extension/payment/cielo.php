<?php
// Heading
$_['heading_title']                 = 'Checkout Cielo';

// Text
$_['text_extension']                = 'Extensões';
$_['text_success']                  = 'Pagamento por Checkout Cielo modificado com sucesso!';
$_['text_edit']                     = 'Configurações do pagamento por Checkout Cielo';
$_['text_cielo']                    = '<a target="_blank" href="https://www.cielo.com.br/aceite-cartao/checkout/"><img src="view/image/payment/cielo.jpg" alt="Checkout Cielo" title="Checkout Cielo" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_info_geral']               = 'Abaixo você deve preencher as configurações básicas da extensão.';
$_['text_info_api']                 = 'Abaixo você deve preencher as configurações para integração com o Checkout Cielo.';
$_['text_info_situacoes']           = 'Abaixo você deve selecionar as situações de pedido que serão atribuídas automaticamente pela extensão conforme o retorno da Cielo.';
$_['text_info_campos']              = 'Abaixo você deve selecionar onde a extensão encontrará os dados do cliente para enviar ao Checkout Cielo.<br>
                                       <strong>Importante:</strong> Caso ainda não tenha criado os campos personalizados, vá no menu <strong>Clientes->Personalizar cadastro</strong>.<br>
                                       <strong>Observação:</strong> Caso sua loja não utilize os campos personalizados, selecione a opção "Coluna na tabela de pedidos", e selecione a coluna (na tabela *_order).';
$_['text_info_finalizacao']         = 'As informações abaixo serão utilizadas no checkout da loja.';
$_['text_url_retorno']              = 'URL de retorno:';
$_['text_url_notificacao']          = 'URL de notificação:';
$_['text_url_status']               = 'URL de mudança de status:';
$_['text_campo']                    = 'Campo:';
$_['text_coluna']                   = 'Coluna na tabela de pedidos';
$_['text_razao']                    = 'Coluna Razão Social do cliente:';
$_['text_cnpj']                     = 'Coluna CNPJ do cliente:';
$_['text_cpf']                      = 'Coluna CPF do cliente:';
$_['text_numero_entrega']           = 'Coluna Número para entrega:';
$_['text_complemento_entrega']      = 'Coluna Complemento para entrega:';

// Tab
$_['tab_geral']                     = 'Configurações';
$_['tab_api']                       = 'API';
$_['tab_situacoes']                 = 'Situações';
$_['tab_campos']                    = 'Dados do cliente';
$_['tab_finalizacao']               = 'Finalização';

// Button
$_['button_save_stay']              = 'Salvar e continuar';
$_['button_save']                   = 'Salvar e sair';

// Entry
$_['entry_chave']                   = 'Chave da extensão:';
$_['entry_lojas']                   = 'Lojas:';
$_['entry_tipos_clientes']          = 'Tipos de clientes:';
$_['entry_total']                   = 'Total mínimo:';
$_['entry_geo_zone']                = 'Região geográfica:';
$_['entry_status']                  = 'Situação:';
$_['entry_sort_order']              = 'Posição:';
$_['entry_urls']                    = 'URLs para configuração:';
$_['entry_merchant_id']             = 'Merchant ID:';
$_['entry_soft_descriptor']         = 'Identificação na fatura:';
$_['entry_antifraude']              = 'Habilitar antifraude?';
$_['entry_debug']                   = 'Debug:';
$_['entry_desconto_credito']        = 'Desconto Crédito (%):';
$_['entry_desconto_debito']         = 'Desconto Débito (%):';
$_['entry_desconto_boleto']         = 'Desconto Boleto (%):';
$_['entry_desconto_extension']      = 'Extensão de desconto:';
$_['entry_situacao_pendente']       = 'Pendente:';
$_['entry_situacao_pago']           = 'Pago:';
$_['entry_situacao_negado']         = 'Negado:';
$_['entry_situacao_cancelado']      = 'Cancelado:';
$_['entry_situacao_nao_finalizado'] = 'Não finalizado:';
$_['entry_situacao_autorizado']     = 'Autorizado:';
$_['entry_custom_razao_id']         = 'Razão Social:';
$_['entry_custom_cnpj_id']          = 'CNPJ:';
$_['entry_custom_cpf_id']           = 'CPF:';
$_['entry_custom_numero_id']        = 'Número:';
$_['entry_custom_complemento_id']   = 'Complemento:';
$_['entry_titulo']                  = 'Título da extensão:';
$_['entry_imagem']                  = 'Imagem da extensão:';
$_['entry_one_checkout']            = 'Modo One Checkout:';

// Help
$_['help_chave']                    = 'Funciona por domínio, e é fornecida exclusivamente pelo OpenCart Brasil.';
$_['help_lojas']                    = 'Lojas em que a extensão será oferecida como forma de pagamento.';
$_['help_tipos_clientes']           = 'Tipos de clientes para quem a forma de pagamento será oferecida.';
$_['help_total']                    = 'É o valor mínimo que o pedido deve alcançar para que a extesão seja habilitada. Deixe em branco se não houver valor mínimo.';
$_['help_urls']                     = 'Utilizadas nas configurações de URL no Backoffice da Cielo.';
$_['help_merchant_id']              = 'É gerado e enviado ao lojista pela Cielo através de e-mail, após o envio do formulário que confirma o plano que será utilizado no Checkout Cielo. Contém letras, números e hífen.';
$_['help_soft_descriptor']          = 'Texto com até 13 caracteres que será impresso na fatura do cartão de crédito para que o cliente identifique a origem da cobrança. O texto não deve conter espaço, sinais de pontuação, acentuação ou ç, e as letras devem ser maiúsculas.';
$_['help_antifraude']               = 'Só selecione Sim, se no seu pacote de serviços do Checkout Cielo houver suporte para antifraude.';
$_['help_debug']                    = 'Selecione Sim, caso deseje visualizar as informações enviadas pela API da Cielo para a loja. Por padrão deixe Não.';
$_['help_desconto_credito']         = 'Percentual de desconto para pagamento no crédito à vista.';
$_['help_desconto_debito']          = 'Percentual de desconto para pagamento no débito online.';
$_['help_desconto_boleto']          = 'Percentual de desconto para pagamento no boleto.';
$_['help_desconto_extension']       = 'Caso você utilize uma extensão do tipo Total do pedido para aplicar desconto no pedido, selecione-a para o desconto ser enviado para o Checkout Cielo. O desconto será aplicado a todas as formas de pagamento habilitadas no Checkout Cielo.';
$_['help_situacao_pendente']        = 'Situação quando o pedido estiver pendente.';
$_['help_situacao_pago']            = 'Situação quando o pagamento for confirmado.';
$_['help_situacao_negado']          = 'Situação quando o pagamento for negado.';
$_['help_situacao_cancelado']       = 'Situação quando o pagamento for cancelado.';
$_['help_situacao_nao_finalizado']  = 'Situação quando o pagamento não estiver finalizado.';
$_['help_situacao_autorizado']      = 'Situação quando o pagamento for autorizado.';
$_['help_custom_razao_id']          = 'O campo Razão Social não é nativo do OpenCart, por isso, cadastre-o como um campo do tipo Conta, e selecione-o para que a extensão funcione corretamente.';
$_['help_custom_cnpj_id']           = 'O campo CNPJ não é nativo do OpenCart, por isso, cadastre-o como um campo do tipo Conta, e selecione-o para que a extensão funcione corretamente.';
$_['help_custom_cpf_id']            = 'O campo CPF não é nativo do OpenCart, por isso, cadastre-o como um campo do tipo Conta, e selecione-o para que a extensão funcione corretamente.';
$_['help_custom_numero_id']         = 'O campo Número não é nativo do OpenCart, por isso, cadastre-o como um campo do tipo Endereço, e selecione-o para que a extensão funcione corretamente.';
$_['help_custom_complemento_id']    = 'O campo Complemento não é nativo do OpenCart, por isso, cadastre-o como um campo do tipo Endereço, e selecione-o para que a extensão funcione corretamente.';
$_['help_titulo']                   = 'Título da forma de pagamento Checkout Cielo que será exibido para o cliente na etapa de seleção da forma de pagamento.';
$_['help_imagem']                   = 'Caso não deseje exibir um título, você pode selecionar uma imagem que será exibida para o cliente na etapa de seleção da forma de pagamento.';
$_['help_one_checkout']             = 'Selecione Sim, caso esteja utilizando um checkout em que seja necessário salvar os dados do cliente antes de finalizar o pedido.';

// Error
$_['error_permission']              = 'Atenção: Você não tem permissão para modificar a extensão Checkout Cielo!';
$_['error_warning']                 = 'Atenção: A extensão não foi configurada corretamente! Verifique todos os campos para corrigir os erros.';
$_['error_chave']                   = 'É necessário adicionar pelo menos uma chave.';
$_['error_stores']                  = 'É necessário selecionar pelo menos uma loja.';
$_['error_customer_groups']         = 'É necessário selecionar pelo menos um tipo de cliente.';
$_['error_merchant_id']             = 'O campo Merchant ID é obrigatório.';
$_['error_soft_descriptor']         = 'O campo foi preenchido incorretamente.';
$_['error_campos_coluna']           = 'Selecione a coluna.';
$_['error_titulo']                  = 'O campo Título da extensão é obrigatório.';