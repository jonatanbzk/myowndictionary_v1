<?php
//use PHPUnit\Framework\Error\Notice;
//use PHPUnit\Framework\Error\Warning;
use PHPUnit\Framework\TestCase;

include_once 'model/model.php';


class MockDb extends PHPUnit\Framework\TestCase {

  public function testMockedPDO()
  {
         $_GET['email'] = "fakeEmail@gmail.com";
         $_GET['code'] = "qwertyQWERTY";

         $query = $this->getMockBuilder('\PDOStatement')
                       ->disableOriginalConstructor()
                       ->disableOriginalClone()
                       ->disableArgumentCloning()
                       ->disallowMockingUnknownTypes()
                       ->getMock();
         $query->method('execute')
               ->willReturn(true);
         $query->method('fetch')
               ->willReturn('0');
          // check the stub
          $this->assertEquals(true, $query->execute());

          $this->expectException(Exception::class);
          $this->expectExceptionMessage('Vous n\'avez pas de compte créé');

          verifyEmailAdress($query);
  }
}
