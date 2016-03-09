function botones(accion)
{
	var text = window.getSelection();
	var ele = document.getElementById('respuesta');
	switch(accion)
	{
	case 1:
		//ele.value+=ele.value.substring(0,el.selectionStart) + '[b]';
		ele.value= ele.value.substring(0,ele.selectionStart) + "[b]" + ele.value.substring(ele.selectionStart,ele.selectionEnd) + "[/b]" + ele.value.substring(ele.selectionEnd,ele.value.length);
		//ele.value+="[/b]"+ ele.value.substring(el.selectionEnd,el.value.length);
		break;
	case 2:
		ele.value= ele.value.substring(0,ele.selectionStart) + "[i]" + ele.value.substring(ele.selectionStart,ele.selectionEnd) + "[/i]" + ele.value.substring(ele.selectionEnd,ele.value.length);
		break;
	case 3:
		ele.value= ele.value.substring(0,ele.selectionStart) + "[url=]" + ele.value.substring(ele.selectionStart,ele.selectionEnd) + "[/url]" + ele.value.substring(ele.selectionEnd,ele.value.length);
		break;
	case 4: 
		ele.value= ele.value.substring(0,ele.selectionStart) + "[img]" + ele.value.substring(ele.selectionStart,ele.selectionEnd) + "[/img]" + ele.value.substring(ele.selectionEnd,ele.value.length);
		break;
	case 5: 
		ele.value= ele.value.substring(0,ele.selectionStart) + "[spoiler]" + ele.value.substring(ele.selectionStart,ele.selectionEnd) + "[/spoiler]" + ele.value.substring(ele.selectionEnd,ele.value.length);
		break;
	case 6:
		ele.value= ele.value.substring(0,ele.selectionStart) + "[video]" + ele.value.substring(ele.selectionStart,ele.selectionEnd) + "[/video]" + ele.value.substring(ele.selectionEnd,ele.value.length);
		break;
	}
}

function spoiler(idDiv,idBoton)
{
	var ele = document.getElementById(idDiv);
	var text = document.getElementById(idBoton);
	if(ele.style.display == "") {
    		ele.style.display = "none";
		text.innerHTML = "ver";
  	}
	else {
		ele.style.display = "";
		text.innerHTML = "ocultar";
	}
}