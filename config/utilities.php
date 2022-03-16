<?php

function view(string $view, array $data = []) : void
{
    $file = APP_ROOT . '/views/' . $view . '.php';

    if (is_readable($file)) {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        require_once $file;
    } else {
        die('<h1>Fichier php de la vue inexistant</h1>');
    }
}