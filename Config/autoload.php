<?php
include 'utils.php';

spl_autoload_register(function ($class) {
    include '../Modele/' . $class . '.php';
});
