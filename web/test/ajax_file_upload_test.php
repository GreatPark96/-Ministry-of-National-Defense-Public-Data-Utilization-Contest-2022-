<script src='//code.jquery.com/jquery.min.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js'></script>
<script>
 
$(function() {
	$('#myform').ajaxForm({
		dataType: 'json',
		beforeSend: function() {
			$('#result').append( "beforeSend...\n" );
		},
		complete: function(data) {
			$('#result')
				.append( "complete...\n" )
				.append( JSON.stringify( data.responseJSON ) + "\n" );
		}
	});
});

</script>

<form id='myform' action='ajax_file_upload.php' enctype='multipart/form-data' method='post'>
	<input type='file' name='myfile'>
    <input type='text' name='test'>
	<button>업로드</button>
</form>
<pre id='result'></pre>