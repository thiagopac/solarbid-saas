
          <div class="row">
              <div class="col-xs-12 col-sm-12">
            <a href="<?=base_url()?>estimates/update/<?=$estimate->id;?>/view" class="btn btn-primary" data-toggle="mainmodal"><i class="icon dripicons-pencil visible-xs"></i><span class="hidden-xs"><?=$this->lang->line('application_edit_estimate');?></span></a>
			<div class="btn-group">
			  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    <?=$this->lang->line('application_pdf');?> <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">
			    <li><a href="<?=base_url()?>estimates/preview/<?=$estimate->id;?>" ><?=$this->lang->line('application_download_pdf');?></a></li>
			    <li><a href="<?=base_url()?>estimates/preview/<?=$estimate->id;?>/proposal" target="_blank"><?=$this->lang->line('application_preview_pdf');?></a></li>
			  </ul>
			</div>

			<?php if (($estimate->estimate_status == 'Open' || $estimate->estimate_status == 'Revised') && is_object($estimate->company)) {
        ?><a href="<?=base_url()?>estimates/sendestimate/<?=$estimate->id; ?>" class="btn btn-primary"><i class="icon dripicons-mail visible-xs"></i><span class="hidden-xs"><?=$this->lang->line('application_send_estimate_to_client'); ?></span></a><?php
    } ?>
			<?php if ($estimate->estimate_status == 'Accepted') {
        ?><a href="<?=base_url()?>estimates/estimateToInvoice/<?=$estimate->id; ?>" class="btn btn-success"><i class="icon dripicons-mail visible-xs"></i><span class="hidden-xs"><?=$this->lang->line('application_convert_to_invoice'); ?></span></a><?php
    } ?>
			<?php if ($estimate->estimate_status == 'Invoiced') {
        ?><a href="<?=base_url()?>invoices/view/<?=$estimate->id; ?>" class="btn btn-success"><i class="icon dripicons-mail visible-xs"></i><span class="hidden-xs"><?=$this->lang->line('application_go_to_invoice'); ?></span></a><?php
    } ?>

              </div>
          </div>
          <div class="row">

		<div class="col-md-12">
			<div class="box-shadow">
		<div class="table-head"><?=$this->lang->line('application_estimate_details');?></div>
		<div class="subcont">
		<ul class="details col-xs-12 col-sm-6">
			<li><span><?=$this->lang->line('application_estimate_id');?>:</span> <?=$core_settings->estimate_prefix;?><?=$estimate->estimate_reference;?></li>
			<li class="<?=$estimate->estimate_status;?>"><span><?=$this->lang->line('application_status');?>:</span>
			<?php $unix = human_to_unix($estimate->estimate_sent . ' 00:00');
                    $change_date = '';
                switch ($estimate->estimate_status) {
                    case 'Open': $label = 'label-default'; break;
                    case 'Accepted': $label = 'label-success'; $change_date = 'title="' . date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date . ' 00:00')) . '"'; break;
                    case 'Sent': $label = 'label-warning'; $change_date = 'title="' . date($core_settings->date_format, human_to_unix($estimate->estimate_sent . ' 00:00')) . '"'; break;
                    case 'Declined': $label = 'label-important'; $change_date = 'title="' . date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date . ' 00:00')) . '"'; break;
                      case 'Invoiced': $label = 'label-chilled'; $change_date = 'title="' . $this->lang->line('application_Accepted') . ' ' . date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date . ' 00:00')) . '"'; break;
                      case 'Revised': $label = 'label-warning'; $change_date = 'title="' . $this->lang->line('application_Revised') . ' ' . date($core_settings->date_format, human_to_unix($estimate->estimate_accepted_date . ' 00:00')) . '"'; break;

                    default: $label = 'label-default'; break;
                }
            ?>
			<a class="label <?=$label?> tt" <?=$change_date;?>><?=$this->lang->line('application_' . $estimate->estimate_status);?>
			</a>
			</li>
			<!--<li><span><?/*=$this->lang->line('application_issue_date');*/?>:</span> <?php /*$unix = human_to_unix($estimate->issue_date . ' 00:00'); echo date($core_settings->date_format, $unix);*/?></li>-->
			<li><span><?=$this->lang->line('application_due_date');?>:</span> asdas </li>

			<li><span><?=$this->lang->line('application_vat'); ?>:</span> aa</li>

			<li><span><?=$this->lang->line('application_projects'); ?>:</span> <?php echo $estimate->project->name; ?></li>

			<span class="visible-xs"></span>
		</ul>
		<ul class="details col-xs-12 col-sm-6">

			<li><span><?=$this->lang->line('application_company'); ?>:</span> <a href="<?=base_url()?>clients/view/<?=$estimate->company->id; ?>" class="label label-info"><?=$estimate->company->name; ?></a></li>
			<li><span><?=$this->lang->line('application_contact'); ?>:</span> <?php if (is_object($estimate->company->client)) {
                    ?><?=$estimate->company->client->firstname; ?> <?=$estimate->company->client->lastname; ?> <?php
                } else {
                    echo '-';
                } ?></li>
			<li><span><?=$this->lang->line('application_street'); ?>:</span> <?=$estimate->company->address; ?></li>
			<li><span><?=$this->lang->line('application_city'); ?>:</span> <?=zip_position($estimate->company->zipcode, $estimate->company->city); ?></li>
			<li style="border-bottom: 1px solid #ececec;"><span><?=$this->lang->line('application_state'); ?>:</span> <?php echo $estimate->company->state = empty($estimate->company->state) ? '-' : $estimate->company->state; ?></li>
		</ul>
		<br clear="all">
		</div>
		</div>
		</div>
		</div>

		<div class="row">
		<div class="col-md-12">
		<div class="box-shadow">
		<div class="table-head"><?=$this->lang->line('application_items');?> <?php if ($estimate->estimate_status != 'Accepted' && $estimate->estimate_status != 'Invoiced') {
                ?><span class=" pull-right"><a href="<?=base_url()?>estimates/item/<?=$estimate->id; ?>" class="btn btn-md btn-primary" data-toggle="mainmodal"><i class="fa icon dripicons-plus visible-xs"></i><span class="hidden-xs"><?=$this->lang->line('application_add_item'); ?></span></a></span> <?php
            } ?></div>
		<div class="table-div min-height-200">
		<table class="table noclick" id="items" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
		<thead>
		<th width="4%"><?=$this->lang->line('application_id');?></th>
			<th><?=$this->lang->line('application_name');?></th>
			<th class="hidden-xs"><?=$this->lang->line('application_description');?></th>
			<th class="hidden-xs" width="8%"><?=$this->lang->line('application_hrs_qty');?></th>
			<th class="hidden-xs" width="12%"><?=$this->lang->line('application_unit_price');?></th>
			<th class="hidden-xs" width="12%"><?=$this->lang->line('application_sub_total');?></th>
		</thead>
		<?php $i = 0; $sum = 0;?>
		<?php foreach ($items as $value):?>
		<tr id="<?=$value->id;?>" >

		    <td class="option" style="text-align:left;" width="8%">
                a
			</td>

			<td><?php if (!empty($value->name)) {
                echo $value->name;
            } else {
                echo $estimate->invoice_has_items[$i]->item->name;
            }?></td>
			<td class="hidden-xs">aa</td>
			<td class="hidden-xs" align="center">aa</td>
			<td class="hidden-xs">aa</td>
			<td class="hidden-xs">aa</td>

		</tr>

		<?php $sum = $sum + $estimate->invoice_has_items[$i]->amount * $estimate->invoice_has_items[$i]->value; $i++;?>

		<?php endforeach;
        if (empty($items)) {
            echo "<tr><td colspan='6'>" . $this->lang->line('application_no_items_yet') . '</td></tr>';
        }

        ?>

		<tr class="active">
			<td colspan="5" align="right"><?=$this->lang->line('application_total');?></td>
			<td>Número de propostas</td>
		</tr>
		</table>

		</div>
		</div>
		<div class="row">


<div class=" col-md-12" align="right">

</div>
</div>

<br>
		</div>
		</div>