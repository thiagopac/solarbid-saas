<div id="row">

	<?php include 'parameterization_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
		<div class="box-shadow">
		<div class="table-head">
			<?=$table_title;?>
				<span class="pull-right">
					<a href="<?=base_url()?><?=$create_method;?>" class="btn btn-primary" data-toggle="mainmodal">
						<?=$add_button_title;?>
					</a>
				</span>
		</div>

		<div class="table-div responsive">
			<table id="dealers" class="data-no-search table noclick" cellspacing="0" cellpadding="0">
				<thead>
                    <?php foreach ($column_titles as $column):?>
                        <th>
                            <?=$column;?>
                        </th>
                    <?php endforeach;?>
				</thead>

				<?php foreach ($collection_objects as $object) : ?>

                    <tr id="<?=$object->id;?>">

                        <?php foreach ($object_properies_draw as $index => $property):?>
                            <td style="<?php echo $index==0 ? 'width:50px' : '';?>">
                                <?php

                                if ($object_classes_draw[$index] == 'self'){
                                    if ($object->$property)
                                        echo $object->$property;
                                }else{
                                    echo $object->{$object_classes_draw[$index]}->$property;
                                }

                                ?>
                            </td>
                        <?php endforeach;?>

                        <td class="option" width="8%">
                            <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?><?=$delete_method;?>/<?=$object->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$object->id;?>'>"
                             data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                <i class="icon dripicons-cross"></i>
                            </button>
                            <a href="<?=base_url()?><?=$update_method?>/<?=$object->id;?>" class="btn-option" data-toggle="mainmodal">
                                <i class="icon dripicons-gear"></i>
                            </a>
                        </td>
                    </tr>

				<?php endforeach;?>
			</table>
		</div>
	</div>
	</div>
</div>