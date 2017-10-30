<?php
$this->load->helper("functions");
$this->load->library("CSRF_Protect");
$csrf = new CSRF_Protect();
?>
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title"><?php echo get_phrase('MANAGE EVENTS'); ?></h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
        <a href="javascript: void(0);" target="_blank" onclick="javascript:introJs().start();" id="take-tour" class="fcbtn btn btn-danger btn-outline btn-1d pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Take a Tour</a>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>index.php?student/dashboard"><?php echo get_phrase('Dashboard'); ?></a></li>
            <li class="active">
                <?php echo get_phrase('event_calender'); ?>
            </li>
        </ol>
    </div>
</div>

<!--<link rel="stylesheet" type="text/css" href="assets/new_assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/new_assets/css/datatable.css"/>
<script type="text/javascript" src="assets/new_assets/js/datatable.js"></script>-->


<link href="<?php echo base_url();?>assets/event_assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/event_assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">	
   
    <!-- FullCalendar CSS -->
    <link href="<?php echo base_url();?>assets/event_assets/css/fullcalendar.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/event_assets/css/fullcalendar.print.css" rel="stylesheet" media="print" />	
    <!-- jQuery -->
<script src="<?php echo base_url();?>assets/event_assets/js/jquery.js"></script>	
    <!-- SweetAlert CSS -->
    <script src="<?php echo base_url();?>assets/event_assets/js/sweetalert.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/event_assets/css/sweetalert.css">
<!-- Custom Fonts -->
<link href="<?php echo base_url();?>assets/event_assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <!-- ColorPicker CSS -->
    <link href="<?php echo base_url();?>assets/event_assets/css/bootstrap-colorpicker.css" rel="stylesheet">
	<!-- Header -->
	   <!--<div id="home"></div>-->
		
		<!-- /.intro-header -->

		<!-- Page Content -->
<div class="row m-t-40">
    <div class="col-md-12">
        <!-- row -->
        <div class="row">
            <div class="col-md-3">
                <div class="white-box">
                    <h3 class="box-title">Drag and drop your event </h3>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="calendar-events" class="m-t-20" data-step="6" data-intro="<?php echo get_phrase('View the events category added!!');?>" data-position='top'>
                                <?php foreach($types as $val){ ?>
                                    <div class="calendar-events bg-danger"  bg-<?php echo $val['event_color']?>>
                                        <?php echo $val['title']; ?>
                                    </div>                
                                <?php } ?>
                                <!--<div class="calendar-events" data-class="bg-success"><i class="fa fa-circle text-success"></i> My Event Two</div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="white-box">
		<div id="eventcalendar"></div>
		<div class="content-section-a">
			
			<!--BEGIN PLUGIN -->
			<div class="container-fluid no-padding">
				<div class="row">
				   <div class="col-md-9">
				<div class="panel panel-default dash no-border">
					
					<div class="panel panel-default">
						<div class="panel-heading">
							
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div class="table-responsive" style="color:#aaa!important;border-color:#ddd!important;">
								<div class="col-md-9 no-padding">
									<div id="events"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php

				// If user clicked on the new event button
				if (!empty($_POST['novoevento'])) {
					
					// Variables from form
							$title = $_POST['title'];
							$photo = $_FILES['image'];
							$description = trim(preg_replace('/\s+/', ' ',nl2br($_POST['description'])));			
							$url = $_POST['url'];
							$start = $_POST['start'];
							$end = $_POST['end'];
							$color = $_POST['color'];
				 
					// If photos has been slected
					if (!empty($photo["name"])) {
				 
						// Max width (px)
						$largura = 10000;
						// Max high (px)
						$altura = 10000;
						// Max size (pixels)
						$tamanho = 5000000000;
				 
						// Verifies if this is an image format
						if(!preg_match("/image\/(pjpeg|jpeg|png|gif|bmp)/", $photo["type"])){
						   $error[1] = "Sorry but this is not an image.";
						} 
				 
						// Select image size
						$dimensoes = getimagesize($photo["tmp_name"]);
				 
						// check if the width size is allowed
						if($dimensoes[0] > $largura) {
							$error[2] = "Image width should be max ".$largura." pixels";
						}
				 
						// check if the height size is allowed
						if($dimensoes[1] > $altura) {
							$error[3] = "Image height should be max ".$altura." pixels";
						}
				 
						// check if the total size is allowed
						if($photo["size"] > $tamanho) {
							$error[4] = "Image Should have max ".$tamanho." bytes";
						}
				 
							// Get image extension
							preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $photo["name"], $ext);
				 
							// Creates unique name (md5)
							$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
				 
							// Path for uploading the image
							$caminho_imagem = "<?php echo base_url();?>assets/event_assets/uploads/" . $nome_imagem;
				 
							// upload the image to the folder
							move_uploaded_file($photo["tmp_name"], $caminho_imagem);

							// Saves informationon the database
							$sql = mysql_query("INSERT INTO events VALUES ('', '".$title."', '".$nome_imagem."','".str_replace( "'", "´", $description)."','".$start."','".$end."','".$url."', '".$color."')");

							// If information is correctly saved		
							if (!$sql) {
							echo ("Can't insert into database: " . mysql_error());
							return false;
							} else {
									echo "<script type='text/javascript'>swal('Good job!', 'New Event Created!', 'success');</script>";
									echo '<meta http-equiv="refresh" content="1; index.php">'; 
									die();
							}		
							return true;
						
						// Displays any error on database saving
						if (count($error) != 0) {
							foreach ($error as $erro) {
								echo $erro . "<br />";
							}
						}
					} else // Saves informationon the database
							$sql = mysql_query("INSERT INTO events VALUES ('', '".$title."', '".$nome_imagem."','".str_replace( "'", "´", $description)."','".$start."','".$end."','".$url."', '".$color."')");

							// If information is correctly saved		
							if (!$sql) {
							echo ("Can't insert into database: " . mysql_error());
							return false;
							} else {
									echo "<script type='text/javascript'>swal('Good job!', 'New Event Created!', 'success');</script>";
									echo '<meta http-equiv="refresh" content="1; index.php">'; 
									die();
							}		
							return true;
				}


				// If user clicked on the new event button
				if (!empty($_POST['novotipo'])) {
				 
					// Variables from form
					$title = $_POST['title'];
					
					// Saves informationon the database
					$sql = mysql_query("INSERT INTO type VALUES ('', '".$title."')");
		 
					// If information is correctly saved			
					if (!$sql) {
					echo ("Can't insert into database: " . mysql_error());
					return false;
					} else {
							echo "<script type='text/javascript'>swal('Good job!', 'New Type Created!', 'success');</script>";
							echo '<meta http-equiv="refresh" content="1; index.php">'; 
							die();
					}		
					return true;
				}

			?>
			<!-- Modal with events description 
			
				</div>

			</div>
			<!-- /.container -->

		</div>
		
                        </div>

		</div>
                </div>
                </div>
            </div>
        </div>
    </div>
               

		
		<!-- Bootstrap Core JavaScript -->
		<script src="<?php echo base_url();?>assets/event_assets/js/bootstrap.min.js"></script>
		<!-- DataTables JavaScript -->
		<script src="<?php echo base_url();?>assets/event_assets/js/jquery.dataTables.js"></script>
		<script src="<?php echo base_url();?>assets/event_assets/js/dataTables.bootstrap.js"></script>
		<!-- Listings JavaScript delete options-->
		<script src="<?php echo base_url();?>assets/event_assets/js/listings.js"></script>
		<!-- Metis Menu Plugin JavaScript -->
		<script src="<?php echo base_url();?>assets/event_assets/js/metisMenu.min.js"></script>
		<!-- Moment JavaScript -->
		<script src="<?php echo base_url();?>assets/event_assets/js/moment.min.js"></script>
		<!-- FullCalendar JavaScript -->
		<script src="<?php echo base_url();?>assets/event_assets/js/fullcalendar.min.js"></script>
		<!-- DateTimePicker JavaScript -->
		<script type="text/javascript" src="<?php echo base_url();?>assets/event_assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
		<!-- Datetime picker initialization -->
		<script type="text/javascript">
			//$('.form_date').datetimepicker({
			//	language:  'en',
			//	weekStart: 1,
			//	todayBtn:  1,
			//	autoclose: 1,
			//	todayHighlight: 1,
			//	startView: 2,
			//	minView: 2,
			//	forceParse: 0
			//});
		</script>	
		<!-- ColorPicker JavaScript -->
		<script src="<?php echo base_url();?>assets/event_assets/js/bootstrap-colorpicker.js"></script>
		<!-- Plugin Script Initialization for DataTables -->
		<script>
			$(document).ready(function() {
				$('#dataTables-example').dataTable();
			});
		</script>
		<!-- ColorPicker Initialization -->
		<script>
                    $(function() {
                            //$('#cp1').colorpicker();
                        setTimeout(function(){    
                            $('.fc-prev-button ').html('<i class="fa fa-chevron-left"></i>');
                            $('.fc-next-button ').html('<i class="fa fa-chevron-right"></i>');
                        },500);
                    });
		</script>
		<!-- JS array created from database -->
		<?php echo listEvents(); ?>
<script>
			$(document).ready(function() {
				$('#dataTables-example').dataTable();
                                <?php
                    
                    
                    foreach ($events as $event ):
?>var myevent ={
                    id: "<?php echo $event['id']; ?>",
                    title: "<?php echo $event['title']; ?>",
                    description: "<?php echo $event['description'];?>",					
                    start:"<?php echo $event['start']; ?>",
                    end: "<?php echo $event['end']; ?>",
                    allDay: false  
                 };
                 $('#events').fullCalendar( 'renderEvent', myevent, true);
                         <?php
                         //break;
                         endforeach; ?>
                          
         });
		</script>
		
	</body>

</html>
