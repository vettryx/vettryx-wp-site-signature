<?php
/**
 * Plugin Name: VETTRYX WP Site Signature
 * Plugin URI:  https://github.com/vettryx/vettryx-wp-core
 * Description: Solução de branding e copyright dinâmico para clientes VETTRYX Tech.
 * Version:     1.2.0
 * Author:      VETTRYX Tech
 * Author URI:  https://vettryx.com.br
 * License:     Proprietária (Uso Comercial Exclusivo)
 * Vettryx Icon: dashicons-admin-customizer
 */

// Segurança: Impede o acesso direto ao arquivo
if (!defined('ABSPATH')) {
    exit;
}

/**
 * 1. Copyright Automático
 * Uso: [vettryx_copyright]
 * Saída: © 2026 Nome do Cliente. Todos os direitos reservados.
 */
add_shortcode('vettryx_copyright', function() {
    $ano = date('Y');
    $nome_site = get_bloginfo('name');
    return "&copy; {$ano} {$nome_site}. Todos os direitos reservados.";
});

/**
 * 2. Assinatura do Desenvolvedor Universal
 * Uso em Clientes: [vettryx_developer]
 * Uso em VETTRYX: [vettryx_developer modo="interno"]
 * * Saída Padrão: Desenvolvido por: VETTRYX Tech
 */
add_shortcode('vettryx_developer', function($atts) {
    // Define 'cliente' como o comportamento padrão se o atributo não for passado
    $a = shortcode_atts(['modo' => 'cliente'], $atts);

    // MODO INTERNO (Exibe link para perfil de André Ventura)
    if ($a['modo'] === 'interno') {
        $link_perfil_andre = 'https://github.com/asventura96'; 
        return '<span class="vettryx-signature">Desenvolvido por: <a href="' . esc_url($link_perfil_andre) . '" target="_blank" rel="noopener">André Ventura</a></span>';
    }

    // MODO CLIENTE (Consome API da VETTRYX com cache)
    $url_api = 'https://vettryx.com.br/wp-json'; 
    $url_site = 'https://vettryx.com.br';
    
    // Tenta obter o nome da marca do cache (transient)
    $nome_marca = get_transient('vettryx_brand_name');

    // Se não houver cache, faz a requisição à API
    if (false === $nome_marca) {
        $response = wp_remote_get($url_api, ['timeout' => 5]); 
        
        // Verifica se a resposta é um erro
        if (is_wp_error($response)) {
            $nome_marca = 'VETTRYX Tech'; // Fallback
        } else {
            $dados = json_decode(wp_remote_retrieve_body($response), true);
            $nome_marca = isset($dados['name']) ? $dados['name'] : 'VETTRYX Tech';
            set_transient('vettryx_brand_name', $nome_marca, 86400);
        }
    }

    // Retorna a assinatura com o nome da marca
    return '<span class="vettryx-signature">Desenvolvido por: <a href="' . esc_url($url_site) . '" target="_blank" rel="noopener">' . esc_html($nome_marca) . '</a></span>';
});
