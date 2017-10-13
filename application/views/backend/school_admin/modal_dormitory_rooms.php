<div class="panel panel-success" data-collapsed="0" style="margin-bottom:0px; border-color:#ddd;">
    <div class="panel-heading">
        <div class="panel-title" >
            <i class="entypo-info"></i>
            <?php echo get_phrase('rooms_available'); ?>
        </div>
    </div> 
    <div class="panel-body">
        <?php   foreach($rooms as $room):?>
        <input type="radio" name="room" id="room" value="<?php echo $room['hostel_room_id'];?>"><?php echo $room['room_number'];?><br>  
        <?php endforeach;?>
        <button type="button" name="route_button" onclick="set_hostel()" id="route_button" >Add</button>
        <br>
        <span id="success" style="color:red"></span>
    </div>
 </div>

<script>
    function set_hostel(){
        var hostel_room_id = $('input[name="room"]:checked').val();
        var hostel_id = <?php echo $param2; ?>;
        var student_id = <?php echo $param3; ?>;
            $.ajax({
                url: '<?php echo base_url(); ?>index.php?school_admin/add_student_hostel_enquiry/' + hostel_id + '/' + student_id + '/' + hostel_room_id,
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
</script>
    