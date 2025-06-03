<?php
// Heading
$_['heading_title']    = 'Verificação de e-mail';

// Text
$_['text_edit']        = 'Editar Módulo';
$_['text_extension']   = 'Extensões';
$_['text_success']     = 'Sucesso: Você modificou o módulo!';
$_['text_approve_subject']  = 'Verifique seu endereço de e-mail';
$_['text_approve_content1'] = 'Para ativar sua conta clique no link abaixo ou copie/cole na barra de endereço do navegador:&lt;/div&gt;&lt;table width=&quot;100%&quot;cellpadding=&quot;0&quot;cellspacing=&quot;0&quot; style=&quot;width:100%&quot;&gt;&lt;tbody&gt;&lt;tr&gt;&lt;td&gt;&lt;div class=&quot;table-responsive&quot;&gt;&lt;table class=&quot;link&quot; cellspacing=&quot;0&quot; cellpadding=&quot;0&quot; width=&quot;auto&quot; style=&quot;width:auto;&quot;&gt;&lt;tbody&gt;&lt;tr&gt;&lt;td&gt;&lt;a href=&quot;{{ verification_link|replace({\'&amp;amp;\':\'&amp;amp;\'}) }}&quot; target=&quot;_blank&quot;&gt;&lt;b&gt;{{ verification_link }}&lt;/b&gt; &lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;/div&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/tbody&gt;&lt;/table&gt;&lt;div&gt;&lt;br&gt;Ao fazer login, você poderá acessar outros serviços, incluindo revisão de pedidos anteriores, impressão de faturas e edição de informações de sua conta.&lt;br&gt;&lt;br&gt;&lt;/div&gt;&lt;div class=&quot;last&quot;&gt;Thanks,&lt;br style=&quot;line-height:18px;&quot;&gt;&lt;a href=&quot;{{ store_url|replace({\'&amp;amp;\':\'&amp;amp;\'}) }}&quot; target=&quot;_blank&quot;&gt;&lt;b&gt;{{ store_name }}&lt;/b&gt;&lt;/a&gt;&lt;/div&gt;';
$_['text_approve_heading']  = 'Bem-vindo a {{ store_name }}';
$_['text_icon']         = '<img class="logo_icon" src="view/image/icons/email.png" />';

// Entry
$_['entry_status']     = 'Status';

// Error
$_['error_permission'] = 'Aviso: Você não tem permissão para modificar o módulo!';