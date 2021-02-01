<?php
    $attributes = ['class' => '', 'id' => '_complete'];
    echo form_open_multipart($form_action, $attributes);
?>
    <input type="hidden" id="code" name="code" value="<?=$flow->code?>">
    <label style="text-transform: none">
        <?=$this->lang->line('application_complete_appointment_are_you_sure');?>
    </label>
<p> </p>
    <div class="row">
        <div class="col-md-6 pull-right">
            <div class="form-group">
                <label>
                    <?=$this->lang->line('application_completed_visit_date');?>
                </label>
                <input class="form-control datepicker" name="completed_date" id="completed_date" type="text" required/>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-success" value="<?=$this->lang->line('application_yes');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_cancel');?>
        </a>
    </div>
<?php echo form_close(); ?>