<!--to be deleted-->
<?php
    $events=$this->db->get_where('events',array('id'=>$param2))->result_array();
    if(!empty($events))
    {
    $event=$events[0];
    }
 else {
        
 $event=$this->db->get_where('exam_routine',array('exam_routine_id'=>$param2))->result_array()[0];
 $event['start']=$event['start_datetime'];
              $time = new DateTime($event['start_datetime']);
                $time->add(new DateInterval('PT' . $event['duration'] . 'M'));
                $stamp = $time->format('Y-m-d H:i');
              $event['end']=$stamp;
              $event['description']="Room No: ".$event['room_no'];
              $event['title']="Exam";
 }
   ?>
    <div id='fullCalModal' class="panel panel-default">
		
				<div class='panel-heading'>
					
					<h4><i class='fa fa-calendar' aria-hidden='true'></i> EVENT DETAILS</h4>
				</div>
				
				<div class='panel-body'>
					
						<div class='col-md-12'>
							<h4><i class='fa fa-users' aria-hidden='true'></i> <span id='modalTitle'><?php echo $event['title']; ?></span></h4>
							<p><i class='fa fa-clock-o' aria-hidden='true'></i> <span id='startTime' class="start-time"> <?php echo $event['start']; ?> </span>  To  <span id='endTime' class="end-time"><?php echo $event['end']; ?> </span></p>
						</div>
						<div class='col-md-12'>	
							<div id='imageDiv'> </div>
							<br/>
							<h4><i class='fa fa-globe'></i> DESCRIPTION:</h4>
							 <p id='modalBody' class="desc-event"><?php echo $event['description']; ?></p>
						</div>
					
				</div>
	</div> 
