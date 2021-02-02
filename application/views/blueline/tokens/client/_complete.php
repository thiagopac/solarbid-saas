<?php
    $attributes = ['class' => '', 'id' => '_complete'];
    echo form_open_multipart($form_action, $attributes);
?>
    <input type="hidden" id="code" name="code" value="<?=$flow->code?>">
    <label style="text-transform: none">
        <?=$this->lang->line('application_complete_appointment_are_you_sure');?>
    </label>
<p> </p>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    <?=$this->lang->line('application_completed_visit_date');?>
                </label>
                <input class="form-control datepicker" name="completed_date" id="completed_date" type="text" required/>
            </div>
        </div>
    </div>
<!--    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="userfile"><?/*=$this->lang->line('application_appointment_photos');*/?></label><div>
                    <input id="counter_files" class="form-control uploadFile" placeholder="<?/*=$this->lang->line('application_choose_file');*/?>" disabled="disabled" />
                    <div class="fileUpload btn btn-primary">
                        <span><i class="icon dripicons-upload"></i><span class="hidden-xs"> <?/*=$this->lang->line('application_select');*/?></span></span>
                        <input id="uploadBtn" type="file" name="userfile" class="upload" multiple/>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>
                    <?=$this->lang->line('application_relevant_appointment_comments');?>
                </label>
                <textarea id="comments" name="comments" rows="6" class="textarea summernote-modal"></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-success" value="<?=$this->lang->line('application_yes');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_cancel');?>
        </a>
    </div>
<?php echo form_close(); ?>
<script>
    $(document).ready(function(){
        $("input[type='file']").on("change", function(){
            let numFiles = $(this).get(0).files.length;
            const counter = numFiles > 1 ? numFiles + ' arquivos' : numFiles + ' arquivo';
            $("#counter_files").val(counter)
        })
    });
</script>

