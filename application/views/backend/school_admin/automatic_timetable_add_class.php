<script> var siteBaseURL='<?php echo base_url();?>';</script>
<div class="row bg-title">
    <!-- .page title -->
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase($page_title); ?> </h4></div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
    <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);"  onclick="javascript:introJs().start();" id="take-tour"  class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?school_admin/dashboard"><?php echo get_phrase('dashboard'); ?></a></li>
            <li><?php echo get_phrase('automatic_timetable'); ?>
                <ul>                    
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/automatic_timetable_teacher_priority"><?php echo get_phrase('set_teacher_priority'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/automatic_timetable_create_week_structure"><?php echo get_phrase('create_week_structure'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>index.php?school_admin/class_routine_views"><?php echo get_phrase('show_timetable'); ?></a></li>  
                </ul>
            </li>
            <li class="active">
                <?php echo get_phrase('week_structure'); ?>
            </li>
        </ol>

    </div>
    <!-- /.breadcrumb -->
</div>
<?php// pre($subject_data_arr);die;?>
<div class="col-xs-12 white-box">
    <input type="hidden" name="running_year" id="running_year" value="<?php echo $running_year;?>">
    <input type="hidden" name="year" id="year" value="<?php echo $running_year;?>">
    <div class="form-group col-sm-4" data-step="5" data-intro="Select a teacher, then you will get a list of all classes with their all subjects." data-position='right'>
        <label class="control-label"><?php echo get_phrase('select_class'); ?></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true" id="class" onchange="changeClass()" disabled="">
            <option value=""><?php echo get_phrase('select'); ?></option>
            <?php foreach ($class_data_arr AS $cl):?>
            <option value="<?php echo $cl->class_id;?>" <?php echo ($cl->class_id==$class_id)?'selected':'';?>><?php echo $cl->name; ?></option>
            <?php endforeach;?>
        </select>
    </div>

    <div class="col-sm-4 form-group" data-step="6" data-intro="<?php echo get_phrase('Select a class, then you will get a list of all subjects.');?>" data-position='right'>
        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('select_section'); ?></label><span class="error" style="color: red;"></span>

        <select class="selectpicker" data-style="form-control" data-live-search="true" id="section" onchange="changeSection()" disabled="">
            <option value=""><?php echo get_phrase('select'); ?></option>
            <?php foreach ($section_data_arr AS $cl):?>
            <option value="<?php echo $cl->section_id;?>" <?php echo ($cl->section_id==$section_id)?'selected':'';?>><?php echo $cl->name; ?></option>
            <?php endforeach;?>
        </select>
    </div>

    <div class="form-group col-sm-4" data-step="7" data-intro="<?php echo get_phrase('Select a subject for set a priority.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('select_subject'); ?></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true" id="subject" onchange="changeSubject()" disabled="">
            <option value=""><?php echo get_phrase('select'); ?></option> 
            <?php foreach ($subject_data_arr AS $cl):?>
            <option value="<?php echo $cl->subject_id;?>" <?php echo ($cl->subject_id==$subject_id)?'selected':'';?>><?php echo $cl->name; ?></option>
            <?php endforeach;?>
        </select>
    </div>

    <div class="form-group col-sm-4" data-step="8" data-intro="<?php echo get_phrase('Select a priority to set.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('start_time'); ?></label>
        <select class="form-control" id="sTime" onchange="changeSTime()">
            <option value=""><?php echo get_phrase('select'); ?></option>            
        </select>
    </div>

    <div class="form-group col-sm-4" data-step="8" data-intro="<?php echo get_phrase('Select a priority to set.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('end_time'); ?></label>
        <select class="form-control" id="eTime">
            <option value=""><?php echo get_phrase('select'); ?></option>            
        </select>
    </div>

    <div class="form-group col-sm-4" data-step="8" data-intro="<?php echo get_phrase('Select a priority to set.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('duration_(in_minutes)'); ?></label>
        <select class="form-control" id="tSteps">
            <option value=""><?php echo get_phrase('select'); ?></option>  
            <option value="30">30</option>
            <option value="60">60</option>
        </select>
    </div>

    <div class="form-group col-sm-4" data-step="8" data-intro="<?php echo get_phrase('Select a priority to set.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('Number_of_classes'); ?></label>
        <input size="4" id="n_BLocks" class="form-control" value="2"/>
    </div>

    <div class="form-group col-sm-4" data-step="8" data-intro="<?php echo get_phrase('Select a priority to set.');?>" data-position='right'>
        <label class="control-label"><?php echo get_phrase('Maximum_number_of_continuous_classes'); ?></label>
        <input size="4" id="bSize" value="2" class="form-control"/>
    </div>

    
    <div class="col-sm-4 text-right">
        <button type="submit" class="fcbtn btn btn-danger btn-outline btn-1d" onclick="generate()"><?php echo get_phrase('add_timetable'); ?></button>
    </div>
<br>
    <div class="row text-right">
        <table id="att" class="pure-table" cellspacing="2" style="border-collapse: collapse;">
            <thead>
                
            </thead>
		<tbody></tbody>
		</table>
	</div>
<div class="row text-right padding-10">
    <button type="button" class="fcbtn btn btn-danger btn-outline btn-1d" id="saveButton" onclick="save()">Save</button>
    <button type="button" class="fcbtn btn btn-danger btn-outline btn-1d" onclick="location.href='<?php echo base_url()?>index.php?school_admin/automatic_timetable_create_week_structure';">Back</button>
</div>

</div>

<input type="hidden" name="running_year" id="running_year" value="<?php echo $running_year;?>">
<input type="hidden" name="year" id="year" value="<?php echo $running_year;?>">
<script type="text/javascript">
    $(document).ready(function(){
        console.log('$starttoData : '+'<?php echo $starttoData;?>');
        console.log('$starttoData : '+'<?php echo $endfromData;?>');
    });
function fillSelect(ajaxFunction, selectId, clearSelect, text, value, params, lastfunc)
{
	$.post({url:siteBaseURL+"index.php?automatic_timetable_ajax_controller/" + ajaxFunction,
		data: params,
		success: function(result)
		  {
		  	if(clearSelect)
		  		$('#'+selectId).empty()
		  	jsonResult = JSON.parse(result)
		  //	console.log(jsonResult)
		  	for (var i = 0; i<jsonResult.length; i++) {
		  		 $('#'+selectId).append("<option value='"+jsonResult[i][value]+"'>"+jsonResult[i][text]+"</option>")
		  	}
		  	 if (lastfunc != null)
		  	 {
		  	 	//debugger
		  	 	lastfunc()
		  	 }
			}
		}
	)
}

var ch = 0
function changeClass(atEnd)
{
  fillSelect("getSections", "section", true, "name", "id", 
		{class_id : $('#class').val()}
		,
	    function()
	    {
	    	ch++
	    //	console.log("ch = " + ch)
	    	changeSection(atEnd)
	    }
		)

}

function changeSection(atEnd)
{
	
  fillSelect("getSubjects", "subject", true, "name", "id", 
		{class_id : $('#class').val(),
         section_id : $('#section').val()
	    },
	    function()
	    {
	    	checkTableExists()	
	    	if(atEnd != null)
	    		atEnd()
	    }
		)
}

function changeSTime()
{
	$('#eTime').empty();
	var st = $('#sTime').val();
        console.log('st :: '+st);
	for (var i = st; i<='<?php echo $endfromData;?>'; i++) {
		$('#eTime').append("<option value='"+i+"'>"+i+":00</option>")
    }
}

// saves the current schedule
function save(){ //alert("bbb");
	var year = $('#year').val()
	var subject_id = $('#subject').val()
	var sTime = $('#sTime').val()
	var eTime = $('#eTime').val()
	var tStep = $('#tSteps').val()
	var nBlocks = $('#n_BLocks').val()
	var bSize = $('#bSize').val()

	$.post({url:siteBaseURL+"index.php?automatic_timetable_ajax_controller/setScheduleRestriction",
		data: {subject_id : subject_id,
			   year : year,
			   sTime : sTime,
			   eTime : eTime,
			   tStep : tStep,
			   nBlocks : nBlocks,
			   bSize : bSize,
			   week : week
		     },
		success: function(result){
                    //alert(result);
		  	//window.history.back()
                        location.href=siteBaseURL+'index.php?school_admin/automatic_timetable_create_week_structure';
		}
	}
	)

}

function getYears(newYear)
{
	$.ajax({url:siteBaseURL+"index.php?automatic_timetable_ajax_controller/getYears",
		success: function(result){
		  	$('#year').empty();
		  	if(newYear != null){
		  		//$('#year').append("<option value='"+newYear+"'>"+newYear+"</option>")
		  		$('#year').val(newYear);
		  	}
		  	/*jsonResult = JSON.parse(result)
		  	for (var i = 0; i<jsonResult.length; i++) {
		  		 $('#year').append("<option value='"+jsonResult[i].year+"'>"+jsonResult[i].year+"</option>")
		  	}*/

		  	//getClassRoutine() 

		  }
		}
		)
}

//var days = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];
var days = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];

//var nRows, nCols = 7;
var nRows, nCols = days.length;
week = []
function generate(){
    var error_str="";
    var error_state=false;
    if($('#sTime').val()==""){
        error_str+="Please select start time \n";
        error_state=true;
    }
    
    if($('#eTime').val()==" "){
        error_str+="Please select end time \n";
        error_state=true;
    }
    
    if($('#tSteps').val()==""){
        error_str+="Please select time duration \n";
        error_state=true;
    }
    
    if($('#n_BLocks').val().trim()==""){
        error_str+="Please enter number of classes \n";
        error_state=true;
    }
    
    if($('#bSize').val().trim()==""){
        error_str+="Please enter Maximum Number Of Continuous Classes \n";
        error_state=true;
    }
    
    if($('#n_BLocks').val().trim()<$('#bSize').val().trim()){
        error_str+="Kindly enter No. of continuous classes less than or equal to Number Of Classes \n";
        error_state=true;
    }
    
    if(error_state==true){
        EliminaTipo2(error_str,'error');
        return false;
    }
    $('#att thead').empty()
    $('#att tbody').empty()
    var header_row = "<tr><th style='border-bottom:1px solid #707cd2;'>&nbsp;</th>"
    for(var i = 0; i < days.length; i++){ 
            header_row += "<th onclick='changeCol("+i+")'>"+days[i]+"</th>";
        }
    header_row += "</tr>";
    //alert(header_row);
    $('#att thead').append(header_row)
    var t0 = parseInt($('#sTime').val())
    var t1 = parseInt($('#eTime').val())
    var step = parseInt($('#tSteps').val())

    t0 *= 60
    t1 *= 60

    var ii = 0

    //week = []

    while(t0 <= t1)
    {
            var h = Math.floor(t0 / 60)
            var m = t0 % 60

            var hs = h < 10 ? "0" + h : "" + h
            var ms = m < 10 ? "0" + m : "" + m

            var str = hs + ":" + ms

            var newrow = "<tr>"
            newrow += "<td onclick='changeRow("+ii+")' style='background-color:#ececec;'>" + str + "</td>"

            var week_row = []
            for(var i = 0; i < days.length; i++)
            {
                    var id = "cell_" + ii + "_" + i
                    newrow += "<td id='"+id+"' onclick='changeCell("+ii+","+i+")'>&nbsp;</td>"
                    week_row.push(true)
            }
            week.push(week_row)
            newrow += "</tr>"
    $('#att tbody').append(newrow)
            t0 += step
            ii++
    }
    nRows = ii
    paintCells()
    $('#saveButton').show()
    //debugger
}

function paintCells(){
    for(var i = 0; i < nRows; i++){
        for(var j = 0; j < days.length; j++){
            var id = "#cell_" + i + "_" + j
            var color = week[i][j] ? "green" : "red"
            $(id).css("background-color", color);
        }
    }
    $('#saveButton').show();
}

function changeCell(i, j)
{
	//alert(week[i][j])
	//debugger;
	week[i][j] = !week[i][j]
	//debugger;
	paintCells()
}

function changeRow(i)
{
	var total = 0
	var ontrue = 0
	for(var j = 0; j < days.length; j++)
	{
		total++
		if(week[i][j])
			ontrue++
	}
	var setTo = ontrue < total / 2
	for(var j = 0; j < days.length; j++)
		week[i][j] = setTo
	paintCells()
}

function changeCol(j)
{
	var total = 0
	var ontrue = 0
	for(var i = 0; i < nRows; i++)
	{
		total++
		if(week[i][j])
			ontrue++
	}
	var setTo = ontrue < total / 2
	for(var i= 0; i < nRows; i++)
		week[i][j] = setTo
	paintCells()
}

function changeSubject()
{
	checkTableExists()	
}

function setETime(){
    $('#eTime').empty();
    //alert("set");
    console.log("set");
    $('#eTime').append("<option value=' '>Select</option>");
    for (var i = <?php echo $starttoData;?>; i<=<?php echo $endfromData;?>; i++) {
	$('#eTime').append("<option value='"+i+"'>"+i+":00</option>")
    }
    console.log("unset");
    //$('#eTime').empty();
    /*for (var i = 7; i<=23; i++) {
	$('#eTime').append("<option value='"+i+"'>"+i+":00</option>")
    }*/
}

function checkTableExists(){
	var subject_id = $('#subject').val()
	var year = $('#year').val()
        
	$.post({url:siteBaseURL+"index.php?automatic_timetable_ajax_controller/getScheduleRestriction",
		data: {subject_id : subject_id,
			   year : year
		     },
		success: function(result)
		  { //alert(result);
		  	var jsonResult = JSON.parse(result)
		  	var info = jsonResult.info

		  	if(info.length == 0)
		  	{
		  		// clear it
				$('#saveButton').hide()
				$('#table thead').empty()
				$('#table tbody').empty()
				//changeSTime()
                                setETime();
		  	}
		  	else
		  	{
		  		info = info[0]
		  		var data = jsonResult.data
		  		var sTime = info.start_time
		  		var eTime = info.end_time
		  		var tSteps = info.time_step
		  		var nBlocks = info.nBlocks
		  		var bSize = info.block_size

		  		$('#n_BLocks').val(nBlocks)
		  		$('#bSize').val(bSize)
		  		$('#sTime').val(sTime)
		  		changeSTime()
		  		$('#eTime').val(eTime)
		  		$('#tSteps').val(tSteps)

		  		//debugger
		  		generate()

		  		if(week.length > 0)
		  		{
			  		for(var i = 0; i < nRows; i++)
			  		{
			  			for(var j = 0; j < days.length; j++)
			  			{
			  				week[i][j] = false
			  			}
			  		}

			  		for(var i = 0; i < data.length; i++)
			  		{
			  			var day = data[i].day
			  			var t0 = data[i].start_time
			  			var t1 = data[i].end_time

			  			var i0 = Math.floor((t0 - sTime * 60) / tSteps)
			  			var i1 = Math.floor((t1 - sTime * 60) / tSteps)

			  			for(var j = i0; j < i1; j++)
			  				week[j][day] = true
			  		}

			  		paintCells()		  		
			  	}
		  	}
		}
	}
	)
}

//getYears()  // gets the years using AJAX

for (var i = <?php echo $starttoData;?>; i<=<?php echo $endfromData;?>; i++) {
	$('#sTime').append("<option value='"+i+"'>"+i+":00</option>");
}

$(document).ready(function(){
    <?php if($action_type=='add'){?>
    $('#saveButton').hide();
    <?php }?>
    $('#saveButton').on('click',function(){
        var test="  MMM  ";
        console.log("="+test+"=");
        console.log("="+$.trim(test)+"=");
        var year = $('#year').val();
	var subject_id = $('#subject').val();
	var sTime = $('#sTime').val();
	var eTime = $('#eTime').val();
	var tStep = $('#tSteps').val();
	var nBlocks = $('#n_BLocks').val();
	var bSize = $('#bSize').val();
        
		//debugger;
        saveURL=siteBaseURL+"index.php?automatic_timetable_ajax_controller/setScheduleRestriction";
        //debugger;
        //alert(week);
        //debugger;
        //aa = week;
        //debugger;
        //ajaxData="subject_id="+subject_id+"&year="+year+"&sTime="+sTime+"&eTime="+eTime+'&tStep='+tStep+'&nBlocks='+nBlocks+'&bSize='+bSize+"&week="+week;
        //alert(ajaxData);
        $.ajax({
           url:saveURL,
           type:"POST",
           data :{subject_id : subject_id,
			   year : year,
			   sTime : sTime,
			   eTime : eTime,
			   tStep : tStep,
			   nBlocks : nBlocks,
			   bSize : bSize,
			   week : week
		     },
           success:function(msg){
               if(msg.trim()=='ok'){
                   swal({ 
                        //title: '<?php //echo $system_name;?>',
                         title: "Class time schedule updated successfully.",
                          type: "success" 
                        },
                        function(){
                          //window.location.href = 'login.html';
                          window.location.href=siteBaseURL+'index.php?school_admin/automatic_timetable_create_week_structure';
                      });
               }else{
                   console.log("="+msg+"=");
               }
           }
        });
        //debugger;
        //console.log(saveURL);
	/*$.post({url:"http://localhost/beta_merge/index.php?automatic_timetable_ajax_controller/setScheduleRestriction",
		data: {subject_id : subject_id,
			   year : year,
			   sTime : sTime,
			   eTime : eTime,
			   tStep : tStep,
			   nBlocks : nBlocks,
			   bSize : bSize,
			   week : week
		     },
		success: function(result){
                    alert(result);
		  	//window.history.back()
                        location.href=siteBaseURL+'index.php?school_admin/automatic_timetable_create_week_structure';
		}
	}
	);*/
    });
});
<?php
 if($subject_id != -1)
 {
 	?>
 	//$('#year').prop('disabled', true)
 	//$('#class').prop('disabled', true)
 	//$('#section').prop('disabled', true)
 	//$('#subject').prop('disabled', true)
checkTableExists();
setETime();
//changeSTime();
/*fillSelect("getClasses", "class", true, "name", "id", 
		null, function()
		{
		    $('#class').val(<?php //echo $class_id; ?>)
			changeClass(
				function()
				{
					$('#section').val(<?php //echo $section_id; ?>)
					changeSection(
						  function()
						  {
						  	$('#subject').val(<?php //echo $subject_id; ?>)
						  	checkTableExists()
						  }
						)

				}
				)
		}
		) 	

*/


 	<?php
 }
 else
 { ?>
changeSTime()
$('#saveButton').hide()
fillSelect("getClasses", "class", true, "name", "id", 
		null, function()
		{
			changeClass()
		}
		)


<?php

 }
?>
</script>