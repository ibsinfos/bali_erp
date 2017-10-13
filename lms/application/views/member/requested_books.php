<?php $this->load->view('member/theme_member/message'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1> <?php echo $this->lang->line("my requested books"); ?></h1>

</section>


<!-- Main content -->
<section class="content">  
  <div class="row">
    <div class="col-xs-12">
        <div cclass="easyui-layout" fit="true" style="width:100%; height:530px;" >
            <table style="border:1px solid #ccc; height:auto px !important;"
            id="tt"  
            class="easyui-datagrid" 
            url="<?php echo base_url()."member/requested_books_data"; ?>" 

            pagination="true" 
            rownumbers="true" 
            toolbar="#tb" 
            pageSize="10" 
            pageList="[5,10,20,50,100]"  
            fit= "true" 
            fitColumns= "true" 
            nowrap= "true" 
            view= "detailview"
            idField="id"
            >

            <!-- url is the link to controller function to load grid data -->
            
                <thead>
                    <tr>
                        <th width="50px" field="book_title" sortable="true"><?php echo $this->lang->line("title"); ?></th>
                        <th width="50px" field="author" sortable="true" ><?php echo $this->lang->line("author"); ?></th>                                      
                        <th width="50px" field="edition" sortable="true" ><?php echo $this->lang->line("edition"); ?></th>                                      
                         <th width="50px" field="view" formatter='action_column'><?php echo $this->lang->line("status"); ?></th>               
                    </tr>
                </thead>
            </table>                        
         </div>
  
       <div id="tb" style="padding:3px">

       <?php $this->load->view("member/theme_member/submenu"); ?>
           
              
            <form class="form-inline" style="margin-top:20px">
               
                <div class="form-group">
                    <input id="book_title" name="book_title" class="form-control" size="20" placeholder="<?php echo $this->lang->line("title"); ?>">
                </div>

                <div class="form-group">
                    <input id="author" name="author" class="form-control" size="20" placeholder="<?php echo $this->lang->line("author"); ?>">
                </div>   
                 
				 <div class="form-group">
                    <?php 
                      $status=array(''=>'Status','accepted'=>'Accepted','rejected'=>'Rejected','pending'=>'Pending');
                      echo form_dropdown('status',$status,"",'class="form-control" id="status"'); 
                    ?>
                </div>
                <button class='btn btn-info'  onclick="doSearch(event)"><?php echo $this->lang->line("search"); ?></button>    
                      
            </form> 

        </div>        
    </div>
  </div>   
</section>


<script>       
    var base_url="<?php echo site_url(); ?>"

    function action_column(value, row, index)
    {
    	var status = row.request_status;
    	var str = "";

    	if(status == "Accepted")
    	str = str+"<label class='label label-success'>"+'<?php echo $this->lang->line("accepted"); ?>'+"</label>";    	

    	if(status == 'Pending')
    		str = str+"<label class='label label-warning'>"+'<?php echo $this->lang->line("pending"); ?>'+"</label>";

    	if(status == 'Rejected')
    		str = str+"<label class='label label-danger'>"+'<?php echo $this->lang->line("rejected"); ?>'+"</label>";

    	return str;

    }    
   
      
    function doSearch(event)
    {
        event.preventDefault(); 
        $j('#tt').datagrid('load',{        
          book_title:       $j('#book_title').val(),
          author:           $j('#author').val(),           
          status:           $j('#status').val(),           
          is_searched:      1
        });


    }  
    

</script>
