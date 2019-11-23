<?php
include_once 'language/locales.php';

class testLanguage extends PHPUnit\Framework\TestCase {
   
   public function testIreturnUsLang() {
        $_SESSION['locale'] = 'en_US';	
 
	$this->assertEquals('Login', I('login_login') );
        $_SESSION['locale']='';
   }
   
   public function testIDefaultReturnFr() {
	$this->assertEquals('Se connecter', I('login_login') );
   } 


   public function testIWithoutVarLocReturnKey() {
	unset($GLOBALS['loc']);
	$this->assertEquals('login_login', I('login_login') );
   } 
}
