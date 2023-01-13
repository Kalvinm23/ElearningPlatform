$( "#post_list" ).sortable({
	placeholder : "ui-state-highlight",
	update  : function(event, ui)
	{
		var post_order_ids = new Array();
		$('#post_list div').each(function(){
			post_order_ids.push($(this).data("post-id"));
		});
		// $.ajax({
		// 	url:"/coursesunits",
		// 	method:"POST",
		// 	data:{post_order_ids:post_order_ids},
		// 	success:function(){
		// 	   alert('Successfully updated')
		// 		  //do whatever after success
		// 	}
		// });
	}
});