function calculate() {


	var xtrafee=0;


	if(document.form.bgcolor.value != 0) {


		xtrafee=flinkhlfee;


	}


	if(document.form.marq.value == 1) {


		xtrafee+=flinkmfee;


	}


	document.form.price.value= ((document.form.amount.value * flinkcost) + xtrafee)


}