 <div class="panel panel-success" data-collapsed="0" style="margin-bottom:0px; border-color:#ddd;">
                <div class="panel-heading">
                    <div class="panel-title" >
                        <i class="entypo-info"></i>
                        <?php echo get_phrase('transport_routes'); ?>
                    </div>
                </div> 
      <div class="panel-body">
<?php 

$routes=  get_data_generic_fun('transport','transport_id,route_name',array(),"arr");
foreach($routes as $route):?>
          <input type="radio" name="route" id="route" onchange="get_bus_stops()" value="<?php echo $route['transport_id'];?>"><?php echo $route['route_name'];?><br>  
<?php endforeach;?>
          <span id="bus_stop_id"></span>
<button type="button" name="route_button" onclick="set_route()" id="route_button" >Add</button>
<br>
<span id="success" style="color:red"></span>
      </div>
 </div>
<script>
function set_route(){
      var route_bus_stop_id = $("#bus_stop_id option:selected").val();
      var student_id = <?php echo $param2; ?>;
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?school_admin/add_student_bus_enquiry/' + student_id + '/' + route_bus_stop_id,
                success: function (response)
                {

                    jQuery('#success').html(response);
                },
        error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
            });
        }
        function get_bus_stops(){
      var route_id = $('input[name="route"]:checked').val();
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?ajax_controller/get_bus_stop/' + route_id,
                success: function (response)
                {

                    jQuery('#bus_stop_id').html(response);
                },
        error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
            });
        }
</script>
    