<?php //pre($generate_schedule);die;?>
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
                <?php echo get_phrase('create_schedule'); ?>
            </li>
        </ol>
    </div>
    <!-- /.breadcrumb -->
</div>
<?php// pre($subject_data_arr);die;?>

<div class="col-md-12 white-box">
    <div class="col-md-3">
        <select id="section_select" onchange="change_section()" class="form-control"> <!--class="selectpicker" data-style="form-control" data-live-search="true"-->
        </select>
    </div>

    <div class="col-md-3 text-right col-md-offset-4">
        <button type="button" class="fcbtn btn btn-danger btn-outline btn-1d" onclick="create()"><?php echo get_phrase('Create_timetable'); ?></button>
    </div>

    <div class="col-md-2 text-right">
        <button type="button" class="fcbtn btn btn-danger btn-outline btn-1d" onclick="fillTable()"><?php echo get_phrase('change_structure'); ?></button>
    </div>
</div>

<div class="col-xs-12 white-box">    
    <input type="hidden" name="running_year" id="running_year" value="<?php echo $running_year;?>">
    <input type="hidden" name="year" id="year" value="<?php echo $running_year;?>">
    <?php /*<div class="form-group col-sm-4" data-step="5" data-intro="Select a teacher, then you will get a list of all classes with their all subjects." data-position='right'>
        <label class="control-label"><?php echo get_phrase('select_class'); ?></label>
        <select class="selectpicker" data-style="form-control" data-live-search="true" id="class" >
            <option value="-1"><?php echo get_phrase('All'); ?></option>
            <?php foreach ($all_section AS $cl):?>
            <option value="<?php echo $cl['section_id'];?>"><?php echo $cl['class_name'].'('.$cl['section_name'].')'; ?></option>
            <?php endforeach;?>
        </select>
    </div>*/?>

    <div class="row">
        <form class="pure-form pure-form-aligned">
	<table id="table" class="pure-table table AttView">
	<thead>
	<tr>
		<th style='border-bottom:1px solid #fff;'>Time</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th><!--<th>Su</th>-->
	</tr>
	</thead>
	<tbody>
	</tbody>

	</table>

	</form>
    </div>
 
</div>

<input type="hidden" name="running_year" id="running_year" value="<?php echo $running_year;?>">
<input type="hidden" name="year" id="year" value="<?php echo $running_year;?>">
<script type="text/javascript">
var days = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
var sections = {}
var subjects = {}

function create()
{
    swal({
        title: "Are you sure?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes!",
        cancelButtonText: "Cancel",
        closeOnConfirm: true
    }, function(isConfirm){
      if (isConfirm) {
        var data = []
        for(var s_id in subjects)
        {    
            for(var d = 0; d < days.length; d++)
            {
                for(var i = 0; i < all_info.data.length; i++)
                {
                    var day_data = all_info.data[i][d]
                    if (day_data.length > 0)
                    {
                        for(var j = 0; j < day_data.length; j++)
                        {
                            if(day_data[j].subject_id == s_id)
                            {
                                var t0 = i
                                i++
                                while(i < all_info.data.length)
                                {
                                    day_data = all_info.data[i][d]
                                    if(day_data.length == 0) break
                                    var found = false
                                    for(var k = 0; k < day_data.length; k++)
                                    {
                                        if(day_data[k].subject_id == s_id)
                                        {
                                            found = true
                                            break
                                        }
                                    }
                                    if(!found)
                                        break
                                    i++
                                }
                                var t1 = i
                                var info = {
                                    class_id : subjects[s_id].class_id,
                                    section_id : subjects[s_id].section_id,
                                    subject_id: s_id,
                                    time_start: t0 * all_info.time_step + parseInt(all_info.min),
                                    time_end: t1 * all_info.time_step + parseInt(all_info.min),
                                    day: d,

                                }

                                data.push(info)
                                break
                            }

                        }
                    }
                }

            }
        }
        
        $.ajax({
            url:siteBaseURL+"index.php?automatic_timetable_ajax_controller/create_structure",
            data: {year : '<?php echo $year; ?>',data : data},
            type:"POST",
            success: function(result)
              {
                EliminaTipo2("Week structure created",'success');
            }
        });
      } else {
        return false;
      }
    });

    /*var data = []
 //  console.log(subjects)

    for(var s_id in subjects)
    {    
        for(var d = 0; d < 7; d++)
        {
            for(var i = 0; i < all_info.data.length; i++)
            {
                var day_data = all_info.data[i][d]
                if (day_data.length > 0)
                {
                    for(var j = 0; j < day_data.length; j++)
                    {
                        if(day_data[j].subject_id == s_id)
                        {
                            var t0 = i
                            i++
                            while(i < all_info.data.length)
                            {
                                day_data = all_info.data[i][d]
                                if(day_data.length == 0) break
                                var found = false
                                for(var k = 0; k < day_data.length; k++)
                                {
                                    if(day_data[k].subject_id == s_id)
                                    {
                                        found = true
                                        break
                                    }
                                }
                                if(!found)
                                    break
                                i++
                            }
                            var t1 = i
                            var info = {
                                class_id : subjects[s_id].class_id,
                                section_id : subjects[s_id].section_id,
                                subject_id: s_id,
                                time_start: t0 * all_info.time_step + parseInt(all_info.min),
                                time_end: t1 * all_info.time_step + parseInt(all_info.min),
                                day: d,

                            }

                            data.push(info)
                           // console.log(info)
                         //   debugger
                            break
                        }

                    }
                }
            }

        }
    }
    
    $.ajax({
        url:siteBaseURL+"index.php?automatic_timetable_ajax_controller/create_structure",
        data: {year : '<?php echo $year; ?>',data : data},
        type:"POST",
        success: function(result)
          {
            EliminaTipo2("Week structure created",'success');
            //jsonResult = JSON.parse(result)
            //console.log(result)
            //window.location = "timetable.html";
        }
    });*/

    /*$.post({url:siteBaseURL+"index.php?automatic_timetable_ajax_controller/create_structure",
        data: {year : '<?php echo $year; ?>',
            data : data
        },
        success: function(result)
          {
            alert("Week structure created")
            //jsonResult = JSON.parse(result)
            //console.log(result)
            window.location = "timetable.html";
        }
    })*/

}

function getSections()
{
	$.post({url:siteBaseURL+"index.php?automatic_timetable_ajax_controller/getSectionsFromYear",
		data: {year : '<?php echo $year; ?>'},
		success: function(result)
		  {
                      //alert(result);
		  	jsonResult = JSON.parse(result)

            //alert(jsonResult)

		  	for(var i = 0; i < jsonResult.length; i++)
		  	{
		  		var section_id = jsonResult[i].section_id
		  		var class_name = jsonResult[i].class_name
		  		var section_name = jsonResult[i].section_name
		  		sections[section_id]
		  		  =
		  		   {
		  		   	section_id : section_id,
		  		   	class_name : class_name,
		  		   	section_name : section_name,
		  		   }
		  	}
		  	console.log(sections)

		  //	debugger

		  	 $('#section_select').append("<option value='-1'>All</option>")

		  	for(var i in sections)
		  	{
		  		 $('#section_select').append("<option value='"+sections[i].section_id+"'>"+sections[i].class_name+"("+sections[i].section_name+")</option>")
		  	}

            getSubjects();

		  	//fillTable()
		  }
		}
		)
}

function getSubjects()
{
    $.ajax({
       url: siteBaseURL+"index.php?automatic_timetable_ajax_controller/getSubjectsFromYear",
       type :"POST",
       data:{year :'<?php echo $year; ?>'},
       success:function(result){
           //alert(result);
            jsonResult = JSON.parse(result)

            console.log(jsonResult)

            for(var i = 0; i < jsonResult.length; i++)
            {
                var subject_id = jsonResult[i].subject_id
                var class_name = jsonResult[i].class_name
                var section_name = jsonResult[i].section_name
                var subject_name = jsonResult[i].subject_name
                var section_id = jsonResult[i].section_id
                var class_id = jsonResult[i].class_id
                subjects[subject_id]
                  =
                   {
                    subject_id : subject_id,
                    section_id : section_id,
                    class_id   : class_id,
                    class_name : class_name,
                    section_name : section_name,
                    subject_name : subject_name,
                   }
            }
            fillTable();
       }
    });
    /*$.post({url:siteBaseURL+"index.php?automatic_timetable_ajax_controller/getSubjectsFromYear",
        data: {year : '<?php //echo $year; ?>'},
        success: function(result)
          {
            alert(result);
            jsonResult = JSON.parse(result)

            console.log(jsonResult)

            for(var i = 0; i < jsonResult.length; i++)
            {
                var subject_id = jsonResult[i].subject_id
                var class_name = jsonResult[i].class_name
                var section_name = jsonResult[i].section_name
                var subject_name = jsonResult[i].subject_name
                var section_id = jsonResult[i].section_id
                var class_id = jsonResult[i].class_id
                subjects[subject_id]
                  =
                   {
                    subject_id : subject_id,
                    section_id : section_id,
                    class_id   : class_id,
                    class_name : class_name,
                    section_name : section_name,
                    subject_name : subject_name,
                   }
            }


            fillTable()
          }
        }
        )
    */
}

var section_to_show = -1

function change_section()
{
	section_to_show = $('#section_select').val()
    rebuild_table()
}

function rebuild_table()
{
	$('#table tbody').empty()
  	var mintime = parseInt(all_info.min)
  	var maxtime = parseInt(all_info.max)
  	var time_step = parseInt(all_info.time_step)
  	var data = all_info.data
        //alert(data.length);
  	for(var i = 0; i < data.length; i++)
  	{
  		if ((i%2) == 0)
  			var bgcolor = '#99ffcc'
  		else
  			var bgcolor = '#4dffa6'

	  	var newrow = "<tr bgcolor='"+bgcolor+"'>"
	  	var time = mintime + i * time_step
	  	var h = Math.floor(time / 60)
	  	var m = time % 60
	  	var h_str = h < 10 ? "0" + h : "" + h
	  	var m_str = m < 10 ? "0" + m : "" + m
	  	var time_td = "<td bgcolor='#ececec' style='border:1px solid #fff; text-align: center;'>" + h_str+":"+m_str + "</td>"

	  	var td_day = []

	  	for(var d = 0; d < days.length; d++)
	  	{
	  		var day_data = data[i][d]
                        //alert(day_data.length+' length '+d);
	  		if(day_data.length == 0)
	  		{ //alert('at blank');
	  			td_day.push("<td>&nbsp</td>")
	  		}
	  		else
	  		{ //alert('at else part');
		  		var td = "<td style='border-right:1px solid #fff;'>"
	  			for(var j = 0; j < day_data.length; j++)
	  			{
                                    var subject_id = day_data[j]['subject_id'];
                                    var section_id = day_data[j]['section_id'];
                                    var teacher_name = day_data[j]['teacher_name'];
                                    /*$.each( day_data[j], function( key, value ) {
                                        alert( "key = "+key + " :::: value =" + value );
                                      });*/
                                    //alert('section_to_show'+section_to_show);
                                    if(section_to_show!=-1 && section_id != section_to_show) continue
                                    //alert('not contine');
	  				//console.log(sections[subject_id])
	  				//console.log(day_data[j])
                                        //console.log('teacher_name : '+teacher_name);
		  			td += subjects[subject_id].class_name +"("+subjects[subject_id].section_name+"): "+subjects[subject_id].subject_name +'('+teacher_name+')' + "<br />"
		  			//td += subjects[subject_id].class_name +"("+subjects[subject_id].section_name+"): "+subjects[subject_id].subject_name + "<br />"
	  			}
		  		 	td += "</td>"
                                //alert('=='+td+'==');        
	  			td_day.push(td)
	  		}
	  	}
	  	newrow += time_td
	  	for(var d = 0; d< days.length; d++)
	  	{
	  		newrow += td_day[d]
	  	}
	  	newrow += "</tr>"	  		

	  	$('#table tbody').append(newrow)
  	}		  	

}

function fillTable()
{ 
    $.ajax({
        url : siteBaseURL+"index.php?automatic_timetable_ajax_controller/generateSchedule",
        type: "POST",
        data: {year : '<?php echo $year; ?>'},
        success:function(result){
            console.log(result);
            //alert(result);
            jsonResult = JSON.parse(result)
		  	all_info = jsonResult
		  	rebuild_table()
        },
        error: function(response) {
                //alert("error");
            }        
    });
	/*$.post({url:siteBaseURL+"index.php?automatic_timetable_ajax_controller/generateSchedule",
		data: {year : '<?php //echo $year; ?>'},
		success: function(result)
		  {
		  	jsonResult = JSON.parse(result)
		  	all_info = jsonResult
		  	rebuild_table()
		  }
		}
	)*/
}
function jsahooRebuild_table(){
    jsonResult = JSON.parse('<?php echo json_encode($generate_schedule);?>');
    all_info = jsonResult;
    rebuild_table();
}
var year = '<?php echo $year; ?>'
getSections()
 //jsahooRebuild_table();

</script>	
