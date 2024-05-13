<?php
$directories = array(
    "models/",
    "controllers/",
    "repositories/",
    "services/",
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

