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
            <input id="reference" type="text" name="dispute_reference" class="form-control" value="<?php if(isset($dispute)){echo $dispute->dispute_reference;} else{ echo $core_settings->dispute_reference; } ?>" required />
        </div>
    </div>
    <div class="form-group">
        <label for="client">
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
        }
        echo form_dropdown('dispute_object_id', $options, $object_id, 'style="width:100%" class="chosen-select"'); ?>
    </div>

    <div class="form-group">
        <label for="issue_date">
            <?=$this->lang->line('application_issue_date');?> *</label>
        <input id="issue_date" type="text" name="issue_date" data-enable-time=true class="form-control datepicker-time required" value="<?php if(isset($dispute)){echo $dispute->issue_date;} ?>" required/>
        <!--<input id="due_date" type="text" name="due_date" data-enable-time=true class="required datepicker-time datepicker-time-linked form-control" value="<?php /*if(isset($dispute)){echo $dispute->due_date;} */?>" required/>-->
    </div>
    <div class="form-group">
        <label for="due_date">
            <?=$this->lang->line('application_due_date');?> *</label>
        <input id="due_date" type="text" name="due_date" data-enable-time=true class="required datepicker-time datepicker-time-linked form-control" value="<?php if(isset($dispute)){echo $dispute->due_date;} ?>" required/>
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
    <!--<div class="form-group">
        <label for="currency"><?/*=$this->lang->line('application_currency');*/?></label>
        <input id="currency" type="text" name="currency" class="required form-control" value="<?php /*if(isset($dispute)){ echo $dispute->currency; }else { echo $core_settings->currency; } */?>" required/>
 </div>-->
    <div class="modal-footer">
        <input type="submit" name="send" id="send" class="btn btn-primary button-loader" data value="<?=$this->lang->line('application_save');?>" />
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>

<?php echo form_close(); ?>