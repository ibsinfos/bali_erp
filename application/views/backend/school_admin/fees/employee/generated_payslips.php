<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('Employee Payslips'); ?> </h4></div>
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
        <div class="row">
            <form method="post" action="<?php echo base_url('index.php?fees/main/generated_payslips')?>">
                <div class="col-md-3">
                    <select class=" selectpicker" data-style="form-control" name="role_id">
                        <option value=""><?php echo get_phrase('select_role')?></option>
                        <?php foreach($roles as $role){?>
                            <option value="<?php echo $role->id?>" <?php echo $role->id==$role_id?'selected':''?>><?php echo $role->rolename?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control dtp" name="month" placeholder='Salary Month' value="<?php echo $month?>" required/>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info">View</button>
                </div>
            </form>
        </div>
    </div>
</div>    

<div class="row m-0">
    <div class="col-md-12 white-box">
        <table class="table table-striped" width="100%" id="dt_table">
            <thead>
                <tr>
                    <th><div><?php echo get_phrase('employee_id');?></div></th>
                    <th><div><?php echo get_phrase('name');?></div></div></th>
                    <th><div><?php echo get_phrase('role');?></div></th>
                    <th><div><?php echo get_phrase('mail_id');?></div></th>
                    <th><div><?php echo get_phrase('work_phone');?></div></th>
                    <th><div><?php echo get_phrase('acc_no.');?></div></th>
                    <th><div><?php echo get_phrase('salary');?></div></th>
                    <th><div><?php echo get_phrase('salary_status/Action');?></div></th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;
                foreach ($generated_payslips as $row): ?>
                    <tr>
                        <td><?php echo $row->employeeId;?></td>
                        <td><?php echo $row->firstname.' '.$row->lastname; ?></td>
                        <td><?php echo $row->emprole_name;?></td>
                        <td><?php echo $row->emailaddress;?></td>
                        <td><?php echo $row->office_number;?></td>
                        <td><?php echo $row->accountnumber;?></td>
                        <td><?php echo decrypt_salary($row->salary);?></td>
                        <td>
                            <?php if($row->payslip_id!=''){
                                    if($row->is_paid){?>
                                        <a href="javascript:;" class="btn btn-success btn-xs"><?php echo get_phrase('paid')?></a>
                                    <?php }else{?>
                                        <a href="javascript:;" class="btn btn-primary btn-xs paymodal" data-toggle="modal" data-target="#selectAccount"
                                            data-payslipid="<?php echo $row->payslip_id?>">
                                            <?php echo get_phrase('pay_now')?>
                                        </a>
                                    <?php }?>
                            <?php }else{?>
                                Not Generated
                            <?php }?>    
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="selectAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Pay Salary</h4>
      </div>
      <input type="hidden" name="payslip_id" id="payslip_id"/>
      <!-- <div class="modal-body">
      </div> -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary paynow">Pay Now</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- <div class="modal fade" id="selectAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Select Account to Deduct From</h4>
      </div>
      <div class="modal-body">
        <form action="{$_url}employees/paynow/">
            <input type="hidden" name="payslip_id" id="payslip_id"/>
            <div class="row">
                <div class="col-md-12">
                    <label>Account</label>
                    <select class="form-control" id="acc_id">
                        <option value="">Select Account</option>
                        {foreach $accts as $act}
                            <option value="{$act['id']}">{$act['account']}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary paynow">Pay Now</button>
      </div>
    </div>
  </div>
</div> -->

<script>
$(function(){
    $('.dtp').datepicker({//startView:1,
                            autoclose:true,
                            format: 'mm-yyyy',
                            viewMode: "months", 
                            minViewMode: "months",
                            clearBtn: true});

    $('#dt_table').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            "pageLength",
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                },
                customize: function (doc) {
                    doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                }
            }
        ],
        order: [[ 0, "desc" ]]
    }); 

    $(document).on('click','.paymodal',function(){
        //console.log($(this).data('payslipid'));
        $('#selectAccount').find('#payslip_id').val($(this).data('payslipid'));
    });

    $(document).on('click','.paynow',function(){
        $modal = $(this).closest('.modal');
        payslip_id = $modal.find('#payslip_id').val();
        $.ajax({
            type:'post',
            url:"<?php echo base_url('index.php?fees/main/paynow')?>",
            data:{payslip_id:payslip_id},
            success:function(data){
                if($.trim(data)=='success'){
                    swal('Success','Salary Paid','success');
                    $modal.modal('hide')
                    window.location.reload();
                }
            }
        });
    });
});
</script>