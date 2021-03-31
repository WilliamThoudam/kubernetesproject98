<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


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

//  MySQL settings - You can get this info from your web host  //
// The name of the database for WordPress */
define( 'DB_NAME', 'dojoko' );

// MySQL database username */
define( 'DB_USER', 'root' );

// MySQL database password */
define( 'DB_PASSWORD', 'mysql' );

// MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/** Custom Permssion. */
define('DISALLOW_FILE_MODS', false);

define('wp_auto_update_core', false);

define('AUTOMATIC_UPDATER_DISABLED', false);

define('FS_METHOD', 'direct');

define( 'WP_DEBUG', false );


/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'F@SKeZAy%D>mMu@9-E!d/>^LL8V6V7rF($1m;J/L<@V#]D+l<FEp(m8[L=mf7_*z' );
define( 'SECURE_AUTH_KEY',   '!pTf6!,3pdOO!>7jK=jl[8}yE!rty@YPfkl8P.Jk}bP,BM7nbO:ko-O]vVxU+f5U' );
define( 'LOGGED_IN_KEY',     '`Xa~W~DD(UPNy/1+nE<9[S3vO4iee}S@R%t,t.w9POmmS.N~y=4/M]S,m&8f61kx' );
define( 'NONCE_KEY',         'y1oSg}] .sv$8<FaKhC3P#tF4d~33PczjNV.{+_i!bKzzs2*dI8^I|074H+v^u4{' );
define( 'AUTH_SALT',         '+gCdur(HkoG^wr3K=8_pkK;ej%enq.S]$~o!5Mt;kS>De+(j7HWK*yOrS<?NxC%^' );
define( 'SECURE_AUTH_SALT',  '&nOUD%oB|ICP=u>%<+@&55v&7& xJLK-F|!+X<(EY%r=@[V2.DWF~Sf]Uw9vB%jZ' );
define( 'LOGGED_IN_SALT',    'k0^2@mg x<|2AlbTl)Xu=*/e1q^%W~`:yIKNU4]#Sd2r]`jQaz5z=l3?7w *`+)b' );
define( 'NONCE_SALT',        '0+[}!/BK|=z<4u9lPS}b@d( H?9Nvuw46M(>pQ<<,ZT@[*sHogxZDOs?b`;42.-&' );
define( 'WP_CACHE_KEY_SALT', 'aem>V@&kd04mI h:d|38:RQyc|w&}aAa-Nd5b~1/&90Q=QRN[gv;b,PmRQHxiS-g' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */

if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false)
    $_SERVER['HTTPS']='false';


$table_prefix = 'wp_';
# No ACM Public SSL Certificate 
define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST']); 
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST']); 




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';