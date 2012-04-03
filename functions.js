/*
Submit Once form validation-
� Dynamic Drive (www.dynamicdrive.com)
For full source code, usage terms, and 100's more DHTML scripts, visit http://dynamicdrive.com
*/
function submitonce(theform){
	if (document.all||document.getElementById){
		for (i=0;i<theform.length;i++){
			var tempobj=theform.elements[i]
			if(tempobj.type.toLowerCase()=="submit"||tempobj.type.toLowerCase()=="reset") tempobj.disabled=true
		}
	}
}

function verifyfields(theform){
	if (document.all||document.getElementById){
		for (i=0;i<theform.length;i++){
			var tempobj=theform.elements[i]
			if(tempobj.type.toLowerCase()=="text"&&tempobj.value=="") {
				alert('You Must Enter A Value For All Fields!!');
				tempobj.focus();
				return false;
			}
		}
	}
}



var xOffset = 15;
var yOffset = 10;
xMousePos = 0; // Horizontal position of the mouse on the screen
yMousePos = 0; // Vertical position of the mouse on the screen
xMousePosMax = 0; // Width of the page
yMousePosMax = 0; // Height of the page



function captureMousePosition(e) {
    if (document.layers) {
        // When the page scrolls in Netscape, the event's mouse position
        // reflects the absolute position on the screen. innerHight/Width
        // is the position from the top/left of the screen that the user is
        // looking at. pageX/YOffset is the amount that the user has
        // scrolled into the page. So the values will be in relation to
        // each other as the total offsets into the page, no matter if
        // the user has scrolled or not.
        xMousePos = e.pageX;
        yMousePos = e.pageY;
        xMousePosMax = window.innerWidth+window.pageXOffset;
        yMousePosMax = window.innerHeight+window.pageYOffset;
    } else if (document.all) {
        // When the page scrolls in IE, the event's mouse position
        // reflects the position from the top/left of the screen the
        // user is looking at. scrollLeft/Top is the amount the user
        // has scrolled into the page. clientWidth/Height is the height/
        // width of the current page the user is looking at. So, to be
        // consistent with Netscape (above), add the scroll offsets to
        // both so we end up with an absolute value on the page, no
        // matter if the user has scrolled or not.
        xMousePos = window.event.x+document.body.scrollLeft;
        yMousePos = window.event.y+document.body.scrollTop;
        xMousePosMax = document.body.clientWidth+document.body.scrollLeft;
        yMousePosMax = document.body.clientHeight+document.body.scrollTop;
    } else if (document.getElementById) {
        // Netscape 6 behaves the same as Netscape 4 in this regard
        xMousePos = e.pageX;
        yMousePos = e.pageY;
        xMousePosMax = window.innerWidth+window.pageXOffset;
        yMousePosMax = window.innerHeight+window.pageYOffset;
    }
}





function showPopup (targetObjectId, eventObj, msg) {
	if(msg == undefined) {
		msg="Error getting help data";
	}
	helpbox.value=msg;
    if(eventObj) {
	// hide any currently-visible popups
	hideCurrentPopup();
	// stop event from bubbling up any farther
	eventObj.cancelBubble = true;
	// move popup div to current cursor position
	// (add scrollTop to account for scrolling for IE)
	var newXCoordinate = (eventObj.pageX)?eventObj.pageX + xOffset:eventObj.x + xOffset + ((document.body.scrollLeft)?document.body.scrollLeft:0);
	var newYCoordinate = (eventObj.pageY)?eventObj.pageY + yOffset:eventObj.y + yOffset + ((document.body.scrollTop)?document.body.scrollTop:0);
	moveObject(targetObjectId, newXCoordinate, newYCoordinate);
	// and make it visible
	if( changeObjectVisibility(targetObjectId, 'visible') ) {
	    // if we successfully showed the popup
	    // store its Id on a globally-accessible object
	    window.currentlyVisiblePopup = targetObjectId;
	    return true;
	} else {
	    // we couldn't show the popup, boo hoo!
	    return false;
	}
    } else {
	// there was no event object, so we won't be able to position anything, so give up
	return false;
    }
} // showPopup

function hideCurrentPopup() {
    // note: we've stored the currently-visible popup on the global object window.currentlyVisiblePopup
    if(window.currentlyVisiblePopup) {
	changeObjectVisibility(window.currentlyVisiblePopup, 'hidden');
	window.currentlyVisiblePopup = false;
    }
} // hideCurrentPopup



// ***********************
// hacks and workarounds *
// ***********************

// initialize hacks whenever the page loads
window.onload = initializeHacks;

// setup an event handler to hide popups for generic clicks on the document
//document.onclick = hideCurrentPopup();

function initializeHacks() {
    // this ugly little hack resizes a blank div to make sure you can click
    // anywhere in the window for Mac MSIE 5
    if ((navigator.appVersion.indexOf('MSIE 5') != -1)
	&& (navigator.platform.indexOf('Mac') != -1)
	&& getStyleObject('blankDiv')) {
	window.onresize = explorerMacResizeFix;
    }
    resizeBlankDiv();
    // this next function creates a placeholder object for older browsers
    createFakeEventObj();
}

function createFakeEventObj() {
    // create a fake event object for older browsers to avoid errors in function call
    // when we need to pass the event object to functions
    if (!window.event) {
	window.event = false;
    }
} // createFakeEventObj

function resizeBlankDiv() {
    // resize blank placeholder div so IE 5 on mac will get all clicks in window
    if ((navigator.appVersion.indexOf('MSIE 5') != -1)
	&& (navigator.platform.indexOf('Mac') != -1)
	&& getStyleObject('blankDiv')) {
	getStyleObject('blankDiv').width = document.body.clientWidth - 20;
	getStyleObject('blankDiv').height = document.body.clientHeight - 20;
    }
}

function explorerMacResizeFix () {
    location.reload(false);
}

function getStyleObject(objectId) {
    // cross-browser function to get an object's style object given its id
    if(document.getElementById && document.getElementById(objectId)) {
	// W3C DOM
	return document.getElementById(objectId).style;
    } else if (document.all && document.all(objectId)) {
	// MSIE 4 DOM
	return document.all(objectId).style;
    } else if (document.layers && document.layers[objectId]) {
	// NN 4 DOM.. note: this won't find nested layers
	return document.layers[objectId];
    } else {
	return false;
    }
} // getStyleObject

function changeObjectVisibility(objectId, newVisibility) {
    // get a reference to the cross-browser style object and make sure the object exists
    var styleObject = getStyleObject(objectId);
    if(styleObject) {
	styleObject.visibility = newVisibility;
	return true;
    } else {
	// we couldn't find the object, so we can't change its visibility
	return false;
    }
} // changeObjectVisibility

function moveObject(objectId, newXCoordinate, newYCoordinate) {
    // get a reference to the cross-browser style object and make sure the object exists
    var styleObject = getStyleObject(objectId);
    if(styleObject) {
	styleObject.left = newXCoordinate;
	styleObject.top = newYCoordinate;
	return true;
    } else {
	// we couldn't find the object, so we can't very well move it
	return false;
    }
} // moveObject






function buylink() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.link.value+'&ptype=link&".$url_variables."'
}
function buyptsu() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.ptsu.value+'&ptype=ptsu&".$url_variables."'
}
function buyxcredits() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.xcredits.value+'&ptype=xcredits&".$url_variables."'
}
function buysurf() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.link.value+'&ptype=surf&".$url_variables."'
}
function buyghits() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.ghits.value+'&ptype=ghits&".$url_variables."'
}
function buypopups() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.popups.value+'&ptype=popups&".$url_variables."'
}
function buyptr() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.ptr.value+'&ptype=ptr&".$url_variables."'
}
function buyptra() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.ptra.value+'&ptype=ptra&".$url_variables."'
}
function buygpoints() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.gpoints.value+'&ptype=gpoints&".$url_variables."'
}
function buyptrac() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.ptrac.value+'&ptype=ptrac&".$url_variables."'
}
function buyfbanner() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.banner.value+'&ptype=fbanner&".$url_variables."'
}
function buybanner() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.banner.value+'&ptype=banner&".$url_variables."'
}
function buyfad() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.fad.value+'&ptype=fad&".$url_variables."'
}
function buyflink() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.flink.value+'&ptype=flink&".$url_variables."'
}
function buyref() {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+document.form.referrals.value+'&ptype=referrals&".$url_variables."'
}
function buyupgrade(id,amount) {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+amount+'&id='+id+'&ptype=upgrade&".$url_variables."'
}
function buyspecial(id,amount) {
	location.href='index.php?view=account&ac=buywizard&step=2&samount='+amount+'&id='+id+'&ptype=special&".$url_variables."'
}