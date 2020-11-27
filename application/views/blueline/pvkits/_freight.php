<?php
$attributes = array('class' => '', 'data-reload' => 'div-pvkits', 'id' => '_freight');
echo form_open_multipart($form_action, $attributes); ?>

<label style="text-transform: none">
    <?=$this->lang->line('application_freight_modal_desc');?>
</label>
<div class="form-group">
    <div class="table-div" id="div-pvkits" name="pv-kits">
        <table class="data-sorting table noclick" id="states" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
            <thead>
            <th class="" style="width: 30%">
                <?=$this->lang->line('application_state')?>
            </th>
            <th class="" style="width: 35%">
                <?=$this->lang->line('application_capital_value')?> (<?=$core_settings->money_symbol?>)
            </th>
            <th class="" style="width: 35%">
                <?=$this->lang->line('application_inland_value')?> (<?=$core_settings->money_symbol?>)
            </th>
            </thead>
            <?php foreach ($states as $state):?>
                <?php $freight = Freight::find('first', ['conditions' => ['pv_kit_id = ? AND state_id = ?', $kit->id, $state->id]]) ?>
                    <tr id="<?=$state->id;?>">
                        <td class="noclick"">
                            <?=$state->name?>
                        </td>
                        <td class="noclick"">
                            <input id="<?=$state->id?>_capital" type="text" name="<?=$state->id?>_capital" class="form-control value" value="<?php if ($state->id == $freight->state_id) {
                                echo display_money(sprintf('%01.2f', $freight->capital_value));
                            } ?>" />
                        </td>
                        <td class="noclick"">
                            <input id="<?=$state->id?>_inland" type="text" name="<?=$state->id?>_inland" class="form-control value" value="<?php if ($state->id == $freight->state_id) {
                                echo display_money(sprintf('%01.2f', $freight->inland_value));
                            } ?>" />
                        </td>
                    </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>
<div class="modal-footer">
    <input type="submit" name="send" class="btn btn-primary" value="<?= $this->lang->line('application_save'); ?>"/>
    <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
</div>
<?php echo form_close(); ?>
<script>
    $(document).ready(function(){
        $(".value").maskMoney({allowNegative: false, thousands:'.', decimal:',', affixesStay: false});
    });
</script>