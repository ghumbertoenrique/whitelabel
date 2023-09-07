<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://www.siemprealdia.co/
 * @since             1.0.0
 * @package           siemprealdiacomplement
 *
 * @wordpress-plugin
 * Plugin Name:       siemprealdiacomplement
 * Description:       Este plugin es el complemento del tema siempre al dia
 * Version:           1.0.0
 * Author:            Humberto Gonzalez
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       siemprealdiacomplement
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'siemprealdiacomplement_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-siemprealdiacomplement-activator.php
 */
function activate_siemprealdiacomplement() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-siemprealdiacomplement-activator.php';
	siemprealdiacomplement_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-siemprealdiacomplement-deactivator.php
 */
function deactivate_siemprealdiacomplement() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-siemprealdiacomplement-deactivator.php';
	siemprealdiacomplement_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_siemprealdiacomplement' );
register_deactivation_hook( __FILE__, 'deactivate_siemprealdiacomplement' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-siemprealdiacomplement.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_siemprealdiacomplement() {

	$plugin = new siemprealdiacomplement();
	$plugin->run();

}
run_siemprealdiacomplement();


// El funciones  

  
function mostrar_redes_sociales_shortcode() {
    ob_start();
  
      // Obtener el ID del autor actual
      $author_id = get_the_author_meta('ID');
  
      // Obtener los enlaces a las redes sociales del autor
      $facebook = get_the_author_meta('facebook', $author_id);
      $twitter = get_the_author_meta('twitter', $author_id);
      $instagram = get_the_author_meta('instagram', $author_id);
      $linkedin = get_the_author_meta('linkedin', $author_id);
  
    // Mostrar los enlaces a las redes sociales
    echo '<div class="redes-sociales">';
    if (isset($facebook) && !empty($facebook)) {
        echo '<a href="' . esc_url($facebook) . '" target="_blank"><span class="dashicons dashicons-facebook"></span></a>';
    }
    if (isset($twitter) && !empty($twitter)) {
        echo '<a href="' . esc_url($twitter) . '" target="_blank"><span class="dashicons dashicons-twitter"></span></a>';
    }
    if (isset($instagram) && !empty($instagram)) {
        echo '<a href="' . esc_url($instagram) . '" target="_blank"><span class="dashicons dashicons-instagram"></span></a>';
    }
    if (isset($linkedin) && !empty($linkedin)) {
        echo '<a href="' . esc_url($linkedin) . '" target="_blank"><span class="dashicons dashicons-linkedin"></span></a>';
    }
    echo '</div>';
  
    return ob_get_clean();
  }
  add_shortcode('mostrar_redes_sociales', 'mostrar_redes_sociales_shortcode');

  function generar_breadcrumb_shortcode() {
    $breadcrumb = '';
    $svg_icon = ' <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" viewBox="0 0 9 14" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M1.0788 0.46967C1.37169 0.176777 1.84657 0.176777 2.13946 0.46967L8.13946 6.46967C8.43235 6.76256 8.43235 7.23744 8.13946 7.53033L2.13946 13.5303C1.84657 13.8232 1.37169 13.8232 1.0788 13.5303C0.785908 13.2374 0.785908 12.7626 1.0788 12.4697L6.54847 7L1.0788 1.53033C0.785908 1.23744 0.785908 0.762563 1.0788 0.46967Z" fill="#0F172A"/>
                </svg> ';

    if (!is_front_page()) {
        $breadcrumb .= '<a href="' . home_url() . '">Home</a>' . $svg_icon;
    }

    if (is_category() || is_single()) {
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0];
            $category_id = $category->term_id;
            $category_parents = array_reverse(get_ancestors($category_id, 'category'));
            foreach ($category_parents as $category_parent) {
                $breadcrumb .= '<a href="' . get_category_link($category_parent) . '">' . get_cat_name($category_parent) . '</a>' . $svg_icon;
            }
            $breadcrumb .= '<a href="' . get_category_link($category_id) . '">' . get_cat_name($category_id) . '</a>';

            $sub_categories = get_categories(array('child_of' => $category_id, 'number' => 1));
            if (!empty($sub_categories)) {
                $sub_category = $sub_categories[0];
                $breadcrumb .= $svg_icon . '<a href="' . get_category_link($sub_category->term_id) . '">' . $sub_category->name . '</a>';
            }
        }
    }
    return $breadcrumb;
}
add_shortcode('breadcrumb', 'generar_breadcrumb_shortcode');


function compartir_redes_sociales_shortcode() {
    $url_actual = urlencode(get_permalink()); // Obtiene la URL actual de la página

    $shortcode_output = '<div class="compartir-redes-sociales" id="social-single-top">';
    $shortcode_output .= '<p> Compartir en: </p>';
    $shortcode_output .= '<a href="https://www.linkedin.com/shareArticle?mini=true&url=' . $url_actual . '" target="_blank"><i class="dashicons dashicons-linkedin"></i></a>';
    $shortcode_output .= '<a href="https://www.facebook.com/sharer.php?u=' . $url_actual . '" target="_blank"><i class="dashicons dashicons-facebook"></i></a>';
    $shortcode_output .= '<a href="https://twitter.com/share?url=' . $url_actual . '" target="_blank"><i class="dashicons dashicons-twitter"></i></a>';
    $shortcode_output .= '</div>';

    return $shortcode_output;
}
add_shortcode('compartir_redes_sociales', 'compartir_redes_sociales_shortcode');


function mostrar_fecha_tiempo_lectura_shortcode() {
    $fecha_publicacion = get_the_date('j, M Y'); // Obtiene la fecha de publicación en el formato deseado
    $tiempo_lectura = ceil(contar_palabras() / 200); // Calcula el tiempo de lectura asumiendo una velocidad de lectura de 200 palabras por minuto

    $shortcode_output = '<p class="fecha-lectura" >' . $fecha_publicacion . '  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" style="vertical-align: middle;">
<path d="M10.5 5C10.5 4.58579 10.1642 4.25 9.75 4.25C9.33579 4.25 9 4.58579 9 5V10C9 10.1989 9.07902 10.3897 9.21967 10.5303L12.2197 13.5303C12.5126 13.8232 12.9874 13.8232 13.2803 13.5303C13.5732 13.2374 13.5732 12.7626 13.2803 12.4697L10.5 9.68934V5Z" fill="#0F172A"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M9.75 0.25C4.36522 0.25 0 4.61522 0 10C0 15.3848 4.36522 19.75 9.75 19.75C15.1348 19.75 19.5 15.3848 19.5 10C19.5 4.61522 15.1348 0.25 9.75 0.25ZM1.5 10C1.5 5.44365 5.19365 1.75 9.75 1.75C14.3063 1.75 18 5.44365 18 10C18 14.5563 14.3063 18.25 9.75 18.25C5.19365 18.25 1.5 14.5563 1.5 10Z" fill="#0F172A"/>
</svg>  ' . $tiempo_lectura . ' min de lectura </p>';
    return $shortcode_output;
}
add_shortcode('fecha_tiempo_lectura', 'mostrar_fecha_tiempo_lectura_shortcode');



function agregar_essential_block_shortcode($atts) {
    // Define el fragmento que deseas agregar
    $fragmento = '
    
  <!-- wp:essential-blocks/post-carousel {"blockId":"eb-post-carousel-p87g08a","blockMeta":{"desktop":" .eb-post-carousel-wrapper.eb-post-carousel-p87g08a{ display: block; position: relative; transition: background 0.5s, border 0.5s, border-radius 0.5s, box-shadow 0.5s ; }  .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-list { margin: calc(-25px/2); } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-slide .ebpg-carousel-post-holder { margin: calc(25px/2); height: calc(100% - 25px); } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-post-carousel-column { transition: background 0.5s, border 0.5s, border-radius 0.5s, box-shadow 0.5s ; } // .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-post-carousel-column:hover { // background-color: rgba(255,255,255,1); // border-color: rgba(37,210,106,1); border-radius: 2px; // } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-carousel-post-holder { background-color: rgba(241,245,249,1); border-radius: 8px; border-width: 2px; border-color: rgba(241,245,249,1); border-style: solid; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-entry-wrapper { background-color: rgba(241,245,249,1); padding-top: 30px; padding-right: 20px; padding-left: 20px; padding-bottom: 20px; border-bottom-right-radius: inherit; border-top-right-radius: inherit; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.style-3 .ebpg-carousel-post-holder { align-items: center; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.style-3 .ebpg-carousel-post-holder .ebpg-entry-media { width: 40%; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.style-3 .ebpg-carousel-post-holder .ebpg-entry-wrapper { width: 60%; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-entry-thumbnail { margin-top: 0px; margin-right: 0px; margin-left: 0px; margin-bottom: 10px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-entry-thumbnail img { height:165px; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-carousel-post-holder .ebpg-entry-thumbnail:after { background-color: rgba(0 0 0 / 0) } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-carousel-post-holder .ebpg-entry-thumbnail:hover:after, .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.style-4 .ebpg-carousel-post-holder:hover .ebpg-entry-thumbnail:after { background-color: rgba(0 0 0 / 0.5); border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.style-4 .ebpg-carousel-post-holder:hover .ebpg-entry-thumbnail:after { border-radius: inherit; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-entry-title { text-align: left; font-family: \u0022Montserrat\u0022, sans-serif; font-size: 18px; font-weight: 700; margin-top: 0px; margin-right: 0px; margin-left: 0px; margin-bottom: 20px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-entry-title a { color: #0f172a; font-family: \u0022Montserrat\u0022, sans-serif; font-size: 18px; font-weight: 700; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-entry-title a:hover { color: #333333; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-carousel-post-excerpt p { color: #ffffff; text-align: left; font-size: 14px; margin-top: 0px; margin-right: 0px; margin-left: 0px; margin-bottom: 10px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-readmore-btn { text-align: left; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-readmore-btn a { color: #0048bf; background-color: undefined; font-family: \u0022Inter\u0022, sans-serif; font-size: 16px; font-weight: 600; margin-top: 0px; margin-right: 0px; margin-left: 0px; margin-bottom: 10px; padding-top: 0px; padding-right: 0px; padding-left: 0px; padding-bottom: 0px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-readmore-btn a:hover { color: #9e9e9e; color: undefined; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-author-avatar img { border-radius: 50px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-posted-on { color: #d18df1; font-size: 13px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-posted-by { color: #d18df1; font-size: 13px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-posted-by a { color: #d18df1; font-size: 13px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-posted-by a:hover { color: #549edc; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-meta a { color: #d18df1; font-size: 13px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-meta a:not(:first-child)::before { background-color: #9e9e9e; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-meta a:hover { color: #2673FF; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-meta.ebpg-dynamic-values { color: #333333; background-color: undefined; font-size: 13px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-categories-meta a { color: #d18df1; font-size: 13px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-categories-meta a:not(:first-child)::before { background-color: #9e9e9e; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-categories-meta a:hover { color: #2673FF; // background-color: undefined; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-tags-meta a { color: #d18df1; background-color: #3f6ddc; font-size: 13px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-tags-meta a:not(:first-child)::before { background-color: #9e9e9e; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-tags-meta a:hover { color: #ffffff; background-color: #2d59c3; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-header-meta { justify-content: left; margin-top: 0px; margin-right: 0px; margin-left: 0px; margin-bottom: 10px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-header-meta .ebpg-entry-meta-items { justify-content: left; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-header-meta .ebpg-author-avatar, .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-header-meta .ebpg-entry-meta-items \u003e * { margin-right:10px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-footer-meta { justify-content: left; margin-top: 0px; margin-right: 0px; margin-left: 0px; margin-bottom: 0px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-footer-meta .ebpg-entry-meta-items { justify-content: left; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-footer-meta .ebpg-author-avatar, .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-footer-meta .ebpg-entry-meta-items \u003e * { margin-right:10px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-prev { left:-50px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-next { right:-50px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-prev i, .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-next i { color: #333333 !important; font-size:19px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-prev:hover i, .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-next:hover i { color: #000000 !important; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.eb-slider-dots, .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.slick-dotted.slick-slider{ margin-bottom: calc(35px + 20px); } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-dots { bottom:-35px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-dots li { margin-right:10px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-dots li button:before { color: #61b6f1 !important; font-size:15px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-2 .slick-dots li button:before { background-color: #61b6f1 !important; font-size: 0; width: 15px; height: 15px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-3 .slick-dots li button:before { background-color: #61b6f1 !important; font-size: 0; width: 15px; height: 15px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-dots li.slick-active button:before { color: #2673FF !important; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-2 .slick-dots li.slick-active button:before { background-color: #2673FF !important; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-3 .slick-dots li.slick-active button:before { background-color: #2673FF !important; width: calc(15px* 2); } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-3 .slick-dots li.slick-active { width: calc(15px* 2); } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-4 .slick-dots li button:before { background-color: #61b6f1 !important; font-size: 0; width: 15px; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-4 .slick-dots li.slick-active button:before { background-color: #2673FF !important; width: calc(15px); } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-4 .slick-dots li.slick-active { width: calc(15px); } ","tab":"   .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-list { margin: calc(-undefinedpx/2); } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-slide .ebpg-carousel-post-holder { margin: calc(undefinedpx/2); height: calc(100% - undefinedpx); } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-carousel-post-holder { border-radius: 8px; border-width: 2px; border-color: rgba(241,245,249,1); border-style: solid; }                 .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-header-meta .ebpg-author-avatar, .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-header-meta .ebpg-entry-meta-items \u003e * { }  .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-footer-meta .ebpg-author-avatar, .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-footer-meta .ebpg-entry-meta-items \u003e * { }    .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.eb-slider-dots, .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.slick-dotted.slick-slider{ margin-bottom: calc(NaNpx + 20px); }    .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-2 .slick-dots li button:before { width: undefinedpx; height: undefinedpx; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-3 .slick-dots li button:before { width: undefinedpx; height: undefinedpx; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-3 .slick-dots li.slick-active button:before { width: calc(undefinedpx* 2); } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-3 .slick-dots li.slick-active { width: calc(undefinedpx* 2); } ","mobile":"   .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-list { margin: calc(-undefinedpx/2); } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .slick-slide .ebpg-carousel-post-holder { margin: calc(undefinedpx/2); height: calc(100% - undefinedpx); } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-carousel-post-holder { border-radius: 8px; border-width: 2px; border-color: rgba(241,245,249,1); border-style: solid; }                 .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-header-meta .ebpg-author-avatar, .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-header-meta .ebpg-entry-meta-items \u003e * { }  .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-footer-meta .ebpg-author-avatar, .eb-post-carousel-wrapper.eb-post-carousel-p87g08a .ebpg-footer-meta .ebpg-entry-meta-items \u003e * { }    .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.eb-slider-dots, .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.slick-dotted.slick-slider{ margin-bottom: calc(NaNpx + 20px); }    .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-2 .slick-dots li button:before { width: undefinedpx; height: undefinedpx; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-3 .slick-dots li button:before { width: undefinedpx; height: undefinedpx; } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-3 .slick-dots li.slick-active button:before { width: calc(undefinedpx* 2); } .eb-post-carousel-wrapper.eb-post-carousel-p87g08a.dot-style-3 .slick-dots li.slick-active { width: calc(undefinedpx* 2); } "},"queryData":{"source":"post","sourceIndex":0,"rest_base":"posts","rest_namespace":"wp/v2","author":"","taxonomies":[],"per_page":"6","offset":"0","orderby":"date","order":"desc","include":"","exclude":"","exclude_current":false},"queryResults":[],"postTerms":{"category":{"label":"Categorías","value":"category"},"post_tag":{"label":"Etiquetas","value":"post_tag"}},"preset":"style-3","showThumbnail":false,"styleVerticalAlignment":"center","titleColor":"#0f172a","showContent":false,"contentColor":"#ffffff","showReadMore":true,"readmoreText":"Leer mas \u003e ","readmoreColor":"#0048bf","showMeta":false,"headerMeta":"[{\u0022value\u0022:\u0022date\u0022,\u0022label\u0022:\u0022Published Date\u0022}]","footerMeta":"[]","authorMetaColor":"#d18df1","dateMetaColor":"#d18df1","autoplay":false,"dots":false,"dotPreset":"dot-style-1","ebpg_readmoreFontFamily":"Inter","ebpg_readmoreFontSize":16,"ebpg_readmoreFontWeight":"600","ebpg_titleFontFamily":"Montserrat","ebpg_titleFontWeight":"700","columnPaddingisLinked":false,"columnPaddingTop":"30","columnPaddingRight":"20","columnPaddingBottom":"20","columnPaddingLeft":"20","titleMarginBottom":"20","footerMetaMarginBottom":"0","thumbnailBDRisLinked":false,"columnBorderShadowborderColor":"rgba(241,245,249,1)","columnBorderShadowborderStyle":"solid","columnBorderShadowBdr_Top":"2","columnBorderShadowBdr_Right":"2","columnBorderShadowBdr_Bottom":"2","columnBorderShadowBdr_Left":"2","columnBorderShadowRds_Top":"8","columnBorderShadowRds_Right":"8","columnBorderShadowRds_Bottom":"8","columnBorderShadowRds_Left":"8","columnBorderShadowHborderColor":"rgba(37,210,106,1)","columnBorderShadowHborderStyle":"solid","columnBorderShadowHRds_Top":"2","columnBorderShadowHRds_Right":"2","columnBorderShadowHRds_Bottom":"2","columnBorderShadowHRds_Left":"2","wrpBGbg_hoverType":"hover","columnBGbackgroundColor":"rgba(241,245,249,1)","hov_columnBGbackgroundColor":"rgba(255,255,255,1)","hov_columnBGgradientColor":"linear-gradient(45deg, rgba(0,0,0,0.8) 0% , rgba(0,0,0,0.4) 100%)","columnsRange":1,"thumbnailImageSizeRange":165,"arrowPositionRange":-50,"arrowSizeRange":19,"className":"highlights","commonStyles":{"desktop":" .wp-admin .eb-parent-eb-post-carousel-p87g08a { display: block; opacity: 1; } .eb-parent-eb-post-carousel-p87g08a { display: block; } ","tab":" .editor-styles-wrapper.wp-embed-responsive .eb-parent-eb-post-carousel-p87g08a { display: block; opacity: 1; } .eb-parent-eb-post-carousel-p87g08a { display: block; } ","mobile":" .editor-styles-wrapper.wp-embed-responsive .eb-parent-eb-post-carousel-p87g08a { display: block; opacity: 1; } .eb-parent-eb-post-carousel-p87g08a { display: block; } "}} /-->
    ';

    // Devuelve el fragmento
    return $fragmento;
}
add_shortcode('agregar_essential-block', 'agregar_essential_block_shortcode');







