function scrollInView(target){
    //var target = $('#navigate tr td:eq('+active+')');
    if (target.length > 0)
    { 
        var top = target.offset().top;
        var pTop = target.parent().offset().top;
        var height = target.height();
        var ac = top - pTop;
        //console.log(target[0],top,pTop,height,window.innerHeight);
        //if((ac+height) > window.innerHeight){
            $('.sidebar').animate({scrollTop: (ac)}, 300);
        //}
    }
}

$(document).ready(function() {
    // Basic
    $('.dropify').dropify();

    $(document).on('click','.sidebar-head',function(){
        if($('.sidebar').hasClass('side_menu1')){
            sideMenu = $('#side-menu'); 
            act = sideMenu.find('li.active');
            if(act.length==0){
                act = sideMenu.find('li:eq(0)');
                act.addClass('active');  
            } 
            scrollInView(act);   
        }
    });

    $(document).on('keydown', function(event){ 
        sidebar = $('.sidebar');
        sideMenu = $('#side-menu'); 
        if(event.ctrlKey && event.keyCode === 32 && sidebar.hasClass('side_menu1')==false){
            $('.fix-sidebar').addClass('overflow-toggle');
            sidebar.addClass('side_menu1');
            sideMenu.show();
            act = sideMenu.find('li.active');
            if(act.length==0){
                act = sideMenu.find('li:eq(0)');
                act.addClass('active');  
            } 
            scrollInView(act);   
            return false;
        }
        if(sidebar.hasClass('side_menu1')){ 
            act = sideMenu.find('li.active');
            newAct = false;
            
            //inSubMenu = false; 
            //subMenu = false;
            if(sideMenu.find('ul:visible').length > 0){
                sideMenu = sideMenu.find('ul:visible');
                /* inSubMenu = true;
                subMenu = sideMenu.find('ul:visible');*/
                act = sideMenu.find('li.active');
            }
            mGrp  = Math.round(sideMenu.width()/sideMenu.find('>li').width());
            
        
            //Left Arrow  
            if  (event.keyCode === 	37) { 
                if(act.index() <= 0 || act.length==0){
                    if(sideMenu.prev('li').length!=0){
                        sideMenu.find('li').removeClass('active'); 
                        sideMenu.prev('li').addClass('active');
                        sideMenu.prev('li').removeClass('subliactive');
                    }
                    return false;
                }
                sideMenu.find('li').removeClass('active'); 
        
                if(act.prev('ul').html()!=undefined){
                    newAct = act.prev().prev('li.menu-item-tile');
                    newAct.addClass('active'); 
                }else{
                    newAct = act.prev('li.menu-item-tile');
                    newAct.addClass('active');           
                }   
            } 
            //Right Arrow  
            if  (event.keyCode === 	39) { 
                act.parent('ul').prev('li').addClass('subliactive');
                if(act.length==0){
                    //console.log(12);
                    sideMenu.find('li:eq(0)').addClass('active'); 
                    newAct = sideMenu.find('li.active');
                    newAct.parent('ul').prev('li').addClass('subliactive');
                    scrollInView(newAct);  
                    return false; 
                }
                
                if((act.index() == sideMenu.children().last().index()) ||  
                    (((act.index()+1) == sideMenu.children().last().index()) && act.next('ul').html()!=undefined)){
                    return false;
                }
                sideMenu.find('li').removeClass('active');
                if(act.next('ul').html()!=undefined){
                    newAct = act.next().next('li.menu-item-tile');
                    newAct.addClass('active'); 
                }else{
                    newAct = act.next('li.menu-item-tile');
                    newAct.addClass('active');           
                }   
            } 
            //Up Arrow  
            if  (event.keyCode === 	38) { 
                curInd = act.index();
                recInd = 0;count = 0;hvScp = false;
                $.each(sideMenu.children(),function(i,o){
                    newIndex = curInd - (i+1);
                    if(newIndex>=0){
                        if(sideMenu.children(':eq('+newIndex+')').prop('nodeName')=='LI'){
                            count += 1;  
                            if(count==mGrp){
                                hvScp = true;
                                recInd = newIndex;   
                            } 
                        }
                    }
                });
                if(hvScp==false){
                    return false;
                } 
                sideMenu.find('li').removeClass('active'); 
                newAct = sideMenu.children(':eq('+recInd+')');
                if(newAct.prop('nodeName')=='UL'){
                    newAct = sideMenu.children(':eq('+(recInd-1)+')');
                }   
                newAct.addClass('active'); 
            } 
            //Down Arrow  
            if (event.keyCode === 	40) { 
                curInd = act.index();
                recInd = 0;count = 0;
                $.each(sideMenu.children(),function(i,o){
                    //console.log(i,$(this).prop('nodeName'));
                    if(i >= curInd && $(this).prop('nodeName') == 'LI'){
                        count += 1;
                        if(count==mGrp){
                            recInd = i;   
                        } 
                    }
                });
                if(recInd==0){
                    return false;
                }
                //console.log(recInd);
                sideMenu.find('li').removeClass('active'); 
                newAct = sideMenu.children(':eq('+(recInd+1)+')');
                if(newAct.prop('nodeName')=='UL'){
                    newAct = sideMenu.children(':eq('+(recInd+2)+')');
                }   
                newAct.addClass('active'); 
            } 
            scrollInView(newAct);

            //Enter 
            if  (event.keyCode === 	13) {
                if(act.length==0){
                    act = sideMenu.prev('li.active');
                }     
                if(act.next('ul').html()!=undefined){
                    //console.log(act[0]);
                    act.find('+ ul').toggle();
                    act.parent('ul').toggleClass('sub-active');
                    prevLi = act.parent('ul').prev('li');
                    if(act.parent('ul').hasClass('sub-active')==false){
                        prevLi.addClass('active');
                        
                        prevLi.data('origIconClass', $("i:nth-child(2)", prevLi).attr('class'));
                        $("i:nth-child(2)", prevLi).attr('class', 'icon-size fa fa-reply').css('margin-top', '55px');
                        $(".icon-size.fa.fa-reply + .menu-text").hide();
                    }else{
                        prevLi.removeClass('active');
                        $('.icon-size.fa.fa-reply + .menu-text').show();
                        prevLi.find('i:nth-child(2)').attr('class', prevLi.data('origIconClass')).css('margin-top', '35px');
                    }
                    //sideMenu.toggleClass('sub-active');

                    //SubMenu
                    if (act.find('i:nth-child(2)').hasClass('fa-reply')) {
                        $('.icon-size.fa.fa-reply + .menu-text').show();
                        act.find('i:nth-child(2)').attr('class', act.data('origIconClass')).css('margin-top', '35px');
                    } else {
                        act.data('origIconClass', act.find('i:nth-child(2)').attr('class'));
                        act.find('i:nth-child(2)').attr('class', 'icon-size fa fa-reply').css('margin-top', '55px');
                        $('.icon-size.fa.fa-reply + .menu-text').hide();
                    }
                }else{
                    window.location.href =  act.find('a').attr('href');           
                }      
            } 

            //Escape
            if(event.keyCode === 27) { 
                sideMenu.toggle();
                sidebar.toggleClass('side_menu1');
                $('body').toggleClass('overflow-toggle');
                $('#page-wrapper').css('opacity', '1');
            } 
        }
    });
});