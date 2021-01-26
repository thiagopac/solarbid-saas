<?php

$idx = 0;

//var_dump($related_objects);exit;
?>
<div class="col-sm-12  col-md-12 main">

    <div class="row">
        <div class="btn-group pull-right-responsive margin-right-3">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php if (isset($auditFilter)) {
                    echo $auditFilter;
                }else{
                    echo $this->lang->line('application_filter');
                }
                ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <?php foreach ($submenu as $name => $value):?>
                    <li>
                        <a id="<?php $val_id = explode('/', $value); if (!is_numeric(end($val_id))) {
                            echo end($val_id);
                        } else {
                            $num = count($val_id) - 2;
                            echo $val_id[$num];
                        } ?>" href="<?=site_url($value);?>">
                            <?=$name?>
                        </a>
                    </li>
                <?php endforeach;?>

            </ul>
        </div>
    </div>
    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_registries');?>
            </div>
            <div class="table-div">
                <table class="data-sorting table noclick" id="audit_registries" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <th style="width:10px">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th style="width:50px">
                        <?=$this->lang->line('application_model');?>
                    </th>
                    <th>
                        <?=$this->lang->line('application_type');?>
                    </th>
                    <th>
                        <?=$this->lang->line('application_related_objects');?>
                    </th>
<!--                    <th>-->
<!--                        --><?//=$this->lang->line('application_content');?>
<!--                    </th>-->
                    <th style="width:100px" class="hidden-xs">
                        <?=$this->lang->line('application_created_at')?>
                    </th>
                    </thead>
                    <?php foreach ($registries as $registry):?>
                        <tr id="<?=$registry->id;?>">
                            <td style="width:70px">
                                <?=$registry->id;?>
                            </td>
                            <td>
                                <?=$registry->subject;?>
                            </td>
                            <td>
                                <?=$registry->type;?>
                            </td>
                            <td>
<!--                                --><?//=var_dump($related_objects[$idx]);?>
                                <?php



                                $object = $related_objects[$idx];
                                $arr_object = (array) $object;

                                if (!in_array($registry->subject, $do_not_render)){

                                    $arr_object_table = (array) $object::table();
                                    $arr_relations = array();

                                    foreach ($arr_object_table as $key => $value){

                                        if (strcmp(preg_replace('/[^A-Za-z0-9. -]/', '', $key), 'ActiveRecordTablerelationships') == 0){

                                            $arr_relation_names = $arr_object_table[$key];

                                            foreach ($arr_relation_names as $relation_name => $relation_value){
                                                array_push($arr_relations, $relation_value);
                                            }

                                        }
                                    }
                                }

                                ?>

                                <?php foreach ($arr_object as $key => $value) : ?>

                                    <?php if (strcmp(preg_replace('/[^A-Za-z0-9. -]/', '', $key), 'ActiveRecordModelattributes') == 0) : ?>

                                        <?php $arr_field_names = $arr_object[$key]; ?>
                                        <?php foreach ($arr_field_names as $field_name => $field_value) : ?>
                                            <?php foreach ($arr_relations as $relation) : ?>

                                                <?php if ($field_name == $relation->foreign_key[0]) : ?>
                                                    <div style="padding: 5px; margin: 0 0 2px 0;  background: #f1f1f1; font-size: 9px">
                                                        <?php
                                                        $field_class = $relation->class_name;

                                                        if ($field_name == 'flow_id'){
                                                            $correct_foreign_key = 'flow_id';
                                                        }else if ($field_name == 'store_flow_id'){
                                                            $correct_foreign_key = 'store_flow_id';
                                                        }else{
                                                            $correct_foreign_key = $field_name;
                                                        }
                                                        
                                                        $field_object = $field_class::find("$correct_foreign_key = ?", $field_value);

                                                        echo (string) "<strong>".$field_class."</strong> ";
                                                        $arr_field_object = (array) $field_object;
                                                        echo json_encode($arr_field_object);
                                                        ?>
                                                    </div>
                                                <?php endif; ?>

                                            <?php endforeach; ?>
                                        <?php endforeach;  ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                            </td>
<!--                            <td class="hidden-xs">-->
<!--                                --><?//=$registry->serialization;?>
<!--                            </td>-->
                            <td class="hidden-xs">
                                <?=empty($registry->created_at) ? '-' : date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($registry  ->created_at))?>
                            </td>

                        </tr>
                        <?php $idx++ ?>
                    <?php endforeach;?>
                </table>

            </div>
        </div>
    </div>
</div>