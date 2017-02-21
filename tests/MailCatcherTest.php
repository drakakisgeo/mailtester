<?php

namespace Drakakisgeo\Mailtester;

use Tests\TestCase;

class MailCatcherTest extends TestCase
{
    use InteractsWithMailCatcher;

    /** @test */
    public function EmailFoundInInbox()
    {
        $this->assertTrue(true);
    }
}
