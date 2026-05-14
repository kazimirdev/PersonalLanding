<footer>
    <div class="font-settings">
        <div class="font-modifier-buttons radio-horizontal">
            <form class="boxed" id="font-size">
                <input type="radio" id="font-small" name="font-size" value="small">
                <label class="boxed" for="font-small">-A</label>
                <input type="radio" id="font-medium" name="font-size" value="medium">
                <label class="boxed" for="font-medium">A</label>
                <input type="radio" id="font-large" name="font-size" value="large">
                <label class="boxed" for="font-large">A+</label>
            </form>
        </div>
    </div>
    <div class="page-width-settings">
        <div class="page-width-modifier-buttons radio-horizontal">
            <form class="boxed" id="page-width">
                <input type="radio" id="page-narrow" name="page-width" value="narrow">
                <label class="boxed" for="page-narrow"><?php echo get_i18n('narrow'); ?></label>
                <input type="radio" id="page-wide" name="page-width" value="wide">
                <label class="boxed" for="page-wide"><?php echo get_i18n('wide'); ?></label>
            </form>
        </div>
    </div>

</footer>
<?php include __DIR__ . '/script.php'; ?>
</body>