(function(){
  'use strict';

  $(document).ready(function(){

  	let form = $('.bootstrap-form');

  	// On form submit take action, like an AJAX call
    $(form).submit(function(e){

        if(this.checkValidity() == false) {
            $(this).addClass('was-validated');
            e.preventDefault();
            e.stopPropagation();
        }

    });
      $('input[type="file"]').change(function(){
          validateFile($(this));
      });
    // On every :input focusout validate if empty
    $(':input').blur(function(){
    	let fieldType = this.type;
        validateRemote($(this));
        validatePercentage($(this));
    	switch(fieldType){
    		case 'text':
					validateText($(this));
			      break;
    		case 'password':
			    validatePassword($(this));
			     break;
            case 'textarea':
                validateText($(this));
                break;
    		case 'email':
                validateEmail($(this));
                break;
    		case 'checkbox':
    			validateCheckBox($(this));
    			break;
    		case 'select-one':
    			validateSelectOne($(this));
    			break;
    		case 'select-multiple':
    			validateSelectMultiple($(this));
    			break;
    		default:
                break;

    	}
	});


	// On every :input focusin remove existing validation messages if any
    $(':input').click(function(){

    	$(this).removeClass('is-valid is-invalid');

	});

    // On every :input focusin remove existing validation messages if any
    $(':input').keydown(function(){

        $(this).removeClass('is-valid is-invalid');

    });

	// Reset form and remove validation messages
    $(':reset').click(function(){
        $(':input, :checked').removeClass('is-valid is-invalid');
    	$(form).removeClass('was-validated');
    });

  });

    // Validate Text and password
    function validateText(thisObj) {
        let attr = thisObj.attr('required');
        if (typeof attr !== typeof undefined && attr !== false) {
            let fieldValue = thisObj.val();
            let error = thisObj.attr('required-error');
            if (fieldValue.length > 1) {
                $(thisObj).addClass('is-valid');
            } else {
                $(thisObj).addClass('is-invalid');
                if (typeof error !== typeof undefined && error !== false) {
                    $(thisObj).parent().find('.invalid-feedback').html(error);
                }
            }
        }
    }

    // Validate Email
    function validateEmail(thisObj) {

        let fieldValue = thisObj.val();
		if(thisObj.prop('required') || fieldValue !=''){
			let pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;;
			if(pattern.test(fieldValue)) {
				$(thisObj).addClass('is-valid');
			} else {
				$(thisObj).addClass('is-invalid');
			}
		}
    }

    // Validate CheckBox
    function validateCheckBox(thisObj) {
        let attr = thisObj.attr('required');
        if (typeof attr !== typeof undefined && attr !== false) {
            if ($(':checkbox:checked').length > 0) {
                $(thisObj).addClass('is-valid');
            } else {
                $(thisObj).addClass('is-invalid');
            }
        }
    }

    // Validate Select One Tag
    function validateSelectOne(thisObj) {
        let attr = thisObj.attr('required');
        if (typeof attr !== typeof undefined && attr !== false) {
            let fieldValue = thisObj.val();

            if (fieldValue != null) {
                $(thisObj).addClass('is-valid');
            } else {
                $(thisObj).addClass('is-invalid');
            }
        }
    }

    // Validate Select Multiple Tag
    function validateSelectMultiple(thisObj) {
        let attr = thisObj.attr('required');
        if (typeof attr !== typeof undefined && attr !== false) {
            let fieldValue = thisObj.val();

            if (fieldValue.length > 0) {
                $(thisObj).addClass('is-valid');
            } else {
                $(thisObj).addClass('is-invalid');
            }
        }
    }

	//Validate confirm password

	function  validatePassword(thisObj){
		let fieldValue = thisObj.val();
		let attr = thisObj.attr('equalTo');
        let password = $(attr).val();
        let error = thisObj.attr('password-error');
		if (typeof attr !== typeof undefined && attr !== false) {
			if(fieldValue == password) {
            $(thisObj).addClass('is-valid');
            thisObj[0].setCustomValidity('');
			} else {
                $(thisObj).addClass('is-invalid');
                thisObj[0].setCustomValidity('Passwords must match');
                if (typeof error !== typeof undefined && error !== false) {
                    $(thisObj).parent().find('.invalid-feedback').html(error);
                }
			}
		}

	}

	function validateRemote(thisObj){
        let attr = thisObj.attr('remote');
        let error = thisObj.attr('remote-error');
		if (typeof attr !== typeof undefined && attr !== false) {
			let name = thisObj.attr('name');
			let fieldValue = thisObj.val();
			let url = attr+'?'+name+'='+fieldValue
			$.get(url, function (data, textStatus, jqXHR) {
				if(data == 1) {
                $(thisObj).addClass('is-valid');
                thisObj[0].setCustomValidity('');
				} else {
                    $(thisObj).addClass('is-invalid');
                    if (typeof error !== typeof undefined && error !== false) {
                        $(thisObj).parent().find('.invalid-feedback').html(error);
                    }
				}
		});
		}

	}

	function validatePercentage(thisObj)
    {
        let attr = thisObj.attr('percentage');
        let error = thisObj.attr('percentage-error');
        var value = thisObj.val();
        if ((typeof attr !== typeof undefined && attr !== false) && value !='') {
            var regx = /^(([1-9]\d?)(\.\d{1,2})?|100(\.00?)?)$/;
            var result = regx.test(value);
            if(result){
                $(thisObj).addClass('is-valid');
                thisObj[0].setCustomValidity('');
            }else{
                $(thisObj).addClass('is-invalid');
                if (typeof error !== typeof undefined && error !== false) {
                    $(thisObj).parent().find('.invalid-feedback').html(error);
                }
            }
        }
    }

    function validateFile(thisObj)
    {
        let attr = thisObj.attr('valid-ext');
        let error = thisObj.attr('valid-ext-error');
        var value = thisObj.val();
        if ((typeof attr !== typeof undefined && attr !== false) && value !='') {
            var regx = /\.(csv|xls|xlsx)$/i;
            var result = regx.test(value);
            if(result){
                $(thisObj).addClass('is-valid');
                thisObj[0].setCustomValidity('');
            }else{
                $(thisObj).addClass('is-invalid');
                if (typeof error !== typeof undefined && error !== false) {
                    $(thisObj).parent().find('.invalid-feedback').html(error);
                }
                thisObj[0].setCustomValidity('In valid');
            }
        }
    }

})();
