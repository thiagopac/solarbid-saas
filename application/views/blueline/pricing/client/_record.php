<?php
$attributes = ['class' => '', 'id' => 'record_form'];
echo form_open_multipart($form_action, $attributes);
?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?=$this->lang->line('application_power_of_plant');?>
                </label>
                <input type="text" value="<?=$pricing_field->power_bottom?><?=$core_settings->rated_power_measurement;?> - <?=$pricing_field->power_top?><?=$core_settings->rated_power_measurement;?>" class="required form-control" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?=$this->lang->line('application_distance_installation_location');?>
                </label>
                <input type="text" value="<?=$pricing_field->distance_bottom?>km - <?=$pricing_field->power_top?>km" class="required form-control" readonly>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="value">
            <?=$this->lang->line('application_value');?> *
        </label>
        <input id="value" type="text" name="value" class="required form-control"  value="<?php if(isset($pricing_record)){echo $pricing_record->value;}?>"  required/>
    </div>
    <div class="form-group">
        <label for="delivery_time_days">
            <?=$this->lang->line('application_delivery_time_days');?> *
        </label>
        <input id="delivery_time_days" type="text" name="delivery_time_days" class="required form-control"  value="<?php if(isset($pricing_record)){echo $pricing_record->delivery_time_days;}?>"  required/>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>