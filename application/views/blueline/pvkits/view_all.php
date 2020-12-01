
<div class="col-sm-12  col-md-12 main">

    <?php include_once ("header_menu.php")?>

    <div class="row">

        <div class="btn-group pull-right-responsive margin-right-3">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <?php if (isset($template_filter)) {
                    echo $template_filter;
                }else{
                    echo $this->lang->line('application_filter');
                }
                ?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right" role="menu">
                <?php foreach ($submenu as $item):?>
                    <?php foreach ($item as $key => $value):?>
                        <li>
                            <a href="<?=site_url($value);?>">
                                <?=$key?>
                            </a>
                        </li>
                    <?php endforeach;?>
                <?php endforeach;?>
            </ul>
        </div>

    </div>
    <div class="row">

        <?php foreach ($pv_kits as $kit):?>
            <div class="col-md-3">
                <div class="box-shadow" style="background: white">
                    <div class="table-head">
                        <div style="text-align: center !important;"><?=$kit->kit_provider?></div>
                    </div>
                    <div class="pull-right" style="margin-right: 10px"><h2><?= $kit->kit_power ?><small><?= $core_settings->rated_power_measurement; ?></small></h2></div>
                    <img width="100%" src="<?=$kit->image?>" class="" />
                    <hr />
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div style="text-align: center"><span style="font-size: 20px">Geração até <span style="font-weight: bolder; font-size: 22px">XYZ</span> kWh/mês</span></div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr />
                            <div class="col-md-6" style="text-align: center">Inversor:</div>
                            <div class="col-md-6" style="text-align: center">Módulos:</div>
                        </div>
                        <div class="col-md-12">
                            <span class="col-md-6" style="text-align: center; font-size: 18px; font-weight: bold"><?= $kit->pv_inverter ?></span>
                            <div class="col-md-6" style="text-align: center; font-size: 18px; font-weight: bold"><?= $kit->pv_module ?></div>
                        </div>
                    </div>

                    <div class="row collapse" id="collapse<?=$kit->id?>">
                        <div class="col-md-12">
                            <div style="text-align: center; font-size: 12px">
                                <p><?= $kit->desc_inverter ?></p>
                                <p><?= $kit->desc_module ?></p>
                                <p><?= $kit->insurance ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div style="text-align: center">
                            <a class="badge btn-light collapse_btn" style="padding: 6px 25px 6px 22px; border-radius: 15px; background: #ebebff; color: #485379" data-toggle="collapse" href="#collapse<?=$kit->id?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                + Mais info
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <div style="text-align: center; font-size: 24px">
                                <strong><?= $core_settings->money_symbol; ?><?= display_money($kit->price) ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
                <p></p>
            </div>
        <?php endforeach; ?>

    </div>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>