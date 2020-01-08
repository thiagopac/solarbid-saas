<?php
$attributes = ['class' => '', 'id' => 'wildcard_form'];
echo form_open_multipart($form_action, $attributes);
?>
    <input id="id" type="hidden" name="id"  value="<?php if(isset($object)){echo $object->id;}?>"/>
    <input id="class_name" type="hidden" name="class_name"  value="<?=$class_name;?>"/>
    <input id="redirect" type="hidden" name="redirect"  value="<?php echo $redirect;?>"/>

    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_name');?> *
        </label>
        <input id="name" type="text" name="name" class="required form-control"  value="<?php if(isset($object)){echo $object->name;}?>"  required/>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>