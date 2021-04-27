<div class="col-sm-12  col-md-12 main">
    <?php include_once ("header_menu.php")?>

    <div class="row">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_all_posts');?>
            </div>
            <div class="table-div">
                <table class="data table" id="posts" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                    <thead>

                    <th class="hidden-xs" style="width:70px">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th>
                        <?=$this->lang->line('application_title');?>
                    </th>
                    <th>
                        <?=$this->lang->line('application_author');?>
                    </th>
                    <th style="text-align: center">
                        <?=$this->lang->line('application_views');?>
                    </th>
                    <th  style="text-align: center">
                        <?=$this->lang->line('application_created_at');?>
                    </th>
                    <th  style="text-align: center">
                        <?=$this->lang->line('application_updated_at');?>
                    </th>
                    <th  style="text-align: center" class="hidden-xs">
                        <?=$this->lang->line('application_active');?>
                    </th>
                    <th style="text-align: center">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($posts as $post):?>

                        <tr id="<?=$post->id;?>">
                            <td class="hidden-xs" style="width:70px">
                                <?=$post->id; ?>
                            </td>
                            <td>
                                <?= $post->title; ?>
                            </td>
                            <td>
                                <?= $post->author; ?>
                            </td>
                            <td style="text-align: center">
                                <?= $post->views; ?>
                            </td>
                            <td style="text-align: center">
                                <?= date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($post->created_at)) ?>
                            </td>
                            <td style="text-align: center">
                                <?= date($core_settings->date_format . ' ' . $core_settings->date_time_format, strtotime($post->updated_at)) ?>
                            </td>
                            <td style="text-align: center" class="hidden-xs">
                                <?php if (!is_null($post->active)) {
                                    echo $post->active == 0 ? '<span style="color:red">'.$this->lang->line('application_no').'</span>' : $this->lang->line('application_yes');
                                }?>
                            </td>
                            <td class="option" width="8%">
                                <button type="button" title="<?=$this->lang->line('application_delete'); ?>" class="btn-option delete po tt" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>blog/post/delete/<?=$post->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$post->id;?>'>" data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>"><i class="icon dripicons-cross"></i></button>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
                <br clear="all">

            </div>
        </div>
    </div>
</div>