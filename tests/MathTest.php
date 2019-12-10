<?php
include_once 'src/ClassDivision.php';
include_once 'src/ClassMultiplication.php';


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
