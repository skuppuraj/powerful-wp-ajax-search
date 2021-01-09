<?php

namespace PWAS;

class Main{

	public function run(){
		add_action( 'plugins_loaded', array( $this, 'add_action_hooks' ), 1 );
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
		wp_enqueue_script( 'pwas_js', "{$front}/js/pwas-{$version}{$min}.js", array(), PWAS_VERSION, true );

		wp_enqueue_style( 'pwas_css', "{$front}/css/pwas-{$version}{$min}.css", array(), PWAS_VERSION );

		$script = '(function ($) {
				    "use strict";
				     $("#sb-search").on("click",function(){
				    	$(".pwas-search-component").show();
					 })

				})(jQuery);';
		
		
		wp_add_inline_script('pwas_js', $script, 'after');
	}

	public function init_pwas_element(){
		echo "<div id='powerful-wp-ajax-search'></div>";
	}
}