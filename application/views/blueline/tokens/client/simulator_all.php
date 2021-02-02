<div class="col-sm-12  col-md-12 main">
    <?php include_once ("header_menu.php")?>
    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_simulator_tokens');?>
            </div>
            <div class="table-div" id="div-simulator-tokens-client" name="simulator-tokens-client">
                <table class="data-sorting table" id="simulator_tokens_client" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
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
                            <?=$this->lang->line('application_type');?>
                        </th>
                        <th style="width:200px; text-align: center">
                            <?=$this->lang->line('application_submited_project');?>
                        </th>
                        <th style="width:100px; text-align: center">
                            <?=$this->lang->line('application_approved_project');?>
                        </th>
                        <th style="width:200px; text-align: center">
                            <?=$this->lang->line('application_created_at');?>
                        </th>
                    </thead>
                    <?php foreach ($simulator_flows as $simulator_flow):?>
                        <tr id="<?=$simulator_flow->code;?>">
                            <td>
                                <?=$simulator_flow->code?>
                            </td>
                            <td class="hidden-xs" style="width:15px">
                                <?=$simulator_flow->city_obj->name?>
                            </td>
                            <td>
                                <?=$simulator_flow->state_obj->name?>
                            </td>
                            <td>
                                <?=$this->lang->line("application_flow_$simulator_flow->type");?>
                            </td>
                            <td style="text-align: center">
                                <?php if ($simulator_flow->integrator_approved == 1) : ?>
                                <label class="label label-success"><?=$this->lang->line('application_yes');?></label>
                                <?php else : ?>
                                    <label class="label label-important"><?=$this->lang->line('application_no');?></label>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center">
                                <?php if ($simulator_flow->solarbid_approved == 1) : ?>
                                    <label class="label label-success"><?=$this->lang->line('application_yes');?></label>
                                <?php else : ?>
                                    <label class="label label-important"><?=$this->lang->line('application_no');?></label>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center">
                                <?=date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($simulator_flow->created_at))?>
                            </td>
                        </tr>

                    <?php endforeach;?>
                </table>

            </div>
        </div>
    </div>
</div>