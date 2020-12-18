<div class="col-sm-12  col-md-12 main">

    <?php include_once ("header_menu.php")?>
    <div class="row">

        <div class="btn-group pull-right-responsive margin-right-3 hidden-xs">
            <button id="bulk-button" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?=$this->lang->line('application_bulk_actions');?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right bulk-dropdown" role="menu">
                <li data-action="start_at_today"><a id="" href="#"><?=$this->lang->line('application_start_at_today');?></a></li>
                <li data-action="start_at_blank"><a id="" href="#"><?=$this->lang->line('application_start_at_blank');?></a></li>
                <li data-action="stop_at_today"><a id="" href="#"><?=$this->lang->line('application_stop_at_today');?></a></li>
                <li data-action="stop_at_blank"><a id="" href="#"><?=$this->lang->line('application_stop_at_blank');?></a></li>
                <li data-action="inactivate"><a id="" href="#"><?=$this->lang->line('application_inactivate');?></a></li>
                <li data-action="activate"><a id="" href="#"><?=$this->lang->line('application_activate');?></a></li>
                <li data-action="delete"><a id="" href="#"><?=$this->lang->line('application_delete');?></a></li>
            </ul>
            <?php
            $form_action = base_url() . 'pvkits/bulkedmond/';
            $attributes = ['class' => '', 'id' => 'bulk-form'];
            echo form_open($form_action, $attributes); ?>
            <input type="hidden" name="list" id="list-data" />
            </form>
        </div>

    </div>
    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_pvkits');?>
            </div>
            <div class="table-div" id="div-pvkits" name="pv-kits">
                <table class="data-sorting table noclick" id="pvkits" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <th class="hidden-xs no_sort simplecheckbox" style="width:16px">
                        <input class="checkbox-nolabel" type="checkbox" id="checkAll" name="selectall" value="">
                    </th>
<!--                    <th style="width:20px">-->
<!--                        --><?//=$this->lang->line('application_id');?>
<!--                    </th>-->
                    <th>
                        <?=$this->lang->line('application_observations');?>
                    </th>
                    <th style="width:120px">
                        <?=$this->lang->line('application_pv_power');?>
                    </th>
                    <th class="hidden-xs" style="text-align: right">
                        <?=$this->lang->line('application_price');?>
                    </th>
                    </thead>
                    <?php foreach ($all_kits as $kit):?>
                        <tr id="<?=$kit->_id;?>">
                            <td class="hidden-xs noclick simplecheckbox" style="width:16px">
                                <input class="checkbox-nolabel bulk-box" type="checkbox" name="bulk[]" value="<?=$kit->_id?>">
                            </td>
<!--                            <td class="hidden-xs" style="width:70px">-->
<!--                                --><?//=$kit->id;?>
<!--                            </td>-->
                            <td><?=$kit->quickNotes?></td>
                            <td class="hidden-xs" style="width:15px">
                                <?=$kit->totalModulePower?> <?=$core_settings->rated_power_measurement?>
                            </td>
                            <td style="text-align: right">
                                <small>
                                    <?= $core_settings->money_symbol; ?>
                                </small>
                                <?= display_money($kit->finalPrice); ?>
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