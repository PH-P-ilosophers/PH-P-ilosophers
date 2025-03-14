<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'b*8{DM97}eoE]|7BE$Q6{t 2$oF/{=!jeg@{he3 zy)K&HauYCJvla?iTv}xPMQ^' );
define( 'SECURE_AUTH_KEY',   '|uZp#SBbmAA%F#K7go{&aL<]%jA@.e9tW9IV|s_9K9Bk3Rhg;,Ny<)N/!5am7~-/' );
define( 'LOGGED_IN_KEY',     'D/&SFX2qVK>(}:VQG7>]I%@_}2m  ltXc|yR,:JA!F~)9=%Xci-7>@78FN kiSP/' );
define( 'NONCE_KEY',         'i!5zi~?oen]%uW.khW&{JS$Fr9|euQx@:RthHe(%[8`g{%R?f-A]G{$^!BH}TBln' );
define( 'AUTH_SALT',         ';]f<g7u-ZcC[_pB_`;LwZ1^wL6xV.n(p| [:qLy,Hcm%8y_HiS<BW(@h9uD#M:q!' );
define( 'SECURE_AUTH_SALT',  '?L YCpi7@yc^MYa q x!WSqx=!=s^0OKjEO~V< h_{ad#_E>Yn/m-uphM?MBK*2~' );
define( 'LOGGED_IN_SALT',    '1)#f.:^,<Qa]QlAt^nc?3gag<cdO`lufT$y)y/`>n},,+7JT:#a}1=r8MB[%@6rj' );
define( 'NONCE_SALT',        'y`I)63tKNQ;yasrSn l?~`o;PfSf+yI(9@9;tB6Y,C$tA@<wK8zSRhZ*/cuFi#+{' );
define( 'WP_CACHE_KEY_SALT', 'Ch+XAT,Oz6*}t?;43$Mimt4Pi?K>IMk`T1ZzV[A8~dObIB%{}acZ#iLn6RcK2BMX' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
