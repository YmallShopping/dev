
var Checkout = Class.create(VarienForm.prototype);
Object.extend(Checkout.prototype, {
	initialize: function(formId, firstFieldFocus, useAjax, step){
		
		this.formId		= formId;
        this.form       = $(formId);
        if (!this.form) {
            return;
        }
        this.currentStep = step || '';
        this.useAjax = useAjax || false;
        this.validateRasult = false;
        this.cache      = $A();
        this.currLoader = false;
        this.currDataIndex = false;
        this.validator  = new Validation(this.form, {onFormValidate:function(result, form){
        	
        	this.validateRasult = result;
        	if(this.useAjax && result && this.currentStep != 'review'){
        		this.submitAjaxForm();
        	}
        	
        }.bind(this)});
        this.elementFocus   = this.elementOnFocus.bindAsEventListener(this);
        this.elementBlur    = this.elementOnBlur.bindAsEventListener(this);
        this.childLoader    = this.onChangeChildLoad.bindAsEventListener(this);
        this.highlightClass = 'highlight';
        this.extraChildParams = '';
        this.firstFieldFocus= firstFieldFocus || false;
        this.bindElements();
        if(this.firstFieldFocus){
            try{
                Form.Element.focus(Form.findFirstElement(this.form))
            }
            catch(e){}
        }
        if(this.useAjax){
        	Event.observe(this.form,'submit',function(ev){
        		
        		if(this.currentStep == 'review'){
        			
        			if(this.validateRasult){
	        			
	        			$('tcheckout-please-wait').style.display = 'block';
	    				$('tcheckout-save-btn').disabled = 'disabled';
	    				$('tcheckout-save-btn').addClassName('disabled');
	    				
    				}
        		}else{
        			Event.stop(ev);
        		}
        		
        		
        	}.bind(this),false);
        }
    },
    back:function(){
    	
    	$('tcheckout-please-wait').style.display = 'block';
    	$('tcheckout-save-btn').disabled = 'disabled';
    	$('tcheckout-save-btn').addClassName('disabled')
    	
    	if(typeof this.backUrl != 'undefined' && this.backUrl){
    		
	    	var request = new Ajax.Request(this.backUrl,
			  {
			    method:'get',
			    parameters:'is_ajax=1',
			    onSuccess: function(transport){ 
			    	var response = eval('('+(transport.responseText || false)+')');
			    	
			    	if(response.error){
			    		
			    	}else{
			    		
			    		if(response.step){
			    			
			    			this.initStep(response.step, response)
			    		}
			    		
			    		
			    	
			    	}
			    	
			    }.bind(this)
			});
			return true;
		}else{
			return false;
		}
    },
    submitAjaxForm:function(){
    	
    	$('tcheckout-please-wait').style.display = 'block';
    	$('tcheckout-save-btn').disabled = 'disabled';
    	$('tcheckout-save-btn').addClassName('disabled');
    	
    	var request = new Ajax.Request(this.form.action,
		  {
		    method:'post',
		    parameters:this.buildQueryString(true),
		    onSuccess: function(transport){ 
		    	
		    	$$('ul.messages').each(function(e){e.remove()});
		    	
		    	var response = eval('('+(transport.responseText || false)+')');
		    	if(response.error){
		    		
		    		var message = '';
		    		
		    		
		    		
		    		
		    		if(typeof response.message == 'object'){
		    			
		    			for(var i = 0;i<response.message.length;i++){
		    				message += '<li>'+response.message[i]+'</li>';
		    			}
		    			
		    		}else{
		    			message = response.message[i] ? '<li>'+response.message[i]+'</li>' : '<li>Sorry, Unknown Error...</li>';
		    		}
		    		$('tcheckout-progress').insert({after:'<ul class="messages"><li class="error-msg"><ul>'+message+'</ul></li></ul>'});
		    		
		    		$('tcheckout-please-wait').style.display = 'none';
    				$('tcheckout-save-btn').disabled = '';
					$('tcheckout-save-btn').removeClassName('disabled');
		    		
		    	}else{
		    		if(response.step){
		    			this.initStep(response.step, response)
		    		}
		    	
		    	}
		    	
		    }.bind(this)
		});
    },
    initStep:function(step, options, initialize_flag){
    	
    	forceInitialize = !(initialize_flag || false);
    	
    	var options = options || {};
    	
    	if(typeof options.back_url != 'undefined'){
			this.backUrl = options.back_url;
		}
    	
    	
    	if(typeof options.content != 'undefined'){
    		$('tcheckout-container').update(options.content);
    	}
    	
    	if(typeof options.progress != 'undefined'){
    		$('tcheckout-progress').update(options.progress);
    	}
    	
		$$('.back-link a, a.back-link').each(function(element){
			
			element.observe('click', function(ev){
				
				if(this.back()){
				
					Event.stop(ev);
				
				}
				
			}.bind(this));
		}.bind(this));
		
		if(forceInitialize){
			this.initialize(this.formId, this.firstFieldFocus, this.useAjax);
    	}
    	this.currentStep = step;
    	
		
    	if(typeof this[step+'Load'] == 'function'){
    		
    		this[step+'Load']();
    		
    	}
    },
    buildQueryString:function(addIsAjax){
		
		var q = '';
		
		if(addIsAjax){
			q+='is_ajax=1&';
		}
		
		elements = Form.getElements(this.form);
		
		for(var i = 0;i < elements.length;i++){
			if((elements[i].type == 'checkbox' || elements[i].type == 'radio') && !elements[i].checked){
				continue;
			}
			q += elements[i].name + '=' + encodeURIComponent(elements[i].value);
			
			if(i+1 < elements.length){
				q += '&';
			}
			
		}
		return q;
	}
});

// billing
var Billing = Class.create();
Billing.prototype = {
    initialize: function(form){
        this.form = form;
    },
	
    newAddress: function(isNew){
        if (isNew) {
            this.resetSelectedAddress();
            Element.show('billing-new-address-form');
        } else {
            Element.hide('billing-new-address-form');
        }
    },

    resetSelectedAddress: function(){
        var selectElement = $('billing-address-select')
        if (selectElement) {
            selectElement.value='';
        }
    },
    
    setUseForShipping: function(flag) {
        $('shipping:same_as_billing').checked = flag;
    }
}

// shipping
var Shipping = Class.create();
Shipping.prototype = {
    initialize: function(form){
        this.form = form;
    },
    newAddress: function(isNew){
        if (isNew) {
            this.resetSelectedAddress();
            Element.show('shipping-new-address-form');
        } else {
            Element.hide('shipping-new-address-form');
        }
        shipping.setSameAsBilling(false);
    },

    resetSelectedAddress: function(){
        var selectElement = $('shipping-address-select')
        if (selectElement) {
            selectElement.value='';
        }
    },
    
    setSameAsBilling: function(flag) {
        $('shipping:same_as_billing').checked = flag;
// #5599. Also it hangs up, if the flag is not false
//        $('billing:use_for_shipping_yes').checked = flag;
        if (flag) {
            this.syncWithBilling();
        }
    },

    syncWithBilling: function () {
        $('billing-address-select') && this.newAddress(!$('billing-address-select').value);
        $('shipping:same_as_billing').checked = true;
        if (!$('billing-address-select') || !$('billing-address-select').value) {
            arrElements = Form.getElements(this.form);
            for (var elemIndex in arrElements) {
                if (arrElements[elemIndex].id) {
                    var sourceField = $(arrElements[elemIndex].id.replace(/^shipping:/, 'billing:'));
                    if (sourceField){
                        arrElements[elemIndex].value = sourceField.value;
                    }
                }
            }
            //$('shipping:country_id').value = $('billing:country_id').value;
            shippingRegionUpdater.update();
            $('shipping:region_id').value = $('billing:region_id').value;
            $('shipping:region').value = $('billing:region').value;
            //shippingForm.elementChildLoad($('shipping:country_id'), this.setRegionValue.bind(this));
        } else {
            $('shipping-address-select').value = $('billing-address-select').value;
        }
    },

    setRegionValue: function(){
        $('shipping:region').value = $('billing:region').value;
    }
    
}

// shipping method
var ShippingMethod = Class.create();
ShippingMethod.prototype = {
    initialize: function(form, saveUrl){
        this.form = form;
    },

    validate: function() {
        var methods = document.getElementsByName('shipping_method');
        if (methods.length==0) {
            alert(Translator.translate('Your order cannot be completed at this time as there is no shipping methods available for it. Please make neccessary changes in your shipping address.'));
            return false;
        }

        if(!this.validator.validate()) {
            return false;
        }

        for (var i=0; i<methods.length; i++) {
            if (methods[i].checked) {
                return true;
            }
        }
        alert(Translator.translate('Please specify shipping method.'));
        return false;
    }
}


var paymentForm = Class.create();
paymentForm.prototype = {
	beforeInitFunc:$H({}),
    afterInitFunc:$H({}),
    beforeValidateFunc:$H({}),
    afterValidateFunc:$H({}),
    initialize: function(formId){
        this.form = $(this.formId = formId);
    },
    init : function () {
        
        var elements = $$('#checkout-payment-method-load input, #checkout-payment-method-load select, #checkout-payment-method-load textarea');
        
        var method = null;
        for (var i=0; i<elements.length; i++) {
            if (elements[i].name=='payment[method]') {
                if (elements[i].checked) {
                    method = elements[i].value;
                }
            }
            elements[i].setAttribute('autocomplete','off');
        }
        
        this.initWhatIsCvvListeners();
        
        if (method) this.switchMethod(method);
    },
    
    switchMethod: function(method){
        if (this.currentMethod && $('payment_form_'+this.currentMethod)) {
        	
            var form = $('payment_form_'+this.currentMethod);
            form.style.display = 'none';
            var elements = form.getElementsByTagName('input');
            for (var i=0; i<elements.length; i++) elements[i].disabled = true;
            var elements = form.getElementsByTagName('select');
            for (var i=0; i<elements.length; i++) elements[i].disabled = true;
            

        }
        if ($('payment_form_'+method)){
            var form = $('payment_form_'+method);
            form.style.display = '';
            var elements = form.getElementsByTagName('input');
            for (var i=0; i<elements.length; i++) elements[i].disabled = false;
            var elements = form.getElementsByTagName('select');
            for (var i=0; i<elements.length; i++) elements[i].disabled = false;
            this.currentMethod = method;
        }
    },
    initWhatIsCvvListeners: function(){
        $$('.cvv-what-is-this').each(function(element){
            Event.observe(element, 'click', this.toggleToolTip);
        }.bind(this));
    },
	toggleToolTip:function(event){
        if($('payment-tool-tip')){
            $('payment-tool-tip').setStyle({
                top: (Event.pointerY(event)-560)+'px'//,
                //left: (Event.pointerX(event)+100)+'px'
            })
            $('payment-tool-tip').toggle();
        }
        Event.stop(event);
    }
}

function elogin(e, p, url){
	
	$('elogin-loading').style.display = 'block';
	$('elogin-buttons').style.display = 'none';
	
	var request = new Ajax.Request(url,
	  {
	    method:'post',
	    parameters:'username='+e+'&password='+p,
	    onSuccess: function(transport){ var response = eval('('+(transport.responseText || false)+')');
	      
	      if(response.error){
	      	  $('elogin-message').innerHTML = response.message;
	      	  $('elogin-loading').style.display = 'none';
			  $('elogin-buttons').style.display = 'block';
	      }else{
	      	  
	      	  location.reload();
	      	  
	      }
	      
	    },
	    onFailure: function(){ alert('Something went wrong...');stopLoadingData(); }
	  });
}