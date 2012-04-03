function reportAd() {
	window.open("gpt.php?v=report&id="+id+"&type="+type+"&"+url_variables+"","","width=500,height=400,status=1")
}

function next(num) {
	if(timer == 0) {parent.location.href='gpt.php?v=verify&buttonClicked='+num+'&id='+id+'&type='+type+'&pretime='+pretime+'&'+url_variables+'';}
	else { alert("You must wait for the counter to reach 0"); }
}

function adTimer() {
	timer--;
	if(timer == 0) {
		var show="Click <img src=\"clickimages/"+key+".png\">";
		$("#buttons").fadeIn();
	}
	else {
		var show="Wait: "+timer;
		setTimeout(adTimer, 1000);
	}
	$("#timer").html(show);
}

$(document).ready(function() {
	if(id != -1) adTimer();
	else $("#timer").html("Cheat Check");
});

