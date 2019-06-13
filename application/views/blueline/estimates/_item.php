<?php   
$attributes = array('class' => '', 'id' => '_item');
echo form_open($form_action, $attributes); 
?>


<input id="invoice_id" type="hidden" name="invoice_id" value="<?=$estimate->id;?>" />


    <div>
        <div class="form-group">
            <label for="name"><?=$this->lang->line('application_name');?></label>
            <input id="name" name="name" type="text" class="form-control"  value="" />
        </div>
        <div class="form-group">
            <label for="value"><?=$this->lang->line('application_value');?></label>
            <input id="value" type="text" name="value" class="form-control number"  value="" />
        </div>
        <div class="form-group">
            <label for="type"><?=$this->lang->line('application_type');?></label>
            <input id="type" type="text" name="type" class="form-control"  value="" />
        </div>
    </div>
 <div class="form-group">
        <label for="amount"><?=$this->lang->line('application_quantity_hours');?></label>
        <input id="amount" type="text" name="amount" class="required form-control number"  value="<?php if(isset($estimate_has_items)){ echo $estimate_has_items->amount; }else{echo '1';} ?>"  />
 </div>
 <div class="form-group">
        <label for="description"><?=$this->lang->line('application_description');?></label>
        <textarea id="description" class="form-control" name="description"><?php if(isset($estimate_has_items)){ echo $estimate_has_items->description; } ?></textarea>
 </div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>
<?php echo form_close(); ?>