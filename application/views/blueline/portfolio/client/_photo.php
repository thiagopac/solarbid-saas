<?php
    $attributes = array('class' => '', 'data-reload' => 'div-photos', 'id' => '_photo');
    echo form_open_multipart($form_action, $attributes);
?>

    <div class="form-group">
        <label for="userfile"><?= $this->lang->line('application_file'); ?></label>
        <div>
            <input id="uploadFile" class="form-control uploadFile"
                   placeholder="<?= $this->lang->line('application_choose_file'); ?>" disabled="disabled"/>
            <div class="fileUpload btn btn-primary">
                <span><i class="icon dripicons-upload"></i><span
                            class="hidden-xs"> <?= $this->lang->line('application_select'); ?></span></span>
                <input id="uploadBtn" type="file" name="userfile" class="upload"/>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" id="send" name="send" class="btn btn-primary send button-loader"><?= $this->lang->line('application_save'); ?></button>
        <a class="btn btn-default" data-dismiss="modal"><?= $this->lang->line('application_close'); ?></a>
    </div>

<?php echo form_close(); ?>