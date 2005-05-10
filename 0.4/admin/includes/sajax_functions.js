function msgBox(msg,statut)
{
	var msgElement = getElement("sajaxmsgbox");
	msgElement.innerHTML=statut+'<br/>'+msg;
	openClose("sajaxmsgbox",1);
}
