<?php
//use PHPUnit\Framework\Error\Notice;
//use PHPUnit\Framework\Error\Warning;
use PHPUnit\Framework\TestCase;

include_once 'model/model.php';


class mockDb extends PHPUnit\Framework\TestCase {
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
             ->willReturn(0);   // add this
        // check the stub
        $this->assertEquals(true, $query->execute());


        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Expected Exception Message');

    	  verifyEmailAdress($query);
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
        // check the stub
        $this->assertEquals(true, $query->execute());


        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Expected Exception Message');

    	  verifyEmailAdress();
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
