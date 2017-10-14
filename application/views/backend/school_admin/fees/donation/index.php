<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?<?php echo $this->session->userdata('login_type');?>/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>

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
        <div class="sttabs tabs-style-flip">
            <nav>
                <ul>
                    <li id="listing" class="active">
                        <a href="#list" class="sticon fa fa-list"><span class="hidden-xs"><?php echo get_phrase('list'); ?></span></a>
                    </li>
                    <li id="create">
                        <a href="#add" class="sticon fa fa-plus">
                            <span class="hidden-xs"><?php echo get_phrase('add'); ?></span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="content-wrap">     	
                <section id="list">  
                    <!--TABLE LISTING STARTS-->           
                    <table class= "custom_table table display" cellspacing="0" width="100%" id="example23">
                        <thead>
                            <tr>
                                <th><div><?php echo get_phrase('no'); ?></div></th>
                                <th><div><?php echo get_phrase('donator_name'); ?></div></th>
                                <th><div><?php echo get_phrase('amount'); ?></div></th>
                                <th><div><?php echo get_phrase('donation_date'); ?></div></th>
                                <th><div><?php echo get_phrase('description'); ?></div></th>
                                <th><div><?php echo get_phrase('action'); ?></div></th>
                            </tr>
                        </thead>
                        <tbody><?php $c= 1; if(count($data)){ foreach($data as $datum){ ?>
                            <tr>
                                <td><?php echo $c++;?></td>
                                <td><?php echo ucwords($datum['donator_name']);?></td>
                                <td><?php echo round($datum['amount'], 2);?></td>
                                <td><?php echo date('d-m-Y', strtotime($datum['donation_date']));?></td>
                                <td><?php echo $datum['description'];?></td>
        <td><a href="javascript: void(0);" onclick="confirm_modal('<?php echo base_url('index.php?fees/donation/delete/').$datum['donation_id'];?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete" title="Delete"><i class="fa fa-trash-o"></i></button></a></td>
                            </tr><?php } }?>

                        </tbody>
                    </table>
                </section>
                <!--TABLE LISTING ENDS-->
                <section id="add"> 
        <?php echo form_open(base_url().'index.php?fees/donation/add'); if($this->session->flashdata('flash_message_error')) {?><div class="alert alert-danger"><?php echo $this->session->flashdata('flash_message_error'); ?></div><?php }?>
<div class="col-md-12">                       
                    <div class="col-md-4">
                        <label for="donator_name"><?php echo get_phrase("donator_name"); ?><span class="error" style="color: red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-user"></i></div><input type="text" class="form-control" placeholder="<?php echo get_phrase("enter_donator_name");?>" required="required" name="donator_name" type="text" value="<?php echo set_value('donator_name'); ?>" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="date"><?php echo get_phrase("date"); ?><span class="error" style="color: red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control mydatepicker" placeholder="<?php echo get_phrase("select_date");?>" required="required" name="donation_date" type="text" value="<?php echo set_value('donation_date'); ?>" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="amount"><?php echo get_phrase("amount"); ?><span class="error" style="color: red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-money"></i></div><input type="text" class="form-control" placeholder="<?php echo get_phrase("enter_amount");?>" required="required" name="amount" type="text" value="<?php echo set_value('amount'); ?>" >
                        </div>
                    </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-9 col-md-offset-1"><br>
                            <label for="description"><?php echo get_phrase('description');?><span class="error" style="color: red;">*</span></label>
                            <textarea class="form-control" rows="8" name="description"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-10 form-group text-right"><br>
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase("submit");?></button> 
                        </div>
                    </div>
                <?php echo form_close();?>                            
                </section>                
            </div>
        </div>
    </div>
</div>  