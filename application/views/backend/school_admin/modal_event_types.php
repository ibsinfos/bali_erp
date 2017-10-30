<section>
<div class="sttabs tabs-style-flip">
    <nav>
        <ul>
            <li id="section1">
                <a href="#section-flip-1" class="sticon fa fa-list "data-step="5" data-intro="Here you can see class list." data-position='right'><span>
                <?php echo get_phrase('event_categories');?></span></a>
            </li>
            <li id="section2">
                <a href="#section-flip-2" class="sticon fa fa-plus" data-step="6" data-intro="From here you can add a class." data-position='left'>
                    <span><?php echo get_phrase('add_event_category');?></span>
                </a>
            </li>
        </ul>
    </nav>                                    
    <div class="content-wrap">
        <section id="section-flip-1">
            <table id="example23" class="table display m-t-20">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Category</th>  
                        <th>Action</th>            
                    </tr>
                </thead>
                
                <tbody>           
                    <?php $count = 1; 
                    foreach ($event_types as $etype): ?>
                    <tr>
                        <td><?php echo $count?></td>
                        <td><?php echo $etype['title'];?></td>        
                        <td>
                            <a href="javascript: void(0);" onclick="showAjaxModal('<?php echo base_url('index.php?modal/popup/modal_events/'. $etype['title'])?>');">
                                <button type="button" class="btn btn-default btn-outline btn-circle m-r-5 tooltip-danger" data-toggle="tooltip" 
                                    data-placement="top" data-original-title="View Events">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </a>
                            <a href="javascript: void(0);" onClick="delete_event_type(<?php echo $etype['id']?>)">
                                <button type="button" class="btn btn-default btn-outline btn-circle m-r-5 tooltip-danger" data-toggle="tooltip" 
                                data-placement="top" data-original-title="Delete Category"><i class="fa fa-trash-o"></i></button>
                            </a>
                        </td>              
                    </tr>            
                    <?php $count++; endforeach; ?>    
                </tbody>    
            </table>
        </section>

        <section id="section-flip-2">
            <div class="row">
                <div class="col-md-12" id="add-type">
                    <div class="form-group">
                        <form class="form-material">
                            <label class="control-label">Event Category</label>
                            <input class="form-control form-white" placeholder="Category Name" type="text" name="category-name" id="category-name"  />
                        </form>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <label class="control-label">Choose Event Color</label>
                    <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color" id="category-color">
                        <option value="success">Success</option>
                        <option value="danger">Danger</option>
                        <option value="info">Info</option>
                        <option value="primary">Primary</option>
                        <option value="warning">Warning</option>
                    </select>
                </div> -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group text-right">
                        <button type="button" class="fcbtn btn btn-danger btn-outline btn-1d save-category">Add</button>
                    </div>
                </div>
            </div>
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

var example23_getrow = $('#example23').DataTable({
        dom: 'frtip',
        responsive: true,
        buttons: [
            "pageLength",
            'excel', 'pdf', 'print'
        ]
    });  

example23_getrow.$('tr').tooltip( {selector: '[data-toggle="tooltip"]'});

function check(){    
    var parent_email = $("input[name='parent_id']:checked").val();    
    $("#parent").val(parent_email);
    $("#parent_email").val(parent_email);
    $.ajax({
        type: "POST",
        //url: "index.php?school_admin/student_add",
        data: { parent_email : 'parent_email'},            
        dataType: "html",
        success: function(data){         
            $("#parent").val(parent_email);
            $("#modal_ajax").modal('hide');            
        },
        error: function(data){
            console.log('error');
        }
    });        
}
</script>

