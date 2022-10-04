<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php if($this->route['action'] == 'advert'): ?>
            <meta name="description" content="<?php echo 'Shef. '.$meta_desc['title'].'.Категория - '.$meta_desc['category'].'. Описание: '.$meta_desc['description'].'.В городе '.$meta_desc['city']; ?>">
            <meta name="keywords" content="<?php echo $meta_key['title'].','.$meta_key['keywords'].', в городе '.$meta_key['city']; ?>">
        <?php endif; ?>

        <title><?php echo $title; ?></title>
        <link rel="icon" href="/public/img/icon/icon.png">
    
        <link rel="stylesheet" href="/public/css/font.css">
        

		<link rel="stylesheet" href="/public/css/style.css">
        <link rel="stylesheet" href="/public/css/page.css">
        <link rel="stylesheet" href="/public/css/preloader.css">
        <link rel="stylesheet" href="/public/css/pagination.css">
        <link rel="stylesheet" href="/public/css/tag.css">        
        <link rel="stylesheet" href="/public/css/nav.css">
        <link rel="stylesheet" href="/public/css/menu.css">
        <link rel="stylesheet" href="/public/css/modal.css">
        <link rel="stylesheet" href="/public/css/search.css">
        <link rel="stylesheet" href="/public/css/chat.css">
        <link rel="stylesheet" href="/public/css/map.css">
        <link rel="stylesheet" href="/public/css/block.css">
        <link rel="stylesheet" href="/public/css/form.css">
        <link rel="stylesheet" href="/public/css/color.css">
        

        <script src="/public/js/jquery.js"></script>
        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
        <script src="/public/js/tile.js"></script>
        <script src="/public/js/imageLoaded.js"></script>
    </head>
    <body>

        <header><?php require_once 'application/views/header/head.tpl'; ?></header>

        <main><?php echo $content; ?></main>

        <footer><?php require_once 'application/views/footer/foot.tpl'; ?></footer>
    
        <script src="/public/js/popper.js"></script>
        <script src="/public/js/bootstrap.js"></script>
        <script src="/public/js/preloader.js"></script>

        <script src="/public/js/ajax.js"></script>
        <script src="/public/js/menu.js"></script>
        <script src="/public/js/geo.js"></script>
        <script src="/public/js/slider.js"></script>

    </body>
</html>