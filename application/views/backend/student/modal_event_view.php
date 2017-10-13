<div id='fullCalModal' class="panel panel-default">
    <div class='row'>
        <div class="col-md-12">
            <div class='col-md-12'>
                <h4><i class="fa fa-globe m-r-5"></i><b> Event Name:</b></h4>
                <p> <span id='modalTitle' class="m-l-30"><?php echo $event->title; ?></span>
                </p>
            </div>
            <div class='col-md-12'>
                <h4><i class="fa fa-calendar m-r-5"></i><b> Event Date:</b></h4>
                <p class="m-l-30"> <span id='startTime' class="start-time"> <?php echo $event->start; ?> </span>  
                    To  <span id='endTime' class="end-time"><?php echo $event->end; ?> </span>
                </p>   
            </div> 
            <div class='col-md-12'>	
                <div id='imageDiv'> </div>
                <br/>
                <h4><i class="fa fa-file-text-o m-r-5"></i><b> DESCRIPTION:</b></h4>
                <p id='modalBody' class="desc-event teacher-word-break m-l-30"><?php echo $event->description; ?></p>
            </div>
        </div>
    </div>
</div> 
