function calculate() {


	linkratio=0


	switch(document.form.cclass.value) {


		case 'A':


			linkratio=class_a_ratio


		break;


		case 'B':


			linkratio=class_b_ratio


		break;


		case 'C':


			linkratio=class_c_ratio


		break;


		case 'D':


			linkratio=class_d_ratio


		break;


	}


	var xtrafee=0;


	if(document.form.bgcolor.value != 0) {


		xtrafee+=linkhlfee;


	}


	if(document.form.subtitle && document.form.subtitle.checked == true) {


		xtrafee+=subtitle_cost;


	}


	if(document.form.icon && document.form.icon.checked == true) {


		xtrafee+=icon_cost;


	}


	document.form.price.value= ((document.form.amount.value * linkratio) * pointprice + xtrafee)


}