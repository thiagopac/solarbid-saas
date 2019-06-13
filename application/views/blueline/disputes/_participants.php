<div class="form-group">
    <div class="table-div responsive">
        <table id="participants" class="table noclick" cellspacing="0" cellpadding="0">
            <thead>
                <th width="10%">
                    <?=$this->lang->line('application_id');?>
                </th>
                <th width="65%">
                    <?=$this->lang->line('application_name');?>
                </th>
                <th width="25%">
                    <?=$this->lang->line('application_city');?>/<?=$this->lang->line('application_state');?>
                </th>
            </thead>
            <?php foreach ($participants as $participant):?>

                <tr>
                    <td>
                        <?=$participant->id;?>
                    </td>
                    <td>
                        <?=$participant->name;?>
                    </td>
                    <td>
                        <?=$participant->city;?>/<?=$participant->state;?>
                    </td>
                </tr>

            <?php endforeach;?>
        </table>
    </div>
</div>
<div class="modal-footer">
    <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
</div>