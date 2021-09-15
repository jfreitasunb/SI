<div id="dialog_general_message">
	<p>
		{message}
	</p>
</div>
<script type="application/javascript">
	$("#dialog_general_message").dialog({
		modal: true,
		buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
			}
		}
	});
</script>