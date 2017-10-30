<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('photo_gallery_images');?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" 
        class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php?'.$this->session->userdata('login_type').'/dashboard');?>"><?php echo get_phrase('Dashboard'); ?></a></li>

            <?php $BRC = get_bread_crumb(); if (strpos($BRC, '^') !== false) { $ExpBrd = explode('^', $BRC);?>
            <li>
                <?php echo get_phrase(@$ExpBrd[0]); ?>
                <?php echo @$ExpBrd[1]; ?>
            </li> 
            <?php }
            else{ $ExpBrd[2] = $BRC;}?>
            <li class="active">
                <?php echo get_phrase(@$ExpBrd[2]); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>

<link rel="stylesheet" href="<?php echo base_url('assets/css/gallery-grid.css')?>"/>
<style>
.tagview {
    border: 1px solid #ea1553;
    width: 100px;
    height: 100px;
    position: absolute;
    display: block;
    opacity: 0;
    color: #FFFFFF;
    text-align: center;
    z-index:9;
}
.tagview:hover {
    display: block !important;
}
</style>

<!-- Core CSS file -->
<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/photoswipe/dist/photoswipe.css')?>"> 

<!-- Skin CSS file (styling of UI - buttons, caption, etc.)
     In the folder of skin CSS file there are also:
     - .png and .svg icons sprite, 
     - preloader.gif (for browsers that do not support CSS animations) -->
<link rel="stylesheet" href="<?php echo base_url('assets/bower_components/photoswipe/dist/default-skin/default-skin.css')?>"> 
<!-- Core JS file -->
<script src="<?php echo base_url('assets/bower_components/photoswipe/dist/photoswipe.min.js')?>"></script> 
<!-- UI JS file -->
<script src="<?php echo base_url('assets/bower_components/photoswipe/dist/photoswipe-ui-default.min.js')?>"></script> 

<div class="row m-0">
    <div class="col-md-12 white-box">
        <div class="row">
            <div class="col-md-6">
                <h2><?php echo $gallery->title?></h2>    
            </div>
        </div>

        <!--Gallery-->
        <div class="row tz-gallery">
            <div class="col-md-12">
                <div class="row">
                    <?php foreach($images as $i=>$img){
                        echo ($i!=0 && ($i % 6) == 0)?'</div><div class="row">':'';?>
                        <div class="col-md-2 mt10">
                            <a class="lightbox mt5" href="<?php echo $img->bucket.$img->main?>" data-type="thumb-a" data-size="<?php echo $img->size?>">
                                <img src="<?php echo $img->bucket.$img->thumb?>" class="img-thumbnail" alt="<?php echo $img->title?>">
                                <small style="word-wrap: break-word;"><?php echo $img->title?></small><br/>
                                <small class="posted-by" style="word-wrap: break-word;"><?php echo get_phrase('posted_by').': '.$img->created_by_name?></small>
                                <p class="photo-brief dis-none"><?php echo $img->brief?></p>
                                <p class="photo-tags dis-none" data-tags="<?php echo count($img->peoples)?>">
                                    <?php foreach($img->peoples as $pi=>$peo){?>
                                        <?php echo $peo->user_name.($pi+1==count($img->peoples)?'':',')?>
                                    <?php }?>
                                </p>
                                <div class="face-tags dis-none">
                                    <?php foreach($img->faces as $i=>$face){?>
                                        <div class="tagview" style="left:<?php echo $face->mouesX?>px; top:<?php echo $face->mouseY?>px;" 
                                            data-num="<?php echo $i?>" data-imgW="<?php echo $face->imgW?>" data-imgH="<?php echo $face->imgH?>">
                                            <div class="square"></div>
                                            <div class="person"><?php echo $face->user_name?></div>
                                        </div>
                                    <?php }?>
                                </div>
                            </a>
                        </div>
                    <?php }?>
                </div><!--row-->
            </div><!--Col-12-->
        </div>
    </div>
</div>

<!-- Modal -->
<div id="add-images" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form method="post" action="<?php echo base_url('index.php?'.$this->session->userdata('login_type').'/photo_gallery_images/'.$gallery->id)?>" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Images</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label><?php echo get_phrase('select_images')?></label>
                    <input type="file" class="form-control" accept="image/png, image/jpeg, image/jpg" name="images[]" multiple="multiple"/>                            
                </div>                                
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">Save</button>
        </div>
    </div>
    </form>
  </div>
</div>

<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <!-- Background of PhotoSwipe. 
        It's a separate element, as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>
    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">
        <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
        <!-- don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <!--  Controls are self-explanatory. Order can be changed. -->
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share" title="Share"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                    <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div> 
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>
<script>
var initPhotoSwipeFromDOM = function(gallerySelector) {
    // parse slide data (url, title, size ...) from DOM elements 
    // (children of gallerySelector)
    var parseThumbnailElements = function(el) {
        var thumbElements = $(el).closest('.tz-gallery').find('a[data-type=thumb-a]'),//el.childNodes,
            numNodes = thumbElements.length,
            items = [],
            figureEl,
            linkEl,
            size,
            item;

        for(var i = 0; i < numNodes; i++) {
            //console.log(thumbElements[i]);

            figureEl = thumbElements[i]; // <figure> element

            // include only element nodes 
            if(figureEl.nodeType !== 1) {
                continue;
            }

            //linkEl = figureEl.children[0]; // <a> element

            //size = linkEl.getAttribute('data-size').split('x');
            mg = $(figureEl).find('img');
            size = figureEl.getAttribute('data-size')?figureEl.getAttribute('data-size').split('x'):[mg[0].naturalWidth,mg[0].naturalHeight];
            //console.log(mg[0].width);

            // create slide object
            item = {
                src: figureEl.getAttribute('href'),//linkEl.getAttribute('href'),
                w: parseInt(size[0], 10),///parseInt(mg[0].naturalWidth, 10),//parseInt(size[0], 10),
                h:  parseInt(size[1], 10),//parseInt(mg[0].naturalHeight, 10)//parseInt(size[1], 10)
            };
            /* if(figureEl.children.length > 1) {
                // <figcaption> content
                item.title = figureEl.children[1].innerHTML; 
            } */
            if(mg.attr('alt')) {
                item.title = mg.attr('alt'); 
            }
            if($(figureEl).find('.photo-brief').html()!='') {
                item.title = item.title+'<br/><small>'+$(figureEl).find('.photo-brief').html()+'</small>'; 
            }
            if($(figureEl).find('.photo-tags').data('tags')>0) {
                item.title = item.title+'<br/><small>Tags: '+$(figureEl).find('.photo-tags').html()+'</small>'; 
            }
            if($(figureEl).find('.posted-by').length>0) {
                item.title = item.title+'<br/><small>'+$(figureEl).find('.posted-by').text()+'</small>'; 
            }

            if(figureEl.children.length > 0) {
                // <img> thumbnail element, retrieving thumbnail url
                item.msrc = figureEl.children[0].getAttribute('src');
            } 

            item.el = figureEl; // save link to element for getThumbBoundsFn
            items.push(item);
        }

        return items;
    };

    // find nearest parent element
    var closest = function closest(el, fn) {
        return el && ( fn(el) ? el : closest(el.parentNode, fn) );
    };

    // triggers when user clicks on thumbnail
    var onThumbnailsClick = function(e) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;

        var eTarget = e.target || e.srcElement;
        if(eTarget.tagName.toUpperCase() !== 'IMG'){
            //console.log($(eTarget).parent());
            return false;
        }

        // find root element of slide
        var clickedListItem = closest(eTarget, function(el) {
            //console.log('--',eTarget,el,el.tagName,'end');
            //return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');

            return (el.tagName && el.tagName.toUpperCase() === 'IMG');
        });

        if(!clickedListItem) {
            return;
        }

        // find index of clicked item by looping through all child nodes
        // alternatively, you may define index via data- attribute
        var clickedGallery = $(eTarget).closest('.tz-gallery')[0],//clickedListItem.parentNode,
            childNodes = $(eTarget).closest('.tz-gallery').find('a[data-type=thumb-a]'),//clickedListItem.parentNode.childNodes,
            numChildNodes = $(eTarget).closest('.tz-gallery').find('a[data-type=thumb-a]').length,
            nodeIndex = 0,
            index;
        //console.log(clickedGallery,childNodes,numChildNodes);

        for (var i = 0; i < numChildNodes; i++) {
            if(childNodes[i].nodeType !== 1) { 
                continue; 
            }

            if($(childNodes[i]).find('img')[0] === clickedListItem) {
                index = nodeIndex;
                break;
            }
            nodeIndex++;
        }



        if(index >= 0) {
            // open PhotoSwipe if valid index found
            openPhotoSwipe( index, clickedGallery );
        }
        return false;
    };

    // parse picture index and gallery index from URL (#&pid=1&gid=2)
    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1),
        params = {};

        if(hash.length < 5) {
            return params;
        }

        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if(!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');  
            if(pair.length < 2) {
                continue;
            }           
            params[pair[0]] = pair[1];
        }

        if(params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        return params;
    };

    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
        var pswpElement = document.querySelectorAll('.pswp')[0],
            gallery,
            options,
            items;

        items = parseThumbnailElements(galleryElement);
        //console.log(items[index].el.getElementsByTagName('img')[0]);
        // define options (if needed)
        options = {

            // define gallery index (for URL)
            galleryUID: galleryElement.getAttribute('data-pswp-uid'),
            
            getThumbBoundsFn: function(index) {
                // See Options -> getThumbBoundsFn section of documentation for more info
                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect(); 

                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
            }

        };

        // PhotoSwipe opened from URL
        if(fromURL) {
            if(options.galleryPIDs) {
                // parse real index when custom PIDs are used 
                // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                for(var j = 0; j < items.length; j++) {
                    if(items[j].pid == index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                // in URL indexes start from 1
                options.index = parseInt(index, 10) - 1;
            }
        } else {
            options.index = parseInt(index, 10);
        }

        // exit if index not found
        if( isNaN(options.index) ) {
            return;
        }

        if(disableAnimation) {
            options.showAnimationDuration = 0;
        }

        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();

        gallery.listen('imageLoadComplete', function(index, item) { 
            resizeTags();
        });

        gallery.listen('afterChange', function() { 
            resizeTags();
        });

        // Viewport size changed
        /* gallery.listen('resize', function() { 
            resizeTags();
        }); */

        gallery.listen('initialZoomOut', function() { resizeTags(); });

        // Closing zoom out animation finished
        gallery.listen('initialZoomOutEnd', function() { resizeTags(); });

        function resizeTags(){
            faceTags = $('.lightbox:eq('+gallery.getCurrentIndex()+')').find('.face-tags').html();
            $(gallery.currItem.container).find('.tagview').remove();
            $(gallery.currItem.container).append(faceTags);
            
            $curImg = $(gallery.currItem.container.children[0]);
            newWh = {w:$curImg.width(),h:$curImg.height()};
            $(gallery.currItem.container).find('.tagview').each(function(i,o){
                var lastWh = {w:$(o).data('imgw'),h:$(o).data('imgh')};
                Y = $(o).css('top').slice(0,-2);    
                X = $(o).css('left').slice(0,-2); 
                  
                Ph = (parseFloat(newWh.h)/parseFloat(lastWh.h))*100;
                NY = parseFloat(Y*Ph/100);
                $(o).css('top',NY+'px');
                
                Pw = (parseFloat(newWh.w)/parseFloat(lastWh.w))*100;
                NX = parseFloat(X*Pw/100);
                $(o).css('left',NX+'px');
                
                $(o).data('imgw',newWh.w);
                $(o).data('imgh',newWh.h);

                
                ObW = parseFloat($(o).width()*Pw/100);
                ObH = parseFloat($(o).height()*Ph/100);
                $(o).css('width',ObW);
                $(o).css('height',ObH);
            });
        }
    };

    // loop through all gallery elements and bind events
    var galleryElements = document.querySelectorAll( gallerySelector );

    for(var i = 0, l = galleryElements.length; i < l; i++) {
        galleryElements[i].setAttribute('data-pswp-uid', i+1);
        galleryElements[i].onclick = onThumbnailsClick;
    }

    // Parse URL and open gallery if it contains #&pid=3&gid=1
    var hashData = photoswipeParseHash();
    if(hashData.pid && hashData.gid) {
        //console.log(galleryElements[ hashData.gid - 1 ]);
        openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
    }
};

// execute above function
initPhotoSwipeFromDOM('.tz-gallery');

$(document).on('mouseover','.tagview',function( ) {
    var pos = $( this ).position();
    $(this).css({ opacity: 1.0 }); // div appears when opacity is set to 1.
}).on('mouseout','.tagview',function( ) {
    $(this).css({ opacity: 0.0 }); // hide the div by setting opacity to 0.
});

$('form').submit(function(){
    $('#add-images').modal('hide');
    $('body').loading('start');
});
</script>