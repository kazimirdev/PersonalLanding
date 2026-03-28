<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title_head ?? "kazimir.dev"; ?></title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="icon" href="static/img/favicon.ico">
</head>
<body>  
    <header>
        <block class="lang-switch">
            <label class="switch">
                <input type="checkbox" id="lang-switcher">
                <span class="slider round"></span>
            </label>
        </block>
        <h1><?php echo $page_title ?? "kazimir.dev"; ?></h1>
        <block class="theme-switch">
            <label class="switch">
                <input type="checkbox" id="theme-switcher">
                <span class="slider round"></span>
            </label>
        </block>
    </header>