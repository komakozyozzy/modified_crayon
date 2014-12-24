$(function() {
	// Author: Nicholas Smith
	$(".tablesorter").tablesorter({ 
 		widgets: ["saveSort", "zebra"] 
 	});

	$(".tablesorter tbody tr").click(function() {
		var spcc = $(this).attr('alt');
		var spcclocation = '../spcc/word/SPCCDX.php?ref='+$(this).attr('alt');
		window.open(spcclocation);
	});


	
});
