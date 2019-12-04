<div class="col-sm-12  col-md-12 main">

    <div class="row tile-row">

        <div class="tile-button">
            <a href="<?= base_url() ?>flows/find" data-toggle="mainmodal">
                <div class="col-md-3 col-xs-3 tile">

                    <div class="icon-frame">
                        <i class="ion-search"></i>
                    </div>
                    <h1>
                <span>
                    <?= $this->lang->line('application_find_flow'); ?>
                </span>
                    </h1>
                </div>
            </a>

        </div>
        <div class="tile-button">
            <a href="<?= base_url() ?>flows/list_simulator">
                <div class="col-md-3 col-xs-3 tile">

                    <div class="icon-frame">
                        <i class="ion-stats-bars"></i>
                    </div>
                    <h1>
                <span>
                    <?= $this->lang->line('application_simulator_flows'); ?>
                </span>
                    </h1>
                </div>
            </a>
        </div>
        <div class="tile-button">

            <a href="<?= base_url() ?>flows/list_store">
                <div class="col-md-3 col-xs-3 tile">

                    <div class="icon-frame">
                        <i class="ion-android-cart"></i>
                    </div>
                    <h1>
                <span>
                    <?= $this->lang->line('application_store_flows'); ?>
                </span>
                    </h1>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-xs-3 tile hidden-xs">
            <div style="width:97%; margin-top: -4px; margin-bottom: 17px; height: 80px;">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_store_flows');?>
            </div>
            <div class="table-div" id="div-store-flows" name="store-flows">
                <table class="data-sorting table" id="store-flows" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>
                        <th style="width:20px">
                            <?=$this->lang->line('application_id');?>
                        </th>
                        <th style="width:100px">
                            <?=$this->lang->line('application_code');?>
                        </th>
                        <th style="width:120px">
                            <?=$this->lang->line('application_city');?>
                        </th>
                        <th style="width:100px">
                            <?=$this->lang->line('application_state');?>
                        </th>
                        <th style="width:100px">
                            <?=$this->lang->line('application_created_at');?>
                        </th>
                    </thead>
                    <?php foreach ($store_flows as $store_flow):?>
                        <tr id="<?=$store_flow->id;?>">
                            <td class="hidden-xs" style="width:70px">
                                <?=$store_flow->id;?>
                            </td>
                            <td>
                                <?=$store_flow->code?>
                            </td>
                            <td class="hidden-xs" style="width:15px">
                                <?=City::find($store_flow->city)->name?>
                            </td>
                            <td>
                                <?=State::find($store_flow->state)->name?>
                            </td>
                            <td>
                                <?=$store_flow->created_at?>
                            </td>
                        </tr>

                    <?php endforeach;?>
                </table>

            </div>
        </div>
    </div>
</div>