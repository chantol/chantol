function findRowNum(input,nosign){
		$('tbody').delegate(input,'keydown',function(){
			var tr=$(this).parent().parent();
			number(tr.find(input),nosign);
		});
	}

	function findRowNumOnly(input){
		$('tbody').delegate(input,'keydown',function(){
			var tr=$(this).parent().parent();
			numberOnly(tr.find(input));
		});
	}
	// input number and dot
	
	function number(input,nosign){
		$(input).keypress(function(evt){
            this.value = this.value.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1'); 
            if(nosign==true){
            	if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) 
	            {
	     			event.preventDefault();
	 			}
            }else{
            	if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which != 45 || $(this).val().indexOf('-') != -1) && (event.which < 48 || event.which > 57)) 
	            {
	     			event.preventDefault();
	 			}
            }
            
		});
	}

	// number only

	function numberOnly(input){
		$(input).keypress(function(evt){
			var e=event || evt;
			var charCode=e.which || e.keyCode;
			if(charCode > 31 && (charCode< 48 || charCode > 57))
				return false;
				return true;
		});
	}
	