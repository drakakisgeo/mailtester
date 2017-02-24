<?php

namespace Drakakisgeo\Mailtester;

use Orchestra\Testbench\TestCase;

class MailCatcherTest extends TestCase
{
    use InteractsWithMailCatcher;

    /** @test */
    public function EmailFoundInInbox()
    {
        $this->buildMailMessage(['body' => 'testmeup!'])->sendMail();

        $this->assertEmailIsSent('Email was send');
    }

    /** @test */
    public function CleanMessagesClearsTheInbox()
    {
        $this->buildMailMessage(['body' => 'testmeup!'])->sendMail();
        $this->cleanEmailMessages();

        $this->assertEmpty($this->getEmailMessages());
    }

    /** @test */
    public function getAllMessagesFromInbox()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage(['body' => 'test1'])->sendMail();
        $this->buildMailMessage(['body' => 'test2'])->sendMail();
        $this->buildMailMessage(['body' => 'test3'])->sendMail();

        $this->assertCount(3, $this->getEmailMessages());
    }

    /** @test */
    public function canGrabOnlyLastEmailFromInbox()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage(['subject' => 'Test 1', 'body' => 'test'])->sendMail();
        $this->buildMailMessage(['subject' => 'Test 2', 'body' => 'test'])->sendMail();

        $this->assertEquals('Test 2', $this->getEmailLastMessage()->subject);
    }

    /** @test */
    public function canGrabOnlyFirstEmailFromInbox()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage(['subject' => 'Test 1', 'body' => 'test'])->sendMail();
        $this->buildMailMessage(['subject' => 'Test 2', 'body' => 'test'])->sendMail();

        $this->assertEquals('Test 1', $this->getEmailFirstMessage()->subject);
    }

    /** @test */
    public function canGrabCertainNthEmailFromInbox()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage(['subject' => 'Test 1', 'body' => 'test'])->sendMail();
        $this->buildMailMessage(['subject' => 'Test 2', 'body' => 'test'])->sendMail();
        $this->buildMailMessage(['subject' => 'Test 3', 'body' => 'test'])->sendMail();

        $this->assertEquals('Test 2', $this->getEmailMessage(2)->subject);
    }


    /** @test */
    public function firstEmailSubjectContainsString()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage(['subject' => 'Test target 1', 'body' => 'test'])->sendMail();
        $this->buildMailMessage(['subject' => 'Test 2', 'body' => 'test'])->sendMail();

        $this->assertEmailFirstSubjectContains('target');
    }

    /** @test */
    public function lastEmailSubjectContainsString()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage(['subject' => 'Test 1', 'body' => 'test'])->sendMail();
        $this->buildMailMessage(['subject' => 'Test target 2', 'body' => 'test'])->sendMail();

        $this->assertEmailLastSubjectContains('target');
    }

    /** @test */
    public function nthEmailSubjectContainsString()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage(['subject' => 'Test 1', 'body' => 'test'])->sendMail();
        $this->buildMailMessage(['subject' => 'Test target 2', 'body' => 'test'])->sendMail();
        $this->buildMailMessage(['subject' => 'Test 3', 'body' => 'test'])->sendMail();

        $this->assertEmailNthSubjectContains('target', 2);
    }

    /** @test */
    public function EmailSubjectIsEqualWithString()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage(['subject' => 'Test 1', 'body' => 'test'])->sendMail();
        $this->buildMailMessage(['subject' => 'Test 2', 'body' => 'test'])->sendMail();
        $this->buildMailMessage(['subject' => 'Test 3', 'body' => 'test'])->sendMail();

        $this->assertEmailFirstSubjectEquals('Test 1');
        $this->assertEmailNthSubjectEquals('Test 2', 2);
        $this->assertEmailLastSubjectEquals('Test 3');
    }

    /** @test */
    public function EmailHtmlBodyContainsString()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage(['subject' => 'Test 1', 'body' => 'test1 body'])->sendMail();
        $this->buildMailMessage(['subject' => 'Test 2', 'body' => 'test2 body'])->sendMail();
        $this->buildMailMessage(['subject' => 'Test 3', 'body' => 'test3 body'])->sendMail();

        $this->assertEmailFirstHtmlContains('test1 body');
        $this->assertEmailNthHtmlContains('test2 body', 2);
        $this->assertEmailLastHtmlContains('test3 body');
    }

    /** @test */
    public function EmailTextBodyContainsString()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage([
            'subject' => 'Test 1',
            'body' => 'test1 textbody',
            'contentType' => 'txt'
        ])->sendMail();
        $this->buildMailMessage([
            'subject' => 'Test 2',
            'body' => 'test2 textbody',
            'contentType' => 'txt'
        ])->sendMail();
        $this->buildMailMessage([
            'subject' => 'Test 3',
            'body' => 'test3 textbody',
            'contentType' => 'txt'
        ])->sendMail();

        $this->assertEmailFirstTextContains('test1 textbody');
        $this->assertEmailNthTextContains('test2 textbody', 2);
        $this->assertEmailLastTextContains('test3 textbody');
    }

    /** @test */
    public function emailSenderIsEqualToString()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage(['from' => ['test1@test.gr'=>'Tester1'], 'body' => 'test1 body'])->sendMail();
        $this->buildMailMessage(['from' => ['test2@test.gr'=>'Tester2'], 'body' => 'test2 body'])->sendMail();
        $this->buildMailMessage(['from' => ['test3@test.gr'=>'Tester3'], 'body' => 'test3 body'])->sendMail();

        $this->assertEmailFirstSenderEquals('test1@test.gr');
        $this->assertEmailNthSenderEquals('test2@test.gr', 2);
        $this->assertEmailLastSenderEquals('test3@test.gr');
    }

    /** @test */
    public function emailRecipientContainsString()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage(['to' => ['test1@test.gr'=>'Tester1'], 'body' => 'test1 body'])->sendMail();
        $this->buildMailMessage(['to' => ['test2@test.gr'=>'Tester2'], 'body' => 'test2 body'])->sendMail();
        $this->buildMailMessage(['to' => ['test3@test.gr'=>'Tester3'], 'body' => 'test3 body'])->sendMail();

        $this->assertEmailFirstRecipientsContain('test1@test.gr');
        $this->assertEmailNthRecipientsContain('test2@test.gr', 2);
        $this->assertEmailLastRecipientsContain('test3@test.gr');
    }

    /** @test */
    public function emailCcContainsEmail()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage(['cc' => ['test1@test.gr'=>'Tester1'], 'body' => 'test1 body'])->sendMail();
        $this->buildMailMessage(['cc' => ['test2@test.gr'=>'Tester2'], 'body' => 'test2 body'])->sendMail();
        $this->buildMailMessage(['cc' => ['test3@test.gr'=>'Tester3'], 'body' => 'test3 body'])->sendMail();

        $this->assertEmailFirstCcContain('test1@test.gr');
        $this->assertEmailNthCcContain('test2@test.gr', 2);
        $this->assertEmailLastCcContain('test3@test.gr');
    }

    /** @test */
    public function emailBccContainsEmail()
    {
        $this->cleanEmailMessages();
        $this->buildMailMessage(['bcc'=> ['testbcc1@test.gr'=>'Tester1'], 'body' => 'test1 body'])->sendMail();
        $this->buildMailMessage(['bcc' => ['testbcc2@test.gr'=>'Tester2'], 'body' => 'test2 body'])->sendMail();
        $this->buildMailMessage(['bcc' => ['testbcc3@test.gr'=>'Tester3'], 'body' => 'test3 body'])->sendMail();

        $this->assertEmailFirstBccContain('testbcc1@test.gr');
        $this->assertEmailNthtBccContain('testbcc2@test.gr', 2);
        $this->assertEmailLastBccContain('testbcc3@test.gr');
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('mailtester.url', 'http://localhost:1080');
        putenv("MAIL_HOST=localhost");
        putenv("MAIL_PORT=1025");
    }
}
