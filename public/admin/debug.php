<?php
header("Content-Type: text/plain");
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD'] . "\n";
echo "\nAll SERVER vars:\n";
foreach ($_SERVER as $key => $val) {
    if (strpos($key, 'REQUEST') !== false || strpos($key, 'SCRIPT') !== false || strpos($key, 'PATH') !== false) {
        echo "$key: $val\n";
    }
}
?>
