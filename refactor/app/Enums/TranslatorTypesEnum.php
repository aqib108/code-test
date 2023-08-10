<?php
  
namespace App\Enums;
 
enum TranslatorTypesEnum:string {
    case Professional = 'professional';
    case Rwstranslator = 'rwstranslator';
    case Volunteer='volunteer';
}