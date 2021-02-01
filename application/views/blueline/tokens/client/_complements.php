<?php
    $attributes = ['class' => '', 'id' => '_complements'];
    echo form_open_multipart($form_action, $attributes);
?>
    <input type="hidden" name="code" value="<?=$flow->code?>"/>
    <div id="container_complements">
        <?php foreach ($complements as $idx => $complement) : ?>
            <div class="row" id="row_complement">
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="name">
                            <?=$this->lang->line('application_description');?>
                        </label>
                        <input id="name_<?=$idx?>" type="text" name="name_<?=$idx?>" class="required form-control" value="<?=$complement->name?>"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group read-only">
                        <label for="price">
                            <?=$this->lang->line('application_price');?>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <?= $core_settings->money_symbol ?>
                            </div>
                            <input id="price_<?=$idx?>" readonly" type="text" name="price_<?=$idx?>" class="form-control price" value="<?=$complement->price?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger pull-right" style="width: 54px; height: 54px;" id="btn_remove">
                        <i style="font-size: 18px" class="icon dripicons-trash"></i>
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <label><span class="badge btn-warning">ATENÇÃO</span> A Solarbid irá precificar os complementos inseridos, coloque apenas a descrição dos itens de forma completa</label>
    <div class="modal-footer">
        <a class="btn btn-success pull-left" id="btn_add">
            <i style="font-size: 16px;" class="icon dripicons-plus"></i>
        </a>
        <input type="submit" id="save" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>
<script>
    $(document).ready(function(){

        let row_complement = '<div class="row" id="row_complement">'+
            '   <div class="col-md-7">'+
            '      <div class="form-group"><label for="name"><?=$this->lang->line("application_description");?></label><input id="name" type="text" name="name" class="required form-control" value=""/></div>'+
            '   </div>'+
            '   <div class="col-md-3">'+
            '      <div class="form-group read-only">'+
            '         <label for="price"><?=$this->lang->line("application_price");?></label> '+
            '         <div class="input-group">'+
            '            <div class="input-group-addon"><?=$core_settings->money_symbol ?></div>'+
            '            <input id="price" readonly type="text" name="price" class="form-control price"/> '+
            '         </div>'+
            '      </div>'+
            '   </div>'+
            '   <div class="col-md-2"><button class="btn btn-danger pull-right" style="width: 54px; height: 54px;" id="btn_remove"><i style="font-size: 14px" class="icon dripicons-trash"></i></button> </div>'+
            '</div>';


        $(".price").maskMoney({allowNegative: false, thousands:'.', decimal:',', affixesStay: false}).trigger('mask.maskMoney');

        $(".modal-footer").on('click', '#btn_add', function(){

            // console.log($("input[name^='name']").length)

            $("#container_complements").append(row_complement);
            $(".price").maskMoney({allowNegative: false, thousands:'.', decimal:',', affixesStay: false}).trigger('mask.maskMoney');
        })

        $("#container_complements").on('click', "#btn_remove", function(){
            this.closest("#row_complement").remove()
        })

        $("#_complements").click(function(e){

            $("#container_complements").find($("input[name^='name']")).each(function (index){
                $(this).attr('name', 'name_' + index).attr('id', 'name_' + index)
            });

            $("#container_complements").find($("input[name^='price']")).each(function (index){
                $(this).attr('name', 'price_' + index).attr('id', 'price_' + index)
            });

        });

    });
</script>