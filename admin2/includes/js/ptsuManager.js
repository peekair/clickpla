var manager_start;
var manager_epp;
var manager_sortType;
var manager_sortOrder;
var manager_searchStr;
var manager_searchItem;
	
	
///*				Edit Ad Functions			 */
	function edit_ad(id) {
		setLoading('loading_alert', 1);
		loadFile("adminAjax.php?resource=ptsu&action=edit_ad&id="+id+"&"+url_variables, "edit_ad", 1);
	}
	
	function do_edit_ad(id){
		setLoading('loading_alert', 1);
		//var formElements = Form.serialize('editForm');
		//var ajax = new Ajax.Updater('returnOut',"", {method:'post', postBody:formElements, evalScripts:true, asynchronous:true});
		var formData = $("#editForm").serialize();
		this.loadFile("adminAjax.php?resource=ptsu&action=do_edit&id="+id+"&"+formData+"&"+url_variables, "returnOut", 0);
	}
	
	function edit_done() {
		setLoading('loading_alert', 0);
	//	document.getElementById("edit_ad").style.height=400;
		$("#edit_ad_message").html('Your changes have been saved!');
	//	$(document.getElementById("edit_ad_message")).slideDown("slow");
		$("#edit_ad_message").show("slow");
	}
	
	
	
	
///*				New Ad Functions			 */
	function create_ad(){
		if(verifyForm() == false) return false;
		setLoading('loading_alert', 1);
		//var formElements = Form.serialize('newAdForm');
		//var ajax = new Ajax.Updater('returnOut',"adminAjax.php?resource=ptsu&action=new_ad&"+url_variables, {method:'post', postBody:formElements, evalScripts:true, asynchronous:true});
		var formData = $("#newAdForm").serialize();
		this.loadFile("adminAjax.php?resource=ptsu&action=new_ad&"+formData+"&"+url_variables, "returnOut", 0);
	}
	
	function create_done() {
		setLoading('loading_alert', 0);
		$("#new_ad_message").html('Your ad has been created!');
		$("#new_ad_message").slideDown("slow");
	}
		
		
		
///*				Delete Functions			 */
	function delete_ad(id) {
		if(confirm("Are you sure you want to delete this ad?")) {
			setLoading('loading_alert', 1);
			//var ajax = new Ajax.Updater('returnOut',", {method:'post', evalScripts:true, asynchronous:true});
			this.loadFile("adminAjax.php?resource=ptsu&action=delete_ad&id="+id+"&"+url_variables, "returnOut", 0);
		}
	}
	function delete_done() {
		setLoading('loading_alert', 0);
		$("#edit_ad").html('<div align="center" style="padding: 10 0 0 0px">You must select an ad to edit from the manage ads tab.</div>');
		refresh_manager();
		grabTab('maintab', 'manage_ads');
	}
	



///*				Approve Ads Functions			 */
	function approve_ads_load() {
		setLoading('loading_alert', 1);
		loadFile("adminAjax.php?resource=ptsu&action=approve_ads&"+url_variables, "approve_ads", 0);
	}
	function approve_load_done() {
		setLoading('loading_alert', 0);
	}
	function approve_ads_sm(targetobj) {
		$("#"+targetobj).show("slow");
	}
	function approve_ad(id,approval) {
		setLoading('loading_alert', 1);
		//var ajax = new Ajax.Updater('returnOut',"adminAjax.php?resource=ptsu&action=do_approve_ad&id="+id+"&approve="+approval+"&"+url_variables, {method:'post', evalScripts:true, asynchronous:true});
		loadFile("adminAjax.php?resource=ptsu&action=do_approve_ad&id="+id+"&approve="+approval+"&"+url_variables, "returnOut", 0);
	}
	function approve_done(contId) {
		setLoading('loading_alert', 0);
		$("#approve_ad_main"+contId).hide("slow");
	}

	
	

///*				Ad Tagger Functions			 */
	function tag(id, button) {
		var tag;
		setLoading('loading_alert', 1);
		if(button.checked == true) {
			tag=1;
		}
		else tag=0;
		//var ajax = new Ajax.Updater('returnOut',"adminAjax.php?resource=ptsu&action=tag&id="+id+"&tag="+tag+"&"+url_variables, {method:'post'});
		loadFile("adminAjax.php?resource=ptsu&action=tag&id="+id+"&tag="+tag+"&"+url_variables, "returnOut", 0);
		setLoading('loading_alert', 0);
	}


	
	
	
	
	
///*				Main Manager Functions			 */
	function update_manager(start, epp, sortType, sortOrder, searchStr, searchItem) {
		manager_start = start;
		manager_epp = epp;
		manager_sortType = sortType;
		manager_sortOrder = sortOrder;
		if(!searchStr || !searchItem) {
			searchStr='';
			searchItem='';
		}
		manager_searchStr = searchStr;
		manager_searchItem = searchItem;
		setLoading('loading_alert', 1);
		loadFile("adminAjax.php?resource=ptsu&action=manager&start="+start+"&epp="+epp+"&sortType="+sortType+"&sortOrder="+sortOrder+"&searchStr="+searchStr+"&searchItem="+searchItem+"&"+url_variables, "manage_ads", 0);
	}
	function refresh_manager() {
		update_manager(manager_start, manager_epp, manager_sortType, manager_sortOrder, manager_searchStr, manager_searchItem);
	}
	function reset_manager() {
		update_manager(0,10,'','','','');
	}
	function sort_manager(sortType, sortOrder) {
		manager_sortType = sortType; 
		manager_sortOrder = sortOrder;
		refresh_manager();
	}
	function change_manager_page(start) {
		manager_start = start; 
		refresh_manager();
	}
	function dosearch() {
		$("#manage_ads").html('<div style="height: 350px"></div>');
		manager_start = 0;
		manager_epp = 10;
		manager_sortType = '';
		manager_sortOrder = '';
		manager_searchStr = $("#search_str").val();
		manager_searchItem = $("#search_by").val();
		refresh_manager();
		grabTab('maintab', 'manage_ads');
	}
	function viewTagged() {
		$("#manage_ads").html('<div style="height: 350px"></div>');
		manager_start = 0;
		manager_epp = 10;
		manager_sortType = '';
		manager_sortOrder = '';
		manager_searchStr = '1';
		manager_searchItem = 'tagged';
		refresh_manager();
		grabTab('maintab', 'manage_ads');
	}
	
	
	
	
	function loadpage(page_request, containerid, grabtab){
		if (page_request.readyState == 4 && page_request.status==200) {
			$("#"+containerid).html(page_request.responseText);
			if(grabtab == 1) grabTab('maintab', containerid);
		}
		setLoading('loading_alert', 0);
	}
	
	
	function loadFileold(url, containerid, grabtab){
		var page_request = false
		if (window.XMLHttpRequest) // if Mozilla, Safari etc
			page_request = new XMLHttpRequest()
		else if (window.ActiveXObject){ // if IE
			try {
				page_request = new ActiveXObject("Msxml2.XMLHTTP")
			} 
			catch (e){
				try{
					page_request = new ActiveXObject("Microsoft.XMLHTTP")
				}
				catch (e){}
			}
		}
		else return false;
		
		page_request.onreadystatechange=function(){
			loadpage(page_request, containerid, grabtab)
		}
		
		bustcacheparameter=(url.indexOf("?")!=-1)? "&"+new Date().getTime() : "?"+new Date().getTime()
		
		page_request.open('GET', url+bustcacheparameter, true)
		page_request.send(null)
		
	}
	
	
	function loadFile(url, containerid, grabtab, postData){
		setLoading('loading_alert', 1);
		bodyContent = $.ajax({
			url: url,
			global: false,
			type: "POST",
			data:  postData, //({id : this.getAttribute('id')}),
			dataType: "html",
			success: function(msg){
				$("#"+containerid).html(msg);
				if(grabtab == 1) grabTab('maintab', containerid);
				setLoading('loading_alert', 0);
			}
		}).responseText;

	}
	
	
	function hide(targetobj) {
		$(targetobj).slideUp("slow");
	}
	
	
	function approve_signups_sm(targetobj) {
		$("#"+targetobj).show("slow");
	}
	function approve_signup(id,approval) {
		setLoading('loading_alert', 1);
		//var ajax = new Ajax.Updater('returnOut',", {method:'post', evalScripts:true, asynchronous:true});
		this.loadFile("adminAjax.php?resource=ptsu&action=do_approve_signup&id="+id+"&approve="+approval+"&"+url_variables, "returnOut", 0);

	}
	function approve_done_signup(contId) {
		setLoading('loading_alert', 0);
		$("#approve_signup_main"+contId).hide("slow");
	}