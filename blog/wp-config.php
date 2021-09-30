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
define( 'DB_NAME', 'lc_ontarget_wp' );

/** MySQL database username */
define( 'DB_USER', 'homestead' );

/** MySQL database password */
define( 'DB_PASSWORD', 'secret' );

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
define( 'AUTH_KEY',         '5sGMz1k#H.$~i3dq?S6W-xe;O1M<`+-a+;q[(5A_@o%fxVo?)eLI9o(fSsK@Th`1' );
define( 'SECURE_AUTH_KEY',  '[LkjY+~bOO3(su5+:0<$W@[8JU`-[XWy+MF3d]0!;rm<rbsbRS!BAn(vJI}PJy3j' );
define( 'LOGGED_IN_KEY',    'GjCA8^5}9[qaX4nH<MC7PvRl>of1=-~`5$?d~y`Y>U88it+=c(R%N/SY<db]6Y]U' );
define( 'NONCE_KEY',        'sr^H>X.;j}S|PhEmt1!M1Ny)VvJ&*|A,`a4:!sK68AA_(5>^/3?FjS0dl %ESx[d' );
define( 'AUTH_SALT',        'gb_z(xC#FOSF6T-ZweWwRLnm).bPfu,`*Ej)a(dB*72eZZPLTGINtAzU+@}uammk' );
define( 'SECURE_AUTH_SALT', 'EQ6k1ZOoO(*<wBSzCbWPUPkoa/~JE+o5fX{>*kA+ipZCM[k_3>&#QlT^l3^_^@9p' );
define( 'LOGGED_IN_SALT',   '7-uS->xf.G/;[bJy`W9SjG&]uMQIJ;zAzq!Gu30#s^]GeoBz;5Hg9%5D~|~)2A-<' );
define( 'NONCE_SALT',       '>la2IKm_sgzaemv.R`W9^u?o/ 25VauV.l$g1;*SLr_Tb7#R,cS*9g4k_j+.;7i0' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'lc_';

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
