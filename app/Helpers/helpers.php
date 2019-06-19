<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function p($str, $die = 0 ) {
    print_r('<pre>');
    print_r($str);
    if ($die) {
        die;
    }
}