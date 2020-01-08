<?php
$attributes = ['class' => '', 'id' => 'tariff_form'];
echo form_open_multipart($form_action, $attributes);
?>

    <div class="form-group">
        <label><?=$this->lang->line('application_energy_dealer');?></label>
        <?php
        $dealers['0'] = '-';

        foreach ($dealers as $dealer):
            $dealers[$dealer->id] = $dealer->name;
        endforeach;

        if(isset($object)){$dealer_selected = $dealer->id;}

        echo form_dropdown('energy_dealer_id', $dealers, $dealer_selected, 'style="width:100%" class="chosen-select"');?>
    </div>

    <div class="form-group">
        <label><?=$this->lang->line('application_activity');?></label>
        <?php
        $dealers['0'] = '-';

        foreach ($activities as $activity):
            $activities[$activity->id] = $activity->name;
        endforeach;

        if(isset($object)){$activity_selected = $activity->id;}
        echo form_dropdown('activity_id', $activities, $activity_selected, 'style="width:100%" class="chosen-select"');?>
    </div>

    <div class="form-group">
        <label>
            <?=$this->lang->line('application_value');?> *
        </label>
        <input id="value" type="text" name="value" class="required form-control"  value="<?php if(isset($object)){echo $object->value;}?>"  required/>
    </div>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>