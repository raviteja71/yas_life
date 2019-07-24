<?php
namespace UnitTestFiles\Test;
use PHPUnit\Framework\TestCase;

require_once('index.php');

class indexClassTest extends TestCase
{
	/**
	 * Setups the original class object for test
	 * 
	 * @return NULL
	 */ 
	protected function setUp(): void
    {
        $this->indexclass = new \Yas\Index\indexClass();
    }
    /**
	 * This test must check the text to contain
	 * 
	 * 	"Country language code: es" when we pass "Spain"
	 * 		as Country
	 * 
	 * @return boolean
	 */
	public function testgetResultforBolivia() {
		$testArray = array('index.php', 'Bolivia');
		$result = $this->indexclass->getResult($testArray);
		$this->assertRegexp("/Country language code\(s\)/", $result);
	}
	/**
	 * This test must check the text to contain
	 * 
	 * 	"Country language code: es" when we pass "Spain"
	 * 		as Country
	 * 
	 * @return boolean
	 */
	public function testgetResultforScountries() {
		$testArray1 = array('index.php', 'Spain');
		$result1 = $this->indexclass->getResult($testArray1);
		$this->assertRegexp("/Country language code\(s\): es/", $result1);
	}
	/**
	 * This test must check the text to contain
	 * 
	 * 	"pain and England do speak the same language" when we pass "Spain"
	 * 		as first Country and England as Second
	 * 
	 * @return boolean
	 */
	public function testgetResultforSLangugages() {
		$testArray2 = array('index.php', 'Spain', 'Australia');
		$result2 = $this->indexclass->getResult($testArray2);
		$this->assertRegexp("/Spain and Australia do not speak the same language/", $result2);
	}
	/**
	 * This test must handle the failure scenario 1
	 * 
	 * @return boolean
	 */
	public function testgetResultforFailure1() {
		$testArray2 = array('index.php', 'Spainoche');
		$result2 = $this->indexclass->getResult($testArray2);
		$this->assertRegexp("/Not a valid Country name. Please check/", $result2);
	}
	/**
	 * This test must handle the failure scenario 2
	 * 
	 * @return boolean
	 */
	public function testgetResultforFailure2() {
		$testArray2 = array('index.php', 'Spainoche', 'England');
		$result2 = $this->indexclass->getResult($testArray2);
		$this->assertRegexp("/First Country name paramter is not a valid value: Spainoche/", $result2);
	}
	/**
	 * This test must handle the failure scenario 3
	 * 
	 * @return boolean
	 */
	public function testgetResultforFailure3() {
		$testArray2 = array('index.php', 'Spain', 'England');
		$result2 = $this->indexclass->getResult($testArray2);
		$this->assertRegexp("/Second Country name paramter is not a valid value: England/", $result2);
	}
}
?>
