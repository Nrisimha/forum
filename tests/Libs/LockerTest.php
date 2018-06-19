<?php

namespace Tests\Libs;
use Shared\Locker\Session as Locker;

/**
 * Class UnitTest
 */
class LockerTest extends \UnitTestCase
{
    public function test_Default()
    {
        $locker = new Locker();

        $this->assertEquals(
            false,
            $locker->unlock('cant'),
            "Locker unlocked by default"
        );
    }
}