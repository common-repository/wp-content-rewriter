jQuery(document).ready(function() {
 
	jQuery( "#wp_rewrite_submit" ).click(function() {
		var content = jQuery('#wp_rewrite_text').val();
		jQuery('#waiting_image').show();

		var urll = 'http://'+document.location.hostname+"/wp-admin/admin-ajax.php";
		  jQuery.ajax({
			  type: "POST",
			  url: urll,
			  //data: content,
			  data: ({'action' : 'wp_rewriter_ajax_request', 'content':content}),
			  success: function(data) {
				  //jQuery('#waiting_image').hide();
				  jQuery('#rewrited_c').show();
				  jQuery('#remove_span').show();
				jQuery('#wp_rewrited_text').html(data.substring(0, data.length - 1));
			  },
			  error: function(){
					alert('Oopsssss Something Wrong..');
				  }
			});
			
	});
	
	jQuery( "#remove_span" ).click(function() {
		//alert(jQuery(this).val());
		if(jQuery(this).val() == 'Convert to Plain Text'){
				var html_content = jQuery('#wp_rewrited_text').html();
				jQuery('#text_backup').html(html_content);
				var content = jQuery('#wp_rewrited_text').text();
				jQuery('#wp_rewrited_text').text(content);
				jQuery(this).val('Revert text');
		}else{
				var content = jQuery('#wp_rewrited_text').text();
				var html_content = jQuery('#text_backup').html();
				jQuery('#text_backup').text(content);
				
				jQuery('#wp_rewrited_text').html(html_content);
				jQuery(this).val('Convert to Plain Text');
		}
		
	});
          
});
