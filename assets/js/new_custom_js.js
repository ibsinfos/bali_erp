$(document).ready(function(){
    $('.DoNotConflict').click(function(){
        $('#cce').hide();
        $('#cce').css("display","none");
    });

    $('#cce_outer').click(function(){
        $('#cce').show();
    });

	function EliminaTipo1(message,message_type){
		swal(message,'',message_type)
	}    
});

