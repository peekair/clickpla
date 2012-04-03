var signupsLeft;

	function load_pending(status) {
		var targetContainer;
		setLoading('loading_alert', 1);
		if (status == 1) targetContainer = "pending_admin";
		else targetContainer="pending_advertiser";
		var ajax = new Ajax.Updater(targetContainer,"adminAjax.php?resource="+ajax_resource+"&action=pending_signups&status="+status+"&"+url_variables, {method:'post', evalScripts:true, asynchronous:true});
	}
	
	function approve_load_done(status) {
		setLoading('loading_alert', 0);
		var targetContainer;
		if (status == 1) targetContainer = "pending_admin";
		else targetContainer="pending_advertiser";
		
	}
	
	
	function deselectBox(id, disableBox) {
		var cBox;
		var x;
		for(x=0; cBox = document.getElementById('checkBox'+x+''); x++) {
			var id2 = cBox.getAttribute("rel");
			if(id == id2) {
				cBox.checked=false;
				if(disableBox == 1) {
					cBox.setAttribute("dis","1");
				}
			}
		}	
	}
	
	function deselectAllBoxes(disableBox) {
		var cBox;
		var x;
		for(x=0; cBox = document.getElementById('checkBox'+x+''); x++) {
			if(disableBox == 1 && cBox.checked == true) {
				cBox.setAttribute("dis","1");
			}
			cBox.checked=false;
		}	
	}
	
	function getSelectedBoxes() {
		var index=0;
		var selected = new Array;
		var selected2 = "";
		var x;
		for(x=0; cBox = document.getElementById('checkBox'+x+''); x++) {
			var id2 = cBox.getAttribute("rel");
			if(cBox.checked == true) {
				selected[index]=id2;
				index++;
			}
		}	
		if(selected.length == 0) alert("No items selected!"); 
		else {
			selected2 = selected.join(",");
		}
		return selected2;
	}
	
	

	function toggleBoxes(mainBox, total) {
		newStatus = mainBox.checked;
		var x;
		for(x=0; x<total; x++) {
			cBox = document.getElementById('checkBox'+x+'');
			if(cBox.getAttribute("dis") != 1) cBox.checked=newStatus;
		}
	}
	
	function approve_signups_sm(targetobj) {
		jQuery(document.getElementById(targetobj)).slideToggle("fast");
	}
	
	function approve_signup(id,approval) {
		deselectBox(id,1);
		setLoading('loading_alert', 1);
		var ajax = new Ajax.Updater('returnOut',"adminAjax.php?resource="+ajax_resource+"&action=do_approve_signup&id="+id+"&approve="+approval+"&"+url_variables, {method:'post', evalScripts:true, asynchronous:true});
	}
	function approve_done_signup(contId) {
		setLoading('loading_alert', 0);
		jQuery(document.getElementById("approve_signup_main"+contId)).hide("fast");
		countDown();
	}
	
	
	function mass_approve_signup(approval) {
		toggleButtons('true');
		var selected = getSelectedBoxes();
		if(selected != "") {
			setLoading('loading_alert', 1);
			var ajax = new Ajax.Updater('returnOut',"adminAjax.php?resource="+ajax_resource+"&action=do_approve_signup&mass=1&ids="+selected+"&approve="+approval+"&"+url_variables, {method:'post', evalScripts:true, asynchronous:true});
		}
	}
	
	function countDown() {
		signupsLeft--;
		if(signupsLeft <= 0) {
			load_pending(1);
		}
	}

	function approve_done_mass_signup(ids) {
		deselectAllBoxes(1);
		setLoading('loading_alert', 0);
		ida = ids.split(",");
		toggleButtons('');
		var x;
		for(x=0; x<ida.length; x++) {
			jQuery(document.getElementById("approve_signup_main"+ida[x])).hide("fast");
			countDown();
		}
		scroll(0,0);
	}
	
	function toggleButtons(setTo) {
		document.getElementById('doButton1').disabled=setTo;
		document.getElementById('doButton2').disabled=setTo;
		document.getElementById('doButton3').disabled=setTo;
	}
	