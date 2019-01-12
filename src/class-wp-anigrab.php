<?php
declare(strict_types=1);
/**
 * Class Grei\Wp_Anigrab
 *
 * @package Wp_Anigrab
 */
namespace Grei;
use Exception;
class Wp_Anigrab {

	final public static function ani_render( array $data, array $postarr ):array {
		$post    = $data['post_content'];
		$anigrab = new Anigrab( $post );
		if ( $anigrab->validate ) {
			$replace  = "<!--powered by anigrab (https://github.com/anigrab/wp-anigrab)--> \n";
			$replace .= "<!--{$anigrab->tag}--> \n";
			try {
				$anigrab->start_grab();

				$replace .= $anigrab->render();
			} catch ( Exception $e ) {
				$err      = strtoupper( $e->getMessage() );
				$replace .= "===== ERROR RENDERING! ===== \n\n $err \n\n===== please open issue at https://github.com/anigrab/wp-anigrab/issues =====";
			}
			$replaced             = str_replace( $anigrab->tag, $replace, $post );
			$data['post_content'] = $replaced;
		}
		return $data;
	}
	final public static function register() {
		add_filter( 'wp_insert_post_data', '\Grei\Wp_Anigrab::ani_render', '99', 2 );
	}
}

