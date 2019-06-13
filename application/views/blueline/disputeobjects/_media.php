<?php
$attributes = array('class' => 'dynamic-form', 'data-reload' => 'media', 'id' => '_media');
echo form_open_multipart($form_action, $attributes);
?>
<?php if(isset($media)){ ?>
    <input id="id" type="hidden" name="id" value="<?php echo $media->id; ?>" />
<?php } ?>
    <input id="date" type="hidden" name="date" value="<?php echo $datetime; ?>" />

    <div class="form-group">
        <label for="filename">
            <?=$this->lang->line('application_filename');?>
        </label>
        <input id="filename" type="text" name="filename" class="form-control" value="<?php if(isset($media)){echo $media->filename;} ?>" />
    </div>
    <div class="form-group">
        <label for="kind">
            <?=$this->lang->line('application_kind');?>
        </label>
        <?php $options = array();
        $options['area'] = $this->lang->line('application_area');
        $options['bill'] = $this->lang->line('application_bill');
        $options['other'] = $this->lang->line('application_other');

        if (isset($media) && is_object($media)) {
            $kind = $media->kind;
        }
        echo form_dropdown('kind', $options, $kind, 'style="width:100%" class="chosen-select"'); ?>
    </div>
    <div class="form-group">
        <label for="description">
            <?=$this->lang->line('application_observations');?>
        </label>
        <input id="description" type="text" name="description" class="form-control" value="<?php if(isset($media)){echo $media->description;} ?>" />
    </div>
<?php if(!isset($media)){ ?>

    <div class="form-group">
        <label for="userfile">
            <?=$this->lang->line('application_file');?>
        </label>
        <div>
            <input id="uploadFile" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>" disabled="disabled" />
            <div class="fileUpload btn btn-primary">
                <span><i class="icon dripicons-upload"></i><span class="hidden-xs"> <?=$this->lang->line('application_select');?></span></span>
                <input id="uploadBtn" type="file" name="userfile" class="upload" />
            </div>
        </div>
    </div>

<?php } ?>

    <div class="modal-footer">
        <button type="submit" id="send" name="send" class="btn btn-primary send button-loader">
            <?=$this->lang->line('application_save');?>
        </button>
        <a class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>

<?php echo form_close(); ?>