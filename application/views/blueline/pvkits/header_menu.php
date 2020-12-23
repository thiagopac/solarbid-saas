<div class="row tile-row">

    <div class="tile-button">
        <a href="<?= base_url() ?>pvkits/create" data-toggle="mainmodal">
            <div class="col-md-3 col-xs-3 tile">

                <div class="icon-frame">
                    <i class="ion-android-add-circle"></i>
                </div>
                <h1>
                <span>
                    <?= $this->lang->line('application_add_pv_kit'); ?>
                </span>
                </h1>
            </div>
        </a>
    </div>

    <div class="tile-button">
        <a href="<?= base_url() ?>pvkits">
            <div class="col-md-3 col-xs-3 tile">

                <div class="icon-frame">
                    <i class="ion-eye"></i>
                </div>
                <h1>
                <span>
                    <?= $this->lang->line('application_view_kits_table'); ?>
                </span>
                </h1>
            </div>
        </a>
    </div>

    <div class="tile-button">
        <a href="<?= base_url() ?>pvkits/view_all">
            <div class="col-md-3 col-xs-3 tile">

                <div class="icon-frame">
                    <i class="ion-eye"></i>
                </div>
                <h1>
                <span>
                    <?= $this->lang->line('application_view_kits_template'); ?>
                </span>
                </h1>
            </div>
        </a>
    </div>

    <div class="tile-button">
        <a href="<?= base_url() ?>pvkits/get_edmond_kits">
            <div class="col-md-3 col-xs-3 tile">
                <div class="icon-frame">
                    <i class="ion-ios-cloud-download"></i>
                </div>
                <h1>
                <span>
                    <?= $this->lang->line('application_pv_kits_appsolar'); ?>
                </span>
                </h1>
            </div>
        </a>
    </div>

    <div class="hidden-xs">
        <div style="margin-top: -4px; margin-bottom: 17px; height: 90px;">
        </div>
    </div>
</div>