<?php
 if($comp_has_disps){
    foreach ($comp_has_disps as $comp_has_disp): ?>
        <li class="hidden" data-link="<?=base_url()?>cdisputes/view/<?=$comp_has_disp->dispute->id;?>">
          <div class="col col-1"><span class="dot"></span>
              <p class="title"><?php echo $core_settings->dispute_prefix.$comp_has_disp->dispute->dispute_reference; ?></p><span class="star-toggle icon dripicons-chevron-right"></span>
          </div>
          <div class="col col-2">
              <div class="subject"><?=date($core_settings->date_format." ".$core_settings->date_time_format, human_to_unix($comp_has_disp->dispute->due_date))?></div>
              <div class="date"><?=fnTimeElapsed($comp_has_disp->time, false, 'pt_BR') ?></div>
          </div>
        </li>
    <?php endforeach;?>

<?php } else{ ?>
        <li style="padding-left:21px"><?=$this->lang->line('application_no_messages');?></li>
<?php } ?>

<script>
jQuery(document).ready(function($) {

    $("#main .message-list li").removeClass("hidden").delay(300).addClass("visible");
    var cols = {},

        messageIsOpen = false;

        cols.showOverlay = function() {
            $('body').addClass('show-main-overlay');
        };
        cols.hideOverlay = function() {
            $('body').removeClass('show-main-overlay');
        };


        cols.showMessage = function() {
            $('body').addClass('show-message');
            messageIsOpen = true;
        };
        cols.hideMessage = function() {
            $('body').removeClass('show-message');
            $('#main .message-list li').removeClass('active');
         messageIsOpen = false;
        };


        cols.showSidebar = function() {
            $('body').addClass('show-sidebar');
        };
        cols.hideSidebar = function() {
            $('body').removeClass('show-sidebar');
        };

        // Show sidebar when trigger is clicked

        $('.trigger-toggle-sidebar').on('click', function() {
            cols.showSidebar();
            cols.showOverlay();
        });


        $('.trigger-message-close').on('click', function() {
            cols.hideMessage();
            cols.hideOverlay();
        });


      // When you click on a message, show it

        $('#main .message-list li').on('click', function(e) {
            var item = $(this),
            target = $(e.target);
            NProgress.start();

            if(target.is('label')) {
                item.toggleClass('selected');
            }else{
                if(messageIsOpen && item.is('.active')) {
                    cols.hideMessage();
                    cols.hideOverlay();
                    NProgress.done();
                } else {
                    if(messageIsOpen) {
                        cols.hideMessage();
                        item.addClass('active');
                        setTimeout(function() {
                        var url = item.data('link');
                        if (url.indexOf('#') === 0) {

                        }else{
                            $.get(url, function(data) {
                            $('#message').html(data);
                        }).done(function() {
                            NProgress.done();
                            cols.showMessage();
                                });
                            }
                        }, 300);
                    } else {

                        item.addClass('active');

                        var url = item.data('link');
                        if (url.indexOf('#') === 0) {
                        }else{
                            $.get(url, function(data) {
                            $('#message').html(data);
                        }).done(function() {
                        NProgress.done();
                        cols.showMessage();

                            });
                        }
                    }
                    cols.showOverlay();
                }
            }
        });

        // This will prevent click from triggering twice when clicking checkbox/label

        $('input[type=checkbox]').on('click', function(e) {
            e.stopImmediatePropagation();
        });


      // When you click the overlay, close everything

        $('#main > .overlay').on('click', function() {
            cols.hideOverlay();
            cols.hideMessage();
            cols.hideSidebar();
        });


      // Enable sexy scrollbars
        $('.nano').nanoScroller();

});
</script>
<?//=var_dump($comp_has_disp->time)?>