memberManager = function() {
	
	var manager_start;
	var manager_epp;
	var manager_sortType;
	var manager_sortOrder;
	var manager_searchStr;
	var manager_searchItem;
	var userid=0;
	
	
///*				Edit Member Functions			 */
	this.edit_member = function(id) {
		setLoading('loading_alert', 1);
		this.loadFile("adminAjax.php?resource=memberManager&action=view_main&id="+id+"&"+url_variables, "edit_member", 1);
	}
	
	this.edit_save = function() {
		setLoading('loading_alert', 1);
		var formData = $("#vm_edit_form").serialize();
		$("#vm_edit_status").html("");
		this.loadFile("adminAjax.php?resource=memberManager&action=vm_edit_save&save=1&"+formData+"&id="+this.userid+"&"+url_variables, "vm_edit_status", 0);
		window.scroll(0,0);
	}
	

	///*				Edit Membership Functions			 */
	
	this.membership_save = function() {
		setLoading('loading_alert', 1);
		var formData = $("#vm_membership_form").serialize();
		this.loadFile("adminAjax.php?resource=memberManager&action=vm_membership&save=1&"+formData+"&id="+this.userid+"&"+url_variables, "vm_content", 0);
	}
	

	///*				Edit Password Functions			 */
	
	this.password_save = function() {
		if(confirm('Are you sure you want to change this user\'s password?')) {
			setLoading('loading_alert', 1);
			var formData = $("#vm_password_form").serialize();
			this.loadFile("adminAjax.php?resource=memberManager&action=vm_pwd&save=1&"+formData+"&id="+this.userid+"&"+url_variables, "vm_content", 0);
		}
	}
	
	///*				Referral Functions			 */
	
	this.referrals_massCheck = function() {
		var checkVal = $("#allbox").attr("checked");
		$("input[name='referralsList\[\]'][type='checkbox']").each(function(){
			//alert( $(this).val() );
			$(this).attr("checked",checkVal);
		});
	}
	

	this.referrals_shift = function() {
		if($("input[name='touser']").val() == '') {
			alert('Please enter a username to shift these referrals to!');
			return false;
		}
		else {
			var formData = $("#referrals_form").serialize();
			this.loadFile("adminAjax.php?resource=memberManager&action=vm_downline&shift=1&"+formData+"&id="+this.userid+"&"+url_variables, "vm_content", 0);
		}
	}	

	
	///*			Cancel/Delete Payment Request Functions			 */

	this.payment_cancel = function(pid) {
		if(confirm('Are you sure you want to cancel this payment?')) {
			this.loadFile("adminAjax.php?resource=memberManager&action=vm_payments&cancel=1&pid="+pid+"&id="+this.userid+"&"+url_variables, "vm_content", 0);			
		}
	}
	this.payment_delete = function(pid) {
		if(confirm('Are you sure you want to delete this payment?')) {
			this.loadFile("adminAjax.php?resource=memberManager&action=vm_payments&delete=1&pid="+pid+"&id="+this.userid+"&"+url_variables, "vm_content", 0);			
		}
	}
	
	
///*				Delete Functions			 */
	this.deleteMember = function() {
		if(confirm("Are you sure you want to delete this member?")) {
			setLoading('loading_alert', 1);
			this.loadFile("adminAjax.php?resource=memberManager&action=vm_delete&delete=1&id="+this.userid+"&"+url_variables, "edit_member", 0);
		}
	}
	
	

///*				Member Tagger Functions			 */
	this.tag = function(id, button) {
		var tag;
		setLoading('loading_alert', 1);
		if(button.checked == true) {
			tag=1;
		}
		else tag=0;
		this.loadFile("adminAjax.php?resource=memberManager&action=tag&id="+id+"&tag="+tag+"&"+url_variables, "", 0);
//		var ajax = new Ajax.Updater('returnOut',"adminAjax.php?resource=memberManager&action=tag&id="+id+"&tag="+tag+"&"+url_variables, {method:'post'});
		setLoading('loading_alert', 0);
	}

	
	
	
///*				Main Manager Functions			 */
	this.update_manager = function(start, epp, sortType, sortOrder, searchStr, searchItem) {
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
		this.loadFile("adminAjax.php?resource=memberManager&action=manager&start="+start+"&epp="+epp+"&sortType="+sortType+"&sortOrder="+sortOrder+"&searchStr="+searchStr+"&searchItem="+searchItem+"&"+url_variables, "manage_members", 0);
	}
	this.refresh_manager = function() {
		this.update_manager(manager_start, manager_epp, manager_sortType, manager_sortOrder, manager_searchStr, manager_searchItem);
	}
	this.reset_manager = function() {
		this.update_manager(0,10,'','','','');
	}
	this.sort_manager = function(sortType, sortOrder) {
		manager_sortType = sortType; 
		manager_sortOrder = sortOrder;
		this.refresh_manager();
	}
	this.change_manager_page = function(start) {
		manager_start = start; 
		this.refresh_manager();
	}
	this.dosearch = function() {
		document.getElementById("manage_members").innerHTML='<div style="height: 350px"></div>';
		manager_start = 0;
		manager_epp = 10;
		manager_sortType = '';
		manager_sortOrder = '';
		manager_searchStr = document.getElementById("search_str").value;
		manager_searchItem = document.getElementById("search_by").value;
		this.refresh_manager();
		grabTab('maintab', 'manage_members');
	}
	this.viewTagged = function() {
		document.getElementById("manage_members").innerHTML='<div style="height: 350px"></div>';
		manager_start = 0;
		manager_epp = 10;
		manager_sortType = '';
		manager_sortOrder = '';
		manager_searchStr = '1';
		manager_searchItem = 'tagged';
		this.refresh_manager();
		grabTab('maintab', 'manage_members');
	}
	
	
	this.ajaxError = function(textStatus) {
		switch(textStatus) {
		case "timeout":
			alert("Error: The server timed out during your request.");
			break;
			case "notmodified":
				alert("Error: Not modified?");
			break;
			case "parsererror":
				alert("Error: There was an error parsing the data.");
			break;
			default:
				alert("There was an unexpected error loading the data.");
				break
		}
	}
	
	this.loadFile = function(url, containerid, grabtab, postData){
		var objectPointer = this;
		setLoading('loading_alert', 1);
		$.ajax({
			url: url,
			type: "POST",
			cache: false,
			data:  postData,
			dataType: "html",
			success: function(msg,textStatus) {
				if(textStatus == "success") {
					$("#"+containerid).html(msg);
					if(grabtab == 1) grabTab('maintab', containerid);
					setLoading('loading_alert', 0);
				} else {
					objectPointer.ajaxError(textStatus);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				objectPointer.ajaxError(textStatus);
			}
		});

	}
	
	this.hide = function(targetobj) {
		jQuery(targetobj).slideUp("slow");
	}
	

	var freeze = false;

	this.vmChange = function(id) {
		if(freeze == false) {
			$("#vm_content").html("");
			this.loadFile("adminAjax.php", "vm_content", 0,"resource=memberManager&action=vm_"+id+"&id="+this.userid+"&"+url_variables);
			freeze=true;
			$("#vm_back").show();
			$("#vm_menu").slideUp("normal",function() {
				$("#vm_content").fadeIn();
				freeze=false;
			});
		}
	}

	this.gotoMenu = function() {
		if(freeze == false) {
			freeze=true;	
			$("#vm_content").fadeOut("fast",function(){
				$("#vm_menu").slideDown("fast",function(){
					$("#vm_back").fadeOut("fast",function() {
						freeze=false;
					});
				});	
			});	
		}
	}

	
	
}


