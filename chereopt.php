<?php
/*
 * Plugin Name: Chereopciones
 * Description: Opciones
 * Version: 1.2.0
 * Author: Chereguini
 * Author URI: https://chereguini.com
 * GitHub Plugin URI: https://github.com/chereguini/chereopciones.git
 */


// PAGINA DE ADMINISTRACION ************************************************


// Añadir menú en el panel de administración
function chereopciones_admin_menu() {
    add_menu_page(
        'Chere Opciones', // Título de la página
        'Chere Opciones', // Título del menú
        'manage_options', // Capacidad requerida
        'chereopciones-settings', // Slug de la página
        'chereopciones_settings_page', // Función que muestra el contenido
        'dashicons-admin-generic', // Icono
        80 // Posición en el menú
    );
}
add_action('admin_menu', 'chereopciones_admin_menu');

// Registrar las opciones
function chereopciones_register_settings() {
    register_setting('chereopciones_settings_group', 'chereopciones_background_pink');
    register_setting('chereopciones_settings_group', 'chereopciones_gallery_responsive');
    register_setting('chereopciones_settings_group', 'chereopciones_gallery_links');
}
add_action('admin_init', 'chereopciones_register_settings');

// Mostrar la página de opciones
function chereopciones_settings_page() {
    ?>
    <div class="wrap">
        <h1>Chere Opciones</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('chereopciones_settings_group');
            do_settings_sections('chereopciones_settings_group');
            ?>
            <table class="form-table">
                <tr>
                    <th>Fondo rosa en el body</th>
                    <td>
                        <input type="checkbox" 
                               name="chereopciones_background_pink" 
                               value="1" 
                               <?php checked(1, get_option('chereopciones_background_pink', 0)); ?> />
                        <label>Activar fondo rosa</label>
                    </td>
                </tr>
                <tr>
                    <th>Galerías responsive en móviles</th>
                    <td>
                        <input type="checkbox" 
                               name="chereopciones_gallery_responsive" 
                               value="1" 
                               <?php checked(1, get_option('chereopciones_gallery_responsive', 0)); ?> />
                        <label>Activar galerías responsive</label>
                    </td>
                </tr>
                <tr>
                    <th>Enlaces en imágenes de galerías</th>
                    <td>
                        <input type="checkbox" 
                               name="chereopciones_gallery_links" 
                               value="1" 
                               <?php checked(1, get_option('chereopciones_gallery_links', 0)); ?> />
                        <label>Activar enlaces a imágenes ampliadas</label>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}


// OPCIONES ************************************************


// Body con fondo rosa y estilos generales
function chereopciones_enqueue_styles(): void {
    $background_pink_active = get_option('chereopciones_background_pink', false);
    $gallery_responsive_active = get_option('chereopciones_gallery_responsive', false);

    // Cargar el CSS solo si alguna opción que lo necesite está activada
    if ($background_pink_active || $gallery_responsive_active) {
        wp_enqueue_style(
            'chereopciones-styles',
            plugin_dir_url(__FILE__) . 'css/chereopciones.css',
            [],
            '1.2.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'chereopciones_enqueue_styles');

// Enlaces en imágenes de galerías
function chereopciones_enqueue_gallery_links_script(): void {
    $gallery_links_active = get_option('chereopciones_gallery_links', false);
    
    if ($gallery_links_active && is_admin()) {
        wp_enqueue_script(
            'chereopciones-gallery-links',
            plugin_dir_url(__FILE__) . 'js/gallery-links.js',
            ['wp-blocks', 'wp-dom-ready', 'wp-edit-post'],
            '1.2.0',
            true
        );
    }
}
add_action('enqueue_block_editor_assets', 'chereopciones_enqueue_gallery_links_script');