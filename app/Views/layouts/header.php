<body>  
    <header>
        <block class="lang-switch">
            <label class="switch">
                <input type="checkbox" id="lang-switcher">
                <span class="slider round"></span>
            </label>
        </block>
        <div class="central-header"> 
            <?php if (!($page_title_header)): ?>
                <h1><a href="/" style="visibility: hidden"> ⇇   </a></h1>
                <h1>kazimir.dev</h1>
            <?php else: ?>
                <h1><a href="/"> ⇇   </a></h1>
                <h1><?= get_i18n($page_title_header) ?></h1>
            <?php endif; ?>
            <?php // if slug exists, return to page before slug ?>
            <?php if (isset($slug)): ?>
                <h1><a href="<?= $prepage ?>">   ↰ </a></h1>
            <?php else: ?>
                <h1><a style="visibility: hidden">   ↰ </a></h1>
            <?php endif; ?>
        </div>
        <block class="theme-switch">
            <label class="switch">
                <input type="checkbox" id="theme-switcher">
                <span class="slider round"></span>
            </label>
        </block>
    </header>