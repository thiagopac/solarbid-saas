<?php
$attributes = ['class' => '', 'id' => 'wildcard_form'];
echo form_open_multipart($form_action, $attributes);
?>
    <input id="id" type="hidden" name="id"  value="<?php if(isset($object)){echo $object->id;}?>"/>
    <input id="class_name" type="hidden" name="class_name"  value="<?=$class_name;?>"/>
    <input id="redirect" type="hidden" name="redirect"  value="<?php echo $redirect;?>"/>

<?php
$arr = $object != null ? (array) $object : (array) new $class_name();

$idx = 0;

foreach ($arr as $key => $value) : ?>

    <?php if ($idx == 1) : ?>
        <?php $arr_field_names = $arr[$key]; ?>

        <?php foreach ($arr_field_names as $field_name => $field_value) : ?>

            <?php if (!in_array($field_name, $object_properties_not_draw)) : ?>

                <div class="form-group">
                    <label>
                        <?=$this->lang->line("application_$field_name") != null ? $this->lang->line("application_$field_name") : $field_name ?>
                    </label>
                    <input id="<?=$field_name?>" type="text" name="<?=$field_name?>" class="form-control"  value="<?php if(isset($arr)){echo $field_value;}?>" />
                </div>

            <?php endif; ?>

       <?php endforeach;  ?>

    <?php endif; ?>

    <?php $idx++; ?>

<?php endforeach; ?>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>