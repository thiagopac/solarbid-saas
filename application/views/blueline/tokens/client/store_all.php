<div class="col-sm-12  col-md-12 main">
    <?php include_once ("header_menu.php")?>
    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_store_tokens');?>
            </div>
            <div class="table-div" id="div-store-tokens-client" name="store-tokens-client">
                <table class="data-sorting table" id="store_tokens_client" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                        <th style="width:200px">
                            <?=$this->lang->line('application_code');?>
                        </th>
                        <th style="width:200px">
                            <?=$this->lang->line('application_city');?>
                        </th>
                        <th style="width:200px">
                            <?=$this->lang->line('application_state');?>
                        </th>
                        <th style="width:200px">
                            <?=$this->lang->line('application_approved_project');?>
                        </th>
                        <th style="width:200px">
                            <?=$this->lang->line('application_created_at');?>
                        </th>
                    </thead>
                    <?php foreach ($store_flows as $store_flow):?>
                        <tr id="<?=$store_flow->code;?>">
                            <td>
                                <?=$store_flow->code?>
                            </td>
                            <td>
                                <?=$store_flow->city_obj->name?>
                            </td>
                            <td>
                                <?=$store_flow->state_obj->name?>
                            </td>
                            <td>
                                <?php if ($store_flow->integrator_approved == 1) : ?>
                                    <label class="label label-success"><?=$this->lang->line('application_yes');?></label>
                                <?php else : ?>
                                    <label class="label label-important"><?=$this->lang->line('application_no');?></label>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?=date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($store_flow->created_at))?>
                            </td>
                        </tr>

                    <?php endforeach;?>
                </table>

            </div>
        </div>
    </div>
</div>
