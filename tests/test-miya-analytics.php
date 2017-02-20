<?php
/**
 * Class SampleTest
 *
 * @package Miya_Analytics
 */

/**
 * Sample test case.
 */
class Miya_Analytics_Test extends WP_UnitTestCase
{
	/**
	 * A single example test.
	 */
	 function test_get_code()
 	{
 		add_filter( 'miya_analytics_tracking_id', function() {
 			return 'abcde'; // Your tracking ID.
 		} );

 		$code = Miya_Analytics::get_code();
 		$this->assertRegExp( '/abcde/', $code );
 	}

	function test_get_code_with_empty_id()
	{
		$code = Miya_Analytics::get_code();
		$this->assertEmpty( $code );
	}
}
