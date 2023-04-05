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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'portfolio_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'KZ]]zk*k4jk) &@Q6t n.~{z;.kU^i1`ebLcOT&2`B5@*:{d<*ZibOy^P<SYVLuP' );
define( 'SECURE_AUTH_KEY',  'oHPyS0~#>))4cKjPJo_]KYLQKFr /9W/pO{jV{@^hvD6WosAZhcqgZ>Kf(@W6V j' );
define( 'LOGGED_IN_KEY',    '/38DN)6StYd&-bg6=m;VkdQX^?dX7bm8nfK1 |{`H6Jr;Uj>#woWV-zyHWqs/YZv' );
define( 'NONCE_KEY',        '{,~/hGHC&u3<BgG@Cl?9W/R:Ln oiu/&D1 mse;{%5@Q$O(MLJ>t(cpwq0Tjx!Av' );
define( 'AUTH_SALT',        '5z0j[xdpd<HXjtS3;AF^Bs14zkF5d%eRI77-]W1^vJ9pEMuU_?460vUQ`Ukp0@E$' );
define( 'SECURE_AUTH_SALT', ',TYZ9pnq16.9nK7zT:+oSZ}Q* [onq*3cY2dBd%vRQ9x}YAE9e@!slFtD%&h:ADY' );
define( 'LOGGED_IN_SALT',   '50.&1%sX6fb#*W#pd|Lg?aB|#[Hw{M7%{R2%--]5dXt>]TXj;g|`$n(34sUBz5NG' );
define( 'NONCE_SALT',       '-AX0~kW3?u[s,g&<!q=ev~~}lX?D$T>hxV{/lrMi!yPUptss5buNNzE![;}$i/sY' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
