<?php

namespace PWAS\Actions;
use PWAS\Core\ActionCore;

class CarouselAction extends ActionCore {

	
	public function __construct( $id, $no_privilege, $action_prefix ) {
		parent::__construct( $id, $no_privilege, $action_prefix );
	}

	public function action() {

		global $wpdb;

		$post_content = $wpdb->get_results("select ID,post_title from $wpdb->posts where post_status='publish' AND post_type = 'post'", ARRAY_A);  

		if ( empty( $post_content ) ) {
			return array();
		}

		foreach ( $post_content as $key => $post ) {
			$image = get_the_post_thumbnail_url( $post['ID'], array( 125, 125) );
			$post_content[$key]['img'] = $image;
		}

		$this->out($post_content);
	}
}
