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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'aliceenglish' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         '-s]4D47oqLzy6qMYQpJId>b ~X!~~*spW-.7$]P)o!cLQDWc !o[rHU+73S_SM_8' );
define( 'SECURE_AUTH_KEY',  'P1D62#-iyZYWRYl+No+s?tG=caEjSD-i]/QHhA[_Nc4}rHZMP->RvY>12WMS8?:3' );
define( 'LOGGED_IN_KEY',    'w3:`}1_N[4L1Oi&[eVC#,ExU<B@7(e5m?yAjG?]WI&W,2u$Rh%%~}:=zUI8v=##u' );
define( 'NONCE_KEY',        'C [!RG0>drnsRoG$IK<|[_I<@>IAE@mrArt>f*lHH8y{lwB&EGt2nK^o=[9?fM<L' );
define( 'AUTH_SALT',        '`[}C./`=)J ?WnGpRNy-J9*AMQdZ)^-3]<+%>+y/nazut19=b,mX74XBAc^z&}ia' );
define( 'SECURE_AUTH_SALT', 'd/fp?.vh*)/ T?PAUsd/=W?V]#*0B%F%r<{~~0gKN]SX,n3wJp#vF6$pq5;%@5kA' );
define( 'LOGGED_IN_SALT',   '>ZMxQWrA3Q%Gp>d7:p5Ax&v-W.,Z?h=|j?k*Vg-s<U)+7FY/q`e )/ZNXMgOx3pg' );
define( 'NONCE_SALT',       'l5{S1o^xiOUTce,HF[SF2:m6|[Eq/4CySI&0_&Rj8E1rdhgCaa]6]%_|#A4<VWXI' );

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
