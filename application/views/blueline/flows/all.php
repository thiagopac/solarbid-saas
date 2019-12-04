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
    </div>


</div>