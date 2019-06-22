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


function createSlug($string) {

  // replace non letter or digits by -
  $string = preg_replace('~[^\pL\d]+~u', '-', $string);

  // transliterate
  $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);

  // remove unwanted characters
  $string = preg_replace('~[^-\w]+~', '', $string);

  // trim
  $string = trim($string, '-');

  // remove duplicate -
  $string = preg_replace('~-+~', '-', $string);

  // lowercase
  $slug = strtolower($string);

  return $slug;
}