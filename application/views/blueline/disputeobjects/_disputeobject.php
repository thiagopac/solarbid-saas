<?php
$attributes = array('class' => 'dynamic-form', 'id' => '_disputeobject', 'data-reload' => 'disputeobjects');
echo form_open($form_action, $attributes);
?>

<?php if(isset($disputeobject)){ ?>
    <input id="id" type="hidden" name="id" value="<?=$disputeobject->id;?>" />
<?php } ?>
<?php if(isset($view)){ ?>
    <input id="view" type="hidden" name="view" value="true" />
<?php } ?>
    <div class="form-group">
        <label for="disputeobject_reference">
            <?=$this->lang->line('application_reference_id');?> *</label>
        <div class="input-group">
            <div class="input-group-addon">
                <?=$core_settings->disputeobject_prefix;?>
            </div>
            <input id="disputeobject_reference" type="text" name="disputeobject_reference" class="form-control" value="<?php if(isset($disputeobject)){echo $disputeobject->disputeobject_reference;} else{ echo $core_settings->disputeobject_reference; } ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_owner_name');?> *</label>
        <input id="owner_name" type="text" name="owner_name" class="form-control" value="<?php if(isset($disputeobject)){echo $disputeobject->owner_name;} ?>" required/>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">
                    <?=$this->lang->line('application_city');?> *</label>
                <input id="city" type="text" name="city" class="form-control" value="<?php if(isset($disputeobject)){echo $disputeobject->city;} ?>" required/>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="state">
                    <?=$this->lang->line('application_state');?> *
                </label>
                <?php
                $settings = Setting::first();
                $statesList = $settings->list_states();

                echo form_dropdown('state', $statesList, $disputeobject->state, 'required="required" style="width:100%" class="chosen-select"');?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">
                    <?=$this->lang->line('application_phone');?> <?=$this->lang->line('application_phone_pattern');?>
                </label>
                <input id="phone" type="text" name="phone" class="form-control" value="<?php if(isset($disputeobject)){echo $disputeobject->phone;} ?>" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">
                    <?=$this->lang->line('application_email');?>
                </label>
                <input id="email" type="text" name="email" class="form-control" value="<?php if(isset($disputeobject)){echo $disputeobject->email;} ?>" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">
                    <?=$this->lang->line('application_compensated_bills');?>
                </label>
                <input id="compensated_bills" type="number" name="compensated_bills" class="form-control" value="<?php if(isset($disputeobject)){echo $disputeobject->compensated_bills;} ?>" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="name">
                    <?=$this->lang->line('application_approximate_area');?> <span style="text-transform: lowercase !important;">(<?=$core_settings->area_measurement?>)</span>
                </label>
                <input id="approximate_area" type="number" name="approximate_area" class="form-control" value="<?php if(isset($disputeobject)){echo $disputeobject->approximate_area;} ?>" />
            </div>
<!--            <div class="form-group">-->
<!--                <label for="name">-->
<!--                    --><?//=$this->lang->line('application_rated_power');?><!-- * (--><?//=$core_settings->rated_power_measurement?><!--)</label>-->
<!--                <input id="rated_power_mod" type="number" name="rated_power_mod" class="form-control" value="--><?php //if(isset($disputeobject)){echo $disputeobject->rated_power_mod;} ?><!--" required/>-->
<!--            </div>-->
        </div>
    </div>
    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_object_reason');?>
        </label>
        <input id="object_reason" type="text" name="object_reason" class="form-control" value="<?php if(isset($disputeobject)){echo $disputeobject->object_reason;} ?>" />
    </div>
    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_installation_location');?>
        </label>
        <input id="installation_location" type="text" name="installation_location" class="form-control" value="<?php if(isset($disputeobject)){echo $disputeobject->installation_location;} ?>" />
    </div>
    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_additional_info');?>
        </label>
        <input id="additional_info" type="text" name="additional_info" class="form-control" value="<?php if(isset($disputeobject)){echo $disputeobject->additional_info;} ?>" />
    </div>
    <div class="form-group">
        <label for="inactive">
            <?=$this->lang->line('application_inactive');?>
        </label>
        <?php $options = array();
        $options['no'] = $this->lang->line('application_no');
        $options['yes'] = $this->lang->line('application_yes');

        if (isset($disputeobject) && is_object($disputeobject)) {
            $inactive = $disputeobject->inactive;
        }
        echo form_dropdown('inactive', $options, $inactive, 'style="width:100%" class="chosen-select"'); ?>
    </div>
    <div class="modal-footer">
        <input type="submit" name="send" id="send" class="btn btn-primary button-loader" data value="<?=$this->lang->line('application_save');?>" />
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>

<?php echo form_close(); ?>