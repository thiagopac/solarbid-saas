<div class="row tile-row" style="margin-bottom: 15px">

    <div class="tile-button">
        <a href="<?=base_url()?>blog">
            <div class="col-md-3 col-xs-3 tile">

                <div class="icon-frame">
                    <i class="ion-ios-browsers"></i>
                </div>
                <h1>
                <span>
                    <?= $this->lang->line('application_all_posts'); ?>
                </span>
                </h1>
            </div>
        </a>
    </div>
    <div class="tile-button">
        <a href="<?=base_url()?>blog/post">
            <div class="col-md-3 col-xs-3 tile">

                <div class="icon-frame">
                    <i class="ion-ios-compose"></i>
                </div>
                <h1>
                <span>
                    <?= $this->lang->line('application_write'); ?>
                </span>
                </h1>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xs-6 tile hidden-xs">
        <div style="margin-top: -4px; margin-bottom: 17px; height: 80px;">
        </div>
    </div>
</div>