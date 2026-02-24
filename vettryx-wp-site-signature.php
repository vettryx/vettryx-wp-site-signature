<?php
/**
 * Plugin Name: VETTRYX WP Site Signature
 * Plugin URI:  https://github.com/vettryx/vettryx-wp-site-signature
 * Description: Solução de branding e copyright dinâmico para clientes VETTRYX Tech.
 * Version:     1.0.0
 * Author:      VETTRYX Tech
 * Author URI:  https://vettryx.com.br
 * License:     GPLv2
 */

if (!defined('ABSPATH')) exit;

// --- INÍCIO DA ATUALIZAÇÃO AUTOMÁTICA (GITHUB) ---
// Define o caminho exato do arquivo da biblioteca
$puc_file = plugin_dir_path(__FILE__) . 'plugin-update-checker/plugin-update-checker.php';

// Só executa a atualização se a pasta da biblioteca realmente existir
if (file_exists($puc_file)) {
    require $puc_file;
    
    $myUpdateChecker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
        'https://github.com/vettryx/vettryx-wp-site-signature',
        __FILE__,
        'vettryx-wp-site-signature'
    );
}
// --- FIM DA ATUALIZAÇÃO AUTOMÁTICA ---

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
 * 2. Assinatura do Desenvolvedor (Consome API da VETTRYX)
 * Uso: [vettryx_developer]
 * * Saída Padrão: Desenvolvido por: VETTRYX Tech
 */
add_shortcode('vettryx_developer', function() {
    // URL da API da sua empresa
    $url_api = 'https://vettryx.com.br/wp-json'; 
    $url_site = 'https://vettryx.com.br';
    
    // Tenta buscar o nome via API e salva em cache por 24h (86400 segundos)
    $nome_marca = get_transient('vettryx_brand_name');

    if (false === $nome_marca) {
        $response = wp_remote_get($url_api, ['timeout' => 5]); // Timeout curto para não travar
        
        if (is_wp_error($response)) {
            $nome_marca = 'VETTRYX Tech'; // Fallback se a API falhar
        } else {
            $dados = json_decode(wp_remote_retrieve_body($response), true);
            $nome_marca = isset($dados['name']) ? $dados['name'] : 'VETTRYX Tech';
            
            // Salva no banco do cliente por 24 horas
            set_transient('vettryx_brand_name', $nome_marca, 86400);
        }
    }

    // Retorna o link formatado (Você pode ajustar o estilo CSS inline conforme preferir)
    return '<span class="vettryx-signature">Desenvolvido por: <a href="' . esc_url($url_site) . '" target="_blank" rel="noopener">' . esc_html($nome_marca) . '</a></span>';
});

/**
 * 3. Declaração de conformidade com a API de Consentimento
 */
add_action('plugins_loaded', function() {
    $plugin_slug = plugin_basename(__FILE__);
    add_filter("wp_consent_api_registered_{$plugin_slug}", '__return_true');
});
