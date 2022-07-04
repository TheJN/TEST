<?php

function debug($variable){
    echo '<pre>' . print_r($variable,true) . '</pre>';
}

function progress($quantity,$quantity_ref){
    $progress_value = $quantity/$quantity_ref*100;
    if ($progress_value<25){
        echo 'bg-danger';
    }elseif($progress_value<50){
        echo 'bg-warning';
    }elseif($progress_value<75){
        echo '';
    }else{
        echo 'bg-success';
    }
}