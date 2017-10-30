<style>
#dt_table thead{    background: #707cd2;}
#dt_table thead tr th{font-weight:bold;color:#fff}
.show-detail-box{}
</style>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('compare_transaction_report');?></h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript:void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        
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
        <form method="post" action="">
            <div class="row">
                <div class="col-md-6">
                    <label>Start Date</label>
                    <input type="text" class="form-control dtp" name="from_date" placeholder="YYYY-MM-DD" value="<?php echo $from_date?>" required/>
                </div> 
                <div class="col-md-6">
                    <label>End Date</label>
                    <input type="text" class="form-control dtp" name="to_date" placeholder="YYYY-MM-DD" value="<?php echo $to_date?>" required/>
                </div> 
            </div>

            <div class="row text-center">
                <h2>AND</h2>
            </div>

            <div class="row mt10">
                <div class="col-md-6">
                    <label>Start Date</label>
                    <input type="text" class="form-control dtp" name="from_date2" placeholder="YYYY-MM-DD" value="<?php echo $from_date2?>" required/>
                </div> 
                
                
                <div class="col-md-6">
                    <label>End Date</label>
                    <input type="text" class="form-control dtp" name="to_date2" placeholder="YYYY-MM-DD" value="<?php echo $to_date2?>" required/>
                </div> 

                <div class="col-md-12 text-center">
                    <label>&nbsp;</label><br/>
                    <button type="submit" class="btn btn-danger btn-outline btn-1d">View</button>
                </div> 
            </div>
        </form>
    </div>
</div>    

<?php if($report_generated){?>
<div class="row m-0">
    <div class="col-md-12 white-box">
        <h3><?php echo get_phrase('transaction_report')?></h3>
        <table class="table table-striped table-bordered" width="100%" id="dt_table">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('S.No.');?></div></th>
                    <th><div><?php echo get_phrase('finance_category');?></div></th>
                    <th><div><?php echo get_phrase('date_range_1');?></div></th>
                    <th><div><?php echo get_phrase('date_range_2');?></div></th>
                </tr>
            </thead>
            <tbody> 
                <tr>
                    <td colspan="2"><?php echo get_phrase('income');?></td>
                    <td><?php echo get_phrase('amount');?></td>
                    <td><?php echo get_phrase('amount');?></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td><?php echo get_phrase('donations')?></td>
                    <td><?php echo $donations;?></td>
                    <td><?php echo $donations2;?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><?php echo get_phrase('school_fee')?></td>
                    <td><?php echo $school_fee;?></td>
                    <td><?php echo $school_fee2;?></td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo get_phrase('expense');?></td>
                    <td><?php echo get_phrase('amount');?></td>
                    <td><?php echo get_phrase('amount');?></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td><?php echo get_phrase('employee_salary')?></td>
                    <td><?php echo $salary;?></td>
                    <td><?php echo $salary2;?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php }?>

<script>
$(function(){
    $('.dtp').datepicker({
       autoclose: true,
       format:'yyyy-mm-dd'
    });
});
</script>