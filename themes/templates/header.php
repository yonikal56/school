<!DOCTYPE html>
<html>
    <head>
        <title>{title}</title>
        <meta name="description" content="{description}">
        <meta name="keywords" content="{keywords}">
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="{base}themes/css/main.css">
        <link type="text/css" rel="stylesheet" href="{base}themes/css/theme.css">
        <link type="text/css" rel="stylesheet" href="{base}themes/css/navbar-fixed-side.css">
        <link type="text/css" rel="stylesheet" href="{base}themes/css/website.css">
        <link type="text/css" rel="stylesheet" href="{base}themes/js/fullcalendar/fullcalendar.css" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <!-- Vars -->
        <script>
            var is_connected = '{is_connected}';
            var base = '{base}';
            var connecting_minutes = {connecting_minutes};
        </script>
    </head>
    <body>
        <!-- Main Content Container -->
        <main class="container">
            <!-- Header -->
            <header>
                <div class="dates-wrapper col-md-12">
                    <div class="pull-right heb-date">{heb-date}</div>
                    <div class="pull-left time-date">{time-date}</div>
                </div>
                <div class="logo col-md-12">
                    <a href="{base}home"><img src="{base}themes/images/logo.jpg"></a>
                </div>
                <div class="clearfix"></div>
            </header>
            <!-- Start Of Main Content -->
            <?= $this->parser->parse('templates/menu', ['type' => 'top'], true); ?>
            <div class="clr" style="margin-top: 10px;"></div>