<style>
    .read-only {
        background: #fbfbfb !important;
    }

    .read-only input {
        color: black !important;
    }
</style>
<?php
    $attributes = ['class' => '', 'id' => '_find'];
    echo form_open_multipart($form_action, $attributes);
?>
<?php //var_dump($pvkit); ?>
    <div class="form-group">
        <label for="contact">
            <?=$this->lang->line('application_pvkits'); ?>
        </label>
        <?php $options = [];
        $options['0'] = '-';
        foreach ($pv_kits as $value):
            $options[$value->id] = "[".$value->kit_provider."] - ".
                $value->kit_power." ".
                $core_settings->rated_power_measurement.
                " - Inversores: ".$value->pv_inverter.
                " - Módulos: ".$value->pv_module.
                " - ".$value->structure_type->name.
                " - ".$core_settings->money_symbol.
                " ".display_money($value->price);
        endforeach;
        if (is_object($pvkit)) {
            $pvkit_id = $pvkit->id;
        } else {
            $pvkit_id = '0';
        }
        echo form_dropdown('pvkit_id', $options, $pvkit_id, 'id="pvkit_id" style="width:100%" class="chosen-select"'); ?>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group read-only">
                <label for="provider">
                    <?=$this->lang->line('application_provider');?>
                </label>
                <input id="provider" type="text" class="form-control" disabled="disabled" />
            </div>
            <div class="form-group read-only">
                <label for="pv_power">
                    <?=$this->lang->line('application_pv_power');?>
                </label>
                <input id="pv_power" type="text" class="form-control" disabled="disabled" />
            </div>
            <div class="form-group read-only">
                <label for="inverter">
                    <?=$this->lang->line('application_inverters');?>
                </label>
                <input id="inverter" type="text" class="form-control" disabled="disabled" />
            </div>
            <div class="form-group read-only">
                <label for="desc_inverter">
                    <?=$this->lang->line('application_desc_inverter');?>
                </label>
                <input id="desc_inverter" type="text" class="form-control" disabled="disabled" />
            </div>
            <div class="form-group read-only">
                <label for="module">
                    <?=$this->lang->line('application_modules');?>
                </label>
                <input id="module" type="text" class="form-control" disabled="disabled" />
            </div>
            <div class="form-group read-only">
                <label for="desc_module">
                    <?=$this->lang->line('application_desc_module');?>
                </label>
                <input id="desc_module" type="text" class="form-control" disabled="disabled" />
            </div>
            <div class="form-group read-only">
                <label for="structure_type">
                    <?=$this->lang->line('application_structure_type');?>
                </label>
                <input id="structure_type" type="text" class="form-control" disabled="disabled" />
            </div>
            <div class="form-group read-only">
                <label for="price">
                    <?=$this->lang->line('application_price');?>
                </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <?= $core_settings->money_symbol ?>
                    </div>
                    <input id="price" type="text" class="form-control" disabled="disabled" />
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <img width="100%" id="image" class="" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group read-only">
                <label for="insurance">
                    <?=$this->lang->line('application_insurance');?>
                </label>
                <input id="insurance" type="text" class="form-control" disabled="disabled" />
            </div>
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
<script>
    $(document).ready(function(){


        getKit($('#pvkit_id').val());

        $("#pvkit_id").change(function() {getKit(this.value)});


        function getKit(id) {
            $.ajax({
                type: "GET",
                url: "<?=base_url()?>ctokens/kit_by_id/"+id,
                success: function(response, status, xhr) {

                    $("#provider").val(response.data.kit_provider)
                    $("#pv_power").val(response.data.kit_power + " <?= $core_settings->rated_power_measurement; ?>")
                    $("#inverter").val(response.data.pv_inverter)
                    $("#desc_inverter").val(response.data.desc_inverter)
                    $("#module").val(response.data.pv_module)
                    $("#desc_module").val(response.data.desc_module)
                    $("#structure_type").val(response.data.structure_type.name)
                    $("#price").val(response.data.price)
                    $("#insurance").val(response.data.insurance)
                    $("#image").attr({"src" : response.data.image})

                    // $("#price").maskMoney({allowNegative: false, thousands:'.', decimal:',', affixesStay: false}).trigger('mask.maskMoney');
                },
                complete: function() {}
            });
        }



    });
</script>
