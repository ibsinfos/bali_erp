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
            <form method="post" action="<?php echo base_url('index.php?fees/main/approved_payslips')?>">
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
                    <th><div><?php echo get_phrase('acc_no.');?></div></th>
                    <th><div><?php echo get_phrase('generate_day.');?></div></th>
                    <th><div><?php echo get_phrase('salary');?></div></th>
                    <th><div><?php echo get_phrase('net_pay');?></div></th>
                    <th><div><?php echo get_phrase('Action');?></div></th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;
                foreach ($approved_payslips as $row): ?>
                    <tr>
                        <td><?php echo $row->employeeId;?></td>
                        <td><?php echo $row->userfullname; ?></td>
                        <td><?php echo $row->emprole_name;?></td>
                        <td><?php echo $row->accountnumber;?></td>
                        <td><?php echo $row->generate_date;?></td>
                        <td><?php echo decrypt_salary($row->salary);?></td>
                        <td><?php echo $row->net_pay;?></td>
                        <td>
                            <a href="<?php echo base_url('index.php?fees/prints/employee_payslip/'.$row->payslip_id)?>" class="btn btn-primary btn-xs" target="_blank">
                                <i class="fa fa-eye"></i> View Paylip
                            </a>  
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

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
});
</script>