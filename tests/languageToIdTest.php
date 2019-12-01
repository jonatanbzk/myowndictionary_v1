<?php
//use PHPUnit\Framework\Error\Notice;
use PHPUnit\Framework\Error\Warning;
//use PHPUnit\Framework\TestCase;

include_once 'model/model.php';
include_once 'language/locales.php';

class testIdLanguage extends PHPUnit\Framework\TestCase {

   public function testLanguageToIdReturnDefaultPolishInFrench() {
	   $this->assertEquals('Polonais', languageToId(1) );
  }

   public function testLanguageToIdReturnFrenchWhenLangUs() {
	   $_SESSION['locale'] = 'en_US';
	   $this->assertEquals('French', languageToId(2) );
  }

   public function testLanguageToIdNan() {
	   $this->assertEquals('French', languageToId('French') );
   } 

   public function testLanguageToIdWrongIdZero() {
	   $this->assertEquals(0, languageToId(0) );
  }

   public function testLanguageToIdWrongIdTen() {
	   $this->assertEquals(10, languageToId(10) );
  }
/*
   public function testLanguageToIdErrorWhenNan() {
	   $this->expectException(Warning::class);
           languageToId('French');
   } 
 */   
}
