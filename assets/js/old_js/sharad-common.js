var path = location.pathname;
var pathArr=path.split('/');

var track_click = 1; 

var total_pages;

var offPage = 0;
var tidiitConfirm1Var=false;

$(function(){
    jQuery.validator.addMethod("phoneno", function(value, element) {
        return this.optional(element) || /^[0-9?=.\+\-\ ]+$/.test(value);
    }, "Phone must contain only numbers, or special characters.");
    // add new validate method for alphabets and space validation.
    jQuery.validator.addMethod("sharadAlphaSpace", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Phone must contain only alphabet and space.");

    // add new validate method for alphabets validation.
    jQuery.validator.addMethod("tiditAlpha", function(value, element) {
        return this.optional(element) || /^[a-zA-Z]+$/.test(value);
    }, "Phone must contain only alphabets.");

    jQuery.validator.addMethod("notEqual", function(value, element, param) {
    return this.optional(element) || value != param;
    }, "Please specify a different (non-default) value"); 


    pleaseWaitDiv = $('<div class="modal modal_login" id="myLoadingModal" tabindex="-1" role="dialog" aria-labelledby="myLoadingModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"><div class="modal-dialog"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div>');
    pleaseWebadminWaitDiv = $('<div class="modal modal_login" id="myLoadingModal" tabindex="-1" role="dialog" aria-labelledby="myLoadingModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"><div class="modal-dialog"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div>');

    // js utility function to submit formm using ajax 
    myJsMain.commonFunction = {
        ajaxSubmit: function($this, url, callback) {
            var ajaxUrl =url,
            data = new FormData($this[0]);
            jQuery.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: data,
                dataType:'json',
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success: callback
            });
        },
        callBackFuction: function(callback, data) { 
            // Call our callback, but using our own instance as the context
            callback.call(this, data);
        },
        js_dynamic_text:function(length){
            var randomStuff =["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9","0","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
            var sl=0;
            var index;
            var char;
            var str='';
            for(sl=0;sl<length;sl++){
                    index=Math.floor((Math.random()*61)+1);
                    char=randomStuff[index];
                    str=str+char;
            }

            var SecretTextSetAjaxData='secret='+str;
            jQuery.ajax({
               type: "POST",
               url: myJsMain.baseURL+'ajax/reset_secret/',
               data: SecretTextSetAjaxData,
               success: function(){
                   if(myJsMain.showHowItWorksBoxLoaded==0)
                        myJsMain.commonFunction.showHowItWorksBox();
               }
             });
            return str;
        },
        GeneratNewImage:function(){
            jQuery('#secret_img').html("");
            var c=document.getElementById("secret_img");
            c.width = c.width;
            var ctx=c.getContext("2d");
            var str='';
            ctx.font="20px cursive"; //monotype corsiva  Helvetica  sans-serif
            str=myJsMain.commonFunction.js_dynamic_text(8);
            ctx.fillText(str,5,15);
            var SecretTextSetAjaxData='secret='+str;
            jQuery.ajax({
               type: "POST",
               url: myJsMain.SecretTextSetAjaxURL,
               data: SecretTextSetAjaxData,
               success: function(msg){ //alert(msg);
               }
             });
        },
        sharadAlert:function(boxTitle,alertMessaage){
            var msg='<p><i class="fa fa-exclamation-triangle fa-2x fa-fw"></i> '+alertMessaage+'</p>';
            bootbox.alert({
                title:boxTitle,
                message: alertMessaage
            });
        },
        sharadConfirm:function(boxTitle,confirmMessaage,actionUrlWithData){
            bootbox.confirm({
                title:boxTitle,
                message: confirmMessaage,
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result){
                        //alert(actionUrlWithData);
                        //location.href=actionUrlWithData;                    
                        window.location.href=actionUrlWithData;
                    }
                }
            });
        },
        shradConfirm1:function(boxTitle,confirmMessaage,height,formId,oldSubmitStatus){
            if(height==0){
                height=175;
            }
            if(myJsMain.isMobile=='yes'){tidiitAlertBoxWidth=350;}else{tidiitAlertBoxWidth=450;}
            $('#dialog-confirm-message-text').text(confirmMessaage);
            $( "#dialog-confirm" ).dialog({
                resizable: false,
                height:height,
                width:tidiitAlertBoxWidth,
                modal: true,
                title:boxTitle,
                dialogClass: 'success-dialog',
                buttons: {
                    "OK": function() {
                        oldSubmitStatus=true;
                        $(formId).submit();
                        $( this ).dialog( "close" );
                    },
                    Cancel: function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        },
        sharadConfirm2:function(boxTitle,confirmMessaage,height,obj){
            if(!tidiitConfirm1Var){
                if(height==0){
                    height=175;
                }
                if(myJsMain.isMobile=='yes'){tidiitAlertBoxWidth=350;}else{tidiitAlertBoxWidth=450;}
                jQuery('#dialog-confirm-message-text').text(confirmMessaage);
                console.log('cimming inside tidiitConfirm2');
                jQuery( "#dialog-confirm" ).dialog({
                    resizable: false,
                    height:height,
                    width:tidiitAlertBoxWidth,
                    modal: true,
                    title:boxTitle,
                    dialogClass: 'success-dialog',
                    buttons: {
                        "OK": function() {
                            jQuery( this ).dialog( "close" );
                            tidiitConfirm1Var = true;//obj.click();
                        },
                        Cancel: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                });
            }
            return tidiitConfirm1Var;
        },
        showPleaseWait: function() {
            pleaseWaitDiv.modal('show');
        },
        hidePleaseWait: function () {
            pleaseWaitDiv.modal('hide');
        }
        //MainSiteBaseURL
    };
});