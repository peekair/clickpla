function calculate() {


	var xtrafee=0;


	if(document.form.subtitle.checked == true) {


		xtrafee+=subtitle_cost;


	}


	if(document.form.icon.checked == true) {


		xtrafee+=icon_cost;


	}


	document.form.price.value=  (document.form.amount.value * ptsuprice + xtrafee)


}