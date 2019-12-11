<?php
$attributes = ['class' => '', 'id' => '_company'];
echo form_open_multipart($form_action, $attributes);
?>

<?php if (isset($company)) {
    ?>
    <input id="id" type="hidden" name="id" value="<?=$company->id; ?>" />
    <?php
} ?>
<?php if (isset($view)) {
    ?>
    <input id="view" type="hidden" name="view" value="true" />
    <?php
} ?>

    <div class="form-group">

        <label for="reference">
            <?=$this->lang->line('application_reference_id');?> *</label>
        <?php if (!empty($core_settings->company_prefix)) {
        ?>
        <div class="input-group">
            <div class="input-group-addon">
                <?=$core_settings->company_prefix; ?>
            </div>
            <?php
            } ?>
            <input id="reference" type="text" name="reference" class="required form-control" value="<?php if (isset($company)) {
                echo $company->reference;
            } else {
                echo $core_settings->company_reference;
            } ?>" readonly="readonly" />
            <?php if (!empty($core_settings->company_prefix)) {
            ?>
        </div>
    <?php
    } ?>
    </div>

<?php if (isset($company)) {
    ?>
    <div class="form-group">
        <label for="contact">
            <?=$this->lang->line('application_primary_contact'); ?>
        </label>
        <?php $options = [];
        $options['0'] = '-';
        foreach ($company->clients as $value):
            $options[$value->id] = $value->firstname . ' ' . $value->lastname;
        endforeach;
        if (is_object($company->client)) {
            $client = $company->client->id;
        } else {
            $client = '0';
        }
        echo form_dropdown('client_id', $options, $client, 'style="width:100%" class="chosen-select"'); ?>
    </div>
    <?php
} ?>

    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_name');?> *</label>
        <input id="name" type="text" name="name" class="required form-control" value="<?php if (isset($company)) {
            echo $company->name;
        } ?>" required/>
    </div>

    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_corporate_name');?> *</label>
        <input id="corporate_name" type="text" name="corporate_name" class="required form-control" value="<?php if (isset($company)) {
            echo $company->corporate_name;
        } ?>" required/>
    </div>

    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_registered_number');?> *
        </label>
        <input id="registered_number" type="text" name="registered_number" class="required form-control" value="<?php if (isset($company)) {
            echo $company->registered_number;
        } ?>" required/>
    </div>

    <div class="form-group">
        <label for="phone">
            <?=$this->lang->line('application_phone');?>
        </label>
        <input id="phone" type="text" name="phone" class="form-control" value="<?php if (isset($company)) {
            echo $company->phone;
        }?>" />
    </div>
    <div class="form-group">
        <label for="mobile">
            <?=$this->lang->line('application_mobile');?>
        </label>
        <input id="mobile" type="text" name="mobile" class="form-control" value="<?php if (isset($company)) {
            echo $company->mobile;
        }?>" />
    </div>
    <div class="form-group">
        <label for="address">
            <?=$this->lang->line('application_address');?> *
        </label>
        <input id="address" type="text" name="address" class="required form-control" value="<?php if (isset($company)) {
            echo $company->address;
        }?>" />
    </div>
    <div class="form-group">
        <label for="zipcode">
            <?=$this->lang->line('application_zip_code');?>
        </label>
        <input id="zipcode" type="text" name="zipcode" class="form-control" value="<?php if (isset($company)) {
            echo $company->zipcode;
        }?>" />
    </div>

    <div class="form-group">
        <label for="state">
            <?=$this->lang->line('application_state');?> *
        </label>
        <?php
        $options = array();
        $state = array();

        $options[null] = $this->lang->line('application_select_state');

        foreach ($states as $value):
            $options[$value->letter] = $value->name;
        endforeach;

        if(isset($company)){}else{$state = "";}

        $label = $this->lang->line('application_select_state');

        echo form_dropdown('state', $options, $company_state, 'style="width:100%" class="chosen-select"');?>
    </div>

    <div class="form-group">
        <label for="city">
            <?=$this->lang->line('application_city');?> * <small><small>(<?=$this->lang->line('application_city_desc')?>)</small></small>
        </label>
        <?php
        $options = array();
        $city = array();

        $options[null] = $this->lang->line('application_select_city');

        foreach ($cities as $value):
            $options[$value->name."/".$value->state] = $value->name."/".$value->state;
        endforeach;

        if(isset($company)){}else{$city = "";}

        $label = $this->lang->line('application_select_city');

        echo form_dropdown('city', $options, $company_city, "style='width:100%' class='chosen-select' $disabled data-placeholder='$label'");
        ?>
    </div>

    <div class="form-group">
        <label for="country">
            <?=$this->lang->line('application_country');?>
        </label>
        <?php
        $options = array();
        $country = array();

        //    $options[null] = $this->lang->line('application_select_country');

        foreach ($countries as $value):
            $options[$value->name] = $value->name;
        endforeach;

        if(isset($company)){}else{$country = "";}

        $label = $this->lang->line('application_select_country');

        echo form_dropdown('country', $options, $company_country, "style='width:100%' class='chosen-select' $disabled");?>
    </div>

    <div class="form-group">
        <label for="country">
            <?=$this->lang->line('application_plan');?>
        </label>
        <?php
        $options = array();
        $plan = array();

        $options[null] = $this->lang->line('application_select_plan');

        foreach ($plans as $value):
            $options[$value->id] = $value->name;
        endforeach;

        if(isset($company)){}else{$plan = "";}

        $label = $this->lang->line('application_select_plan');

        echo form_dropdown('plan_id', $options, $company_plan, "style='width:100%' class='chosen-select' $disabled");?>
    </div>

    <div class="form-group">
        <label for="inactive"><?=$this->lang->line('application_inactive');?> (<?=$this->lang->line('application_inactive_desc')?>)</label><br />
        <?php   $options = array();
        $options['1'] = $this->lang->line('application_yes');
        $options['0'] = $this->lang->line('application_no');
        echo form_dropdown('inactive', $options, $company->inactive, 'style="width:100%" class="chosen-select" ');?>
    </div>

    <div class="form-group">
        <label for="unlocked"><?=$this->lang->line('application_unlocked');?> (<?=$this->lang->line('application_unlocked_desc')?>)</label><br />
        <?php   $options = array();
        $options['1'] = $this->lang->line('application_yes');
        $options['0'] = $this->lang->line('application_no');
        echo form_dropdown('unlocked', $options, $company->unlocked, 'style="width:100%" class="chosen-select" ');?>
    </div>

    <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>
<?php echo form_close(); ?>
<script>
    $(document).ready(function() {

        $('#registered_number').mask('00.000.000/0000-00', {reverse: false})

    });
</script>
