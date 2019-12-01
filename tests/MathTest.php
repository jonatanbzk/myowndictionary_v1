<?php
include_once 'src/ClassDivision.php';
include_once 'src/ClassMultiplication.php';
use \Mockery;
  class MockMathTest extends PHPUnit\Framework\TestCase {

    public function testHalf (){
      $stub = $this->createStub(MathDouble::class);
      $stub->method('double')
            ->willReturn(8);

//      $this->assertEquals(4, $stub->double(4));
      $test = new MathHalf($stub);
      $this->assertEquals(4, $test->half(4));
    }
  }










/*  ex OC
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


//  other with stub
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
