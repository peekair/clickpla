var openCids = new Array;
var currentPopObj;

//createCookie('menuHold','','99');

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}

function saveMenuCookie() {
	var tempCookie = generateCidlist();
	createCookie('menuHold',tempCookie,'99');
}

function showArrayList(a) {
	var temp=a.join(", ");
}

function generateCidlist() {
	var tempCookie="";
	var len = openCids.length;
	tempCookie = openCids.join(" ");
	return tempCookie;
}

function removeCidFromList(cid) {
	var x;
	for(x=0; x<openCids.length; x++) {
		if(openCids[x] == cid) {
			openCids.splice(x, 1);
			showArrayList(openCids);
		}
	}
}

function addCidToList(cid) {
	var len = openCids.length;
	openCids[len]=cid;
	showArrayList(openCids);
}

function outputStat(cont) {
	document.getElementById('statOutput').innerHTML=cont;
}

function toggleSub(cid) {
	targObj = document.getElementById('dropCont'+cid);
	if(targObj) {
		if(targObj.style.display != "block") addCidToList(cid);
		else removeCidFromList(cid); //remove from list
		saveMenuCookie()
		jQuery(targObj).slideToggle("medium");
	}
		return false;
}

function openHoldMenus() {
	var tmp = readCookie('menuHold').split(" ");
	var len = tmp.length;
	var x;
	for(x=0; x<len; x++) {
		if(tmp[x] != '') {
			addCidToList(tmp[x]);
			if(document.getElementById('dropCont'+tmp[x])) document.getElementById('dropCont'+tmp[x]).style.display='block';
		}
	}
}


function setAdminLoading(toggle) {
	var newtoggle = (toggle == 1) ? 'block' : 'none';
	document.getElementById('adminLoading').style.display=newtoggle;
}


function loadAjaxPage(contId, resource, url, vars) {
	setAdminLoading(1);
	var ajax = new Ajax.Updater(contId,"adminAjax.php?resource="+resource+"&action="+url+"&"+vars+url_variables, {method:'post',onSuccess: function(transport){setAdminLoading(0);}, evalScripts:true, asynchronous:true});
}


function closeAdminPopup() {
	if(currentPopObj) { 
		var storage = document.getElementById('domStorage');
		document.getElementById('adminPopupCont').style.display='none';
		currentPopObj.parentNode.removeChild(currentPopObj);
		storage.appendChild(currentPopObj);
	}
}



function openAdminPopup(srcId, title) {
	closeAdminPopup();
	currentPopObj = document.getElementById(srcId);
	var targetParent = document.getElementById('adminPopupContent');
	currentPopObj.parentNode.removeChild(currentPopObj);
	targetParent.appendChild(currentPopObj);
	document.getElementById('adminPopupTitle').innerHTML=title;
	document.getElementById('adminPopupCont').style.display='block';
}	


/*

{method:'post',onSuccess: function(transport){
      var response = transport.responseText || "no response text";
      alert("Success! \n\n" + response);
    }
*/

jQuery(document).ready(function(){
	jQuery(".tableData tr").hover(function(){
		jQuery(this).addClass("hover");
	},function(){
		jQuery(this).removeClass("hover");
	});
	
	jQuery(".tableData tr:even").addClass("even");
	jQuery(".tableData tr:odd").addClass("odd");
});