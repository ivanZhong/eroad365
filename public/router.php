<?php

if (is_file($_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"])) {
    var_dump($_SERVER["DOCUMENT_ROOT"]);
    return false;
} else {
    if (!isset($_SERVER['PATH_INFO'])) {
        $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
    }
    require __DIR__ . "/index.php";
}
