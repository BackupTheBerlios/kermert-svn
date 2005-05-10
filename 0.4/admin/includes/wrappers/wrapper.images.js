/* Receivers */

function statusUpdated(result)
{
	var results = parseGET(result);
	document.getElementById("b"+results['id']).value=results['button_text'];
}

/* Callers */

function updateStatus(id)
{
	x_updateImageStatus(id,statusUpdated);
	
}