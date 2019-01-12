<?php
declare(strict_types=1);
/**
 * Class Grei\Anigrab
 *
 * @package Wp_Anigrab
 */
namespace Grei;
use Jikan\Jikan;
use Mustache_Engine;
class Anigrab {

	private $id;
	private $img;
	private $content;
	private $type;
	public $collection;
	public $validate;
	public $tag;

	public function __construct( String $data ) {
		if ( preg_match( '`\[(anigrab|mangrab)=(\d+)\]((.|\n)*)\[/\1\]`', $data, $matches ) ) {
			list($tag, $type, $id, $content, $ig) = $matches;
			$this->type     = $type;
			$this->validate = true;
			$this->content                 = $content;
			$this->id                  = (int) $id;
			$this->tag = $tag;
		} else {
			$this->validate = false;
		}

	} // end __construct()

	public function start_grab() {
		$id    = $this->id;
		$jikan = new Jikan;
		if ( 'anigrab' === $this->type ) {
			$anime = $jikan->Anime( $id )->response;
			foreach ( $anime as $key => $value ) {
				if ( is_array( $value ) ) {
					unset( $anime[ $key ] );
				}
			}
		} else {
			$anime = $jikan->Manga( $id )->response;
			foreach ( $anime as $key => $value ) {
				if ( is_array( $value ) ) {
					unset( $anime[ $key ] );
				}
			}
		}

		$this->img        = $anime['image_url'];
		$this->collection = $anime;
	} // end start_grab()

	private function ani_dump():String {
		$info = $this->collection;
		unset( $info['image_url'] );
		$ret  = "<img src=\"{$this->img}\" alt=\"poster\"/> <br> \n";
		$ret .= "[ <a href=\"{$info['link_canonical']}\" target=\"_blank\">go to</a> myanimelist page ] <br> <br> \n";
		unset( $info['link_canonical'] );
		foreach ( $info as $key => $value ) {
			$ret .= "<strong>$key:</strong> $value <br> <br>\n";
		}
		return $ret;
	} // end ani_dump();

	public function render():String {
		if ( 'dump' == trim($this->content) ) {
			$out = $this->ani_dump();
			return $out;
		} else {
			$m = new Mustache_Engine;
			return $m->render( $this->content, $this->collection );
		}
	} // end render()

}
