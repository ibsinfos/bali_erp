<style type="text/css">
    #BottomRightBtn{
        z-index: 2147483000!important;
        position: fixed!important;
        bottom: 20px;
        right: 20px;
        width: 60px!important;
        height: 60px!important;
        border-radius: 50%!important;
        padding: 3px;
        cursor: pointer;
    }
    .intercom-launcher-frame{bottom: 160px !important;}

    #feedback_sidebar{
        z-index: 2147483000!important;
        position: fixed!important;
        bottom: 85px;
        right: 20px;
        width: 60px!important;
        height: 60px!important;
        border-radius: 50%!important;
        padding: 3px;
        cursor: pointer;
        display: none;
    }
</style>

<div id="feedback_sidebar" class="circle bg-info" onclick="open_panel()"></div>

<div id="BottomRightBtn" class="circle bg-info"><i class="fa fa-smile-o fa-4x" aria-hidden="true"></i></div>

<script type="text/javascript">
    $("#BottomRightBtn").hover(function(){
        $(".intercom-launcher-frame").show();
        $("#feedback_sidebar").show();
    },function(){
        $(".intercom-launcher-frame").fadeOut('slow');
        $("#feedback_sidebar").fadeOut('slow');
    });

</script>

 <footer class="footer text-center"> 2017 &copy; Avant Garde. </footer>
 
 <script type="text/javascript">
     myJsMain = window.myJsMain || {};
     var siteBaseUrl="<?php echo base_url();?>";
	$(document).ready(function(){
		

	    /*$('#PublicSearch').on('keyup click', function(){
	        var search = $(this).val();
	        if(search!=''){
	        	$('#SearchInOuter').show();
	        }else{
	        	$('#SearchInOuter').hide();
	        }
	    });*/

        /*$('#SearchIn li a').click(function(){
			var SearchIn = $(this).attr('search-location');
			var SearchChar = $('#PublicSearch').val();

			if((SearchIn!='') && (SearchChar!='')){
				var url ='<?php echo base_url(); ?>index.php?'+SearchIn+'/search/'+SearchChar;
				if(SearchIn=='finance'){
                    backendLoginFinance();
                    var url ='<?php echo base_url(); ?>fi/?ng=contacts/list/search/'+SearchChar;
                        setTimeout(function(){ 
                        window.location.href = url;  
                    }, 3000);
				} else {
                    window.location.href = url;    
                }
			}
	    });*/

        $("#PublicSearch").click(function() {
            $('#searchString').focus();
        });
        
        $('.dummy-media-object').click(function() {            
            var SearchIn = $(this).attr('search-location');
            var Text = $('#searchString').val();

            var SearchChar = $.trim(Text);

            if((SearchIn!='') && (SearchChar!='')){
                var url ='<?php echo base_url(); ?>index.php?'+SearchIn+'/search/'+SearchChar;
                
                if(SearchIn=='finance'){
                    backendLoginFinance();
                    var url ='<?php echo base_url(); ?>fi/?ng=contacts/list/search/'+SearchChar;
                        setTimeout(function(){ 
                        window.location.href = url;  
                    }, 3000);
                } else {
                    window.location.href = url;    
                }
            }
        });

	});
        
    function backendLoginFinance() {
        var base_url            =   $('#base_url').val();
        $.ajax({
            async       :   true,
            dataType    :   'json',
            url         :   base_url+'index.php?fms/welcome',
            success     : function(response){
            },
            error       : function(error_param,error_status) {

            }
        }); 
        var url = base_url+'fi/?ng=login'
         $.ajax({
            async       :   true,
            dataType    :   'json',
            url         :   base_url+'fi/?ng=login',
            success     : function(response){
            },
            error       : function(error_param,error_status) {

            }
        }); 
    }    
    
    function EliminaTipo2(msg,message_type_str){
            swal(
                    msg,
                   '',
                   message_type_str
            )
            }


$(function () {
       $('.preview_outer').on('shown.bs.tooltip', function (e) {
          setTimeout(function () {
            $(e.target).tooltip('hide');
          }, 500);
       });
    });            
</script>