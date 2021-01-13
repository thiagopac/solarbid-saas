<div class="col-sm-12  col-md-12 main">

    <?php

    $arr_registry = (array) $registry;

    $arr_object = (array) $object;

    $arr_object_table = (array) $object::table();
    $idx3 = 0;

    $arr_relations = array();

    foreach ($arr_object_table as $key => $value){

        if ($idx3 == 9){
            $arr_relation_names = $arr_object_table[$key];

            foreach ($arr_relation_names as $relation_name => $relation_value){
                array_push($arr_relations, $relation_value);
            }

        }

        $idx3++;
    }

//    var_dump($arr_relations);
    ?>

    <div class="row">
        <div class="pull-left">
            <a href="javascript:history.back()" class="btn btn-primary"><?=$this->lang->line('application_back')?></a>
        </div>
    </div>

    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_audit_registry');?>
            </div>
            <div class="table-div">

                <table id="registry_table" class="table no-sort noclick" cellspacing="0" cellpadding="0">
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
                        <?php foreach ($arr_registry as $key => $value) : ?>
                            <?php if (strcmp(preg_replace('/[^A-Za-z0-9. -]/', '', $key), 'ActiveRecordModelattributes') == 0) : ?>
                                <?php $arr_field_names = $arr_registry[$key]; ?>
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
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_audit_object_reflected');?> <span style="text-transform: none !important;">[<?=$registry->subject?>]</span>
            </div>
            <div class="table-div">
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

                            <?php if (strcmp(preg_replace('/[^A-Za-z0-9. -]/', '', $key), 'ActiveRecordModelattributes') == 0) : ?>

                                <?php $arr_field_names = $arr_object[$key]; ?>
                                <?php foreach ($arr_field_names as $field_name => $field_value) : ?>
                                    <tr>
                                        <td style="text-align: right">
                                            <b><?=$field_name?></b>
                                        </td>
                                        <td style="text-align: left">

                                            <?php if (strpos($field_name, 'password') === false) : ?>
                                                <?=$field_value?>
                                            <?php endif; ?>

                                            <?php foreach ($arr_relations as $relation) : ?>

                                                <?php if ($field_name == $relation->foreign_key[0]) : ?>
                                                    <a href="<?=base_url()?>audits/relation_record/<?=$relation->class_name?>/<?=$field_value?>" data-toggle="mainmodal"><span class="badge btn-primary" style="padding: 5px 7px 5px 7px">Ver registro [<?=$relation->class_name?>]</span></a>
                                                <?php endif; ?>

                                            <?php endforeach; ?>


                                        </td>
                                    </tr>
                                <?php endforeach;  ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

