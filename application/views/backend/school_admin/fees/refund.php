<style type="text/css">
    #ex tr td div{bacfdkground-color: lightgray; padding: 15px 15px; colfdor: #000;}

</style>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title);?></h4> </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript:void(0);" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
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
<!-- /.row -->
<div class="row">
    <div class="col-md-12 white-box">
        <div class="col-md-3">
            <h4>Session : <?php echo get_phrase($running_year); ?></h4>
        </div>

        <div class="col-md-9">
            <label class="control-label"><?php echo get_phrase('find_students'); ?></label>
            <div class="input-group">
                <div class="input-group-addon"><i class="ti-user"></i></div>
                <input type="text" class="form-control" placeholder="Type Enrollment No or First Name" id="SearchText" value="<?php echo $this->uri->segment(5);?>">
            </div>
        </div>
        
        <div class="col-md-4 text-left col-xs-12 p-t-20 no-padding col-md-offset-3">
            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d FindStudent"><?php echo get_phrase("search");?></button>
        </div>

    </div>
</div>

<?php if(count($data)){?>

<div class="row">
    <div class="col-md-12 white-box">
        <table id="ex" class="table">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('sl_no'); ?></div></th>
                    <th><div><?php echo get_phrase('student_name'); ?></div></th>
                    <th><div><?php echo get_phrase('enroll_code'); ?></div></th>
                    <th><div><?php echo get_phrase('class'); ?></div></th>
                    <th><div><?php echo get_phrase('section'); ?></div></th>
                    <th><div><?php echo get_phrase('dob'); ?></div></th>
                    <th><div><?php echo get_phrase('gender'); ?></div></th>
                    <th><div><?php echo get_phrase('category'); ?></div></th>
                    <th><div><?php echo get_phrase('phone'); ?></div></th>
                    <th><div><?php echo get_phrase('action'); ?></div></th>
                </tr>
            </thead>

            <tbody><?php $n = 1; foreach($data as $datum){?>
                <tr>
                    <td><?php echo $n;?></td>
                    <td><?php echo ucwords($datum['stu_fname'].' '.$datum['stu_mname'].' '.$datum['stu_lname']);?></td>
                    <td><?php echo $datum['enroll_code'];?></td>
                    <td><?php echo ucfirst($datum['class_name']);?></td>
                    <td><?php echo ucfirst($datum['section_name']);?></td>
                    <td><?php echo $datum['birthday'];?></td>
                    <td><?php echo ucfirst($datum['sex']);?></td>
                    <td><?php echo ucfirst($datum['caste_category']);?></td>
                    <td><?php if($datum['phone']!='null'){ echo ucfirst($datum['phone']);}?></td>
        <td data-toggle="collapse" class="accordion-toggle" data-target="#row<?php echo $n; ?>"><a href="javascript: void(0);"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('proceed'); ?>" title="<?php echo get_phrase('proceed'); ?>"><i class="fa fa-share-square-o"></i></button></a></td>
                </tr>
                <tr class="hiddenRow accordian-body collapse" id="row<?php echo $n; ?>">
                    <td colspan="10">
                    <div class="sttabs tabs-style-flip">
                        <nav>
                            <ul>
                                <li><a href="#tab1" class="sticon fa fa-plus-circle"><span><?php echo get_phrase('add_refund'); ?></span></a></li>
                                <li><a href="#tab2" class="sticon fa fa-list"><span><?php echo get_phrase('refund_list'); ?></span></a></li>
                            </ul>
                        </nav>

                        <div class="content-wrap">
                            <section id="tab1">

<?php echo form_open(base_url().'index.php?fees/refund/request/add'); if($this->session->flashdata('flash_message_error')) {?><div class="alert alert-danger"><?php echo $this->session->flashdata('flash_message_error'); ?></div><?php }?>                       
                                    <div class="col-md-4">
                                        <label class="control-label"><?php echo get_phrase('select_collection'); ?></label>
                                        <select class="selectpicker" data-style="form-control" data-live-search="true" id="collection_id" onchange="GetAmount()" name="collection_id">
                                            <option value=""><?php echo get_phrase('select'); ?></option>
<?php if(count($CollectionData)){ foreach ($CollectionData AS $coll_datum):?>
                                            <option value="<?php echo $coll_datum['id']; ?>"><?php echo ucwords($coll_datum['collection_name']); ?></option>
<?php endforeach; }?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="control-label"><?php echo get_phrase('select_refund_rule'); ?></label>
                                        <select class="form-control" id="refund_rule_id" onchange="GetAmount()" name="refund_rule_id">
                                            <!-- <option value=""><?php echo get_phrase('select'); ?></option> -->

<?php if(count($RefundRule)){ foreach ($RefundRule AS $rule_datum):?>
                                            <option value="<?php echo $rule_datum['id']; ?>"><?php echo ucwords($rule_datum['rule_name']); ?></option>
<?php endforeach; }?>

                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="amount"><?php echo get_phrase("refundable_amount"); ?></label>
                                        <input type="text" class="form-control" name="refund_amount" readonly id="refund_amount">
                                    </div>

                                    <div class="col-md-7 col-md-offset-1">
                                        <label for="comment"><?php echo get_phrase('comment');?></label>
                                        <textarea class="form-control" id="request_comment" rows="8" name="request_comment"></textarea>
                                    </div>

                                    <input type="hidden" name="enroll_id" value="<?php echo $datum['enroll_id'];?>">
                                    <input type="hidden" name="running_year" value="<?php echo $running_year; ?>">

                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('send_request');?></button>
                                    </div>
                                <?php echo form_close();?>
                            </section>

                            <section id="tab2">
                                <table id="ex" class="table">
                                    <thead>
                                        <tr>
                                            <th><div><?php echo get_phrase('sl_no'); ?></div></th>
                                            <th><div><?php echo get_phrase('collection/_refund_name'); ?></div></th>
                                            <th><div><?php echo get_phrase('amount'); ?></div></th>
                                            <th><div><?php echo get_phrase('request_date'); ?></div></th>
                                            <th><div><?php echo get_phrase('status'); ?></div></th>
                                            <th><div><?php echo get_phrase('approvel_/disapprovel_date'); ?></div></th>
                                            <th><div><?php echo get_phrase('session'); ?></div></th>
                                            <th><div><?php echo get_phrase('request_comment'); ?></div></th>
                                            <th><div><?php echo get_phrase('replied_comment'); ?></div></th>
                                            <th><div><?php echo get_phrase('action'); ?></div></th>
                                        </tr>
                                    </thead>

                                    <tbody>
<?php $c = 1; if(count($datum['request_data'])){ foreach($datum['request_data'] as $request_datum){ ?>
                                        <tr>
                                            <td><?php echo $c++;?></td>
                                        <td><?php echo get_phrase($request_datum['collection_name'].' / '.$request_datum['refund_rule_name']);?></td>
                                            <td><?php echo $request_datum['refund_amount'];?></td>
                                            <td><?php echo date('d-m-Y', strtotime($request_datum['request_date']));?></td>
        <td><?php echo ($request_datum['request_status']=='1'? 'Approved': ($request_datum['request_status']=='2'? 'Rejected': 'Pending'));?></td>
                <td><?php echo ($request_datum['request_status']=='1'? $request_datum['approve_date']: ($request_datum['request_status']=='2'? $request_datum['reject_date']: ' '));?></td>
                                            <td><?php echo ucfirst($request_datum['running_year']);?></td>
                                            <td><?php echo ucfirst($request_datum['request_comment']);?></td>
                                            <td><?php echo ucfirst($request_datum['replied_comment']);?></td>
    <td><?php if($request_datum['request_status']=='1'){?><a href="javascript: void(0);" onclick="ConfirmAction('#');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Pay" title="Pay"><i class="fa fa-money"></i></button></a><?php }?></td>
                                        </tr><?php } }?>
                                    </tbody>
                                </table>
                            </section>
                        </div>
                    </div>                        

                    </td>
                </tr>
            <?php $n++; }?>
            </tbody>

        </table>
    </div>
</div> <?php }?>

<script>
$(document).ready(function() {
    $('.FindStudent').click(function(){
        var Text = $('#SearchText').val();            
        var SearchText = $.trim(Text);
        if(SearchText!=''){
            var url ='<?php echo base_url(); ?>index.php?fees/refund/request/search/'+SearchText;
            window.location.href = url;

        }else{
            alert('Plese type enrollment no or first name');
        }
    });

});

function GetAmount(){
    var CollectionId = $('#collection_id').val();
    var RuleId = $('#refund_rule_id').val();

    if((CollectionId!='') && (RuleId!='')){
        $.ajax({
            url : '<?php echo base_url();?>index.php?ajax_controller/get_refund_amount',
            type: 'POST',
            data :{CollectionId: CollectionId, RuleId: RuleId},
            success: function(rs){
                if(rs){
                    $('#refund_amount').empty();
                    $('#refund_amount').val(rs);                                 
                }else{
                    alert('An error occured.');
                }                
            },
            error: function(){
                alert('An error occured.');
                $('#refund_amount').empty();
            }
        });
    }
}
</script>