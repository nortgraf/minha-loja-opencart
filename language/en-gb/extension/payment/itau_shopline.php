<?php
// Heading
$_['heading_title']               = 'Itaú Shopline';

// Text
$_['text_extension']              = 'Extensões';
$_['text_success']                = 'Pagamento por Itaú Shopline modificado com sucesso!';
$_['text_edit']                   = 'Configurações do pagamento por Itaú Shopline';
$_['text_itau_shopline']          = '<a target="_blank" href="https://www.itau.com.br/empresas/pagamentos-recebimentos/shopline/"><img src="view/image/payment/itau_shopline.gif" alt="Itaú Shopline" title="Itaú Shopline" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_info_geral']             = 'Abaixo você deve preencher as configurações básicas da extensão.';
$_['text_info_api']               = 'Abaixo você deve preencher as configurações para integração com o Itaú Shopline.<br>
                                    <strong>Importante:</strong> O Código do site e a Chave de criptografia são fornecidos pelo Itaú.';
$_['text_info_situacoes']         = 'Abaixo você deve selecionar as situações de pedido que serão atribuídas automaticamente pela extensão conforme o retorno do Itaú Shopline.';
$_['text_info_campos']            = 'Configurações para indetificar as informações extras no cadastro do cliente que devem ser enviadas para o Itaú Shopline.<br>
                                    <strong>Importante:</strong> Para cadastrar campos personalizados, vá no menu <strong>Clientes > Personalizar cadastro</strong> e cadastre os campos extras como CPF e número do endereço.<br>
                                    <strong>Observação:</strong> Se os campos extras foram criados diretamente na tabela de pedidos, selecione a opção "<strong>Coluna na tabela de pedidos</strong>", e selecione a coluna na tabela *_order correspondente.';
$_['text_info_finalizacao']       = 'As informações abaixo serão utilizadas no checkout da loja.';
$_['text_url_retorno']            = 'Acesse sua conta no Itaú e cadastre a URL exatamente como está abaixo:';
$_['text_linha_comando']          = 'Cadastre a linha de comando abaixo no agendador de tarefas de sua hospedagem para ser executado a cada 1 hora:';
$_['text_campo']                  = 'Campo:';
$_['text_coluna']                 = 'Coluna na tabela de pedidos';
$_['text_razao']                  = 'Coluna Razão Social:';
$_['text_cnpj']                   = 'Coluna CNPJ:';
$_['text_cpf']                    = 'Coluna CPF:';
$_['text_numero_fatura']          = 'Coluna Número para fatura:';
$_['text_complemento_fatura']     = 'Coluna Complemento para fatura:';

// Tab
$_['tab_geral']                   = 'Configurações';
$_['tab_api']                     = 'API';
$_['tab_situacoes']               = 'Situações do pedido';
$_['tab_campos']                  = 'Dados do cliente';
$_['tab_finalizacao']             = 'Finalização';

// Button
$_['button_save_stay']            = 'Salvar e continuar';
$_['button_save']                 = 'Salvar e sair';

// Entry
$_['entry_chave']                 = 'Chave da extensão:';
$_['entry_lojas']                 = 'Lojas:';
$_['entry_tipos_clientes']        = 'Tipos de clientes:';
$_['entry_total']                 = 'Total mínimo:';
$_['entry_geo_zone']              = 'Região geográfica:';
$_['entry_status']                = 'Situação:';
$_['entry_sort_order']            = 'Posição:';
$_['entry_codigo_site']           = 'Código do site:';
$_['entry_chave_criptografia']    = 'Chave de criptografia:';
$_['entry_url_retorno']           = 'URL de retorno:';
$_['entry_linha_comando']         = 'Linha de comando:';
$_['entry_url_key']               = 'Chave de segurança:';
$_['entry_email_notificacao']     = 'E-mail de notificação:';
$_['entry_vencimento']            = 'Dias para vencimento:';
$_['entry_expirar']               = 'Minutos para expirar:';
$_['entry_observacao1']           = '1ª observação:';
$_['entry_observacao2']           = '2ª observação:';
$_['entry_observacao3']           = '3ª observação:';
$_['entry_prefixo']               = 'Remover prefixo:';
$_['entry_sufixo']                = 'Remover sufixo:';
$_['entry_debug']                 = 'Debug:';
$_['entry_aguardando']            = 'Aguardando pagamento:';
$_['entry_gerado']                = 'Boleto gerado:';
$_['entry_compensando']           = 'Boleto compensando:';
$_['entry_nao_compensado']        = 'Boleto não compensado:';
$_['entry_pago']                  = 'Pago:';
$_['entry_cancelado']             = 'Cancelado:';
$_['entry_custom_razao_id']       = 'Razão Social:';
$_['entry_custom_cnpj_id']        = 'CNPJ:';
$_['entry_custom_cpf_id']         = 'CPF:';
$_['entry_custom_numero_id']      = 'Número:';
$_['entry_custom_complemento_id'] = 'Complemento:';
$_['entry_titulo']                = 'Título da extensão:';
$_['entry_imagem']                = 'Imagem da extensão:';
$_['entry_instrucoes']            = 'Instruções para pagamento:';
$_['entry_texto_botao']           = 'Texto do botão confirmar:';
$_['entry_codigo_css']            = 'Código CSS:';

// Help
$_['help_chave']                  = 'A chave da extensão funciona por domínio, e é fornecida exclusivamente pelo OpenCart Brasil.';
$_['help_lojas']                  = 'Lojas em que a extensão será oferecida como forma de pagamento.';
$_['help_tipos_clientes']         = 'Tipos de clientes para quem a forma de pagamento será oferecida.';
$_['help_total']                  = 'Total mínimo que o pedido deve alcançar para a extensão seja habilitada. Deixe em branco se não houver total mínimo.';
$_['help_codigo_site']            = 'É fornecido pelo Itaú Shopline. Possui exatos 26 caracteres e deve ser preenchido em maiúsculo.';
$_['help_chave_criptografia']     = 'É fornecida pelo Itaú Shopline. Possui exatos 16 caracteres e deve ser preenchido em maiúsculo.';
$_['help_url_retorno']            = 'Utilizada para receber as informações do Itaú Shopline e gerar segunda via do boleto.';
$_['help_linha_comando']          = 'Utilizada para consultar o status das transações no Itaú Shopline e atualizar a situação dos pedidos.';
$_['help_url_key']                = 'Utilizada para proteger a URL da linha de comando. Utilize apenas letras e números.';
$_['help_email_notificacao']      = 'Selecione Sim, caso deseje receber um e-mail de notificação quando o status da transação for alterado.';
$_['help_vencimento']             = 'Dias somados na data do pedido para calcular a data de vencimento no boleto bancário.';
$_['help_expirar']                = 'Minutos para expirar o pedido com Itaú Shopline, caso o cliente não escolha uma opção de pagamento. Deixe 0 para não expirar.';
$_['help_observacao1']            = 'Linha de informação adicional impressa no boleto bancário. Deve possuir no máximo 60 caracteres.';
$_['help_observacao2']            = 'Linha de informação adicional impressa no boleto bancário. Deve possuir no máximo 60 caracteres.';
$_['help_observacao3']            = 'Linha de informação adicional impressa no boleto bancário. Deve possuir no máximo 60 caracteres.';
$_['help_prefixo']                = 'Caso o código de seus pedidos seja maior que 8 caracteres pelo acréscimo de prefixo, digite o prefixo para remoção.';
$_['help_sufixo']                 = 'Caso o código de seus pedidos seja maior que 8 caracteres pelo acréscimo de sufixo, digite o sufixo para remoção.';
$_['help_debug']                  = 'Selecione Habilitado caso deseje visualizar as informações recebidas através da API do Itaú Shopline. Por padrão deixe Desabilitado.';
$_['help_aguardando']             = 'Pedido aguardando pagamento.';
$_['help_gerado']                 = 'Quando o boleto for gerado.';
$_['help_compensando']            = 'Quando o boleto for compensando.';
$_['help_nao_compensado']         = 'Quando o boleto não for compensado.';
$_['help_pago']                   = 'Quando o pagamento for confirmado.';
$_['help_cancelado']              = 'Quando uma forma de pagamento não é selecionada em até 1 hora após o pedido.';
$_['help_custom_razao_id']        = 'Só selecione se você tiver o campo para preencher a Razão Social no cadastro do cliente.';
$_['help_custom_cnpj_id']         = 'Só selecione se você tiver o campo para preencher o CNPJ no cadastro do cliente.';
$_['help_custom_cpf_id']          = 'Selecione o campo que armazena o CPF no cadastro do cliente.';
$_['help_custom_numero_id']       = 'Selecione o campo que armazena o número no endereço do cliente.';
$_['help_custom_complemento_id']  = 'Só selecione se você tiver o campo para preencher o complemento no endereço do cliente.';
$_['help_titulo']                 = 'Título que será exibido na finalização do pedido.';
$_['help_imagem']                 = 'Caso selecione uma imagem, ela será exibida no lugar do título da extensão.';
$_['help_instrucoes']             = 'Você pode selecionar uma página de informações com instruções.';
$_['help_texto_botao']            = 'É exibido dentro do botão.';
$_['help_codigo_css']             = 'Utilizado para estilizar a aparência dos dados para pagamento exibidos na página de sucesso (após confirmar o pedido).';

// Error
$_['error_permission']            = 'Atenção: Você não tem permissão para modificar a extensão Itaú Shopline!';
$_['error_warning']               = 'Atenção: A extensão não foi configurada corretamente! Verifique todos os campos para corrigir os erros.';
$_['error_chave']                 = 'É necessário adicionar pelo menos uma chave.';
$_['error_stores']                = 'É necessário selecionar pelo menos uma loja.';
$_['error_customer_groups']       = 'É necessário selecionar pelo menos um tipo de cliente.';
$_['error_codigo_site']           = 'O campo possui exatos 26 caracteres.';
$_['error_chave_criptografia']    = 'O campo possui exatos 16 caracteres.';
$_['error_vencimento']            = 'O campo só aceita números.';
$_['error_expirar']               = 'O campo só aceita números.';
$_['error_observacao']            = 'O campo não pode ter mais que 60 caracteres.';
$_['error_campos_coluna']         = 'Selecione o nome da coluna.';
$_['error_obrigatorio']           = 'O preenchimento é obrigatório.';
