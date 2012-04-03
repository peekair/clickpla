
function setLoader(target, status) {
	if(status == 1) document.getElementById(target).style.display='block';
	else document.getElementById(target).style.display='none';
	
}


function updateStats() {
//	setLoader('liveStatsLoading', 1);
	var ajax = new Ajax.Updater('liveStats',"adminAjax.php?resource=stats&action=live&", {method:'post', evalScripts:true, asynchronous:true});
}
