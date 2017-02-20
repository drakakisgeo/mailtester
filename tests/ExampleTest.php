<?php

namespace League\Skeleton;

use Drakakisgeo\Mailtester\MailtesterHelper;

class ExampleTest extends \PHPUnit_Framework_TestCase
{
    use MailtesterHelper;

    /** @test */
    public function MailHelper()
    {
        $this->assertEmailIsSent('test');
    }
}
