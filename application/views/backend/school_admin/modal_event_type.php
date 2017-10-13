<div class="modal-body">                               
    <!-- New Event Creation Form -->
    <form action="<?php echo base_url() . 'index.php?school_admin/event_type/create' ?>" method="post" enctype="multipart/form-data" class="form-horizontal" name="novotipo">
            <fieldset>

                    <!-- Text input-->
                    <div class="form-group">
                            <label class="col-md-3 control-label" for="title">Title</label>
                            <div class="col-md-9">
                                    <input id="title" name="title" type="text" class="form-control input-md" required>
                            </div>
                    </div>

                    <!-- Button -->
                    <div class="form-group">
                            <label class="col-md-12 control-label" for="singlebutton"></label>

                            <div class="col-xs-12 pull-right">
                                    <input type="submit" name="novotipo" class="btn btn-success pull-right" value="Submit Type" />

                            </div>
                    </div>


            </fieldset>
    </form>
</div>