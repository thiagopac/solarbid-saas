<?php
$attributes = array('class' => 'ajaxform', 'id' => '_proposal', 'data-reload' => 'proposals');
echo form_open($form_action, $attributes);
?>

<?php if(isset($proposal)){ ?>
    <input id="id" type="hidden" name="id" value="<?=$proposal->id;?>" />
<?php } ?>
<?php if(isset($view)){ ?>
    <input id="view" type="hidden" name="view" value="true" />
<?php } ?>
    <div class="form-group">
        <label for="value">
            <?=$this->lang->line('application_value');?> *</label>
        <div class="input-group">
            <div class="input-group-addon">
                <?=$core_settings->money_symbol;?>
            </div>
            <input id="value" type="text" name="value" class="form-control" value="<?php if(isset($proposal)){echo display_money(sprintf('%01.2f',$proposal->value));}?>" required />
        </div>
    </div>

    <div class="form-group">
        <label for="rated_power_mod">
            <?=$this->lang->line('application_rated_power');?> *</label>
        <div class="input-group">
            <div class="input-group-addon">
                <?=$core_settings->rated_power_measurement;?>
            </div>
            <input id="rated_power_mod" type="text" name="rated_power_mod" class="form-control" value="<?php if(isset($proposal)){echo display_money(sprintf('%01.2f',$proposal->rated_power_mod));}?>" required />
        </div>
    </div>

    <div class="form-group">
        <label for="delivery_time">
            <?=$this->lang->line('application_delivery_time');?> *</label>
        <div class="input-group">
            <input id="delivery_time" type="number" name="delivery_time" class="form-control" value="<?php if(isset($proposal)){echo $proposal->delivery_time;}?>" required />
        </div>
    </div>

    <div class="modal-footer">
        <input type="submit" name="send" id="send" class="btn btn-primary button-loader" data value="<?=$this->lang->line('application_save');?>" />
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>

<?php echo form_close(); ?>
<script>
    $(document).ready(function(){

        $('#send').on('click', function () {
            $('.modal').modal('hide');
        })

        $("#value").maskMoney({allowNegative: false, thousands:'.', decimal:',', affixesStay: false});

        $("#rated_power_mod").mask("#.00", {reverse: true});

    });

</script>