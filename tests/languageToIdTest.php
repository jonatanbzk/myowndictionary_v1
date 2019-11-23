<?php 
unset($_SESSION['locale']);   
include_once 'model/model.php';
include_once 'language/locales.php';

class testIdLanguage extends PHPUnit\Framework\TestCase {

   public function testLanguageToIdReturnDefaultPolishInFrench() {
	   $this->assertEquals('Polonais', languageToId(1) );
  }

}
