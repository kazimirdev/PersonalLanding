<body>  
    <header>
        <block class="lang-switch">
            <label class="switch">
                <input type="checkbox" id="lang-switcher">
                <span class="slider round"></span>
            </label>
        </block>
        <h1>
        <?php if (!($page_title_header)): ?>
            <a href="/" style="visibility: hidden"> ⇇ </a>
            <h1>kazimir.dev</h1>
        <?php else: ?>
            <a href="/"> ⇇ </a>
            <?= $page_title_header ?>
        <?php endif; ?>
        <?php // if slug exists, return to page before slug ?>
        <?php if (isset($slug)): ?>
            <a href="<?= $prepage ?>"> ↰ </a>
        <?php else: ?>
            <a style="visibility: hidden"> ↰ </a>
        <?php endif; ?>
        </h1>
        <block class="theme-switch">
            <label class="switch">
                <input type="checkbox" id="theme-switcher">
                <span class="slider round"></span>
            </label>
        </block>
    </header>