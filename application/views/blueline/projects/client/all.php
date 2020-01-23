<div class="col-sm-12 col-md-12 messages">
    <!--<main id="main">
        <div class="overlay"></div>
        <header class="header">
            <h1 class="page-title">
                <div class="message-list-header">
                    <span id="inbox-folder"><i class="icon dripicons-inbox"></i> <?/*=$this->lang->line('application_INBOX');*/?></span>
                </div>
            </h1>
        </header>
        <div class="action-bar">
            <ul>
                <li>
                    <div class="btn-group">
                        <a class="btn btn-primary message-list-load inbox-folder" id="message-trigger" style="display: ;" role="button" href="<?/*=base_url()*/?>cinbox/itemslist" title="Inbox"><i class="icon glyphicon glyphicon-refresh"></i> <span class="hidden-xs"><?/*=$this->lang->line('application_refresh');*/?></span></a>
                    </div>
                </li>
            </ul>
        </div>
        <div id="main-nano-wrapper" class="nano">
            <div class="nano-content">
                <ul id="message-list" class="message-list">

                </ul>
            </div>
        </div>
    </main>
    <div id="message">
    </div>-->

    <div ng-app="ScrumApp">
        <div>
            <div class="flex">
                <div class="scrum-board backlog">
                    <h2>Passo 0</h2>
                    <div class="input-group overflow">
                        <span>Wash dishes</span>
                    </div>
                    <div class="input-group overflow">
                        <span>Make bed</span>
                    </div>
                    <div class="input-group overflow">
                        <span>Cook dinner</span>
                    </div>
                    <div class="input-group overflow">
                        <span>Ask wife permission to go on trip</span>
                    </div>
                </div>
                <div class="scrum-board">
                    <h2>Passo 1</h2>
                </div>
                <div class="scrum-board">
                    <h2>Passo 2</h2>
                </div>
                <div class="scrum-board">
                    <h2>Passo 3</h2>
                </div>
                <div class="scrum-board">
                    <h2>Passo 4</h2>
                </div>
                <div class="scrum-board">
                    <h2>Passo 5</h2>
                </div>
            </div>
        </div>
</div>
</div>
<script>
    jQuery(document).ready(function($) {

        $(document).on("click", '.message-list-load', function(e) {
            e.preventDefault();

            messageheader(this);

            $('.message-list-footer').fadeOut('fast');

            var url = $(this).attr('href');
            if (url.indexOf('#') === 0) {

            } else {
                $.get(url, function(data) {
                    $('#message-list').html(data);

                }).done(function() {});
            }
        });
        $('#message-trigger').click();

        //message list menu
        function messageheader(active) {
            var classes = $(active).attr("class").split(/\s/);
            if (classes[3]) {
                $('.message-list-header span').hide();
                $('.message-list-header #' + classes[3]).fadeIn('slow');
            }

        }

        // Search box responsive stuff

        $('.search-box input').on('focus', function() {
            if ($(window).width() <= 1360) {
                cols.hideMessage();
            }
        });

    });
</script>