<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('review_feedback'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?teacher/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>

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
</div>

<div class="row">
    <div class="col-sm-12">    
        <div class="white-box" data-step="5" data-intro="<?php echo get_phrase('Here you see feedback information');?>" data-position='top'> 
            <?php if(!empty($over_all_rating)){?>
            <div class="text-center">
                <h3><b><?php echo get_phrase('your_over_all_rating_is_')." ".$over_all_rating."%";?></b></h3>
            </div>
            <?php } ?>
             <table id="example23" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>          
                        <th style="width:10% !important;"><div><?php echo get_phrase('no:'); ?></div></th> 
                        <th style="width:65% !important;"><div><?php echo get_phrase('feedback'); ?></div></th> 
                        <th style="width:25% !important;"><div><?php echo get_phrase('rating'); ?></div></th>
                    </tr>
                </thead>
                <tbody> 
			<?php $count = 1;
                        foreach($feed_backs as $feeds){ 
                        ?>
                    <tr>
                        <td style="max-width:10% !important;"><div><label><?php echo $count++; ?></label></div></td>
                        <td style="max-width:65% !important;"><div><label style="word-wrap: break-word; word-break: break-all;"><?php echo $feeds['feedback_content']; ?></label></div></td>                
                        <td style="max-width:25% !important;">
                            <?php for($i=0;$i<$feeds['rating'];$i++) { ?>
                            <i class="fa fa-star" style="color:#FFD700; font-size: 18px;">&nbsp;</i>
                            <?php } ?>
                            <?php for($i=0;$i<5-$feeds['rating'];$i++) { ?>
                            <i class="fa fa-star" style="font-size: 18px; color: #ccc;">&nbsp;</i>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>                    
            </table> 
        </div>
    </div>
</div> 

<style>
/*@import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);*/

fieldset, label { margin: 0; padding: 0; }
/*body{ margin: 20px; }*/
h1 { font-size: 1.5em; margin: 10px; }

/****** Style Star Rating Widget *****/

.rating { 
  border: none;
  float: left;
}

.rating > input { display: none; } 
.rating > label:before { 
  margin: 5px;
  font-size: 1.25em;
  font-family: FontAwesome;
  display: inline-block;
  content: "\f005";
}

.rating > .half:before { 
  content: "\f089";
  position: absolute;
}

.rating > label { 
  color: #ddd; 
 float: right; 
}

/***** CSS Magic to Highlight Stars on Hover *****/

.rating > input:checked ~ label, /* show gold star when clicked */
.rating:not(:checked) > label:hover, /* hover current star */
.rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */

.rating > input:checked + label:hover, /* hover current star when changing rating */
.rating > input:checked ~ label:hover,
.rating > label:hover ~ input:checked ~ label, /* lighten current selection */
.rating > input:checked ~ label:hover ~ label { color: #FFED85;  }     
</style>
<script>

$('#example23').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            'copy', 'excel', 'pdf', 'print'
        ]
    });  


</script>