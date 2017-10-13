<div class="row bg-title"> 
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

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

<div class="row m-0">
    <div class="col-md-12 white-box">
        <section>
            <div class="sttabs tabs-style-flip">                
            <nav>
		<ul> 
                <?php if(isset($edit_profile)): ?>
                <li class="active">
                    <a href="#edit" class="sticon fa fa-pencil-square-o">                    
                        <span><?php echo get_phrase('edit_phrase');?></span>
                    </a>
                </li>
                <?php endif;?>    

                
                <li class="active" data-step="5" data-intro="<?php echo get_phrase('you can see the language list from here!!');?>" data-position='top'>
                    <a href="#list" class="sticon fa fa-list">
                        <span> <?php echo get_phrase('language_list');?></span>
                    </a>
                </li>
              
                <li data-step="6" data-intro="<?php echo get_phrase('you can add a phrase from here!!');?>" data-position='top'>
                    <a href="#add" class="sticon fa fa-plus-square-o">
                        <span><?php echo get_phrase('add_phrase');?></span>
                    </a>
                </li>
                <li class="" data-step="7" data-intro="<?php echo get_phrase('you can add a language from here!!');?>" data-position='top'>
                    <a href="#add_lang" class="sticon fa fa-language">
                        <span><?php echo get_phrase('add_language');?></span>
                    </a>
                </li>
		</ul>
            </nav>
                
            <div class="content-wrap">
                
             <?php if (isset($edit_profile)): ?>    
            <section id="edit">   
                
		<div class="tab-pane active" id="edit">
                <div class="">
                    <div class="row">
                    <?php 
                    
                        $current_editing_language	=	$edit_profile;
                        //echo $current_editing_language; exit;
                        echo form_open(base_url() . 'index.php?school_admin/manage_language/update_phrase/'.$current_editing_language  , array('id' => 'phrase_form'));
                        $count = 1;
                       // $language_phrases	=	$this->db->query("SELECT `phrase_id` , `phrase` , `$current_editing_language` FROM `language`")->result_array();
                        //print_r();
                        foreach($language_phrases as $row) {
                            $count++;
                            $phrase_id			=	$row['phrase_id'];					//id number of phrase
                            $phrase				=	$row['phrase'];						//basic phrase text
                            $phrase_language	=	$row[$current_editing_language];	//phrase of current editing language
                         ?>
                        
                        <div class="col-xs-12 col-md-6 form-group">
                           
                             
                            <label><?php echo $row['phrase'];?></label>
                              <div>
                                    <input type="text" name="phrase[]" 	
                                            value="<?php echo $phrase_language;?>" class="form-control"/>
                                    <input type="hidden" name="id[]" 	
                                            value="<?php echo $phrase_id;?>" class="form-control"/>
                                     
                                
                            </div>
                        </div>                        
			<?php 	} ?>
                        <input type="hidden" name="total_phrase" value="<?php echo $count;?>" />
		    </div>
                    
                    <input type="submit" value="<?php echo get_phrase('update_phrase');?>" onClick="document.getElementById('phrase_form').submit();" class="btn btn-blue"/>	
                    <?php echo form_close();?>                                     
                </div>              
		</div>
            </section>
            <?php endif;?>    
                
                
                
            <section id="list">
                <div class="tab-pane <?php if(!isset($edit_profile))echo 'active';?>" id="list"> 
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th><?php echo get_phrase('language');?></th>
                            <th><?php echo get_phrase('option');?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($fields as $field) {
                                    if($field == 'phrase_id' || $field == 'phrase')continue; ?>
                            <tr>
                                <td><?php echo ucwords($field);?></td>
                                <td>
                                    <a href="<?php echo base_url();?>index.php?school_admin/manage_language/edit_phrase/<?php echo $field;?>"
                                             class="btn btn-default"> <?php echo get_phrase('edit_phrase');?>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>           
           
                
            <section id="add">
            <div class="tab-pane box" id="add">
                <div class="box-content">
                    <?php echo form_open(base_url() . 'index.php?school_admin/manage_language/add_phrase/' , array('class' => 'form-horizontal form-groups-bordered validate'));?>
                        <div class="padded">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('phrase');?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="phrase" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                </div>
                            </div>                            
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-info"><?php echo get_phrase('add_phrase');?></button>
                            </div>
                        </div>
                    <?php echo form_close();?>                
                </div>                
            </div>
            </section>        
        
            <section id="add_lang">
                <div class="tab-pane box" id="add_lang">
                    <div class="box-content">
                        <?php echo form_open(base_url() . 'index.php?school_admin/manage_language/add_language/' , array('class' => 'form-horizontal form-groups-bordered validate'));?>
                            <div class="padded">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><?php echo get_phrase('language');?></label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="language" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
                                    </div>
                                </div>                            
                            </div>
                            <div class="form-group">
                                  <div class="text-center">
                                      <button type="submit" class="btn btn-info"><?php echo get_phrase('add_language');?></button>
                                  </div>
                            </div>
                        <?php echo form_close();?> 
                    </div>
                </div>
            </section>
        </div>
</div>
        </section>
    </div>
    


            
            
