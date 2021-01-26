<?php
$attributes = array('class' => '', 'data-reload' => 'div-pvkits', 'id' => '_pvkit');
echo form_open_multipart($form_action, $attributes);
if (isset($pv_kit)) { ?>
    <input id="id" type="hidden" name="id" value="<?php echo $pv_kit->id; ?>"/>
<?php } ?>

    <div class="form-group">
        <label for="kit_provider"><?= $this->lang->line('application_provider'); ?> *</label>
        <?php $options = array();
        foreach ($kit_providers as $kit_provider):
            $options[$kit_provider->name] = $kit_provider->name;
        endforeach;
        if (isset($pv_kit->kit_provider)) {
            $kit_provider = $pv_kit->kit_provider;
        }
        echo form_dropdown('kit_provider', $options, $kit_provider, 'style="width:100%" class="chosen-select"'); ?>
    </div>

    <div class="form-group">
        <label for="kit_power">
            <?= $this->lang->line('application_pv_power'); ?> *
        </label>
        <div class="input-group">
            <div class="input-group-addon">
                <?= $core_settings->rated_power_measurement ?>
            </div>
            <input id="kit_power" name="kit_power" type="text" class="required form-control"
                   value="<?php if (isset($pv_kit)) {
                       echo $pv_kit->kit_power;
                   } ?>" required/>
        </div>
    </div>

    <div class="form-group">
        <label for="pv_inverter"><?= $this->lang->line('application_inverter'); ?> *</label>
        <?php $options = array();

        array_push($options, $this->lang->line('application_select'));

        foreach ($inverters as $inverter):
            $options[$inverter->name] = $inverter->name;
        endforeach;
        if (isset($pv_kit->pv_inverter)) {
            $pv_inverter = $pv_kit->pv_inverter;
        }
        echo form_dropdown('pv_inverter', $options, $pv_inverter, 'style="width:100%" class="chosen-select"'); ?>
    </div>

    <div class="form-group">
        <label for="desc_inverter"><?= $this->lang->line('application_desc_inverter'); ?> *</label>
        <small class="text-muted">(<strong>Padrão:</strong> N inversor ABCDE de X kW)</small>
        <input placeholder="Ex: 1 inversor Sungrow de 4,0 kW" id="desc_inverter" type="text" name="desc_inverter"
               class="form-control" value="<?php if (isset($pv_kit)) {
            echo $pv_kit->desc_inverter;
        } ?>" required/>
    </div>

    <div class="form-group">
        <label for="pv_module"><?= $this->lang->line('application_modules'); ?> *</label>

        <?php $options = array();

        array_push($options, $this->lang->line('application_select'));

        foreach ($modules as $module):
            $options[$module->name] = $module->name;
        endforeach;
        if (isset($pv_kit->pv_module)) {
            $pv_module = $pv_kit->pv_module;
        }
        echo form_dropdown('pv_module', $options, $pv_module, 'style="width:100%" class="chosen-select"'); ?>
    </div>

    <div class="form-group">
        <label for="desc_module"><?= $this->lang->line('application_desc_module'); ?> *</label>
        <small class="text-muted">(<strong>Padrão:</strong> N módulos ABCDE de X W)</small>
        <input placeholder="Ex: 12 módulos GCL de 370 W" id="desc_module" type="text" name="desc_module"
               class="form-control" value="<?php if (isset($pv_kit)) {
            echo $pv_kit->desc_module;
        } ?>" required/>
    </div>

    <div class="form-group">
        <label for="pv_module"><?= $this->lang->line('application_structure_type'); ?> *</label>

        <?php $options = array();

        array_push($options, $this->lang->line('application_select'));

        foreach ($structure_types as $structure_type):
            $options[$structure_type->id] = $structure_type->name;
        endforeach;
        if (isset($pv_kit->structure_type_id)) {
            $structure_type_id = $pv_kit->structure_type_id;
        }
        echo form_dropdown('structure_type_id', $options, $structure_type_id, 'style="width:100%" class="chosen-select"'); ?>
    </div>

    <div class="form-group">
        <label for="country"><?= $this->lang->line('application_country'); ?> *</label>
        <?php
        $options = array();
        $country = array();

        foreach ($countries as $country):
            $options[$country->name] = $country->name;
        endforeach;

        if (isset($pv_kit)) {
        } else {
            $country = "";
        }

        $label = $this->lang->line('application_select_country');

        echo form_dropdown('country', $options, $country, 'style="width:100%" class="chosen-select"'); ?>
    </div>

    <div class="form-group">
        <label for="value"><?= $this->lang->line('application_use_repeated_image'); ?> *</label>
        <?php $options = array();


        array_push($options, $this->lang->line('application_select'));

        foreach ($all_kits as $kit):

            if ($options[$kit->image] == null){
                $options[$kit->image] = "[$kit->id] - $kit->kit_provider - $kit->kit_power.$core_settings->rated_power_measurement - $kit->desc_inverter - $kit->desc_module - ".StructureType::find($kit->structure_type_id)->name;
            }

            $image = $options[0];

        endforeach;
        echo form_dropdown('image', $options, $image, 'style="width:100%" class="chosen-select"'); ?>
    </div>

    <div class="form-group">
        <label for="userfile"><?= $this->lang->line('application_image'); ?> * <small>(Só enviar nova imagem se ela não for de nenhum outro kit)</small></label>
        <div>
            <input id="uploadFile" class="form-control uploadFile"
                   placeholder="<?= $this->lang->line('application_choose_file'); ?>" disabled="disabled"/>
            <div class="fileUpload btn btn-primary">
                <span><i class="icon dripicons-upload"></i><span
                            class="hidden-xs"> <?= $this->lang->line('application_select'); ?></span></span>
                <input id="uploadBtn" type="file" name="userfile" class="upload"/>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="image"><?= $this->lang->line('application_image_in_server'); ?> *</label>
        <a style="margin: 10px 6px 0 0;" href="<?=base_url()?>pvkits/image_server/<?=$pv_kit->id ?>" class="btn btn-primary pull-right" data-toggle="mainmodal">
            <?=$this->lang->line('application_select_image_in_server');?>
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">

            <div class="form-group">
                <label><?= $this->lang->line('application_start'); ?> </label>
                <input class="form-control datepicker-time not-required" data-enable-time=true name="start_at" id="start_at" type="text"
                       value="<?php if ($pv_kit->start_at != null) {
                           echo $pv_kit->start_at;
                       } ?>" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?= $this->lang->line('application_end'); ?> </label>
                <input class="form-control datepicker-time datepicker-time-linked not-required" data-enable-time=true name="stop_at" id="stop_at" type="text"
                       value="<?php if ($pv_kit->stop_at != null) {
                           echo $pv_kit->stop_at;
                       } ?>"/>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="value"><?= $this->lang->line('application_value'); ?> *</label>
        <div class="input-group">
            <div class="input-group-addon">
                <?= $core_settings->money_symbol ?>
            </div>
            <input id="price" type="text" name="price" class="required form-control" value="<?php if (isset($pv_kit)) {
                echo display_money(sprintf('%01.2f', $pv_kit->price));
            } ?>" required/>
        </div>
    </div>

    <div class="form-group">
        <label for="insurance"><?= $this->lang->line('application_insurance'); ?> *</label>
        <small class="text-muted">(<strong>Padrão:</strong> Seguro All risk de 1 ano incluso)</small>
        <input placeholder="Ex: Seguro All risk de 1 ano incluso" id="insurance" type="text" name="insurance"
               class="form-control" value="<?php if (isset($pv_kit)) {
            echo $pv_kit->insurance;
        } ?>" required/>
    </div>

    <div class="form-group">
        <label for="inactive"><?= $this->lang->line('application_inactive'); ?> *</label>
        <?php $options = array();
        $options['0'] = $this->lang->line('application_no');
        $options['1'] = $this->lang->line('application_yes');
        echo form_dropdown('inactive', $options, $pv_kit->inactive, 'style="width:100%" class="chosen-select" '); ?>
    </div>

    <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?= $this->lang->line('application_save'); ?>"/>
        <a class="btn" data-dismiss="modal"><?= $this->lang->line('application_close'); ?></a>
    </div>
<?php echo form_close(); ?>

<script>
    $(document).ready(function(){
        $("#price").maskMoney({allowNegative: false, thousands:'.', decimal:',', affixesStay: false});
    });
</script>
