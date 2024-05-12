<?php
$directories = array(
    "models/",
    "controllers/",
    "repositories/",
    "util/"
);

foreach ($directories as $directory) {
    $files = scandir($directory);

    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            require_once $directory . $file;
        }
    }
}

