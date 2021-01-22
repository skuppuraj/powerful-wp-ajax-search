<?php

namespace PWAS;
use PWAS\Controllers\AjaxController;
use PWAS\Actions\SearchAction;
use PWAS\Actions\CarouselAction;

class Main{

	private $ajax_manager;

	public function run(){
		$this->create_objects();
		$this->configure_objects();
		add_action( 'plugins_loaded', array( $this, 'add_action_hooks' ), 1 );
	}

	public function create_objects(){
		$this->ajax_manager = new AjaxController( $this->get_ajax_actions() );
	}

	private function configure_objects() {
		$this->ajax_manager->load_all();
	}

	public function add_action_hooks(){
		add_action( 'wp_footer', array( $this, 'init_pwas_element' ) );
		add_action( 'wp', array( $this, 'init_hooks' ), 1 );
	}

	public function init_hooks(){
		$this->load_actions();
	}

	public function load_actions(){
		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ), 11 ); 
	}

	public function load_assets(){
		$min = ( 0 ) ? '.min' : '';

		$front = trailingslashit( PWAS_PLUGIN_URL ) . 'dist';
		$version = PWAS_VERSION;
		wp_enqueue_script( 'pwas-js', "{$front}/js/pwas-{$version}{$min}.js", array(), PWAS_VERSION, true );

		wp_enqueue_style( 'pwas-css', "{$front}/css/pwas-{$version}{$min}.css", array(), PWAS_VERSION );

		$script = '(function ($) {
				    "use strict";
				     $("#sb-search").on("click",function(){
				    	$(".pwas-search-component").show();
				    	$("body").css({"overflow":"hidden"});
					 })
					 $("#pwas-close-button").on("click",function(){
				    	$(".pwas-search-component").hide();
				    	$("body").css({"overflow":""});
					 })

				})(jQuery);';
		
		
		wp_add_inline_script('pwas-js', $script, 'after');

		$variables = array(
		        'ajaxurl' => admin_url( 'admin-ajax.php' )
		    );
		wp_localize_script('pwas-js', "pwas_object", $variables);
	}

	public function init_pwas_element(){
		echo "<div id='powerful-wp-ajax-search'></div>";
	}

	public function get_ajax_actions() {
		return array(
			new SearchAction( 'search', true, 'wp_ajax_' ),
			new CarouselAction( 'carousel', true, 'wp_ajax_' ),
		);
	}
}