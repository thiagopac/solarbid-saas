<div class="col-sm-12  col-md-12 main">

    <?php include_once ("header_menu.php")?>

    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_pvkits');?>
            </div>
            <div class="table-div" id="div-pvkits" name="pv-kits">
                <table class="data-sorting table noclick" id="pvkits" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
<!--                    <th style="width:20px">-->
<!--                        --><?//=$this->lang->line('application_id');?>
<!--                    </th>-->
                    <th>
                        <?=$this->lang->line('application_observations');?>
                    </th>
                    <th style="width:120px; text-align: center">
                        <?=$this->lang->line('application_pv_power');?>
                    </th>
                    <th class="hidden-xs" style="text-align: center">
                        <?=$this->lang->line('application_price');?>
                    </th>
                    <th class="hidden-xs" style="text-align: center">
                        <?=$this->lang->line('application_imported');?>
                    </th>
                    <th class="hidden-xs" style="text-align: center">
                            <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($all_kits as $kit):?>
                        <tr id="<?=$kit->_id;?>">
<!--                            <td class="hidden-xs" style="width:70px">-->
<!--                                --><?//=$kit->id;?>
<!--                            </td>-->
                            <td><?=$kit->quickNotes?></td>
                            <td class="hidden-xs" style="width:15px; text-align: center">
                                <?=$kit->totalModulePower?> <?=$core_settings->rated_power_measurement?>
                            </td>
                            <td style="text-align: center">
                                <small>
                                    <?= $core_settings->money_symbol; ?>
                                </small>
                                <?= display_money($kit->finalPrice); ?>
                            </td>
                            <td class="hidden-xs" style="width:15px; text-align: center">
                                <? if($kit->imported == 1) : ?> <span class="label label-success"><?=$this->lang->line('application_yes')?></span> <?php else: ?> <span class="label label-important"><?=$this->lang->line('application_no')?> <?endif;?>
                            </td>
                            <td  style="text-align: center">
                                <a href="<?=base_url()?>pvkits/update_edmond_kit/<?=$kit->_id ?>" class="btn btn-primary flat-invert" data-toggle="mainmodal">
                                    <?=$this->lang->line('application_import');?>
                                </a>
                            </td>
                        </tr>

                    <?php endforeach;?>
                </table>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('input[name="bulk[]"]').on('change', function () {
            $(this).closest('tr').toggleClass('active');
        })

        $('input[name="selectall"]').on('change', function () {
            if ($(this).prop('checked')) {
                $('tbody>tr').addClass('active');
            }else{
                $('tbody>tr').removeClass('active');
            }

        })
    });
</script>