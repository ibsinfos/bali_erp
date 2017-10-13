<div class="row bg-title"> 
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
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
    <!-- /.breadcrumb -->
</div>


<div class="row">
    <div class="col-md-12">
        <div class="white-box">

            <section>
                <div class="sttabs tabs-style-flip">
                    <nav>
                        <ul>

                            <li id="section1" data-step="5" data-intro="<?php echo get_phrase('From here you can view the List of holidays.');?>" data-position="top"><a href="#section-flip-1" class="sticon fa fa-list"><span><?php echo get_phrase('holiday_list'); ?></span></a></li>
                            <li id="section2" data-step="6" data-intro="<?php echo get_phrase('From here you can add a new holiday.');?>" data-position="top"><a href="#section-flip-2" class="sticon fa fa-plus"><span><?php echo get_phrase('add_holiday'); ?></span></a></li>
                        </ul>
                    </nav>

                    <div class="content-wrap">
                        <section id="section-flip-1">

                            <!----TABLE LISTING STARTS-->
                            <div class="tab-pane box active for-table-top" id="list">
                                <table class= "custom_table table display"  id="example23">
                                    <thead>
                                        <tr>
                                            <th><div><?php echo get_phrase('sl_no'); ?></div></th>
                                            <th><div><?php echo get_phrase('holiday'); ?></div></th>
                                            <th><div><?php echo get_phrase('start_date'); ?></div></th>
                                            <th><div><?php echo get_phrase('end_date'); ?></div></th>
                                            <th><div><?php echo get_phrase('status'); ?></div></th>
                                            <th data-step="7" data-intro="<?php echo get_phrase('From here you can edit or delete a holiday.');?>" data-position="top"><div><?php echo get_phrase('option'); ?></div></th>
                                        </tr>
                                    </thead>
                                    <tbody><?php
                                        if (count($holidays)) { $n = 1;
                                            foreach ($holidays as $holiday):
                                                ?>
                                                <tr>
                                                    <td><?php echo $n++; ?></td>
                                                    <td><?php echo $holiday['title']; ?></td>
                                <td><?php echo $holiday['date_start'];?></td>
                                <td><?php echo date('Y-m-d', strtotime($holiday['date_start']. ' + '.($holiday['number_of_days']-1).' days')); ?></td>
                                <td><input class="toggleswith" id="holiday_<?php echo $holiday['id'];?>" type="checkbox" <?php if($holiday['is_active']==1){echo "checked"; }?> data-toggle="toggle"></td>

                                <td>
                                <!-- edit -->
                                    <a onclick="showAjaxModal('<?php echo base_url(); ?>index.php?modal/popup/modal_edit_holiday/<?php echo $holiday['id']; ?>');">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Edit Holiday" title="Edit Holiday"><i class="fa fa-pencil-square-o"></i></button>
                                    </a>
                                <!-- delete -->
                                    <a onclick="confirm_modal('<?php echo base_url(); ?>index.php?school_admin/delete_holiday/<?php echo $holiday['id'];?>');">
                                        <button type="button" class="btn btn-default btn-outline btn-circle btn-lg m-r-5 tooltip-danger" data-toggle="tooltip" data-placement="top" data-original-title="Delete Holiday" title="Delete Holiday"><i class="fa fa-trash-o"></i></button>
                                    </a>
                                </td>
                                                </tr><?php
                                            endforeach;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <!----TABLE LISTING ENDS--->   
                        </section>

                        <section id="section-flip-2">
                            <!----CREATION FORM STARTS---->

                            <form class="form-horizontal form-groups-bordered validate" name='add_exam_form' id="add_exam_form" method="post" action="<?php echo base_url(); ?>index.php?school_admin/save_holiday_list/indian">

                                <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label>
                                            <?php echo get_phrase('title'); ?>
                                            <span class="mandatory"> *</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-book"></i></div>
                                            <input type="text" class="form-control" name="title" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"/>
                                        </div>
                                        <label class="mandatory"> <?php echo form_error('name'); ?></label>
                                    </div> 
                                </div>

                                <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label>
                                            <?php echo get_phrase('date'); ?>
                                            <span class="error" style="color: red;"> *</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon" id="exam_date"><i class="fa fa-calendar"></i></div>
                                            <input type="text" required="required" class="form-control" id="datepicker" name="date" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_required_value');?>"/>
                                                      
                                        </div>
                                        <label class="mandatory"> <?php echo form_error('date'); ?></label>
                                    </div>
                                </div>


                                <div class="row">          
                                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                                        <label>
                                            <?php echo get_phrase('number_of_days'); ?>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-comment"></i></div>
                                            <input type="text" class="form-control" name="number_of_days" data-validate="required" data-message-required="<?php echo get_phrase('please_enter_required_value'); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d">
                                        <?php echo get_phrase('add_holiday'); ?>
                                    </button>
                                </div>

                            </form>

                            <!----CREATION FORM ENDS-->   
                        </section>
                    </div>

                </div>

            </section>
        </div>
    </div>
</div>
<!-- <select id="selectCountry">
    
    <option value="">select</option>
    <option value="indian">India</option>
  </select> -->
<script type="text/javascript">
    $("#selectCountry").change(function(e) {
  $("#output").html("Loading...");
  var country = $("#selectCountry").val();
  var calendarUrl = 'https://www.googleapis.com/calendar/v3/calendars/en.' + country 
                  + '%23holiday%40group.v.calendar.google.com/events?key=AIzaSyDYfODXDnw3A0BvfH_yDXU9TnGOs8_VErw';

  $.getJSON(calendarUrl)
    .success(function(data) {
        console.log(data);
                      $("#output").empty();
                      for (item in data.items) {
                          $.ajax({
                              type: 'POST',
                              url: '<?php echo base_url(); ?>index.php?school_admin/save_holiday_list/' + country,
                              data: {
                                  title: data.items[item].summary,
                                  date: data.items[item].start.date
                              },
                              success: function (response) {
                                  console.log(response);
                              },
                              error: function () {
                                 console.log('error');
                              }
                          });
                      }
                  })
                  .error(function (error) {
                      $("#output").html("An error occurred.");
                  })
      });
      $("#selectCountry").trigger("change");
    $('.toggleswith').click(function() {
   var id = $(this).attr('id');  //-->this will alert id of checked checkbox.
       if(this.checked){
            $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>index.php?school_admin/activate_holiday/'+id,
                //data: $(this).attr('id'), //--> send id of checked checkbox on other page
                success: function(data) {
                    //alert('it worked');
                    //alert(data);
                    $('#container').html(data);
                },
                 error: function() {
                    //alert('it broke');
                },
                complete: function() {
                    //alert('it completed');
                }
            });

            }
            else
            {
                $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>index.php?school_admin/deactivate_holiday/'+id,
               // data: $(this).attr('id'), //--> send id of checked checkbox on other page
                success: function(data) {
                    console.log('it worked');
                    console.log(data);
                    //$('#container').html(data);
                },
                 error: function() {
                    //alert('it broke');
                },
                complete: function() {
                    //alert('it completed');
                }
            });
            }
      });
  </script>


