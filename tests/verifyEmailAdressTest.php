<?php
//use PHPUnit\Framework\Error\Notice;
//use PHPUnit\Framework\Error\Warning;
use PHPUnit\Framework\TestCase;

include_once 'model/model.php';


class MockDb extends PHPUnit\Framework\TestCase {
  public function testMockedPDO()
  {
         $_GET['email'] = "fakeEmail@gmail.com";
         $_GET['code'] = "qwertyytrewq";

         $query = $this->getMockBuilder('\PDOStatement')
                       ->disableOriginalConstructor()
                       ->disableOriginalClone()
                       ->disableArgumentCloning()
                       ->disallowMockingUnknownTypes()
                       ->getMock();
         $query->method('execute')
               ->willReturn(true);
         $query->method('fetch')
               ->willReturn(0);
          // check the stub
          $this->assertEquals(true, $query->execute());


          $this->expectException(Exception::class);
          $this->expectExceptionMessage('Expected Exception Message');

      	  verifyEmailAdress();    verifyEmailAdress($query);
  }
}




/*
'could not find driver'
public function testMockedPDO()
{
       $_GET['email'] = "fakeEmail@gmail.com";
       $_GET['code'] = "qwertyytrewq";

       $query = $this->getMockBuilder('\PDOStatement')
                     ->disableOriginalConstructor()
                     ->disableOriginalClone()
                     ->disableArgumentCloning()
                     ->disallowMockingUnknownTypes()
                     ->getMock();
       $query->method('execute')
             ->willReturn(true);
       $query->method('fetch')                    // add this
             ->willReturn(0);
        // check the stub
        $this->assertEquals(true, $query->execute());


        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Expected Exception Message');

    	  verifyEmailAdress();    verifyEmailAdress($query);
}


// gist gitHub  no works

public function testMockedPDO()
{
       $query = $this->getMockBuilder('\PDOStatement');
       $query->method('execute')->willReturn(true);

       $db = $this->getMockBuilder('\PDO')
           ->disableOriginalConstructor()
           ->setMethods(['prepare'])
           ->getMock();

       $db->method('prepare')->willReturn($query);
       $this->assertEquals(true, $query);
  //     $this->expectException(Exception::class);

   	//	verifyEmailAdress();
  }
  Error: Call to undefined method PHPUnit\Framework\MockObject\MockBuilder::method()   l2


  */
