
function selectTab(targetobj) {
	targetobj.blur();
	var container = targetobj.getAttribute("rel");

	if(targetobj.parentNode.className == "selected") {
		return false;
	} 
	var ullist=targetobj.parentNode.parentNode.getElementsByTagName("li");
	for (var i=0; i<ullist.length; i++) ullist[i].className="";  //deselect all tabs

	var ullist=targetobj.parentNode.parentNode.getElementsByTagName("a");
	for (var i=0; i<ullist.length; i++)	{
		if(document.getElementById(ullist[i].getAttribute("rel")).style.display == 'block') {
			document.getElementById(ullist[i].getAttribute("rel")).style.display='none';  //hide all containers
		}
	}

	targetobj.parentNode.className="selected";
//	jQuery(document.getElementById(container)).slideDown("slow");
	jQuery(document.getElementById(container)).fadeIn("normal");
	document.getElementById(container).style.display='block';
	runFunc(targetobj)
	return false;
}

function runFunc(targetobj) {
	if(targetobj.getAttribute("rev")) {
		var runFunction = targetobj.getAttribute("rev");
		eval(runFunction);
	}	
}

function grabTab(targettab, targetrel) {
	targetobj = document.getElementById(targettab);
	var ullist=targetobj.parentNode.parentNode.getElementsByTagName("li");
	for (var i=0; i<ullist.length; i++) ullist[i].className="";  //deselect all tabs

	var ullist=targetobj.parentNode.parentNode.getElementsByTagName("a");
	for (var i=0; i<ullist.length; i++)	{
		if(ullist[i].getAttribute("rel") == targetrel) {
			selectTab(ullist[i]);
		}
	}
}	


function startTabs(){
	for (var i=0; i<arguments.length; i++){ //loop through passed UL ids
		var ulobj=document.getElementById(arguments[i])
		var ulist=ulobj.getElementsByTagName("li") //array containing the LI elements within UL
		for (var x=0; x<ulist.length; x++){ //loop through each LI element
			var ulistlink=ulist[x].getElementsByTagName("a")[0]
			if(ulist[x].className == "selected") var defaultTab = ulistlink;
			ulistlink.onclick=function(){
				selectTab(this);
				return false
			}
		}
	}
	runFunc(defaultTab);
}


function setLoading(target, status) {
	if(status == 1) document.getElementById(target).style.display='block';
	else document.getElementById(target).style.display='none';
	
}




