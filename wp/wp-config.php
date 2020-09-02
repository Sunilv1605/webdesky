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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'webdesky_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '4B4QI*h$Snu_F7NCh#l0n0``6_*a>mj2v3[m+]2|Ad+_pM%^`k|~s`DKTxe{,feu' );
define( 'SECURE_AUTH_KEY',  'ot:pps5K<cU4^}Q5sv!`VpxNlJSGs%+..Fy>_CAB*P,[}a7wZ7+;QG*NL49m]*#c' );
define( 'LOGGED_IN_KEY',    'PZH>YMuZ~/!}p}Swj;)4TR}{r~ojisP#Cz9&TVm4<j!2~*xj`h#]/{:1UG7pupou' );
define( 'NONCE_KEY',        'Hs6U5fxam`>QhMOo9s&*kvx6_~]5@9R]NmkTYN}=Zs$J#=&akpwgh`@V}8- sBmK' );
define( 'AUTH_SALT',        'zEmByY}&6g7?c5k.yy<5M@){:6_h+AI:yZ+pJEH@^;`n:^CLgKG/?H{XeW{P_OPJ' );
define( 'SECURE_AUTH_SALT', ':Q<You#&<+6GK/2D`GE0%oZ+A,bNByNW-L`3]TgNpB`x7?X4jP$#Kw$7u4%!_4Q6' );
define( 'LOGGED_IN_SALT',   'jIgz.41p.@K#.s;mtf4zgrxTb7k<I_;gqXAiG>R,.KiXv[:ER}wSa(}F/5C:~zp.' );
define( 'NONCE_SALT',       'AT`O6)$P9JF~VVj{OeX2#(Jcow;l UhhA/a8?xL8a3>Ii;}x>GgJj%-Ds5~uXB2p' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wd_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
