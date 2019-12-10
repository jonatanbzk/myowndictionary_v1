<?php
include_once 'src/classDivision.php';
include_once 'src/classMultiplication.php';


 class FakeMathHalf extends MathHalf {
  function __construct($stubbed_doubler) {
    parent::__construct();
    // replace constructed doubler with stubbed one
    $this->doubler = $stubbed_doubler;
  }
}

class MockMathTest extends PHPUnit\Framework\TestCase {
  public function testHalf (){
    // Create a stub for the SomeClass class.
    $stub = $this->getMockBuilder(MathDouble::class)
                 ->disableOriginalConstructor()
                 ->disableOriginalClone()
                 ->disableArgumentCloning()
                 ->disallowMockingUnknownTypes()
                 ->getMock();
    // Configure the stub.
     $stub->method('double')
         ->willReturn(8);
    // Check the stub
    $this->assertEquals(8, $stub->double(4));
    // Faked MathHalf will use the stubbed doubler
    $divider = new FakeMathHalf($stub);
    $this->assertEquals(4, $divider->half(4));
    // regular MathHalf will user regular doubler
    $divider = new MathHalf();
    $this->assertEquals(6, $divider->half(4));
   }
}


/*
man phpunit  8.12
    public function testHalf ()
    {
      $stub = $this->createMock(MathDouble::class);

      $stub->expects($this->once())
           ->method('double')
           ->with($this->equalTo(8));

      $divis = new MathHalf();
      $this->assertEquals(4, $divis->half(4));
    }


  ex OC
    $mathDoubleMock = $this->getMockBuilder(MathDouble::class)
      ->setMethods(['double'])
      ->getMock();
    $mathDoubleMock
      ->expects($this->once())
      ->method('double')
      ->willReturn(8);

    $this->assertEquals(4, MathHalf::half(4) );


// medium
    $mathDoubleMock = $this->getMockBuilder(MathDouble::class)
      ->setMethods(['double'])
      ->getMock();

    $mockNumber = new stdClass();

    $mockNumber->number = 8;
    $mathDoubleMock->method('double')->willReturn($mockNumber);

    $test = new MathHalf($mathDoubleMock);
          $this->assertEquals(4, $test->half(4) );


// this Stub works
class MockMathTest extends PHPUnit\Framework\TestCase {

  public function testHalf (){
    $stub = $this->createStub(MathDouble::class);
    $stub->method('double')
          ->willReturn(8);

    $this->assertEquals(4, $stub->double(4));
  }
}

// not work
//Error: Call to undefined method MathHalf::attach()

public function testHalf (){
  $mathDoublMock = $this->createMock(MathDouble::class);
  $mathDoublMock->expects($this->once())
                ->method('double')
                ->with($this->equalTo(4));

  $mathHalf = new MathHalf();
  $mathHalf->attach($mathDoublMock);

  $mathHalf->half(4);
}


//  other with stub  not call the stub
public function testHalf (){
  $stub = $this->createStub(MathDouble::class);
  $stub->method('double')
        ->willReturn(8);

//  $this->assertEquals(4, $stub->double(4));
    $test = new MathHalf($stub);
    $this->assertEquals(4, $test->half(4));
}


//mockery
public function testHalf (){
  $mock = \Mockery::mock('overload:'.MathDouble::class);
  $mock->shouldReceive(4)->andReturnUsing(function() {
    return 8;
  });
  $this->assertEquals(4, MathHalf::half(4));
}
*/
