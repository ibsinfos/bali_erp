<link rel="stylesheet" href="<?php echo base_url('assets/css/tagging.css')?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/autoComplete/easy-autocomplete.min.css')?>"/>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('edit_gallery_image'); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" 
        class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php?'.$this->session->userdata('login_type').'/dashboard');?>"><?php echo get_phrase('Dashboard');?></a></li>

            <?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> <?php }else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="row m-0">
    <div class="col-md-12 white-box">
        <?php echo form_open(base_url('index.php?'.$this->session->userdata('login_type').'/gallery_img_edit/'.$img->id), array('class' => 'form-horizontal form-groups-bordered validate', 
        'target' => '_top')); ?>
        
            <div class="row">          
                <div class="col-xs-12 col-md-offset-2 col-md-8 tag-container">
                    <img src="<?php echo $img->bucket.$img->main?>" class="img-thumbnail main-img">
                    <?php foreach($faces as $i=>$face){?>
                        <div class="tagview" style="left:<?php echo $face->mouesX?>px; top:<?php echo $face->mouseY?>px;" 
                            data-num="<?php echo $i?>" data-imgW="<?php echo $face->imgW?>" data-imgH="<?php echo $face->imgH?>">
                            <input type="hidden" name="tags[face][<?php echo $i?>][mouesX]" value="<?php echo $face->mouesX?>"/>
                            <input type="hidden" name="tags[face][<?php echo $i?>][mouseY]" value="<?php echo $face->mouseY?>"/>
                            <input type="hidden" name="tags[face][<?php echo $i?>][imgW]" value="<?php echo $face->imgW?>"/>
                            <input type="hidden" name="tags[face][<?php echo $i?>][imgY]" value="<?php echo $face->imgH?>"/>
                            <a class="btn btn-danger btn-xs pull-right ftrem"><i class="fa fa-times"></i></a>
                            <div class="square"></div>
                            <div class="person"><?php echo $face->user_name?></div>
                        </div>
                    <?php }?>
                </div> 
            </div>
            <br/>

            <div class="row mt10">          
                <div class="col-xs-12 col-md-offset-2 col-md-8">
                    <label for="field-1"><strong><?php echo get_phrase('photo_caption');?></strong><span class="error mandatory">*</span></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-road"></i></div>
                        <input type="text" class="form-control" name="title" required="required" value="<?php echo $img->title?>"/> 
                    </div>
                </div> 
            </div>
            <br/>

            <div class="row mt10">          
                <div class="col-xs-12 col-md-offset-2 col-md-8">
                    <label for="field-1"><strong><?php echo get_phrase('photo_brief');?></strong></label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-book"></i></div>
                        <textarea class="form-control" name="brief"><?php echo $img->brief?></textarea>
                    </div> 
                </div>
            </div>
            <br>
            
            <div class="row mt10">          
                <div class="col-xs-12 col-md-offset-2 col-md-8">
                    <label for="field-1"><strong><?php echo get_phrase('tagged_people');?></strong></label>
                    <div class="person-tags">
                        <h3 style="display:<?php echo $peoples?'none':''?>">No one tagged!</h3>
                        <?php foreach($peoples as $i=>$peo){?>
                            <div class="btn-group ptag mt5 mr10" data-num="<?php echo $i?>" data-type="<?php echo $peo->user_type?>" 
                                data-id="<?php echo $peo->user_id?>">
                                <a class="btn btn-danger btn-xs">
                                    <input type="hidden" class="ptname" name="tags[people][<?php echo $i?>][user_name]" value="<?php echo $peo->user_name?>"/>   
                                    <input type="hidden" name="tags[people][<?php echo $i?>][user_type]" value="<?php echo $peo->user_type?>"/>  
                                    <input type="hidden" name="tags[people][<?php echo $i?>][user_gender]" value="<?php echo $peo->user_gender?>"/>
                                    <input type="hidden" name="tags[people][<?php echo $i?>][user_id]" value="<?php echo $peo->user_id?>"/>   
                                    <?php echo $peo->user_name?>
                                </a>
                                <a class="btn btn-danger btn-xs rem-ptag"><i class="fa fa-trash-o"></i></a>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>   

            <div class="row mt10">          
                <div class="col-xs-12 col-md-offset-2 col-md-8">
                    <label for="field-1"><strong><?php echo get_phrase('photo_tagging');?></strong></label>
                    <div class="row">
                        <div class="col-md-4">
                            <select name="user-type" class="selectpicker" data-style="form-control">
                                <option value="1">Student</option>
                                <option value="2">Teacher</option>
                                <option value="3">Parent [father]</option>
                                <option value="4">Parent [mother]</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="user-val" class="selectpicker" data-style="form-control" data-live-search="true">
                                <option value=""><?php echo get_phrase('select_student')?></option>
                                <?php foreach($students as $stu){?>
                                    <option value="<?php echo $stu->student_id?>" data-type="S" data-gender="1"><?php echo $stu->name.' '.$stu->lname?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <a class="btn btn-primary add-tag"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="form-group">
                <div class="text-right">
                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('submit');?></button>
                </div>
            </div>
        <?php echo form_close()?> 
    </div>
</div>
<script src="<?php echo base_url('assets/bower_components/autoComplete/jquery.easy-autocomplete.min.js')?>"></script>
<script>
$(function(){
    $(document).on('change','select[name=user-type]',function(){
        $obj = $(this);
        $.ajax({
            type:'POST',
            url:'<?php echo base_url('index.php?'.$this->session->userdata('login_type').'/get_users_by_user_type')?>',
            data:{'class_id':'<?php echo $img->class_id?>','type':$obj.val()},
            dataType:'json',
            success:function(res){
                $('select[name=user-val]').html(res.html);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    });

    var pTnum = 0;
    $(document).on('click','.add-tag',function(){
        $obj = $(this);
        $userType = $('select[name=user-type] option:selected');
        $userVal = $('select[name=user-val] option:selected');
        if($userVal.val()==''){
            return false;
        }
        if($('.ptag[data-type="'+$userType.data('type')+'"]').length > 0 && $('.ptag[data-id="'+$userVal.val()+'"]').length > 0)
            return false;

        html = '<div class="btn-group ptag mt5 mr10" data-num="'+pTnum+'" data-type="'+$userVal.data('type')+'" data-id="'+$userVal.val()+'">'+
                    '<a class="btn btn-danger btn-xs">'+
                        '<input type="hidden" class="ptname" name="tags[people]['+pTnum+'][user_name]" value="'+$userVal.text()+'"/>'+   
                        '<input type="hidden" name="tags[people]['+pTnum+'][user_type]" value="'+$userVal.data('type')+'"/>'+    
                        '<input type="hidden" name="tags[people]['+pTnum+'][user_gender]" value="'+$userVal.data('gender')+'"/>'+  
                        '<input type="hidden" name="tags[people]['+pTnum+'][user_id]" value="'+$userVal.val()+'"/>'+     
                        $userVal.text()+' ('+$userType.text()+')'+
                    '</a>'+
                    '<a class="btn btn-danger btn-xs rem-ptag"><i class="fa fa-trash-o"></i></a>'+
                '</div>';

        $('.person-tags').find('h3').hide();       
        $('.person-tags').append(html);
        pTnum++;
    });

    $(document).on('click','.rem-ptag',function(){
        $ptag = $(this).closest('.ptag');
        $('.tagview[data-num='+$ptag.data('num')+']').remove();  
        $ptag.remove();  
        if($('.person-tags').find('.ptag').length==0) 
            $('.person-tags').find('h3').show();     
    });

    var selData,mouseX,mouseY;
    $('.main-img').click(function(e) { // make sure the image is click
        var imgtag = $(this).parent(); // get the div to append the tagging list
        mouseX = (e.pageX - imgtag.offset().left) - 50; // x and y axis
        mouseY = (e.pageY - imgtag.offset().top) - 50;
        $('#tagbox').remove(); // remove any tagit div first
        $(imgtag).append('<div id="tagbox">\
                            <div class="box"></div>\
                            <div class="name">\
                                <a class="btn btn-danger btn-xs btn-outline btn-1d pull-right ftcancel"><i class="fa fa-times"></i></a>\
                                <br/>\
                                <input type="text" id="hero-demo" class="form-control input-sm tagname" placeholder="<?php echo get_phrase('search')?>"/>\
                                <div class="text-center">\
                                    <a class="btn btn-danger btn-xs btn-outline btn-1d ftsave"><?php echo get_phrase('tag')?></a>\
                                </div>\
                            </div>\
                        </div>' );
        $('#tagbox').css({ top:mouseY, left:mouseX });
        $('#tagbox .tagname').focus();
        //$('#tagbox .tagname').autoComplete({'1':'One','2':'Two'});
        
        var options = {
            /* data: [
                    {"character": "Cyclops", "realName": "Scott Summers"},
                    {"character": "Professor X", "realName": "Charles Francis Xavier"},
                    {"character": "Mystique", "realName": "Raven Darkholme"},
                    {"character": "Magneto", "realName": "Max Eisenhardt"}
                ], */
            data:$('.ptag').map(function(){return {num:$(this).data('num'),name:$(this).find('.ptname').val()}}).toArray(),
            getValue: 'name', 
            list: {
                onChooseEvent: function() {
                    selData = $('#tagbox .tagname').getSelectedItemData();
                }
            }	
        };
        
        $('#tagbox .tagname').easyAutocomplete(options);
    });

    $(document).on('click', '#tagbox .ftcancel', function() {
        $('#tagbox').fadeOut();
    });

    $(document).on('click','#tagbox .ftsave', function(){
        //console.log(selData.length);
    
        /* $mnImg = $('.main-img');
        var lastWh = {w:$mnImg.width(),h:$mnImg.height()}; */
        if(selData.num!=undefined){
            $('#tagbox .tagname').val('');
            $('#tagbox').fadeOut();
            saveData = selData;
            selData = {};
            //console.log(selData);
             
            if($('.tagview[data-num='+saveData.num+']').length > 0){
                $('.tagview[data-num='+saveData.num+']').remove();   
            }    

            html = '<div class="tagview" style="left: '+mouseX+'px; top: '+mouseY+'px; opacity: 1;" data-num="'+saveData.num+'">\
                        <input type="hidden" name="tags[face]['+saveData.num+'][mouesX]" value="'+mouseX+'"/>\
                        <input type="hidden" name="tags[face]['+saveData.num+'][mouseY]" value="'+mouseY+'"/>\
                        <input type="hidden" name="tags[face]['+saveData.num+'][imgW]" value="'+$mnImg.width()+'"/>\
                        <input type="hidden" name="tags[face]['+saveData.num+'][imgY]" value="'+$mnImg.height()+'"/>\
                        <a class="btn btn-danger btn-xs pull-right ftrem"><i class="fa fa-times"></i></a>\
                        <div class="square"></div>\
                        <div class="person">'+saveData.name+'</div>\
                    </div>';
            $('.tag-container').append(html);        
        }
        
        /* name = $('#tagbox .tagname').val();
        var img = $('.main-img').find( 'img' );
        var id = $( img ).attr( 'id' ); */
        /*$.ajax({
            type: 'POST', 
            url: '', 
            data: "pic_id=" + id + "&name=" + name + "&pic_x=" + mouseX + "&pic_y=" + mouseY + "&type=insert",
            cache: true, 
            success: function(data){
                $('#tagbox').fadeOut();
            }
        }); */
    });

    $(document).on('click', '.tag-container .ftrem', function() {
        $(this).closest('.tagview').remove();
    });

    $('.tag-container').on('mouseover','.tagview',function( ) {
		var pos = $( this ).position();
		$(this).css({ opacity: 1.0 }); // div appears when opacity is set to 1.
	}).on('mouseout','.tagview',function( ) {
		$(this).css({ opacity: 0.0 }); // hide the div by setting opacity to 0.
    });
    
    $mnImg = $('.main-img');
    var lastWh = {w:$mnImg.width(),h:$mnImg.height()};
    $(window).resize(function(){
        newWh = {w:$mnImg.width(),h:$mnImg.height()};
        //if(newWh.w >lastWh.w){
            $.each($('.tag-container').find('.tagview'),function(i,o){
                Y = $(o).css('top').slice(0,-2);    
                X = $(o).css('left').slice(0,-2); 
                  
                Pt = (parseFloat(newWh.h)/parseFloat(lastWh.h))*100;
                NY = parseFloat(Y*Pt/100);
                $(o).css('top',NY+'px');
                
                Pt = (parseFloat(newWh.w)/parseFloat(lastWh.w))*100;
                NX = parseFloat(X*Pt/100);
                $(o).css('left',NX+'px');
            });
            lastWh = newWh;
        /* }else{
            $.each($('.tag-container').find('.tagview'),function(){
                x = $(o).css('left');   
                    
            });
        } */
        /* console.log($('.main-img').height()); */
    });
});
</script>