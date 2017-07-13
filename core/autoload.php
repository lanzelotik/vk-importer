<?php
spl_autoload_register(function ($className) {
    if (strpos($className, '\\') !== false) {
        $className = str_replace('\\', '/', $className);
    }

    $fileName = __DIR__ . '/../' . $className . '.php';
    if ($fileName === false || !is_file($fileName)) {
        return;
    }

    include $fileName;
});