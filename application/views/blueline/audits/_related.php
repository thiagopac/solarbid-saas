<?php
$arr_object = (array) $object;
$idx = 0;
?>

<div class="form-group">
    <div class="subcont preview">
        <div>
            <table id="object_table" class="table no-sort noclick" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th style="text-align: right; width: 15%" class="no-sort">
                        <?=$this->lang->line('application_field'); ?>
                    </th>
                    <th class="no-sort">
                        <?=$this->lang->line('application_value')?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($arr_object as $key => $value) : ?>
                    <?php if ($idx == 1) : ?>
                        <?php $arr_field_names = $arr_object[$key]; ?>
                        <?php foreach ($arr_field_names as $field_name => $field_value) : ?>
                            <tr>
                                <td style="text-align: right">
                                    <b><?=$field_name?></b>
                                </td>
                                <td style="text-align: left">
                                    <?=$field_value?>
                                </td>
                            </tr>
                        <?php endforeach;  ?>
                    <?php endif; ?>
                    <?php $idx++; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn" data-dismiss="modal">
        <?=$this->lang->line('application_close');?>
    </a>
</div>