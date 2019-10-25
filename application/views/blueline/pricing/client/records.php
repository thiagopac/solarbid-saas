<div class="col-md-12 col-lg-12">
    <div class="row tile-row">

        <div class="tile-button">
            <a href="<?=base_url()?>cpricing/edit" data-toggle="mainmodal">
                <div class="col-md-3 col-xs-6 tile">

                    <div class="icon-frame hidden-xs">
                        <span class="iconify" data-icon="subway:pencil" data-inline="true"></span>
                    </div>
                    <h1>
                <span>
                    <?=$this->lang->line('application_edit_table');?>
                </span>
                    </h1>
                </div>
                <div class="col-md-6 col-xs-12 tile hidden-xs">
                    <div style="width:97%; margin-top: -4px; margin-bottom: 17px; height: 80px;">
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="grid__col-md-7 dashboard-header">
        <h1><?=$this->lang->line('application_price_table')?> #1</h1>
        <small>
            <?=$this->lang->line('application_at_least_one_pricing_table');?>
        </small>
    </div>
    <div class="box-shadow">


        <div class="table-div">

            <p></p>

            <?php
                $last_pricing_field = null;
                $repeat = false;
            ?>

            <? foreach ($pricing_fields as $pricing_field) : ?>

            <?php if ($pricing_field->power_bottom === $last_pricing_field->power_bottom
                    && $pricing_field->power_top === $last_pricing_field->power_top){
                    $repeat = true;
            } ?>

            <div class="row">

                <div class="col-md-3">
                    <ul class="details">
                        <li>
                            <?php if($repeat === false): ?>
                            <span>Potência da Usina</span>
                            <h2><small>de</small> <?=$pricing_field->power_bottom?>kWp <small>até</small> <?=$pricing_field->power_top?>kWp</h2>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="details">
                        <li>
                            <span>Distância até local de instalação</span>
                            <h2><small>de</small> <?=$pricing_field->distance_bottom?>km <small>até</small> <?=$pricing_field->distance_top?>km</h2>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="details" style="text-align: right; padding-right: 40px;">
                        <li>
                            <span><?=$this->lang->line('application_Wp_value');?></span>
<!--                            <h2>R$5,34</h2>-->
                            <h2><span class="badge btn-danger" style="font-size: 14px; font-weight: 100"><?=$this->lang->line('application_undefined')?></span></h2>
                            <a>Editar</a>
                        </li>
                    </ul>
                </div>
            </div>


            <?php
                if ($repeat === true){

                    echo '<hr style="height:3px;border:none;color:#333;background-color:#efefef;" />';
                }

                $last_pricing_field = $pricing_field;
                $repeat = false;
            ?>

            <? endforeach; ?>

        </div>
    </div>
    <p></p>
</div>


<?php //var_dump($var_dump);  ?>