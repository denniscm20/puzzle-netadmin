var idlist;

function ManageTabPanelDisplay() {
	if(arguments.length < 1) { return; }
	for(var i = 0; i < idlist.length; i++) {
		var block = false;
		for(var ii = 0; ii < arguments.length; ii++) {
			if(idlist[i] == arguments[ii]) {
				block = true;
				break;
			}
		}
		if(block) { document.getElementById(idlist[i]).style.display = "block"; }
		else { document.getElementById(idlist[i]).style.display = "none"; }
	}
}