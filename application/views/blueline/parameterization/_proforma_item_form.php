<?php
$attributes = ['class' => '', 'id' => 'proforma_item_form'];
echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <label><?=$this->lang->line('application_proforma');?></label>
        <?php

//        var_dump($proforma_item);exit;

        foreach ($proformas as $proforma):
            $proformas[$proforma->id] = $proforma->name;
        endforeach;

        $proformas['0'] = '-';

        if(isset($proforma_item)){$proforma_selected = $proforma_item->pv_proforma_id;}
        echo form_dropdown('pv_proforma_id', $proformas, $proforma_selected, 'style="width:100%" class="chosen-select"');?>
    </div>
    <div class="form-group">
        <label><?=$this->lang->line('application_item');?></label>
        <?php

        foreach ($pv_items as $pv_item):
            $pv_items[$pv_item->id] = $pv_item->description;
        endforeach;

        $pv_items['0'] = '-';

        if(isset($proforma_item)){$pv_item_selected = $proforma_item->pv_item_id;}
        echo form_dropdown('pv_item_id', $pv_items, $pv_item_selected, 'style="width:100%" class="chosen-select"');?>
    </div>
    <div class="form-group">
        <label for="qty">
            <?=$this->lang->line('application_qty');?> *
        </label>
        <input id="qty" type="text" name="qty" class="required form-control"  value="<?php if(isset($proforma_item)){echo $proforma_item->qty;}?>"  required/>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>