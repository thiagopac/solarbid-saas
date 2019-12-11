<div class="col-sm-12  col-md-12 main">
    <div class="row tile-row">

        <div class="tile-button">
            <a href="<?=base_url()?>clients/find" data-toggle="mainmodal">
                <div class="col-md-3 col-xs-3 tile">

                    <div class="icon-frame">
                        <i class="ion-search"></i>
                    </div>
                    <h1>
                <span>
                    <?= $this->lang->line('application_find_company'); ?>
                </span>
                    </h1>
                </div>
            </a>
        </div>
        <div class="tile-button">
            <a href="<?=base_url()?>clients/company/create" data-toggle="mainmodal">
                <div class="col-md-3 col-xs-3 tile">

                    <div class="icon-frame">
                        <i class="ion-android-add-circle"></i>
                    </div>
                    <h1>
                <span>
                    <?= $this->lang->line('application_add_new_company'); ?>
                </span>
                    </h1>
                </div>
            </a>
        </div>
        <div class="tile-button">
            <a href="<?=base_url()?>clients/companies">
                <div class="col-md-3 col-xs-3 tile">

                    <div class="icon-frame">
                        <i class="ion-flash"></i>
                    </div>
                    <h1>
                <span>
                    <?= $this->lang->line('application_companies'); ?>
                </span>
                    </h1>
                </div>
            </a>
        </div>
        <div class="tile-button">
            <a href="<?=base_url()?>clients/screening_companies">
                <div class="col-md-3 col-xs-3 tile">

                    <div class="icon-frame">
                        <i class="ion-flash-off"></i>
                    </div>
                    <h1>
                <span>
                    <?= $this->lang->line('application_screening_companies'); ?>
                </span>
                    </h1>
                </div>
            </a>
        </div>
        <div class="col-md-0 col-xs-0 tile hidden-xs">
            <div style="margin-top: -4px; margin-bottom: 17px; height: 80px;">
            </div>
        </div>
    </div>