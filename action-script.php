<script type="text/javascript">
	function deleteBacklink(id) {
		domain = document.getElementById("domain_" + id).getAttribute("value");

		var queryString = '&domain=' + domain + '&id=' + id;

		var deleteConfirm = confirm("Are you sure to delete " + domain + ' from your record ?');
		if (deleteConfirm == true) {

			jQuery.ajax({
			url: "../wp-content/plugins/sintesa-backlink-management/delete.php",
			data:queryString,
			type: "POST",
				success:function(data){
					$('#backlink_'+id).css('display','none');
				},
				error:function (){
					alert("Sorry something error happens, please try again");
				}
			});
		}
	}

	function update(id) {

		$('#image_'+id).fadeIn('slow');
		domain = document.getElementById("domain_" + id).getAttribute("value");
		element = document.getElementById ( "domain_authority_" + id ).innerText;

		var queryString = '&id=' + id + '&domain=' + domain;

			jQuery.ajax({
			url: "../wp-content/plugins/sintesa-backlink-management/update.php",
			data:queryString,
			type: "POST",
				success:function(data){
					$('#image_'+id).fadeOut('slow');
					document.getElementById( "domain_authority_" + id ).innerText = data;
				},
				error:function (){
					alert("Sorry something error happens, please try again");
					$('#image_'+id).fadeOut('slow');
				}
			});
	}
</script>