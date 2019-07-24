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
	 * @return true
	 */
	public function testgetResultforScountries() {
		$testArray1 = array('index.php', 'Spain');
		$result1 = $this->indexclass->getResult($testArray1);
		$this->assertRegexp("/Country language code: es/", $result1);
	}
	/**
	 * This test must check the text to contain
	 * 
	 * 	"pain and England do speak the same language" when we pass "Spain"
	 * 		as first Country and England as Second
	 * 
	 * @return true
	 */
	public function testgetResultforSLangugages() {
		$testArray2 = array('index.php', 'Spain', 'England');
		$result2 = $this->indexclass->getResult($testArray2);
		$this->assertRegexp("/Spain and England do speak the same language/", $result2);
	}
}
?>
