$(function() {
	// Author: Michael Robinson
	$(".tablesorter").tablesorter({ 
 		widgets: ["saveSort", "zebra"] 
 	});

	$(".tablesorter tbody tr").click(function() {
		var spcc = $(this).attr('alt');
		//alert(spcc);
		var spcclocation = '../spcc/word/SPCCDX.php?ref='+$(this).attr('alt');
		window.open(spcclocation);
	});


	
});