<div id="row">

	<?php include 'parameterization_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
		<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_proforma_items');?>
				<span class="pull-right">
                    <?php if ($show_add_button == true) : ?>
                        <a href="<?=base_url()?>parameterization/proforma_item_create" class="btn btn-primary flat-invert" data-toggle="mainmodal">
                            <?=$this->lang->line('application_add_new');?>
                        </a>
                    <?php endif; ?>
				</span>
		</div>
		<div class="table-div responsive">
			<table id="proforma_items" class="data-no-search table noclick" cellspacing="0" cellpadding="0">
				<thead>
                    <th style="width:80px" class="hidden-xs">
                        <?=$this->lang->line('application_id');?>
                    </th>
					<th class="hidden-xs">
						<?=$this->lang->line('application_proforma');?>
					</th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_item');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_qty');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_action');?>
                    </th>
				</thead>
				<?php foreach ($proforma_items as $proforma_item):?>

				<tr id="<?=$proforma_item->id;?>">
					<td class="hidden-xs">
						<?=$proforma_item->id;?>
					</td>
					<td>
                        <?=$proforma_item->pv_proforma->name;?>
					</td>
                    <td>
                        <?=$proforma_item->pv_item->description;?>
                    </td>
                    <td>
                        <?=$proforma_item->qty;?>
                    </td>
					<td class="option" width="8%">
                        <?php if ($show_delete_button == true) : ?>
                            <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>parameterization/proforma_item_delete/<?=$proforma_item->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$proforma_item->id;?>'>"
                             data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                <i class="icon dripicons-cross"></i>
                            </button>
                        <?php endif; ?>
                        <?php if ($show_edit_button == true) : ?>
                            <a href="<?=base_url()?>parameterization/proforma_item_update/<?=$proforma_item->id;?>" class="btn-option" data-toggle="mainmodal">
                                <i class="icon dripicons-gear"></i>
                            </a>
                        <?php endif; ?>
					</td>
				</tr>

				<?php endforeach;?>
			</table>
		</div>
	</div>
	</div>
</div>