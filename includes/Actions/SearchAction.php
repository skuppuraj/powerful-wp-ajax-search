<?php

namespace PWAS\Actions;
use PWAS\Core\ActionCore;

class SearchAction extends ActionCore {

	
	public function __construct( $id, $no_privilege, $action_prefix ) {
		parent::__construct( $id, $no_privilege, $action_prefix );
	}

	public function action() {
		$s = $_POST['aslp'];
		$s = apply_filters('asl_search_phrase_before_cleaning', $s);

		$s = stripcslashes($s);
		$s = trim($s);
		$s = preg_replace('/\s+/', ' ', $s);

		$s = apply_filters('asl_search_phrase_after_cleaning', $s);

		$id = 0;
		$instance = wd_asl()->instances->get($id);
		$sd = &$instance['data'];

		$searchController = new \asl_searchController(array(
		    "phrase"    => $s,
		    "id"        => $id,
		    "instance"  => $instance
		));

		$results = $searchController->search();

		if (count($results) <= 0 && $sd['kw_suggestions'])
		    $results = $searchController->kwSuggestions();

		do_action('asl_after_search', $s, $results, $id);

		if (empty($results) || !empty($results['nores'])) {
            $this->out($results);
        } else {
            $this->out($results);
            

        }


	}
}
