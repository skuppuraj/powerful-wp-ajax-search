<?php

namespace PWAS\Actions;
use PWAS\Core\ActionCore;

class SearchAction extends ActionCore {

	
	public function __construct( $id, $no_privilege, $action_prefix ) {
		parent::__construct( $id, $no_privilege, $action_prefix );
	}

	public function action() {
		$this->out( 'SearchAction.php' );
	}
}
