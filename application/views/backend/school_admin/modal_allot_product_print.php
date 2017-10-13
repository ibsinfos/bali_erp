<style>
#scissors {
    height: 25px; /* image height */
    width: 90%;
    margin: auto auto;
    background-image: url('<?php echo base_url() ?>assets/images/cXciH.png');
    background-repeat: no-repeat;
    background-position: right;
    position: relative;
}
#scissors div {
    position: relative;
    top: 50%;
    border-top: 3px dashed black;
    margin-top: -3px;
}
</style>
<div class="row m-0">
        <div class="col-md-12 white-box">
               <div class="col-md-12 m-b-20 text-right ">
         <button value="Print"  onclick="PrintElem('#print');" class="fcbtn btn btn-danger btn-outline btn-1d"> Print </button>
    </div>
            <div id="print">
<center>
                <img src="<?php echo base_url() . 'assets/images/logo_ag.png'; ?>" width="50" height="50">
            </center>
            <h2><center><b>Allocation Receipt</b></center></h2>
      <div class="form-group">
          <br/>
          <br/>
          <div class="col-md-12 m-b-20"><p style="font-size: 18px">This Product <b><?php echo $productArr->product_name; ?></b> with product Id <b><?php echo $productArr->product_unique_id; ?></b> is allocated to <b><?php echo $productArr->name ." ". ($productArr->middle_name!=''?$productArr->middle_name:'') ." ". $productArr->last_name; ?></b> on <?php echo $productArr->allot_date; ?></p></div>
          
          <div class="col-md-12 m-b-20 text-right" style="font-size: 15px;">
          <br/>
               Signature<br>
              <?php echo $productArr->name ." ". ($productArr->middle_name!=''?$productArr->middle_name:'') ." ". $productArr->last_name; ?>
    </div>
    
    </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div class="form-group">
            <div id="scissors">
            <div></div>
            </div>
            </div>
             <br><br><br>
            <center>
                <img src="<?php echo base_url() . 'assets/images/logo_ag.png'; ?>" width="50" height="50">
            </center>
            <h2><center><b>Allocation Receipt</b></center></h2>
      <div class="form-group">
          <br/>
          <br/>
          <div class="col-md-12 m-b-20"><p style="font-size: 18px">This Product <b><?php echo $productArr->product_name; ?></b> with product Id <b><?php echo $productArr->product_unique_id; ?></b> is allocated to <b><?php echo $productArr->name ." ". ($productArr->middle_name!=''?$productArr->middle_name:'') ." ". $productArr->last_name; ?></b> on <?php echo $productArr->allot_date; ?></p></div>
          
          <div class="col-md-12 m-b-20 text-right" style="font-size: 15px;">
          <br/>
               Signature<br>
              <?php echo $productArr->name ." ". ($productArr->middle_name!=''?$productArr->middle_name:'') ." ". $productArr->last_name; ?>
    </div>    
    </div>  
      </div>
 </div>
</div>
<script type="text/javascript">

    function PrintElem(elem) {
        Popup($(elem).html());
    }

    function Popup(data) {
        var myWindow = window.open('', 'my div', 'height=400,width=600');
        myWindow.document.write('<html><head>');
        myWindow.document.write('<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/transfer_certificate_print.css" type="text/css" /><style type="text/css"> #scissors {height: 25px; width: 90%; margin: auto auto; background-image: url("<?php echo base_url(); ?>assets/images/cXciH.png"); background-repeat: no-repeat; background-position: right; position: relative;} #scissors div {position: relative; top: 50%;border-top: 3px dashed black;margin-top: -3px;}</style>');
        myWindow.document.write('</head><body>');
        myWindow.document.write(data);
        myWindow.document.write('</body></html>');
        myWindow.document.close(); // necessary for IE >= 10

        myWindow.onload = function () { // necessary if the div contain images
            myWindow.focus(); // necessary for IE >= 10
            myWindow.print();
            myWindow.close();
        };
    }
</script>