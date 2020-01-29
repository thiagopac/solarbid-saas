<link href="<?=base_url()?>assets/blueline/css/plugins/messages.css" rel="stylesheet">

<div class="col-sm-12 col-md-12 messages">

    <main id="main" class="projects">
        <div class="overlay"></div>
        <div>
            <div class="flex">

                <?php foreach ($steps as $step) : ?>
                    <div class="scrum-board">
                        <h2><?=$step->name?></h2>

                        <?php foreach ($items as $item) : ?>

                            <?php if($item->project_step_id == $step->id) : ?>
                                <div class="project input-group" data-link="<?=base_url()?>cprojects/view/<?=$item->id;?>">
                                    <span><?=$item->flow_id != null ? $item->flow_id : $item->store_flow_id ;?></span>
                                </div>
                            <?php endif; ?>

                        <?php endforeach; ?>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <div id="message"></div>
</div>
<script>
    jQuery(document).ready(function($) {

        $("#main .project").removeClass("hidden").delay(300).addClass("visible");
        var cols = {}, messageIsOpen = false;

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
            $('#main .project').removeClass('active');
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

        $('#main .project').on('click', function(e) {
            var item = $(this),
                target = $(e.target);
            NProgress.start();

            if(target.is('label')) {
                item.toggleClass('selected');
            }else{
                if(messageIsOpen && item.is('.active')) {
                    cols.hideMessage();
                    cols.hideOverlay();

                    item.find(".indicator").addClass('dripicons-chevron-down');
                    item.find(".indicator").removeClass('dripicons-chevron-right');

                    NProgress.done();
                } else {
                    if(messageIsOpen) {
                        cols.hideMessage();
                        item.addClass('active');

                        item.find(".indicator").addClass('dripicons-chevron-right');
                        item.find(".indicator").removeClass('dripicons-chevron-down');

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
                                // console.log(data);
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

        // When you click the overlay, close everything

        $('#main > .overlay').on('click', function() {
            cols.hideOverlay();
            cols.hideMessage();
            cols.hideSidebar();
        });

    });
</script>