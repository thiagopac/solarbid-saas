<?php
/**
 * @file        Application View
 * @author      Thiago Pires
 * @copyright   Solarbid
 * @version     1.x.x
 */

$act_uri = $this->uri->segment(1, 0);
$lastsec = $this->uri->total_segments();
$act_uri_submenu = $this->uri->segment($lastsec);
if (!$act_uri) {
    $act_uri = 'cpricing';
}
if (is_numeric($act_uri_submenu)) {
    $lastsec = $lastsec - 1;
    $act_uri_submenu = $this->uri->segment($lastsec);
}
$message_icon = false;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="robots" content="none" />

    <link rel="SHORTCUT ICON" href="<?=base_url()?>assets/blueline/img/favicon.ico" />

    <?php if ($core_settings->push_active == 1) { ?>
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <?php } ?>

    <title>
        <?=$core_settings->company;?>
    </title>

    <script src="<?=base_url()?>assets/blueline/js/plugins/jquery-2.2.4.min.js"></script>

    <?php
    require_once '_partials/fonts.php';
    require_once '_partials/js_vars.php';
    ?>

    <link rel="stylesheet" href="<?=base_url()?>assets/blueline/css/app.css" />
    <link rel="stylesheet" href="<?=base_url()?>assets/blueline/css/user.css" />
    <link rel="stylesheet" href="<?=base_url()?>assets/blueline/css/important.css" />
<!--    <link rel="stylesheet" href="--><?//=base_url()?><!--assets/blueline/css/line-awesome.min.css">-->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <?=get_theme_colors($core_settings);?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div id="mainwrapper">

    <div class="side">
        <div class="sidebar-bg"></div>
        <div class="sidebar">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><img src="<?=base_url()?><?=$core_settings->logo;?>" alt="<?=$core_settings->company;?>"></a>
            </div>

            <ul class="nav nav-sidebar">
                <?php foreach ($menu as $key => $value) {
                    ?>
                    <?php
                    if (strtolower($value->link) == 'cmessages') {
                        $message_icon = true;
                    } ?>
                    <li id="<?=strtolower($value->name); ?>" class="<?php if ($act_uri == strtolower($value->link)) {
                        echo 'active';
                    } ?>"><a href="<?=site_url($value->link); ?>"><span class="menu-icon"><i class="fa <?=$value->icon; ?>"></i></span><span class="nav-text"><?php echo $this->lang->line('application_' . $value->link); ?></span>
                            <?php if (strtolower($value->link) == 'cmessages' && $messages_new[0]->amount != '0') {
                                ?><span class="notification-badge"><?=$messages_new[0]->amount; ?></span><?php
                            } ?>
                            <?php if (strtolower($value->link) == 'quotations' && $quotations_new[0]->amount != '0') {
                                ?><span class="notification-badge"><?=$quotations_new[0]->amount; ?></span><?php
                            } ?>
                            <?php if (strtolower($value->link) == 'cestimates' && $estimates_new[0]->amount != '0') {
                                ?><span class="notification-badge"><?=$estimates_new[0]->amount; ?></span><?php
                            } ?>

                        </a> </li>
                    <?php
                } ?>
            </ul>

        </div>
    </div>

    <div class="content-area">
        <div class="row mainnavbar">
            <div class="topbar__left noselect">
                <a href="#" class="menu-trigger"><i class="ion-navicon visible-xs"></i></a>
                <i class="icon dripicons-menu topbar__icon fc-dropdown--trigger hidden"></i>
                <div class="fc-dropdown shortcut-menu grid">
                    <div class="grid__col-6 shortcut--item"><i class="ion-ios-paper-outline shortcut--icon"></i>
                        <?=$this->lang->line('application_create_invoice');?>
                    </div>
                    <div class="grid__col-6 shortcut--item"><i class="ion-ios-lightbulb shortcut--icon"></i>
                        <?=$this->lang->line('application_create_project');?>
                    </div>
                    <div class="grid__col-6 shortcut--item"><i class="ion-ios-pricetags shortcut--icon"></i>
                        <?=$this->lang->line('application_create_ticket');?>
                    </div>
                    <div class="grid__col-6 shortcut--item"><i class="ion-ios-email shortcut--icon"></i>
                        <?=$this->lang->line('application_write_messages');?>
                    </div>
                </div>
                <i class="icon dripicons-bell topbar__icon fc-dropdown--trigger" data-placement="bottom" title="<?=$this->lang->line('application_alerts');?>"><?php if ($unread_notifications > 0) {
                        ?><span class="badge counter" style="margin-top: 22px;margin-left:0px;position: absolute;height: 20px;background: #ed5564; font-style: normal; font-weight: 300; font-family: monospace;""><?=$unread_notifications?></span><?php
                    } ?></i>
                <div class="fc-dropdown notification-center">
                    <div class="notification-center__header">
                        <a href="#" class="active"><?=$this->lang->line('application_notifications');?> (<?=$notification_count;?>)</a>

                        <?php if ($unread_notifications > 0) : ?>
                            <span class="pull-right ajax-silent mark_all_read" style="cursor: pointer; color: #2980b9; font-weight: normal;" data-href="<?=base_url()?>notifications/read_all/client"><?=$this->lang->line('application_mark_all_as_read')?></span>
                        <?php endif; ?>
                    </div>
                    <ul style="overflow-y: scroll; ">
                        <?php
                        foreach ($notification_list as $notification): ?>
                            <li id="notification_<?=$notification->id?>" class="<?=$notification->status == 'new' ? 'new-notification' : '';?>">
                                <div class="col col-1"><span class="dot"></span></div>
                                <a href="<?=$notification->url == null ? " # " : $notification->url; ?>" style="cursor: <?=$notification->url == null ? 'default' : 'pointer' ?>;font-weight:normal; color: black;"><p class="truncate <?=$notification->status?>" style="white-space: normal"><?=$notification->message;?></p></a>

                                <div class="two-columns">
                                    <div style="">
                                        <?php $data['core_settings'] = Setting::first();echo date($data['core_settings']->date_format . ' ' . $data['core_settings']->date_time_format, strtotime($notification->created_at))?>
                                    </div>
                                    <div>
                                        <?php if ($notification->status == 'new') : ?><span class="ajax-silent mark_read" data-href="<?=base_url()?>notifications/read/<?=$notification->id;?>/client" style="cursor: pointer; color: #2980b9" id="<?=$notification->id?>"><?=$this->lang->line('application_mark_as_read')?><span><? endif; ?></div>
                                </div>

                            </li>
                        <?php endforeach;?>
                        <?php if ($notification_count == 0) {
                            ?>
                            <li> <p class="truncate"><?=$this->lang->line('application_no_notifications_yet'); ?></p></li>
                            <?php
                        } ?>
                    </ul>
                </div>

                <?php if ($message_icon) {
                    ?>
                    <span class="hidden-xs">
                  <a href="<?=site_url('messages'); ?>" title="<?=$this->lang->line('application_messages'); ?>">
                     <i class="icon dripicons-inbox topbar__icon"></i>
                  </a>
              </span>
                    <?php
                } ?>

            </div>
            <div class="topbar__left noselect company_name">
                <?php echo character_limiter($this->client->company->name, 25);?>
            </div>
            <div class="topbar noselect">

                <span class="badge" style="cursor: help">
                    <div class="pull-right small-text" title="<?=$integrator_status_desc?>">
                        <small>
                            <?php if ($integrator_online == true) : ?>
                                <?=$this->lang->line('application_integrator_active_platform')?>
                            <?php else : ?>
                                <?=$this->lang->line('application_integrator_inactive_platform')?>
                            <?php endif; ?>

                        </small>
                        <span class="dot-colored <?=$integrator_online == true ? 'active' : 'inactive';?>"></span>
                    </div>
                </span>


                <?php
                if ($this->client->userpic){
                    $userimage = $this->client->userpic;
                }else{
                    $userimage = base_url()."files/media/user/user-placeholder.png  ";
                }
                ?>
                <img class="img-circle topbar-userpic" src="<?=$userimage;?>" height="32px">
                <span class="topbar__name fc-dropdown--trigger">
                    <span class="hidden-xs"><?php echo character_limiter($this->client->firstname, 25);?></span><i class="icon dripicons-chevron-down topbar__drop"></i></span>
                    <div class="fc-dropdown profile-dropdown">
                        <ul>
                            <li>
                                <a href="<?=site_url('agent');?>" data-toggle="mainmodal">
                                    <span class="icon-wrapper"><i class="icon dripicons-gear"></i></span>
                                    <?=$this->lang->line('application_profile');?>
                                </a>
                            </li>

                            <li class="profile-dropdown__logout">
                                <a href="<?=site_url('logout');?>" title="<?=$this->lang->line('application_logout');?>">
                                    <?=$this->lang->line('application_logout');?> <i class="icon dripicons-power pull-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

            </div>

        </div>

        <?=$yield?>

        <div id="dvLoading"><img/></div>

    </div>
    <!-- Notify -->
    <?php if ($this->session->flashdata('message')) {
        $exp = explode(':', $this->session->flashdata('message'))?>
        <div class="notify <?=$exp[0]?>">
            <?=$exp[1]?>
        </div>
        <?php
    } ?>

    <!-- Modal -->
    <div class="modal fade" id="mainModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mainModalLabel" aria-hidden="true"></div>

    <!-- Js Files -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.8.3/apexcharts.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>
    <script src="https://code.iconify.design/1/1.0.3/iconify.min.js"></script>

    <script type="text/javascript" src="<?=base_url()?>assets/blueline/js/app.js"></script>
    <script>
        flatdatepicker(false, langshort);
    </script>

</div>
<!-- Mainwrapper end -->

</body>

</html>
<script>
    $(window).ready(function(){
        $('#dvLoading').hide();
    });

    $(document).ready(function() {

        $('a').on('click', function() {
            $("#dvLoading").removeClass('hidden').show().delay(3000).hide(200);
        });

        $('span.mark_read').on('click', function(event) {

            $.ajax({
                url: $(this).data('href')
            });
            $(this).toggleClass('hidden');
            $("#notification_" + this.id).toggleClass('new-notification');

            if ($('.counter').html() != "1") {
                $('.counter').html($('.counter').html() - 1);
            } else {
                $('.counter').toggleClass('hidden')
            }

        });

        $('span.mark_all_read').on('click', function(event) {

            $.ajax({
                url: $(this).data('href')
            });

            $('.counter').remove('');
            $(this).toggleClass('hidden');

            $('li').removeClass('new-notification');
            $('span.mark_read').remove();
        });

        <?php if ($core_settings->push_active == 1) { ?>

        var OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "<?=$core_settings->push_app_id;?>",
            });

            OneSignal.setExternalUserId("<?=$this->client->email;?>");
        });

        <?php } ?>

    });
</script>