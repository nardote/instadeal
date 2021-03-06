<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'wp-instadeal');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '(ICSbyyw1;+k$8:<Yb3S; ouyLU>B0lc_;DK#>)UWt_QBq!>]&R?e~{rqySbYUe+'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', '*9Q2H~@@#W@i.j9Bc9~dSLkGZsOPhiA.X~B^5!Bsbx{jQ{Nwl- o>c?=&].]Q!Z5'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', '4ltx`S5pL<{43Pr~=qdrMA4m}|H%I;K|}MAXqlMgkQ&;x.c@Wu0p5C:^)~%v3W6O'); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', 'Y#ysCY35#HG`Z!etjP~,;Y>mn`IH6nW$hrG@a+yTDqF 1TiG3@l#Uc5G`t4xLgic'); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', 'GuTggGVX4*bxycm+Lc[V*r.T,#sm_?:5r,{g;V_Jeq;#=9~9QUa)tcQ{;`cSuk}8'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', 'e=+,rHj~!)y}vL`VR`NM2k6Ka1<P19H^Qrr6$WJgbe*+rF77lrCY&7I7LP<XRl[m'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', 'Jm^F^!Jb9|O|C441uZVj#%jEqH[|t(,AMZ0n2jR9E5fb8YgY1w)&<%CQt~9%yjq|'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', 'M,ljdXO62/3YExYD0mBWjSOL 9_I#H<$_1ud.P*FKFOl9D_(V<4>]M>FLzhRK#VM'); // Cambia esto por tu frase aleatoria.

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';

/**
 * Idioma de WordPress.
 *
 * Cambia lo siguiente para tener WordPress en tu idioma. El correspondiente archivo MO
 * del lenguaje elegido debe encontrarse en wp-content/languages.
 * Por ejemplo, instala ca_ES.mo copiándolo a wp-content/languages y define WPLANG como 'ca_ES'
 * para traducir WordPress al catalán.
 */
define('WPLANG', 'es_ES');

/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

