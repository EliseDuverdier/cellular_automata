<?php

function __autoload($className) {
    include $className . '.php';
}

function fatalHandler() {
    $error = error_get_last();
    header('Content-Type: application/json');
    echo json_encode(array(
        'error' => array(
            'message' => $error['message'],
            'file' => $error['file'] .':'. $error['line'],
        )
    ));
}