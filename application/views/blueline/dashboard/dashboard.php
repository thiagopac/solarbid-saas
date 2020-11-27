<style>
  @media (max-width: 767px){
  .content-area {
      padding: 0;
  }
  .row.mainnavbar {
    margin-bottom: 0px;
    margin-right: 0px;
  }
}

</style>

<div class="grid">
  <div class="grid__col-md-7 dashboard-header">
        <h1><?=sprintf($this->lang->line('application_welcome_back'), $this->user->firstname);?></h1>
<!--        <small>--><?//=sprintf($this->lang->line('application_welcome_subline'), $messages_new[0]->amount, $event_count_for_today);?><!--</small>-->
      </div>
      <div class="grid__col-md-5 dashboard-header hidden-xs">

          <div class="">
              <div class="btn-group pull-right margin-right-3">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      <?php if (isset($active_task_filter)) {
                          echo $this->lang->line('application_due_' . $active_task_filter);
                      } else {
                          echo $this->lang->line('application_task_filter');
                      } ?>
                      <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu pull-right" role="menu">
                      <li>
                          <a id="all" href="<?=base_url()?>dashboard/taskfilter/all">
                              <?=$this->lang->line('application_due_all');?>
                          </a>
                      </li>
                      <li>
                          <a id="delayed" href="<?=base_url()?>dashboard/taskfilter/delayed">
                              <?=$this->lang->line('application_due_delayed');?>
                          </a>
                      </li>
                      <li>
                          <a id="today" href="<?=base_url()?>dashboard/taskfilter/today">
                              <?=$this->lang->line('application_due_today');?>
                          </a>
                      </li>
                      <li>
                          <a id="two" href="<?=base_url()?>dashboard/taskfilter/two">
                              <?=$this->lang->line('application_due_two');?>
                          </a>
                      </li>
                      <li>
                          <a id="week" href="<?=base_url()?>dashboard/taskfilter/week">
                              <?=$this->lang->line('application_due_week');?>
                          </a>
                      </li>
                      <li>
                          <a id="weekahead" href="<?=base_url()?>dashboard/taskfilter/weekahead">
                              <?=$this->lang->line('application_due_weekahead');?>
                          </a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>


    <div class="grid__col-sm-12 grid__col-md-8 grid__col-lg-9 grid__col--bleed">
      <div class="grid grid--align-content-start">
<?php if($this->user->admin == "1"){ ?>
        <!--<div class="grid__col-12 update-panel">
          <div class="tile-base box-shadow">
              <div class="panel-heading red"><span class="title red"><?/*=$this->lang->line('application_update_available');*/?></span><span id="hideUpdate"class="pull-right"><i class="ion-close"></i></span></div>
              <div class="panel-content"><h2><a href="<?/*=base_url()*/?>settings/updates"><?/*=$this->lang->line('application_new_update_is_ready');*/?></a></h2></div>
              <div class="panel-footer">Version <span id="versionnumber"></span></div>
          </div>
        </div>-->

<!-- DASHBOARD - QUADRO DE PAGAMENTOS FEITOS DO MODULO FINANCEIRO -->
        <!-- <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6 grid__col-md-6 grid__col-lg-3">
            <div class="tile-base box-shadow tile-with-icon">
                  <div class="tile-icon hidden-md hidden-xs"><i class="ion-ios-analytics-outline"></i></div>
                  <div class="tile-small-header">
                      <?=$this->lang->line('application_'.$month);?> <?=$this->lang->line('application_payments');?>
                  </div>
                  <div class="tile-body">
                      <div class="number" id="number1"><?php if(empty($payments)){echo display_money(0, $core_settings->currency, 0);}else{echo display_money($payments, $core_settings->currency); }?></div>
                  </div>
                  <div class="tile-bottom">
                      <div class="progress tile-progress tt"
                      title="<?=display_money($payments);?> / <?=display_money($paymentsOutstandingMonth);?>">
                      <div class="progress-bar" role="progressbar" aria-valuenow="<?=$paymentsForThisMonthInPercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$paymentsForThisMonthInPercent?>%"></div>
                      </div>
                  </div>
            </div>
        </div> -->

<!-- DASHBOARD - QUADRO DE PAGAMENTOS PENDENTES DO MODULO FINANCEIRO -->
        <!-- <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6 grid__col-md-6 grid__col-lg-3">
            <div class="tile-base box-shadow">
                <div class="tile-icon hidden-md hidden-xs">
                    <i class="ion-ios-information-outline"></i>
                </div>
                <div class="tile-small-header">
                    <?=$this->lang->line('application_total_outstanding');?>
                </div>
                <div class="tile-body">
                    <div class="number" id="number2"><?php if(empty($paymentsoutstanding)){echo display_money(0, $core_settings->currency, 0);}else{echo display_money($paymentsoutstanding, $core_settings->currency); } ?></div>
                </div>
                <div class="tile-bottom">
                    <div class="progress tile-progress tile-progress--red tt"
                        title="<?=display_money($totalIncomeForYear);?> / <?=display_money($paymentsoutstanding);?>">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?=$paymentsOutstandingPercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$paymentsOutstandingPercent?>%">
                    </div>
                    </div>
                </div>
            </div>
        </div> -->
<!-- DASHBOARD - QUADRO DE PROJETOS EM ABERTO -->
        <!-- <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6  grid__col-md-6 grid__col-lg-3">
            <a href="<?=base_url();?>projects/filter/open" class="tile-base box-shadow">
            <div class="tile-icon hidden-md hidden-xs"><i class="ion-ios-lightbulb-outline"></i></div>
            <div class="tile-small-header"><?=$this->lang->line('application_open_projects');?></div>
              <div class="tile-body">
                  <?=$projects_open;?><small> / <?=$projects_all;?></small>
              </div>
              <div class="tile-bottom">
                      <div class="progress tile-progress tile-progress--green" >
                      <div class="progress-bar" role="progressbar" aria-valuenow="<?=$openProjectsPercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$openProjectsPercent?>%"></div>
                      </div>
                  </div>
            </a>
        </div> -->

<!-- DASHBOARD - QUADRO DE PROJETOS CONCLUÍDOS -->
        <!-- <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6  grid__col-md-6 grid__col-lg-3">
            <a href="<?=base_url();?>projects/filter/closed" class="tile-base box-shadow">
            <div class="tile-icon hidden-md hidden-xs"><i class="ion-ios-lightbulb-outline"></i></div>
            <div class="tile-small-header"><?=$this->lang->line('application_closed_projects');?></div>
              <div class="tile-body">
                  <?=$projects_open;?><small> / <?=$projects_all;?></small>
              </div>
              <div class="tile-bottom">
                      <div class="progress tile-progress tile-progress--green" >
                      <div class="progress-bar" role="progressbar" aria-valuenow="<?=$openProjectsPercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$openProjectsPercent?>%"></div>
                      </div>
                  </div>
            </a>
        </div> -->

<!-- DASHBOARD - QUADRO DE FATURAS EM ABERTO -->
        <!-- <div class="grid__col-6 grid__col-xs-6 grid__col-sm-6 grid__col-md-6 grid__col-lg-3">
            <a href="<?=base_url();?>invoices/filter/open" class="tile-base box-shadow">
            <div class="tile-icon hidden-md hidden-xs"><i class="ion-ios-paper-outline"></i></div>
            <div class="tile-small-header"><?=$this->lang->line('application_open_invoices');?></div>
              <div class="tile-body">
                  <?=$invoices_open;?><small> / <?=$invoices_all;?></small>
              </div>
              <div class="tile-bottom">
                      <div class="progress tile-progress tile-progress--orange">
                      <div class="progress-bar" role="progressbar" aria-valuenow="<?=$openInvoicePercent?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$openInvoicePercent?>%"></div>
                      </div>
                  </div>
            </a>
        </div> -->


<?php } ?>


</div>

<script type="text/javascript">
$(document).ready(function(){

});
</script>
