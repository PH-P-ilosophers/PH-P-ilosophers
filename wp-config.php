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
define( 'AUTH_KEY',          'T3HtA:P.R~5g/c?.UUqUhyiPw|CK(hlUUjS?3>lR}~%,Ak V:]1)uH9.ugjcf&mI' );
define( 'SECURE_AUTH_KEY',   'naR4P0^C?m}h`&rp-t?7{kA~!@14.`4uaD*.ib!}E=F.PWm)F&UzR@NuI&T#2hy`' );
define( 'LOGGED_IN_KEY',     '?zg$k3}BO;IY-GysBMo<3_AYdB=Sdv[ B9o02FXI4@J4m*zptdj|bt|j>0Mv}=TU' );
define( 'NONCE_KEY',         'l&u[g3eB(8a8?-+7%#`^GENtDQ_t:.gBE%4APHUW`;|_z;H5^f)24O[Bw$_@c|a<' );
define( 'AUTH_SALT',         'Xxy({p]_}=>nn].`bg=iXP5}En&r;>/>hwcXZ8NcZ&4xZu/Tqo^~+cYFxmETVN[z' );
define( 'SECURE_AUTH_SALT',  '8pA~jQyf|3Z;tq?hP6vkc3I_:b+&>]sAX^dh3JA~u[MR6*{fM]Tzo}1:67r&XTp1' );
define( 'LOGGED_IN_SALT',    'p;CZnG0-C23I5?_0n%,9fe^V~ 9oec7&)L>lxvJbN@8G*`?Z$cI%4n_DoWmIe/|_' );
define( 'NONCE_SALT',        'i?:vcmyjpk-wb@Oa`GPrzdU_Mfn8gq6a1G]=~WF8X[h)_3=G7tQhn<!%C~Bc~$o ' );
define( 'WP_CACHE_KEY_SALT', '-e=vp.-zD~@zOZ8w^o</?.:<8/2JN?2tsQ=H4RC,44H::6R)_Shzzej&n,2>>>)x' );


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
