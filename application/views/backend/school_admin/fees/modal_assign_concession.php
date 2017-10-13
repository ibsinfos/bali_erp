<section>
<div class="sttabs tabs-style-flip">
    <nav>
        <ul>
            <li id="section1">
                <a href="#section-flip-1" class="sticon fa fa-list">
                    <span>
                        <?php if($record->type==1)
                                echo get_phrase('assigned_fee_groups');
                            else if($record->type==2)   
                                echo get_phrase('assigned_classes');
                            else if($record->type==3)   
                                echo get_phrase('assigned_students');?>
                    </span>
                </a>
            </li>
            <li id="section2">
                <a href="#section-flip-2" class="sticon fa fa-plus">
                    <span>
                        <?php if($record->type==1)
                                echo get_phrase('select_fee_groups');
                            else if($record->type==2)   
                                echo get_phrase('select_classes');
                            else if($record->type==3)   
                                echo get_phrase('select_students');?>
                    </span>
                </a>
            </li>
        </ul>
    </nav>                                    
    <div class="content-wrap">
        <section id="section-flip-1">
            <table class="table table-bordered modal-table">
                <thead>
                    <tr>
                        <th><?php echo get_phrase('no');?></th>
                        <th><?php echo get_phrase('name');?></th>
                        <?php if($record->type==3){?>
                            <th><?php echo get_phrase('class');?></th>
                            <th><?php echo get_phrase('phone');?></th>
                            <th><?php echo get_phrase('email');?></th>
                        <?php }?>      
                        <th><?php echo get_phrase('Action');?></th>   
                    </tr>
                </thead>
                
                <tbody>    
                    <?php $count = 1;
                       if($record->type==1){
                        foreach ($sel_records as $rec): ?>
                            <tr>
                                <td><?php echo $count;?></td>
                                <td><?php echo $rec->name?></td>
                                <td>
                                    <?php $rem_url = base_url('index.php?fees/main/concession_rel_del/'.$rec->id.'/'.$record->id);?>  
                                    <a href="javascript:void(0)" onclick="confirm_act('<?php echo $rem_url?>',{reload:0,hide:0},false,this,'tr')">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                                        data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                    </a>
                                </td>
                            </tr>
                        <?php $count++; endforeach; ?>
                    <?php } else if($record->type==2){
                            foreach ($sel_records as $rec): ?>
                                <tr>
                                    <td><?php echo $count;?></td>
                                    <td><?php echo $rec->name?></td>
                                    <td>
                                        <?php $rem_url = base_url('index.php?fees/main/concession_rel_del/'.$rec->class_id.'/'.$record->id);?>  
                                        <a href="javascript:void(0)" onclick="confirm_act('<?php echo $rem_url?>',{reload:0,hide:0},false,this,'tr')">
                                            <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                                            data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                        </a>
                                    </td>
                                </tr>
                            <?php $count++; endforeach; ?>
                    <?php } else if ($record->type==3){
                        foreach ($sel_records as $rec): ?>
                            <tr>
                                <td><?php echo $count;?></td>
                                <td><?php echo $rec->name;?></td>
                                <td><?php echo $rec->class_name.'-'.$rec->section_name;?></td>
                                <td><?php echo $rec->phone;?></td>
                                <td><?php echo $rec->email;?></td>
                                <td>
                                    <?php $rem_url = base_url('index.php?fees/main/concession_rel_del/'.$rec->student_id.'/'.$record->id);?>  
                                    <a href="javascript:void(0)" onclick="confirm_act('<?php echo $rem_url?>',{reload:0,hide:0},false,this,'tr')">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" 
                                        data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                                    </a>
                                </td>
                            </tr>
                        <?php $count++; endforeach; ?>
                    <?php }?>    
                </tbody>    
            </table>
        </section>

        <section id="section-flip-2">
            <?php echo form_open(base_url('index.php?fees/main/concession_assign/'.$record->id));?>
            <table class="table table-bordered modal-table">
                <thead>
                    <tr>
                        <th><?php echo get_phrase('action');?></th>
                        <th><?php echo get_phrase('name');?></th>
                        <?php if($record->type==3){?>
                            <th><?php echo get_phrase('class');?></th>
                            <th><?php echo get_phrase('phone');?></th>
                            <th><?php echo get_phrase('email');?></th>
                        <?php }?>         
                    </tr>
                </thead>
                
                <tbody>    
                    <?php $count = 1;
                        if($record->type==1){
                            foreach ($rem_records as $rec): ?>
                                <tr>
                                    <td><input type="checkbox" name="items[]" value="<?php echo $rec->id?>"/></td>
                                    <td><?php echo $rec->name?></td>
                                </tr>
                            <?php $count++; endforeach; ?>
                    <?php } else if($record->type==2){
                            foreach ($rem_records as $rec): ?>
                                <tr>
                                    <td><input type="checkbox" name="items[]" value="<?php echo $rec->class_id?>"/></td>
                                    <td><?php echo $rec->name?></td>
                                </tr>
                            <?php $count++; endforeach; ?>
                    <?php } else if($record->type==3){
                        foreach ($rem_records as $rec): ?>
                            <tr>
                                <td><input type="checkbox" name="items[]" value="<?php echo $rec->student_id?>"/></td>
                                <td><?php echo $rec->name;?></td>
                                <td><?php echo $rec->class_name.'-'.$rec->section_name;?></td>
                                <td><?php echo $rec->phone;?></td>
                                <td><?php echo $rec->email;?></td>
                            </tr>
                        <?php $count++; endforeach; ?>
                    <?php }?>    
                </tbody>    
            </table> 
                        
            <?php if($rem_records){?>            
                <div class="row mt10">
                    <div class="col-md-12">
                        <div class="form-group text-right">
                            <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d"><?php echo get_phrase('save')?></button>
                        </div>
                    </div>
                </div>
            <?php }?>
            <?php echo form_close();?>
        </section> 
    </div>
</div>
</section>
<!-- <div class="row">
    <div class="col-md-12">
        <a href="#" data-toggle="modal" data-target="#add-type" class="btn btn-danger">
            <i class="fa fa-plus-circle"></i> Add Event Type 
        </a>
    </div>
</div>  -->

<script type="text/javascript"> 
$(function(){
    [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
        new CBPFWTabs(el);
    });
}); 

var example23_getrow = $('.modal-table').DataTable({
        dom: 'frtip',
        responsive: false,
        buttons: [
            "pageLength"
        ]
    });  

example23_getrow.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});
</script>

