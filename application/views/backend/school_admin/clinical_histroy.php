
<style>
button.accordion {
    background-color: #1b9e77;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}

button.accordion.active, button.accordion:hover {
    background-color: #ddd; 
}

#section {
    padding: 0 18px;
    display: none;
    background-color: white;
}
</style>


<?php if(!empty($clinic_history)){?>
<br>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default ">
          <div class="panel-body" style="color:black;">
            
          <div class="row">
            <div class="col-md-6 lead">Student Name<hr></div>
            <div class="col-md-6 lead"><b><?php echo $clinic_history[0]['first_name']." ".$clinic_history[0]['last_name'];?></b><hr></div>
          </div>
          <div class="row">
            <!--div class="col-md-4 text-center">
              <!--img class="img-circle avatar avatar-original" style="-webkit-user-select:none; 
              display:block; margin:auto;" src="http://robohash.org/sitsequiquia.png?size=120x120">
            </div-->
            <div class="col-md-12">
              <div class="row">
                <div class="col-md-12">                  
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                    <span class="text-muted"><b>Birth date: </span></b><?php echo " ".$clinic_history[0]['birth_date'];?><br>
                </div>
                <div class="col-md-3">
                    <span class="text-muted"><b>Age: </span></b><?php echo " ".$clinic_history[0]['age'];?><br>
                </div> 
                <div class="col-md-3">
                  <span class="text-muted"><b>Gender:</span></b><?php echo " ".$clinic_history[0]['gender'];?><br><br>
                </div>
                <div class="col-md-3">
                  <span class="text-muted"><b>Mobile:</span></b><?php echo " ".$clinic_history[0]['mobile'];?><br><br>
                </div> 
                </div>
                
              </div>
            </div>
              <div class="row">
              <div class="col-md-12">
              
              <div class="row">
                <div class="col-md-6">
                  <span class="text-muted"><b>History: </span></b><?php echo " ".$clinic_history[0]['history'];?><br>
                </div>
                  
                <div class="col-md-6">
                  <span class="text-muted"><b>Surgical History: </span></b><?php echo " ".$clinic_history[0]['surgical_history'];?><br>
                </div> 
              </div>
                  <br>
                <div class="row">   
                <div class="col-md-6">
                  <span class="text-muted"><b>Genetic Diseases:</span></b><?php echo " ".$clinic_history[0]['genetic_diseases'];?><br><br>
                </div>
                <div class="col-md-6">
                  <span class="text-muted"><b>Obstetric History:</span></b><?php echo " ".$clinic_history[0]['obstetric_history'];?><br><br>
                </div> 
                </div>
                
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <!--hr><button class="btn btn-default pull-right"><i class="glyphicon glyphicon-pencil"></i> Edit</button-->
            </div>
          </div>
        </div>
    
     
        
    <body>    
    <h2>Clinical History</h2>
    <?php //echo "<pre>"; print_r($student_medical_history);?>
    <?php foreach($student_medical_history as $history):?>   
    <button class="accordion"><span class="text-muted"><b>Date & Time : </span></b><?php echo " ".$history['date']." ".$history['time'];?><br></button>
    <div class="panel" id="section" style="color:black;">
        <div class="row">
        <br>
        <div class="col-md-3">
            <span class="text-muted"><b>Title: </span></b><?php echo $history['title'];?><br>
        </div>
    </div>
    <div class="row">
        <br>
        <div class="col-md-3">
            <span class="text-muted"><b>Status: </span></b><?php echo $history['status'];?><br>
        </div>
    </div>
        <br>
       
    <div class="row">
        <div class="col-md-3">
            <span class="text-muted"><b>Prescription: </span></b><?php echo $history['prescription'];?><br>
        </div>
    </div>
        
        <br>
    <div class="row">
    <div class="col-md-3">
        <span class="text-muted"><b>Diagnosis: </span></b><?php echo $history['diagnosis'];?><br>
    </div>
    </div>
        <br>
    <div class="row">
    <div class="col-md-3">
        <span class="text-muted"><b>Comments: </span></b><?php echo $history['comments'];?><br>
    </div>
    </div>    
        
    </div>
    <?php endforeach; ?>  
    <?php //} ?>    
    </div>
        
        
        
     
</body>
 </div>
    </div>
<?php }?>





<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].onclick = function(){
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    }
}
</script>

