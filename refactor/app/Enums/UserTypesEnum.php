<?php
  
namespace App\Enums;
 
enum UserTypesEnum:string {
    case Customer = 'customer';
    case Translator = 'translator';
}