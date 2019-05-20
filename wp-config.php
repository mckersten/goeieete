<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
ini_set('display_errors',0);
//error_reporting(E_ALL);
date_default_timezone_set("Europe/Amsterdam");
define( 'WP_AUTO_UPDATE_CORE', false );
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'dkuzhwbn_wp2');

/** MySQL database username */
define('DB_USER', 'dkuzhwbn_wp2');

/** MySQL database password */
define('DB_PASSWORD', '10@B20cd30');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define ('WPLANG', 'nl_NL');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
/*define('AUTH_KEY',         'i#Pd@SZT.ta%qc>s[PK{.o(ul_FE=U]xWj,k2%aVxD.Ati2!YI#4n%e`@9WR(q,:');
define('SECURE_AUTH_KEY',  'GaED3|;0Ti0ADwhT*Po5Jxd+9w u%)YurANhr;+Tq{UD+B7%l gOyUS;GFJxl^6R');
define('LOGGED_IN_KEY',    'yA*ZX2IHJ28sf91B7xarmjdtr2i/)WqZ%Kfqg8%}}lf8%kk81Wp @?Fkw[@P&C4x');
define('NONCE_KEY',        '|<5kgJanAwz0Y]hWX$ m*Aa=PDv%gGR#9JPG`}~vx0-IN,GO?}{$x.@mziq!dQ[:');
define('AUTH_SALT',        '$n,sa^m>m{KBR0f:u)/$fdC:3oGmnWzrwkd>BhKV:834~cut>me16N#FeV_=_&pi');
define('SECURE_AUTH_SALT', 'S-^*rAxp1b^J@bYU;S-Xx<`Dz+H%5eW*bnh`Y_5Owg85F.RnAZ@,thpv;:N8u+gC');
define('LOGGED_IN_SALT',   'N]F?863hY9q=2%>uNxECknD?)Z%[22HUE[SBW!8*Xjz-,2+P0D7}dxJ_@.,1|P3u');
define('NONCE_SALT',       'e*tRK76(kHR~|VY*z0bPVof<iG7BUiv;7Y %_s@g9v};q Y)UIu$jQv7Fdgc>|ur');*/
define( 'AUTH_KEY',         'wz.Us^03B6$ g~$N@d_fj^cS>Pb[]K!v0C:anrEy{?h^:sEPzP487D*t`MZy`%-`' );
define( 'SECURE_AUTH_KEY',  'fEvT,b)?r#(5=0K`62jE<@mjyz|l6+2<by#SiE6+rC3_]2tU=OY@;pCg@IMH_/pl' );
define( 'LOGGED_IN_KEY',    'ru%EGGBI1+!S,{%_hxI98q/U#J74{^|$Buq^j]>d,X8>P}O&A1D^Z0OMX5772Hb`' );
define( 'NONCE_KEY',        '*D$+{7F1gS 3jw*RV`yC~B#duW&Ec6wSw,G=54M73Ix`dY+h 8<W)_oD7v4xf5n4' );
define( 'AUTH_SALT',        '`X7YZM/1r&s9c@!3T!O&OO{i9,tWrh9wYYN:y^9N]r,PE}H>zab.Me7yKbr<N{V6' );
define( 'SECURE_AUTH_SALT', '*c+Y/ZARt>~isWwdAU*{NcJ>p[ x#X>)D=:@}y^)P~MF:`0zW}]]E5ZO%&g%-z0f' );
define( 'LOGGED_IN_SALT',   'cGD|,cRQ9i&><jnLRaefH&j.8|1zvC&`rPU++$AQ>c41.|SLu>R?.Gq1Ty*sKdwm' );
define( 'NONCE_SALT',       'D-,@>:nINxldG$_.0B]am!_K.>|bp9Kf2_a.F)8mbn!v6?-(aRG9j8!|CvoV(0e2' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
/*function wp_mail() {
	
}*/