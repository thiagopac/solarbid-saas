<div class="col-sm-12  col-md-12 main">

    <div class="row">
        <a href="<?=base_url()?>disputeobjects/create" class="btn btn-primary" data-toggle="mainmodal"><?=$this->lang->line('application_create_dispute_object');?></a>
    </div>
    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_dispute_objects');?>
            </div>
            <div class="table-div">
                <table class="data table" id="disputeobjects" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <th width="70px" class="hidden-xs">
                        <?=$this->lang->line('application_dispute_id');?>
                    </th>
                    <th>
                        <?=$this->lang->line('application_owner_name');?>
                    </th>
                    <th width="15%" style="text-align: center" class="hidden-xs">
                        <?=$this->lang->line('application_city');?> / <?=$this->lang->line('application_state');?>
                    </th>

                    <!--<th width="8%" style="text-align: center" class="hidden-xs">
                        <?/*=$this->lang->line('application_rated_power');*/?>
                    </th>-->

                    <th style="text-align: center">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <tbody>
                    <?php foreach ($disputeobjects as $value): ?>
                        <tr <?=$value->inactive == 'yes' ? "style='text-decoration:line-through;'" : ''?> id="<?=$value->id;?>">
                            <td class="hidden-xs">
                                <?=$core_settings->disputeobject_prefix;?><?=$value->disputeobject_reference;?>
                            </td>
                            <td>
                                <?=$value->owner_name;?>
                            </td>
                            <td style="text-align: center">
                                <?=$value->city;?>/<?=$value->state;?>
                            </td>

                            <!--<td style="text-align: center">
                                <?/*=$value->rated_power_mod;*/?> <?/*=$core_settings->rated_power_measurement;*/?>
                            </td>-->

                            <td style="text-align: center" class="option" width="8%">
                                <a href="<?=base_url()?>disputeobjects/update/<?=$value->id;?>" class="btn-option" data-toggle="mainmodal"><i class="icon dripicons-gear"></i></a>
                            </td>
                        </tr>
                    </tbody>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>