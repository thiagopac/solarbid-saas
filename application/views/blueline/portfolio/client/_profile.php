<?php
    $attributes = ['class' => '', 'id' => 'profile_form'];
    echo form_open_multipart($form_action, $attributes);
?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?=$this->lang->line('application_warranty_lowest');?> * (<?=$this->lang->line('application_in_months')?>)
                </label>
                <input id="warranty_lowest" name="warranty_lowest" type="number" onkeypress="return event.code >= 48 && event.code <= 57" value="<?=$company_profile->warranty_lowest;?>" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?=$this->lang->line('application_warranty_highest');?> * (<?=$this->lang->line('application_in_months')?>)
                </label>
                <input id="warranty_highest" name="warranty_highest" type="number" onkeypress="return event.keyCode >= 48 && event.keyCode <= 57" value="<?=$company_profile->warranty_highest;?>" class="form-control">
            </div>
        </div>
    </div>
    <div class="form-group read-only">
        <label>
            <?=$this->lang->line('application_power_plants_installed');?>
        </label>
        <input type="text" readonly value="<?=$company_profile->power_plants_installed;?>" class="form-control"/>
    </div>
    <div class="form-group read-only">
        <label for="value">
            <?=$this->lang->line('application_power_executed');?>
        </label>
        <div class="input-group">
            <div class="input-group-addon">
                <?=$core_settings->rated_power_measurement?>
            </div>
            <input type="text" readonly class="required form-control"  value="<?php if(isset($company_profile)){echo $company_profile->power_executed;}?>"  required/>
        </div>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>