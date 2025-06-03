<?php
/**
 * Módulo Plano de Parcelamento
 * 
 * @author  Cuispi
 * @version 2.4.4
 * @license Commercial License
 * @package admin
 * @subpackage  admin.language.pt-br.extension.module
 */

// Heading
$_['heading_title']                               = 'Plano de Parcelamento';

// Text
$_['text_extension']                              = 'Extensões';
$_['text_module']                                 = 'Módulos';
$_['text_success']                                = 'Sucesso: A configuração do Plano de Informação de Parcelamento foram salvas!';
$_['text_edit']                                   = 'Configurações do módulo Plano de Parcelamento';
$_['text_new']                                    = 'Novo';
$_['text_general']                                = 'Geral';
$_['text_editor']                                 = 'Editor de Texto';
$_['text_hide_on_selected_pages']                 = 'Ocultar nas páginas selecionadas';
$_['text_show_on_selected_pages']                 = 'Mostrar nas páginas selecionadas';
$_['text_product_select_no_results']              = 'Nenhum produto foi adicionado ainda';
$_['text_check_all']                              = 'Marcar Todos';
$_['text_uncheck_all']                            = 'Desmarcar Todos';
$_['text_guest_users']                            = 'Usuários Convidados';
$_['text_expand_all']                             = 'Expandir Tudo';
$_['text_collapse_all']                           = 'Recolher Tudo';
$_['text_confirm_delete']                         = 'Tem certeza de que deseja excluir este item?';
$_['text_confirm_changes_will_be_lost']           = 'Se você sair desta página sem salvar os dados, as alterações serão perdidas.\nVocê tem certeza de que deseja sair desta página?';
$_['text_on']                                     = 'Ativo';
$_['text_off']                                    = 'Inativo';
$_['text_percent']                                = '%';
$_['text_times_sign']                             = 'x';
$_['text_up_to']                                  = 'Até';
$_['text_template_include_code_shown_later']      = 'O código será exibido após a operação de salvar for concluída.';
$_['text_no_data']                                = 'Nenhuma informação disponível';
$_['text_heading_general']                        = 'Geral';
$_['text_heading_display_conditions']             = 'Condições de Exibição';
$_['text_heading_template']                       = 'Arquivo de Modelo';
$_['text_heading_scripts_and_styles']             = 'Scripts e Estilos';
$_['text_heading_misc']                           = 'Diversos';
$_['text_usage_template_include_oc2x_1']          = 'Mostrar o módulo na página do Produto:';
$_['text_usage_template_include_oc2x_2']          = 'Mostrar o módulo (mensagem promocional) em Departamentos, Produtos em Promoção, Destaques, Mais Recentes, e assim por diante:';
$_['text_usage_template_include_1']               = 'Mostrar o módulo na página do Produto:';
$_['text_usage_template_include_2']               = 'Mostrar o módulo (mensagem promocional) em Departamentos (página), Produtos em Promoção (página), Marcas (página), Pesquisa (página), Produtos Mais Vendidos (módulo), Mais Recentes/Produtos Novos (módulo), Produtos em Promoção (módulo), e Destaques (módulo):';
$_['text_template_include_usage_3x_1']            = 'Adicione este código ao arquivo de view de produto (<code>catalog/view/theme/{SEU TEMA}/template/product/product.twig</code>) para incluir este módulo dentro do seu tema:';
$_['text_template_include_usage_3x_2']            = 'Insira este código antes <code> {% if product.tax%} </code> no arquivo de view (.twig) para incluir este módulo dentro do seu tema:';

// Column
$_['column_image']                                = 'Imagem';
$_['column_max_term']                             = 'Número Máximo de Parcelas';
$_['column_name']                                 = 'Nome';
$_['column_sort_order']                           = 'Posição';
$_['column_status']                               = 'Situação';

// Entry
$_['entry_name']                                  = 'Módulo';
$_['entry_title']                                 = 'Título';
$_['entry_title_link']                            = 'Link';
$_['entry_html_content']                          = 'Conteúdo HTML';
$_['entry_image']                                 = 'Imagem';
$_['entry_width']                                 = 'Largura';
$_['entry_height']                                = 'Altura';
$_['entry_status']                                = 'Situação';
$_['entry_stores']                                = 'Lojas';
$_['entry_customer_groups']                       = 'Tipos de Cliente';
$_['entry_categories']                            = 'Departamentos';
$_['entry_products']                              = 'Produtos';
$_['entry_max_instal_amt']                        = 'Valor Máximo de Parcelamento';
$_['entry_min_instal_amt']                        = 'Valor Mínimo de Parcelamento';
$_['entry_min_price']                             = 'Valor Mínimo de Preço';
$_['entry_template']                              = 'Arquivo de Modelo';
$_['entry_use_custom_template']                   = 'Usar um arquivo de modelo personalizado';
$_['entry_external_css']                          = 'CSS Externo';
$_['entry_external_js']                           = 'JS Externo';
$_['entry_use_default_stylesheet']                = 'Ativar o CSS principal dessa extensão';
$_['entry_internal_css']                          = 'CSS Interno';
$_['entry_use_default_javascript']                = 'Ativar o JavaScript principal dessa extensão';
$_['entry_internal_js']                           = 'JS Interno';
$_['entry_params']                                = 'Parâmetros';
$_['entry_installment_plan_provider']             = 'Fornecedor de Serviços de Pagamento';
$_['entry_installment_plan_plan']                 = 'Plano';
$_['entry_installment_plan_direct_debit_pay_fee'] = 'Taxa Débito';
$_['entry_installment_plan_lump_sum_pay_fee']     = 'Taxa Crédito a Vista';
$_['entry_installment_plan_instal_pay_fee']       = 'Taxa de Crédito Parcelado';
$_['entry_installment_plan_fee_per_instal']       = 'Taxa de Parcelamento';
$_['entry_installment_plan_ar_collection']        = 'Plano de Recebimento';
$_['entry_installment_plan_anticipation_fee']     = 'Taxa de Antecipação';
$_['entry_installment_plan_discount_rate']        = 'Taxa de Desconto';
$_['entry_installment_plan_fixed_fee']            = 'Tarifa Fixa';
$_['entry_installment_plan_comment']              = 'Comentário';
$_['entry_installment_plan_promo_message']        = 'Mensagem Promocional';
$_['entry_installment_plan_link']                 = 'Link';
$_['entry_installment_plan_params']               = 'Parâmetros';
$_['entry_installment_plan_status']               = 'Situação';
$_['entry_cc_icon_width_and_height']              = 'Tamanho de Bandeiras';
$_['entry_cc_icon_width']                         = 'Largura';
$_['entry_cc_icon_height']                        = 'Altura';
$_['entry_config_status']                         = 'Situação da Extensão';
$_['entry_config_number_format']                  = 'Formato do Número';
$_['entry_config_js_debug']                       = 'Depuração de JavaScript';
$_['entry_config_editor_status']                  = 'Situação';
$_['entry_config_editor_lang']                    = 'Língua';
$_['entry_config_editor_height']                  = 'Altura';
$_['entry_config_editor_tabsize']                 = 'Tamanho do Tab';
$_['entry_config_editor_codemirror_theme']        = 'Tema de Exibição de Código';
$_['entry_template_include_usage']                = 'Inclusão de Arquivo de Modelo';

  // Help
$_['help_title']                                  = 'Este é o título a ser mostrado na parte superior do módulo.';
$_['help_title_link']                             = 'O hiperlink para o texto do Título. Deixe em branco para desativar esse recurso.';
$_['help_html_content']                           = 'Este é o conteúdo HTML a ser exibido na frente da loja.<br />Para executar o código JavaScript, é altamente recomendável que você escreva seu código na guia Módulos > Seção de Scripts e Estilos > campo JS Interno.';
$_['help_status']                                 = 'Selecione Habilitado para tornar este módulo habilitado no front de sua loja, ou Desabilitado para não usá-lo. A Situação da Extensão na guia Configuração deve primeiro ser definido como Habilitado antes que esta opção possa ser disponibilizada.';
$_['help_stores']                                 = 'Escolha as lojas em que deseja mostrar o módulo.';
$_['help_customer_groups']                        = 'Especifica quais grupos são capazes de visualizar o módulo. Você pode ter mais controle adicionando um grupo de clientes.';
$_['help_categories']                             = 'Este módulo deve primeiro ser atribuído a um layout Category antes que esta opção possa ser disponibilizada.';
$_['help_products']                               = 'Este módulo deve primeiro ser atribuído ao layout de Produto (product/product) antes que esta opção possa ser disponibilizada.';
$_['help_product_select_autocomplete']            = 'Pesquise e adicione produtos';
$_['help_min_instal_amt']                         = 'Especifica a quantidade necessária antes que um único plano de parcelamento fique disponível.';
$_['help_max_instal_amt']                         = 'Especifica a quantidade necessária antes que um único plano de parcelamento fique indisponível.';
$_['help_min_price']                              = 'Especifica o preço necessário antes que este módulo fique disponível.';
$_['help_template']                               = 'Determina se você irá usar um modelo personalizado. Você pode criar um novo modelo a partir do zero ou copiando um modelo existente. O caminho base é:<br /><code>catalog/view/theme/[YOUR_THEME]/template/' . (version_compare(VERSION, '2.3.0.0', '>=') ? 'extension/' : '') . 'module/</code>';
$_['help_template_include_usage']                 = 'Isso é particularmente útil quando você deseja mostrar o módulo em algum lugar diferente dos layouts disponíveis no OpenCart. É altamente recomendável que você use OCMod ou vQmod em vez de modificar diretamente seus arquivos de tema para adicionar o código.';
$_['help_external_css']                           = 'Digite o caminho para o(s) arquivo(s) CSS externo(s) que você deseja incluir; p. ex.,<br /><code>catalog/view/theme/[THEME]/stylesheet/meu-arquivo-css.css</code><br />O caminho de base aponta para o diretório raiz do OpenCart. Use a seguinte tag para o tema selecionado:<br /><code>[THEME]</code><br />A tag acima é substituída automaticamente por um nome de pasta de tema ativo no carregamento da página.<br />Um arquivo por linha.';
$_['help_use_default_stylesheet']                 = 'Determina se deve ou não incluir o arquivo CSS principal desta extensão, localizado em:<br /><code>catalog/view/theme/default/stylesheet/plano_de_parcelamento/plano_de_parcelamento.css</code><br />Para personalizar as regras CSS definidas no arquivo "info.css do plano de instalação", copie e coloque o arquivo na pasta correspondente em seu tema personalizado.';
$_['help_external_js']                            = 'Digite o caminho para o(s) arquivo(s) CSS externo(s) que você deseja incluir; p. ex.,<br /><code>catalog/view/theme/[THEME]/javascript/meu-arquivo-js.js</code><br />O caminho de base aponta para o diretório raiz do OpenCart. Use a seguinte tag para o tema selecionado:<br /><code>[THEME]</code><br />A tag acima é substituída automaticamente por um nome de pasta de tema ativo no carregamento da página.<br />Um arquivo por linha.';
$_['help_use_default_javascript']                 = 'Determina se deve ou não incluir o arquivo JS principal desta extensão, localizado em:<br /><code>catalog/view/javascript/plano_de_parcelamento/plano_de_parcelamento.min.js</code>';
$_['help_internal_css']                           = 'Adicione seu estilo personalizado aqui. É altamente recomendável que você adicione a seguinte tag ao início de cada declaração de regra CSS para limitar a extensão dos estilos criados para que ele não afete em qualquer outro lugar, exceto este módulo no front-end de sua loja(s).<table><tr><td><code>[module]</code></td><td>Um contêiner que contém a saída do módulo.</td></tr></table>A marca acima é substituída automaticamente com um seletor CSS válido no carregamento da página.';
$_['help_internal_js']                            = 'Adicione seu JavaScript personalizado aqui.<br />É altamente recomendável que você use a seguinte tag para limitar a extensão do código criado para que ele não afete em qualquer outro lugar, mas este módulo no front-end de sua loja(s).<table><tr><td><code>[module]</code></td><td>Um contêiner que contém a saída do módulo.</td></tr></table>Ele acima tag é substituído automaticamente com um seletor jQuery válido no carregamento da página.';
$_['help_params']                                 = 'Este é um recurso avançado e é recomendado para aqueles que têm um conhecimento básico de PHP.<br />Os parâmetros opcionais podem ser passados para o arquivo de modelo como variáveis no formato de:<br /><code>key: value</code><br />Você pode acessar os valores no arquivo de modelo:<br />' . (version_compare(VERSION, '3.0.0.0', '<') ? '<code>echo $params[&#39;key&#39;];</code>' : '<code>{{ params.key }}</code>') . '<br />Um par de valores-chave por linha.';
$_['help_installment_plan_provider']              = 'Especifica um fornecedor de serviços de pagamento a ser usada para cálculo de parcelamento.';
$_['help_installment_plan_plan']                  = 'Especifica um plano de pagamento.';
$_['help_installment_plan_direct_debit_pay_fee']  = 'Taxa cobrada por vendas a débito.';
$_['help_installment_plan_lump_sum_pay_fee']      = 'Taxa cobrada por vendas a crédito à vista.';
$_['help_installment_plan_instal_pay_fee']        = 'Taxa cobrada por vendas em crédito parcelado.';
$_['help_installment_plan_fee_per_instal']        = 'Taxa cobrada por parcela por vendas em crédito parcelado.';
$_['help_installment_plan_ar_collection']         = 'Possibilita o recebimento de todo o valor das vendas parceladas em uma única vez (antecipação) ou em parcelas.';
$_['help_installment_plan_anticipation_fee']      = 'Taxa cobrada quando o vendedor opta por receber os valores de suas vendas antecipadamente.';
$_['help_installment_plan_discount_rate']         = 'Especifica a quantidade de desconto em forma de porcentagem.';
$_['help_installment_plan_fixed_fee']             = 'Entre com uma tarifa fixa se existir.';
$_['help_installment_plan_comment']               = 'Especifica o texto do comentário. Os seguintes símbolos estão disponíveis para uso, e serão substituídos por valores reais dinamicamente, quando a saída HTML estiver sendo processada.<table><tr><td><code>{preco}</code></td><td>Preço</td></tr><tr><td><code>{qt_de_parcelas}</code></td><td>Quantidades de parcelas</td></tr><tr><td><code>{tx_debito}</code></td><td>Taxa débito</td></tr><tr><td><code>{tx_credito_vista}</code></td><td>Taxa crédito a vista</td></tr><tr><td><code>{tx_credito_parcelado}</code></td><td>Taxa de crédito parcelado</td></tr><tr><td><code>{tx_parcelamento}</code></td><td>Taxa de parcelamento</td></tr><tr><td><code>{tx_desconto}</code></td><td>Taxa de desconto</td></tr><tr><td><code>{valor_da_parcela}</code></td><td>Valor da parcela</td></tr></table>';
$_['help_installment_plan_promo_message']         = 'Especifica a mensagem promocional.. Os seguintes símbolos estão disponíveis para uso, e serão substituídos por valores reais dinamicamente, quando a saída HTML estiver sendo processada.<table><tr><td><code>{preco}</code></td><td>Preço</td></tr><tr><td><code>{qt_de_parcelas}</code></td><td>Quantidades de parcelas</td></tr><tr><td><code>{tx_debito}</code></td><td>Taxa débito</td></tr><tr><td><code>{tx_credito_vista}</code></td><td>Taxa crédito a vista</td></tr><tr><td><code>{tx_credito_parcelado}</code></td><td>Taxa de crédito parcelado</td></tr><tr><td><code>{tx_parcelamento}</code></td><td>Taxa de parcelamento</td></tr><tr><td><code>{tx_desconto}</code></td><td>Taxa de desconto</td></tr><tr><td><code>{valor_da_parcela}</code></td><td>Valor da parcela</td></tr></table>';
$_['help_installment_plan_link']                  = 'O hiperlink para as parcelas. Deixe em branco para desativar esse recurso.';
$_['help_installment_plan_params']                = 'Este é um recurso avançado e é recomendado para aqueles que têm um conhecimento básico de PHP.<br />Os parâmetros opcionais podem ser passados para o arquivo de modelo como variáveis no formato de:<br /><code>key: value</code><br />Você pode acessar os valores dentro do loop no arquivo de modelo:<br />' . (version_compare(VERSION, '3.0.0.0', '<') ? '<code>echo $installment_plan[&#39;params&#39;][&#39;key&#39;];</code>' : '<code>{{ installment_plan.params.key }}</code>') . '<br />Um par de valores-chave por linha.';
$_['help_config_status']                          = 'Selecione Habilitado para usar esta extensão, ou Desabilitado para não usá-lo.';
$_['help_config_js_debug']                        = 'Quando a Depuração de JavaScript está ativada, a extensão registra informações detalhadas no console JavaScript de seu navegador da Web. Isso deve ser definido como Inativo por razões de segurança quando não for usado.';

// Tab
$_['tab_modules']                                 = 'Módulos';
$_['tab_config']                                  = 'Configuração';
$_['tab_layouts']                                 = 'Layouts';
$_['tab_help']                                    = 'Ajuda';
$_['tab_general']                                 = 'Geral';
$_['tab_installment_plans']                       = 'Planos de Parcelamento';
$_['tab_cards']                                   = 'Bandeiras de Cartões';

// Button
$_['button_add_new']                              = 'Novo';
$_['button_save_and_close']                       = 'Salvar e Fechar';
$_['button_move_down']                            = 'Descer';
$_['button_move_up']                              = 'Subir';
$_['button_remove']                               = 'Remover';
$_['button_add_new_autofill']                     = 'Novo (Autofill)';

// Error
$_['error_warning']                               = 'Atenção: Faltou preencher alguma informação, verifique todos os campos!';
$_['error_permission']                            = 'Atenção: Você não tem permissão para modificar o módulo Plano de Parcelamento!';
$_['error_name']                                  = 'O módulo deve ter entre 3 e 64 caracteres!';
$_['error_width']                                 = 'Largura inválida!';
$_['error_height']                                = 'Altura inválida!';
$_['error_cc_icon_width']                         = 'Largura vazia ou inválida!';
$_['error_cc_icon_height']                        = 'Altura vazia ou inválida!';
$_['error_modification_not_loaded']               = 'Erro: a modificação não está instalada ou desativada!';
$_['error_library_not_loaded']                    = 'Erro: a biblioteca não está carregada!';
$_['error_admin_js_not_loaded']                   = 'Erro: o arquivo Admin JS não está carregado!';

// Payment service providers
$_['provider_boleto_or_deposito']                 = 'Boleto ou Depósito Bancário';
$_['provider_cielo']                              = 'Cielo';
$_['provider_getnet']                             = 'GetNet';
$_['provider_mercadopago']                        = 'MercadoPago';
$_['provider_pagseguro']                          = 'PagSeguro';
$_['provider_paypal_brazil']                      = 'PayPal Brasil';
$_['provider_rede']                               = 'Rede';
$_['provider_custom']                             = 'Personalizadas';

// Plans
$_['plan_debit']                                  = 'Débito';
$_['plan_credit_1x']                              = 'Crédito 1x';
$_['plan_credit_2x']                              = 'Crédito 2x';
$_['plan_credit_3x']                              = 'Crédito 3x';
$_['plan_credit_4x']                              = 'Crédito 4x';
$_['plan_credit_5x']                              = 'Crédito 5x';
$_['plan_credit_6x']                              = 'Crédito 6x';
$_['plan_credit_7x']                              = 'Crédito 7x';
$_['plan_credit_8x']                              = 'Crédito 8x';
$_['plan_credit_9x']                              = 'Crédito 9x';
$_['plan_credit_10x']                             = 'Crédito 10x';
$_['plan_credit_11x']                             = 'Crédito 11x';
$_['plan_credit_12x']                             = 'Crédito 12x';
$_['plan_credit_13x']                             = 'Crédito 13x';
$_['plan_credit_14x']                             = 'Crédito 14x';
$_['plan_credit_15x']                             = 'Crédito 15x';
$_['plan_credit_16x']                             = 'Crédito 16x';
$_['plan_credit_17x']                             = 'Crédito 17x';
$_['plan_credit_18x']                             = 'Crédito 18x';
$_['plan_credit_19x']                             = 'Crédito 19x';
$_['plan_credit_20x']                             = 'Crédito 20x';
$_['plan_credit_21x']                             = 'Crédito 21x';
$_['plan_credit_22x']                             = 'Crédito 22x';
$_['plan_credit_23x']                             = 'Crédito 23x';
$_['plan_credit_24x']                             = 'Crédito 24x';
$_['plan_discount']                               = 'Desconto';

// Accounts receivable (AR) collections
$_['ar_collection_2_days']                        = '2 Dias';
$_['ar_collection_14_days']                       = '14 Dias';
$_['ar_collection_30_days']                       = '30 Dias';
$_['ar_collection_45_days']                       = '45 Dias';
$_['ar_collection_30_days_tarja']                 = '30 Dias - Tarja';
$_['ar_collection_45_days_tarja']                 = '45 Dias - Tarja';
$_['ar_collection_anticipated']                   = 'Antecipado';
$_['ar_collection_in_installments']               = 'Em parcelas';

// Cards
$_['cards']['2checkout']                   = '2Checkout';
$_['cards']['agiplan']                     = 'Agiplan';
$_['cards']['amex']                        = 'American Express';
$_['cards']['aura']                        = 'Aura';
$_['cards']['avista']                      = 'Avista';
$_['cards']['bacs']                        = 'Bacs';
$_['cards']['banco_do_brasil']             = 'Banco do Brasil';
$_['cards']['banco_santander']             = 'Banco Santander';
$_['cards']['banes_card']                  = 'Banes card';
$_['cards']['banrisul']                    = 'Banrisul';
$_['cards']['bcash']                       = 'Bcash';
$_['cards']['bitcoin']                     = 'Bitcoin';
$_['cards']['boleto']                      = 'Boleto Bancário';
$_['cards']['bradesco']                    = 'Bradesco';
$_['cards']['brasilcard']                  = 'Brasilcard';
$_['cards']['cabal']                       = 'Cabal';
$_['cards']['caixa']                       = 'Caixa Econômica Federal';
$_['cards']['cardban']                     = 'CARDBAN';
$_['cards']['chaps']                       = 'CHAPS';
$_['cards']['cielo']                       = 'Cielo';
$_['cards']['cirrus']                      = 'Cirrus';
$_['cards']['cooper_card']                 = 'Cooper Card';
$_['cards']['credz']                       = 'CREDZ';
$_['cards']['delta']                       = 'Delta';
$_['cards']['diners']                      = 'Diners Club';
$_['cards']['discover']                    = 'Discover';
$_['cards']['elo']                         = 'Elo';
$_['cards']['fortbrasil']                  = 'FortBrasil';
$_['cards']['grandcard']                   = 'GrandCard';
$_['cards']['hiper']                       = 'Hiper';
$_['cards']['hipercard']                   = 'Hipercard';
$_['cards']['hsbc']                        = 'HSBC';
$_['cards']['itau']                        = 'Itaú';
$_['cards']['jcb']                         = 'JCB';
$_['cards']['mais']                        = 'Mais!';
$_['cards']['mastercard']                  = 'Mastercard';
$_['cards']['mastercard_1990_1996']        = 'Mastercard (1990-1996)';
$_['cards']['mercadolivre']                = 'MercadoLivre';
$_['cards']['mercadopago']                 = 'MercadoPago';
$_['cards']['oi_paggo']                    = 'Oi Paggo';
$_['cards']['pagseguro']                   = 'PagSeguro';
$_['cards']['paypal']                      = 'PayPal';
$_['cards']['payu']                        = 'PayU';
$_['cards']['payza']                       = 'Payza';
$_['cards']['personalcard']                = 'Personal Card';
$_['cards']['pleno']                       = 'Pleno Card';
$_['cards']['rede']                        = 'Rede';
$_['cards']['redecard']                    = 'Redecard';
$_['cards']['sage_pay']                    = 'Sage Pay';
$_['cards']['skrill']                      = 'Skrill';
$_['cards']['sorocred']                    = 'Sorocred';
$_['cards']['stone']                       = 'Stone';
$_['cards']['unibanco']                    = 'Unibanco';
$_['cards']['unionpay']                    = 'UnionPay';
$_['cards']['valecard']                    = 'ValeCard';
$_['cards']['valecard_until_2015']         = 'ValeCard (Até 2015)';
$_['cards']['visa']                        = 'Visa';
$_['cards']['visa_1992_2006']              = 'Visa (1992-2006)';
$_['cards']['visa_2006_2014']              = 'Visa (2006-2014)';
$_['cards']['visa_electron']               = 'Visa Electron';
$_['cards']['wepay']                       = 'WePay';
$_['cards']['western_union']               = 'Western Union';
