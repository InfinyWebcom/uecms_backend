<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Universal Enterprises CMS</title>
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>app-assets/images/favicon/apple-touch-icon-152x152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>app-assets/images/favicon/favicon-32x32.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/vendors.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/fullcalendar/css/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/fullcalendar/daygrid/daygrid.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/fullcalendar/timegrid/timegrid.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/themes/vertical-gradient-menu-template/materialize.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/themes/vertical-gradient-menu-template/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/pages/dashboard-modern.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/custom/custom.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/pages/app-calendar.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/data-tables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/vendors/data-tables/css/select.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>app-assets/css/pages/data-tables.css">
</head>
<script src="<?php echo base_url(); ?>app-assets/js/jQuery-lib/2.0.3/jquery.min.js"></script>

<style type="text/css">
.user_sign{
        border: 2px solid #8e8a8a;
        padding: 0px 4px;
        border-radius: 50%;
        font-size: 13px;
        font-weight: bold;
        font-family: Adamina;
        width: 28px;
        height: 28px;
        line-height: 23px;
        text-transform: capitalize;
}
</style>
<script>
    var BASE_URL = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript">
$(document).ready(function(){
    setTimeout(function() {
       $('.flashMsg').fadeOut('fast');
    }, 5000);
});
</script>
<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <header class="page-topbar" id="header">
        <div class="navbar navbar-fixed">
            <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-light">
                <div class="nav-wrapper">
                    
                    <ul class="navbar-list right">
                        <li>
                            <a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown">
                                <span class="avatar-status avatar-online" style="vertical-align: inherit;">
                                <!-- <span class="avatar-online"> -->
                                    <!-- <img src="<?php echo base_url(); ?>app-assets/images/avatar/avatar-1.png" alt="avatar"><i></i> -->
                                    <div class="user_sign"><?php echo strtoupper(substr($_SESSION['name'], 0, 2));?></div>
                                </span>
                            </a>
                        </li>
                    </ul>
                   </ul>
                    <!-- profile-dropdown-->
                    <ul class="dropdown-content" id="profile-dropdown">
                        <li><a class="grey-text text-darken-1" href="<?php echo base_url(); ?>home/profile"><i class="material-icons">person_outline</i> Profile</a></li>
                        <li><a class="grey-text text-darken-1" href="<?php echo base_url(); ?>home/changePassword"><i class="material-icons">lock_outline</i> Change Password</a></li>
                        <li><a class="grey-text text-darken-1" href="<?php echo base_url(); ?>home/documents"><i class="material-icons">file_upload</i> Documents</a></li>
                        <li><a class="grey-text text-darken-1" href="<?php echo base_url(); ?>home/logout"><i class="material-icons">keyboard_tab</i> Logout</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>