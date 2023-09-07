<?php 

add_action( 'after_setup_theme', function() {
    add_theme_support( 'customize' );
    add_theme_support( 'full-site-editing' );
} );

function envolver_texto_resultados_busqueda() {
    if (is_search()) {
      ?>
      <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
          if (document.querySelector('.titulo-busqueda')) {
            const tituloBusqueda = document.querySelector('.titulo-busqueda');
            const texto = tituloBusqueda.textContent;
            const nuevoTexto = texto.replace('Resultados de búsqueda de:', '<span>Resultados de búsqueda de:</span>').replace(/«/g, '"').replace(/»/g, '"');
            tituloBusqueda.innerHTML = nuevoTexto;
          }
        });
      </script>
      <?php
    }
  }
  add_action('wp_footer', 'envolver_texto_resultados_busqueda');


  function buntywpesc_html__xtra_user_profile_fields( $user ) {
    $facebook = get_user_meta( $user->ID, 'facebook', true );
    $twitter = get_user_meta( $user->ID, 'twitter', true );
    $instagram = get_user_meta( $user->ID, 'instagram', true );
    $linkedin = get_user_meta( $user->ID, 'linkedin', true );
    ?>
    <h3><?php esc_html__( 'Redes sociales', 'white-label' ); ?></h3>
  
    <table class="form-table">
        <!-- <tr>
        <th><label for="facebook"><?php esc_html__( 'Facebook', 'white-label' ); ?></label></th>
        <td>
            <input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( $facebook ); ?>" class="regular-text" /><br />
            <p class="description"><?php esc_html__( 'Ingresa el enlace a tu perfil de Facebook.', 'white-label' ); ?></p>
        </td>
        </tr>
        <tr>
        <th><label for="twitter"><?php esc_html__( 'Twitter', 'white-label' ); ?></label></th>
        <td>
            <input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( $twitter ); ?>" class="regular-text" /><br />
            <p class="description"><?php esc_html__( 'Ingresa el enlace a tu perfil de Twitter.', 'white-label' ); ?></p>
        </td>
        </tr>
        <tr>
        <th><label for="instagram"><?php esc_html__( 'Instagram', 'white-label' ); ?></label></th>
        <td>
            <input type="text" name="instagram" id="instagram" value="<?php echo esc_attr( $instagram ); ?>" class="regular-text" /><br />
            <p class="description"><?php esc_html__( 'Ingresa el enlace a tu perfil de Instagram.', 'white-label' ); ?></p>
        </td>
        </tr> -->
        <tr>
        <th><label for="linkedin"><?php esc_html__( 'LinkedIn', 'white-label' ); ?></label></th>
        <td>
            <input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( $linkedin ); ?>" class="regular-text" /><br />
            <p class="description"><?php esc_html__( 'Ingresa el enlace a tu perfil de LinkedIn.', 'white-label' ); ?></p>
        </td>
        </tr>
    </table>
    <?php
}

add_action( 'edit_user_profile', 'buntywpesc_html__xtra_user_profile_fields', 10, 1 );
add_action( 'show_user_profile', 'buntywpesc_html__xtra_user_profile_fields', 10, 1 );

function buntywp_save_user_profile_fields( $user_id ) {
    if ( current_user_can( 'edit_user', $user_id ) ) {
        $facebook = sanitize_text_field( $_POST['facebook'] );
        $twitter = sanitize_text_field( $_POST['twitter'] );
        $instagram = sanitize_text_field( $_POST['instagram'] );
        $linkedin = sanitize_text_field( $_POST['linkedin'] );

        update_user_meta( $user_id, 'facebook', $facebook );
        update_user_meta( $user_id, 'twitter', $twitter );
        update_user_meta( $user_id, 'instagram', $instagram );
        update_user_meta( $user_id, 'linkedin', $linkedin );
    }
}

add_action( 'personal_options_update', 'buntywp_save_user_profile_fields' );
add_action( 'edit_user_profile_update', 'buntywp_save_user_profile_fields' );



function contar_palabras() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( strip_tags( $content ) );
    return $word_count;
}

function cargar_dashicons_frontend() {
    wpesc_html__nqueue_style('dashicons');
}
add_action('wpesc_html__nqueue_scripts', 'cargar_dashicons_frontend');


function add_labels_as_placeholders() {
    ?>
    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('commentform');
        var labels = form.querySelectorAll('label');
        var inputs = form.querySelectorAll('input, textarea');
  
        labels.forEach(function(label, index) {
          var input = inputs[index];
          var labelText = label.textContent.trim();
          input.setAttribute('placeholder', labelText);
        });
      });
    </script>
    <?php
  }
  add_action('wp_footer', 'add_labels_as_placeholders');
  

  function limitar_caracteres_js() {
    ob_start();
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var excerpts = document.querySelectorAll(".wp-block-post-excerpt_esc_html__xcerpt");
        var maxLength = 120;

        excerpts.forEach(function(excerpt) {
            var excerptText = excerpt.innerHTML;

            if (excerptText.length > maxLength) {
                excerptText = excerptText.substring(0, maxLength) + "...";
                excerpt.innerHTML = excerptText;
            }
        });
    });
    </script>
    <?php
    echo ob_get_clean();
}
add_action('wp_footer', 'limitar_caracteres_js');







