<?php
declare(strict_types=1);
/**
 * Plugin Name: wp anigrab
 * Plugin URI: https://github.com/anigrab/wp-anigrab
 * Description: grab anime info and save to local WordPress post
 * Version: 2.0.0
 * Author: grei
 * Author URI: https://ipynb.wordpress.com
 * License: GPL-3.0
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
require __DIR__ . '/vendor/autoload.php';

Grei\Wp_Anigrab::register();
