 <footer class="footer text-center"> 2017 &copy; Avant Garde. Brought to you by <a href="http://sharadtechnologies.com/" class="a_col">Sharad Technologies LLC</a> </footer>
 
 <script type="text/javascript">
     myJsMain = window.myJsMain || {};
     var siteBaseUrl="<?php echo base_url();?>";
	$(document).ready(function(){
		<?php if($this->session->flashdata('flash_message')){ ?>
			var msg = '<?php echo $this->session->flashdata("flash_message"); ?>';
            <?php if(isset($_SESSION['flash_message'])){
                unset($_SESSION['flash_message']);
            }?>
            //Created By Beant Kaur
			var message_type_str="success";
			EliminaTipo2(msg,message_type_str);
            
                        
		<?php }?>

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