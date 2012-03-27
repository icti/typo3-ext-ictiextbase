<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateTimeTest
 *
 * @author jaguerra
 */
class Tx_Ictiextbase_Helpers_DateTimeTest  extends Tx_Extbase_Tests_Unit_BaseTestCase  {

	
	/**
	 * @var Tx_Ictiextbase_Helpers_DateTime
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Ictiextbase_Helpers_DateTime();
	}

	public function tearDown() {
		unset($this->fixture);
	}	
	
	/**
	 * @test
	 */
	public function lastDayOfMonth() {
		
        $this->fixture->setDate(1990, 1, 31);
        $this->fixture->setTime(0,0);		
		
		$this->assertEquals(
			31,
			$this->fixture->getLastDayOfMonth()
		);	
		
        $this->fixture->setDate(1990, 2, 1);
        $this->fixture->setTime(0,0);		
		
		$this->assertEquals(
			28,
			$this->fixture->getLastDayOfMonth()
		);	
		
        $this->fixture->setDate(1992, 2, 1);
        $this->fixture->setTime(0,0);		
		
		$this->assertEquals(
			29,
			$this->fixture->getLastDayOfMonth()
		);		
	}
	
	/**
	 * @test
	 */
	public function addMonths() {
        $this->fixture->setDate(1990, 1, 31);
        $this->fixture->setTime(0,0);	
		
		$this->assertEquals(
			'1990-1-31',
			$this->fixture->format('Y-n-j')
		);		
		
		$date = clone $this->fixture;
		$date->addMonths(1);
		$this->assertEquals(
			'1990-2-28',
			$date->format('Y-n-j')
		);	
		
		$date = clone $this->fixture;
		$date->addMonths(25);
		$this->assertEquals(
			'1992-2-29',
			$date->format('Y-n-j')
		);			
	}	
	
	
	/**
	 * @test
	 */
	public function addMonths2() {
        $this->fixture->setDate(1990, 1, 10);
        $this->fixture->setTime(0,0);	
		
		$this->assertEquals(
			'1990-1-10',
			$this->fixture->format('Y-n-j')
		);		
		
		$date = clone $this->fixture;
		$date->addMonths(1);
		$this->assertEquals(
			'1990-2-10',
			$date->format('Y-n-j')
		);	
		
		$date = clone $this->fixture;
		$date->addMonths(25);
		$this->assertEquals(
			'1992-2-10',
			$date->format('Y-n-j')
		);			
	}	
	
	/**
	 * @test
	 */
	public function diffMonths() {
				
        $this->fixture->setDate(1990, 1, 31);
        $this->fixture->setTime(0,0);	
		
		
		$date = new Tx_Ictiextbase_Helpers_DateTime;
		$date->setDate(1990, 2, 28);
		$date->setTime(0,0);
		
		$this->assertEquals(
			1,
			$this->fixture->diffMonths($date)
		);	
		
		$date = new Tx_Ictiextbase_Helpers_DateTime;
		$date->setDate(1991, 3, 15);
		$date->setTime(0,0);
		
		$this->assertEquals(
			14,
			$this->fixture->diffMonths($date)
		);	
		
		$date = new Tx_Ictiextbase_Helpers_DateTime;
		$date->setDate(1989, 12, 28);
		$date->setTime(0,0);
		
		$this->assertEquals(
			-1,
			$this->fixture->diffMonths($date)
		);			
		
	
	}	
	
	/**
	 * @test
	 */	
	public function toFirstDayOfMonth(){
        $this->fixture->setDate(1990, 1, 31);
        $this->fixture->setTime(0,0);	
		
		$this->assertEquals(
			'1990-1-1',
			$this->fixture->toFirstDayOfMonth()->format('Y-n-j')
		);		
	}
	
	/**
	 * @test
	 */	
	public function copyFromDateTime(){
		
		$original = new DateTime();
		
		$original->setTimeZone(new DateTimeZone('Asia/Tokyo'));
        $original->setDate(1990, 1, 31);
        $original->setTime(23,59);
		
		$copy = Tx_Ictiextbase_Helpers_DateTime::copyFromDateTime($original);
		
		$this->assertEquals(
			$original->format('c'),
			$copy->format('c')
		);
		
		
	}
	
	
	/**
	 * @test
	 */	
	public function comparison1(){
        $this->fixture->setDate(1990, 1, 31);
        $this->fixture->setTime(0,0);
		
		$date = new DateTime();
        $date->setDate(1990, 1, 31);
        $date->setTime(0,1);
		
		$this->assertTrue($date >= $this->fixture);
	}
	
	/**
	 * @test
	 */	
	public function comparison2(){
        $this->fixture->setDate(1990, 1, 31);
        $this->fixture->setTime(0,0);
		
		$date = new DateTime();
        $date->setDate(1990, 1, 30);
        $date->setTime(23,58);
		
		$this->assertTrue($date <= $this->fixture);
	}	
	
	
}

?>
