
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"><h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" onclick="javascript:introJs().start();" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?parents/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active"><?php echo get_phrase($page_title); ?></li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<div class="panel panel-danger block6" data-step="5" data-intro="<?php echo get_phrase('For Information');?>" data-position='top'>
    <div class="panel-heading"> Progress Report Notes
        <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
            <p><b>Exceeding Level (Ex):</b> The Child is able to understand, apply  and complete the expected task independently.</p>
            <p><b>Expected Level (Exp):</b>The child is able to understand and complete the expected task independently.</p>
            <p><b>Emerging Level (Em):</b>The child needs assistance to understand and complete the expected task.</p>
        </div>
    </div>
</div>
<div class="badge badge-danger badge-stu-name pull-right m-b-20">
            <i class="fa fa-user"></i> <?php echo $student_name; ?>
        </div>
   <div class="col-md-12 white-box no-padding">
        <div class="col-sm-4 form-group">
            <label class="control-label"><?php echo get_phrase('select_term'); ?></label>
            <select id="term_holder" name="term_id" class="selectpicker class_id" data-style="form-control" data-live-search="true">
                <option value="">Select Term</option>
                <?php
                foreach ($term_list as $row):
                    ?>
                    <option <?php
                    if ($selected_term == $row['term_id']) {
                        echo "selected='selected'";
                    }
                    ?> value="<?php echo $row['term_id']; ?>">
                        <?php echo $row['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
         <div class="col-sm-4 form-group">
            <label class="control-label"><?php echo get_phrase('select_assessment'); ?></label>
            <select id="heading_holder" name="assessment_id" class="selectpicker" data-style="form-control" onchange="onheadingchange(this);" ><option value="" data-live-search="true">Select Assessment</option>
                <?php foreach ($headings as $row) { ?>
                    <option value="<?php echo $row['heading_id'] ?>" <?php if ($selected_heading == $row['heading_id']) echo "selected"; ?>><?php echo $row['heading_description']; ?></option>';
                    ?>

                <?php } ?>
            </select>
        </div>
   </div>

<div class="row" id="print">
    <div class="col-md-12">
        <div class="white-box table-responsive" data-step="6" data-intro="<?php echo get_phrase('This is showing Progress Report Details');?>" data-position='top'>
            <?php
            if(!empty($progress_report_detail)){
            $i = 1;
            $k = "";
             $datatable  =       "";
            foreach ($progress_report_detail as $heading_key=>$details):
if($i==1){
    $datatable_id = "example23";
}else{
    $datatable_id = '';
}                 
                ?>
                <table class="table table-bordered table-condensed table-for-report" id="<?php echo $datatable_id?>">
                    <thead>
                        <tr>
                            <th width="10%"><b>Teacher Name</b></th>
                            <th width="5%" class="text-center"><b><?php echo $i; ?></b></th>
                            <th width="50%"><b><?php echo $details['description']; ?></b></th>
                            <th class="text-center" colspan="3" width="10%"><b>Rating</b></th>
                            <th class="text-center" width="10%"><b>Comment</b></th>
                            <th width="10%" class='text-center'><b>Date</b></th>
                            <th width="10%" class="to_remv"><b>All Report</b></th>
                        </tr>    
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($details['category'])):
                            $j = 1;
                            foreach ($details['category'] as $category_key=>$cate):
                                ?>
                                <tr>   
                                    <?php
                     $count_row = count($progress_report_detail[$heading_key]['category'][$category_key]['subcategory_desc']);              
                                    ?>
                                    <td rowspan="<?php echo $count_row + 1; ?>">
                                        <?php
                                        echo $progress_report_detail[$heading_key]['category'][$category_key]['subcategory_desc'][0]['teacher_name'];
                                        ?>
                                    </td>
                                    <td class="text-center"><?php echo $i . "." . $j; ?></td>
            <?php echo "<td><h5>" . $cate['cat_description'] . "</h5></td>"; ?>             
                                    <td class="text-center">Ex</td>
                                    <td class="text-center">Exp</td>
                                    <td class="text-center">Em</td>
                                    <td colspan="3" class="to_remv"></td>
                                </tr>
            <?php
                 if ($progress_report_detail[$heading_key]['category'][$category_key]['subcategory_desc'] != '') {
                    $k = 1;
                    foreach($progress_report_detail[$heading_key]['category'][$category_key]['subcategory_desc'] as $row_sub_des):
                        echo "<tr><td class='text-center'>".$k."</td><td>" . $row_sub_des['sub_desc'] . "</td>";
                        if(!empty($row_sub_des)){
                            if ($row_sub_des['ex'] != '')
                                echo "<td class='text-center'><input type='checkbox' value='1' checked='checked' disabled></td>";
                            else
                                echo "<td class='text-center'><input type='checkbox' value='1' disabled></td>";
                            if ($row_sub_des['exp'] != '')
                                echo "<td class='text-center'><input type='checkbox' value='1' checked='checked' disabled></td>";
                            else
                                echo "<td class='text-center'><input type='checkbox' value='1' disabled></td>";

                            if ($row_sub_des['em'] != '')
                                echo "<td class='text-center'><input type='checkbox' value='1' checked='checked' disabled></td>";
                            else
                                echo "<td class='text-center'><input type='checkbox' value='1' disabled></td>";

                            if ($row_sub_des['comment'] != '')
                                echo "<td class='text-center'>" . $row_sub_des['comment'] . "</td>";
                            else
                                echo "<td></td>";
                            if ($row_sub_des['date'] != '')
                                echo "<td class='text-center'>" . $row_sub_des['date'] . "</td>";
                            else
                                echo "<td></td>";
                            ?>
                                            <td align="center" class='to_remv' >
                                                <a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url() . 'index.php?modal/get_progress_report/' . $student_id . '/' . $row_sub_des['sub_category_id'].'/'.$selected_term ?>');"><button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View History"><i class="fa fa-eye"></i></button></a></td>
                                            <?php
                                            }else {
                                                echo "<td class='text-center'><input type='checkbox' value='1' disabled></td>";
                                                echo "<td class='text-center'><input type='checkbox' value='1' disabled></td>";
                                                echo "<td class='text-center'><input type='checkbox' value='1' disabled></td>";
                                                echo "<td class='text-center'></td>";
                                                echo "<td class='text-center'></td>";
                                                ?><td align="center" class='to_remv'> <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="View History" disabled=""><i class="fa fa-eye"></i></button></td>
                                        <?php
                                        }
                                        $k = $k + 1;
                                        ?>
                                        </tr><?php endforeach; ?>
                                                <?php
                                            }
                                   
                                        $j = $j + 1;
                                        //break;
                                    endforeach;
                                endif;
                                ?>                 	
                    </tbody>
                </table>
                <div class="text-right">
                <?php if (!empty($progress_report_detail)) { ?>
                    <button value="Print" id="print_button" onclick="PrintElem('#print');" class="fcbtn btn btn-danger btn-outline btn-1d"> Print </button>
                <?php } ?>    
            </div> 
    <?php $i = $i + 1; ?>
            <?php endforeach; ?>
            <?php }else{
                echo "No Data Available";
            }
?>
            
            
        </div>
    </div>
</div>          



<script type="text/javascript">
 function onheadingchange(heading_id)
    {
        var student_id = <?php echo $student_id; ?>
        // remove the below comment in case you need chnage on document ready
        var heading = $("#heading_holder option:selected").val();
        var term = $("#term_holder option:selected").val();
        location.href = "<?php echo base_url(); ?>index.php?parents/progress_report_heading_wise/"+ student_id + "/" + heading + "/" +term;
    }
 
 
    function PrintElem(elem)
    {

        Popup($(elem).html());
    }

    function Popup(allData)
    {
        //alert(allData);
        var systemName = "<?php echo $system_name ?>";
        var phraseName = "<?php echo get_phrase('progress_detail'); ?>";
        var stName = "<?php echo $student_name; ?>";
        var baseUrl = "<?php echo base_url(); ?>";

        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');

        mywindow.document.write('</head><body ><center><img src="' + baseUrl + 'uploads/logo.png" width="100" style="max-height : 60px;"><br><h3 style="font-weight: 100; font-weight:bold;">' + systemName + '</h3>' + phraseName + '<br>' + stName + '<br/><br/></center>');
        mywindow.document.write('<style>.print{border : 1px;}.to_remv{display:none;}</style>');
        mywindow.document.write(allData);
        mywindow.document.write('</body></html>');
        var tables = mywindow.document.getElementsByTagName("table");
        for (var i = 0; i < tables.length; i++) {
            tables[i].setAttribute('cellspacing', '0');
            tables[i].setAttribute('cellpadding', '5');
            tables[i].setAttribute('border', '1');
        }

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10
        mywindow.print();
        mywindow.close();

        return true;
    }
</script>
