function openClose(id,mode)
{
	if(document.getElementById) {
		element = document.getElementById(id);
		img = document.getElementById('img_' + id);
	} else if(document.all) {
		element = document.all[id];
		img = document.all['img_' + id];
	} else return;

	if(element.style) {
		if(mode == 0) {
			if(element.style.display == 'block' ) {
				element.style.display = 'none';
				img.src = 'images/plus.png';
			} else {
				element.style.display = 'block';
				img.src = 'images/moins.png';
			}
		} else if(mode == 1) {
			element.style.display = 'block';
			img.src = 'images/moins.png';
		} else if(mode == -1) {
			element.style.display = 'none';
			img.src = 'images/plus.png';
		}
	}
}

function operations(action,mode)
{
	openClose('actionframe',mode);
	if(document.getElementById) {
		element = document.getElementById('actioncontent');
	} else if(document.all) {
		element = document.all['actioncontent'];
	} else return;
	element.src='./operations.php?act='+action;
	return;
}