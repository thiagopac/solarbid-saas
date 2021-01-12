<div class="col-sm-12  col-md-12 main">

    <div class="row">
        <div class="btn-group pull-right-responsive margin-right-3">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php if (isset($ticketFilter)) {
                    echo $ticketFilter;
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
                <table class="data-sorting table" id="registries" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <th class="hidden-xs" style="width:70px">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th style="width:50px">
                        <?=$this->lang->line('application_model');?>
                    </th>
                    <th>
                        <?=$this->lang->line('application_query');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_created_at')?>
                    </th>
                    </thead>
                    <?php foreach ($registries as $value):?>
                        <tr id="<?=$value->id;?>">
                            <td style="width:70px">
                                <?=$value->id;?>
                            </td>
                            <td>
                                <?=$value->subject;?>
                            </td>
                            <td class="hidden-xs">
                                <?=$value->query;?>
                            </td>
                            <td class="hidden-xs">
                                <?=empty($value->created_at) ? '-' : date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($value->created_at))?>
                            </td>

                        </tr>

                    <?php endforeach;?>
                </table>

            </div>
        </div>
    </div>
</div>