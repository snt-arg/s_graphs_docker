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
define( 'DB_NAME', 'wordpress_s_graphs+' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define( 'FS_METHOD', 'direct' );

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
define( 'AUTH_KEY',         ':;|m9.r0f$)^a.h_va>UT47nS@{#3#hBDqZ;afRnLZkklLiiH>p[R]Rf<4B*Dc7 ' );
define( 'SECURE_AUTH_KEY',  '1h6a#<Z/{ ]Jc.%;|Ex&k?2zit1fHCmp6_3qG]FP1Q{<R|#lO&r-a^tAQ2Kw3:>$' );
define( 'LOGGED_IN_KEY',    'WXD+g[j&$DxTrI_UG~bC7m>c@$jSd=!}UQnz`Sj*:3mhf=U%>&,tZe-$MOT`jgDL' );
define( 'NONCE_KEY',        'ZC>RUJ}{uF@m`=*6x>Mm+0C2$@2s]W J0%A(9&piMiaDX3ZA7tc_b%D;d%Li=mAw' );
define( 'AUTH_SALT',        '>xxcq<k|ylqhsI&pYtiZ&Z|ZV_T qL qCq-hIY1~Yo,Q%uEGATuCCw05hz2qn;t>' );
define( 'SECURE_AUTH_SALT', 'pjJaHZ)_:N%Kun~tOa#ad3Z^3z+yadt@R~c7}TwX)<v0E%z*WlN{kOlBnmu0VoC~' );
define( 'LOGGED_IN_SALT',   'E^/N}|lakSqW^;&~~$mwvni_bySM:kG$Pcp_6(*exDaqIDu3gF|z(}tfe-n8:~w%' );
define( 'NONCE_SALT',       '_8c3hR.?#^Uvw!d=6AUzz8^]0=]E!3xo6E!C_Q>YBGJevOiV =`&gX6Air5lxDx7' );

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

