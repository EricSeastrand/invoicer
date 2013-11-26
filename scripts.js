function prepareNewItemLine(title, price, appendTo) {

	console.log(title, price, appendTo);

	var tr = $('<tr>').appendTo(appendTo);
	$('<td>').text(title).appendTo(tr);
	$('<td>').text('$'+price).appendTo(tr);



}
$(function(){

	$('.invoice-items-table').on('dblclick', 'tr', function(){
		$(this).hide();
	})

$('.new-line-item').on('keyup', function(e){
	if(e.which !== 13) return;
	
	var title = $(this).find('[type="text"]').val();
	var price = $(this).find('[type="number"]').val();

	prepareNewItemLine(title, price, '.new-line-item');

});

})
