<?php
declare(strict_types=1);
namespace Grei;
use Jikan\Jikan;
use Mustache_Engine;
class Anigrab {

	private $id;
	private $tag;
	private $data;
	private $img;
	private $content;
	private $type;
	public $collection;
	public $validate;

	public function __construct( String $data ) {
		if ( preg_match( '`\[(anigrab)=(.*?)\](.+?)\[/\1\]`', $data ) ) {
			$this->data     = $data;
			$this->type     = 'anime';
			$this->validate = true;

		} elseif ( preg_match( '`\[(mangrab)=(.*?)\](.+?)\[/\1\]`', $data ) ) {
			$this->data     = $data;
			$this->type     = 'manga';
			$this->validate = true;
		} else {
			$this->validate = false;
		}

	} // end __construct()

	public function start_grab() {
		$this->ani_bb();
		$id    = $this->id;
		$jikan = new Jikan;
		if ( 'anime' === $this->type ) {
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

	private function ani_bb() {
		preg_match( '`\[(anigrab|mangrab)=(.*?)\](.+?)\[/\1\]`', $this->data, $matches );
		list($tag, $param, $innertext) = array( $matches[1], $matches[2], $matches[3] );
		$this->content                 = $innertext;
			$this->id                  = (int) $param;
			$this->tag                 = $tag;
	} // end ani_bb()

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
		if ( 'dump' == $this->content ) {
			$out = $this->ani_dump();
			return $out;
		} else {
			$m = new Mustache_Engine;
			return $m->render( $this->content, $this->collection );
		}
	} // end render()

}