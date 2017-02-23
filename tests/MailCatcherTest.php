<?php

namespace Drakakisgeo\Mailtester;

use Tests\TestCase;

class MailCatcherTest extends TestCase
{
    use InteractsWithMailCatcher;

    /** @test */
    public function EmailFoundInInbox()
    {
        $this->buildMailMessage(['body'=>'testmeup!'])->sendMail();
        $this->assertEmailIsSent('Email was send');
    }
}
