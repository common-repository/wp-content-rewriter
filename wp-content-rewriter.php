<?php
/**
 * Plugin Name: WP Content Rewriter
 * Plugin URI: http://www.vibgyorlogics.com/wordpress-plugins/
 * Description: WP Content Rewriter.
 * Version: 1.0
 * Author: Vibgyor Logics
 * Author URI: http://www.vibgyorlogics.com/wordpress-plugins/
 * License: GPL2
 */
add_action( 'admin_menu', 'wp_content_rewriter_dashboard' );

function wp_content_rewriter_dashboard(){
   // add_menu_page( 'WP Content Rewriter', 'WP Content Rewriter', 'manage_options', 'wp_content_rewriter', 'wp_content_rewriter', '', 7 );
}
add_action( 'init', 'wp_content_rewriter_scripts' );
add_action("wp_ajax_nopriv_wp_rewriter_ajax_request", "wp_rewriter_ajax_request");
add_action("wp_ajax_wp_rewriter_ajax_request", "wp_rewriter_ajax_request");
/**
 * Proper way to enqueue scripts and styles
 */
function wp_content_rewriter_scripts() {//echo 'dfd';die;
	wp_enqueue_style( 'wp_content_rewriter_style', plugins_url().'/wp-content-rewriter/css/wp-content-rewriter.css' );
	wp_enqueue_script( 'wp_content_rewriter_js', plugins_url().'/wp-content-rewriter/js/wp-content-rewriter.js', array(), '1.0.0', true );
	
}

		
add_shortcode( 'wp_content_rewriter' , 'wp_content_rewriter_f' );
function wp_content_rewriter_f(){
	/*
	require_once(dirname(__FILE__).'/inc/rewriter_classes.php');
	if(isset($_POST['wp_rewrite_submit'])){
		$content = $_POST['wp_rewrite_text'];
		$rewriter_c = new wp_article_rewriter;
		$synonym_content = $rewriter_c->rewrite_content($content);
		$content = $rewriter_c->rebuild_content($synonym_content);
		echo $content;die;
	}*/
	
	?>
	
	<h3>WP Content Rewriter</h3>
	<br	>
	
	<form action = '#' method = 'POST'>
		<h4>Paste Content here</h4>
		<textarea name = 'wp_rewrite_text' id = 'wp_rewrite_text' rows = '10' style="width:100%"></textarea><br>
		<input type = 'button' name = 'wp_rewrite_submit' id = 'wp_rewrite_submit' value = 'Rewrite' style='margin-top: 10px;'> <br><br>
		<hr style="width:100%">
		
		<h4 id = 'rewrited_c' style = 'display:none'>Your Rewrite Content</h4>
		<div id = 'wp_rewrited_text' style = 'width:100%;min-height: 200px;'>
			<span id = 'waiting_image' style = 'display:none'><img src = "<?php echo plugins_url().'/wp-content-rewriter/images/waiting.gif'?>" height= '150px' width='150px'> <p>Content Rewriting in Progress. While enjoy with me.	</p></span>
		</div>
		<div style = 'display:none' id = 'text_backup'></div>
		<!--<textarea name = 'wp_rewrited_text' id = 'wp_rewrited_text' rows = '10' cols = '100'></textarea></br> -->
		<input type = 'button' style = 'display:none' name = 'remove_span' id = 'remove_span' value = 'Convert to Plain Text'> <br>
	</form>
	<?php
}

function wp_rewriter_ajax_request(){
		require_once(dirname(__FILE__).'/inc/rewriter_classes.php');
		$content = $_POST['content'];		
		$rewriter_c = new wp_article_rewriter;
		$synonym_content = $rewriter_c->rewrite_content($content);		
		$content = $rewriter_c->rebuild_content($synonym_content);
		echo $content;
	}
	
?>
