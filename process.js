$(document).ready(function() {
	$('#loading').delay(500).fadeOut(400);

	$('#post').click(function(){
		var post_title   = $('.post_title').val();
		var post_prefix  = $('.post_prefix').val();
		var post_sufix   = $('.post_sufix').val();
		var post_content = $('.post_content').val();

		$('#loading').fadeIn();
		var queryString;
		queryString = '&post_title='+post_title+'&post_prefix='+post_prefix+'&post_sufix='+post_sufix+'&post_content='+post_content;
		jQuery.ajax({
	      	url: '../wp-content/plugins/post-generator/autogenerate-process.php',
	      	data:queryString,
	      	type: "POST",
	      	success:function(data){
	        	$('.post-results').empty();
	    		var array_ = JSON.parse(data);
	    		$.each(array_, function(idx, obj){
	    			var new_element = '<li>'+
						'<div>'+
							'<label>Title</label>'+
							'<p class="title">'+obj.title+'</p>'+
							'<label>Content</label>'+
							'<p class="content">'+obj.content+'</p>'+
						'</div>'+
					'</li>';

	        		$('.post-results').append(new_element);
	    		});

	        	$('#loading').fadeOut();
	      	}
	    });
	});
});