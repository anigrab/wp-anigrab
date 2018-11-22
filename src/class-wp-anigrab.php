<?php
declare(strict_types=1);
namespace Grei;
use Exception;
class Wp_Anigrab {

	final public static function ani_render( Array $data, Array $postarr ):Array {
		$post    = $data['post_content'];
		$anigrab = new Anigrab( $post );
		if ( $anigrab->validate ) {
			preg_match( '`\[(anigrab|mangrab)=(.*?)\](.+?)\[/\1\]`', $post, $tgs );
			$replace  = "<!--powered by anigrab (https://ipynb.wordpress.com)--> \n";
			$replace .= "<!--{$tgs[0]}--> \n";
			try {
				$anigrab->start_grab();

				$replace .= $anigrab->render();
			} catch ( Exception $e ) {
				$err      = strtoupper( $e->getMessage() );
				$replace .= "===== ERROR RENDERING! ===== \n\n $err \n\n===== powered by anigrab =====";
			}
			$replaced             = preg_replace( '`\[(anigrab|mangrab)=(.*?)\](.+?)\[/\1\]`', $replace, $post );
			$data['post_content'] = $replaced;
		}
		return $data;
	}
	final public static function register() {
		add_filter( 'wp_insert_post_data', '\Grei\Wp_Anigrab::ani_render', '99', 2 );
	}
}
