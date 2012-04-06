$(function(){
	$.fn.ticker = function(){
		var self = $(this);
		var margin = self.parent().width();
		var width = self.width();
		self.width(99999);
		var ctr = 0;
		(function animate(){
			if(ctr >= 1565 ){
				ctr=0;
			}
			self.find('li:first').css('margin-left', (margin - ctr++)+'px');
			var timer ;
			clearTimeout(timer);
			timer = setTimeout(animate,60)
		})()
	}


	$('ul.ticker').ticker();
	$('#adHitz').html($('.adHitz').children());
	// $('select').dropkick();

	if($('form#join').length){
		$('form#join').validate({
			rules:{
				uUsername:{required:true,minlength:4},
				uPassword:{required:true,minlength:5},
				uVPassword:{equalTo:'#uPassword'},
				uPin:{required:true,minlength:4},
				uVPin:{equalTo:'#uPin'},
				uName:{required:true},
				uEmail:{required:true,email:true},
				uTerms:{required:true}
			}
		})

	}

})

