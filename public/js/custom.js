successMessage = (msg, timeout = 4000) =>{
	$( "#msgBox" ).css('display', 'block');
	$( "#msgBox" ).addClass('alert');
	$( "#msgBox" ).addClass('alert-success');
	$( "#msgBox" ).html( "<p>"+msg+"</p>" );
	setTimeout(function(){ 
		$( "#msgBox" ).css('display', 'none');
		$( "#msgBox" ).removeClass('alert');
		$( "#msgBox" ).removeClass('alert-success');
	}, timeout);
}

errorMessage = (msg, timeout = 4000) =>{
	$( "#msgBox" ).css('display', 'block');
	$( "#msgBox" ).addClass('alert');
	$( "#msgBox" ).addClass('alert-danger');
	$( "#msgBox" ).html( "<p>"+msg+"</p>" );
	setTimeout(function(){ 
		$( "#msgBox" ).css('display', 'none');
		$( "#msgBox" ).removeClass('alert');
		$( "#msgBox" ).removeClass('alert-danger');
	}, timeout);
}