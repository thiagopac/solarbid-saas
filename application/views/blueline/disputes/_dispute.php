<?php
$attributes = array('class' => 'dynamic-form', 'id' => '_dispute', 'data-reload' => 'disputes');
echo form_open($form_action, $attributes);
?>

<?php if(isset($dispute)){ ?>
    <input id="id" type="hidden" name="id" value="<?=$dispute->id;?>" />
<?php } ?>
<?php if(isset($view)){ ?>
    <input id="view" type="hidden" name="view" value="true" />
<?php } ?>
    <div class="form-group">
        <label for="reference">
            <?=$this->lang->line('application_reference_id');?> *</label>
        <div class="input-group">
            <div class="input-group-addon">
                <?=$core_settings->dispute_prefix;?>
            </div>
            <input <?php echo $dispute->dispute_sent == 'yes' ? 'disabled' : ''; ?> id="reference" type="text" name="dispute_reference" class="form-control" value="<?php if(isset($dispute)){echo $dispute->dispute_reference;} else{ echo $core_settings->dispute_reference; } ?>" required />
        </div>
    </div>

    <small class="text-muted"><?=$this->lang->line("application_impossible_update_dispute_object")?></small>
    <div class="form-group">
        <label for="dispute_object_id">
            <?=$this->lang->line('application_dispute_object');?>
        </label>
        <?php $options = array();
        $options['0'] = '-';

        $objects = [];
        foreach ($dispute_objects as $value):
            $options[$value->id] = $value->owner_name .  ' - '.$value->city.'/'.$value->state;
        endforeach;
        if (isset($dispute) && is_object($dispute)) {
            $object_id = $dispute->dispute_object_id;
            $disabled = empty($dispute->dispute_object_id) ? '' : 'disabled';
        }

        echo form_dropdown('dispute_object_id', $options, $object_id, "style='width:100%' class='chosen-select' $disabled"); ?>
    </div>


    <div class="form-group">
        <label for="start_date">
            <?=$this->lang->line('application_start_date');?> *</label>
        <input <?php echo $dispute->dispute_sent == 'yes' ? 'disabled' : ''; ?> id="start_date" type="text" name="start_date" data-enable-time=true class="form-control datepicker-time required" value="<?php if(isset($dispute)){echo $dispute->start_date;} ?>" required/>
        <!--<input id="due_date" type="text" name="due_date" data-enable-time=true class="required datepicker-time datepicker-time-linked form-control" value="<?php /*if(isset($dispute)){echo $dispute->due_date;} */?>" required/>-->
    </div>
    <div class="form-group">
        <label for="due_date">
            <?=$this->lang->line('application_due_date');?> *</label>
        <input <?php echo $dispute->dispute_sent == 'yes' ? 'disabled' : ''; ?> id="due_date" type="text" name="due_date" data-enable-time=true class="form-control datepicker-time datepicker-time-linked form-control required" value="<?php if(isset($dispute)){echo $dispute->due_date;} ?>" required/>
    </div>
    <div class="form-group">
        <label for="inactive">
            <?=$this->lang->line('application_inactive');?>
        </label>
        <?php $options = array();
        $options['no'] = $this->lang->line('application_no');
        $options['yes'] = $this->lang->line('application_yes');

        if (isset($dispute) && is_object($dispute)) {
            $inactive = $dispute->inactive;
        }
        echo form_dropdown('inactive', $options, $inactive, 'style="width:100%" class="chosen-select"'); ?>
    </div>
    <div class="form-group">
        <label for="status">
            <?=$this->lang->line('application_status');?>
        </label>
        <?php $options = array();
        $options[null] = $this->lang->line('application_select');
        $options['scheduled'] = $this->lang->line('application_scheduled');
        $options['in_progress'] = $this->lang->line('application_in_progress');
        $options['suspended'] = $this->lang->line('application_suspended');
        $options['completed'] = $this->lang->line('application_completed');

        if (isset($dispute) && is_object($dispute)) {
            $status = $dispute->status;
        }
        echo form_dropdown('status', $options, $status, 'style="width:100%" class="chosen-select"'); ?>
    </div>
    <!--<div class="form-group">
        <label for="currency"><?/*=$this->lang->line('application_currency');*/?></label>
        <input id="currency" type="text" name="currency" class="required form-control" value="<?php /*if(isset($dispute)){ echo $dispute->currency; }else { echo $core_settings->currency; } */?>" required/>
 </div>-->
    <div class="modal-footer">
        <span class="pull-left small"><?php echo $dispute->dispute_sent == 'yes' ? $this->lang->line('application_dispute_in_progress_are_not_allowed_to_edit') : ''; ?></span>
        <input type="submit" name="send" id="send" class="btn btn-primary button-loader" data value="<?=$this->lang->line('application_save');?>" />
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>

<?php echo form_close(); ?>