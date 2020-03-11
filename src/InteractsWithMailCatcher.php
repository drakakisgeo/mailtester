<?php

namespace Drakakisgeo\Mailtester;

use GuzzleHttp\Client;

trait InteractsWithMailCatcher
{
    use InteractsWithSwiftEmailer;

    protected $mailcatcher;

    /**
     * Init setup
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->initCatcher();
    }

    /**
     * Init client and clean the messages
     */
    public function initCatcher()
    {
        $this->mailcatcher = new Client(['base_uri' => config('mailtester.url')]);
        $this->cleanEmailMessages();
    }

    /**
     * Clear the list from all emails
     */
    public function cleanEmailMessages()
    {
        $this->mailcatcher->delete('/messages');
    }

    /**
     * Assert one email was send so list is not empty
     */
    public function assertEmailIsSent($description = '')
    {
        $this->assertNotEmpty($this->getEmailMessages(), $description);
    }

    /**
     * Assert that First Email's subject contains a string
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailFirstSubjectContains($needle, $description = '')
    {
        $this->assertStringContainsString($needle, $this->getEmailFirstMessage()->subject, $description);
    }

    /**
     * Assert that Last Email's subject contains a string
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailLastSubjectContains($needle, $description = '')
    {
        $this->assertStringContainsString($needle, $this->getEmailLastMessage()->subject, $description);
    }

    /**
     * Assert that certain Email's subject contains a string
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailNthSubjectContains($needle, $nth, $description = '')
    {
        $this->assertStringContainsString($needle, $this->getEmailMessage($nth)->subject, $description);
    }


    /**
     * Assert that the subject in the first Email is equal to a string
     * @param $expected
     * @param  string  $description
     */
    public function assertEmailFirstSubjectEquals($expected, $description = '')
    {
        $this->assertEmailSubjectEquals($expected, $this->getEmailFirstMessage(), $description);
    }

    /**
     * Assert that the subject in the last Email is equal to a string
     * @param $expected
     * @param  string  $description
     */
    public function assertEmailLastSubjectEquals($expected, $description = '')
    {
        $this->assertEmailSubjectEquals($expected, $this->getEmailLastMessage(), $description);
    }

    /**
     * Assert that the subject in the Nth Email is equal to a string
     * @param $expected
     * @param $nth
     * @param  string  $description
     */
    public function assertEmailNthSubjectEquals($expected, $nth, $description = '')
    {
        $this->assertEmailSubjectEquals($expected, $this->getEmailMessage($nth), $description);
    }


    /**
     * Assert that the subject of an Email is equal to a string
     * @param $expected
     * @param $email
     * @param  string  $description
     */
    public function assertEmailSubjectEquals($expected, $email, $description = '')
    {
        $this->assertEquals($expected, $email->subject, $description);
    }

    /**
     * Assert HTML body of First Email contains a certain text
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailFirstHtmlContains($needle, $description = '')
    {
        $this->assertEmailHtmlContains($needle, $this->getEmailFirstMessage(), $description);
    }

    /**
     * Assert HTML body of Last Email contains a certain text
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailLastHtmlContains($needle, $description = '')
    {
        $this->assertEmailHtmlContains($needle, $this->getEmailLastMessage(), $description);
    }


    /**
     * Assert HTML body of certain Nth Email contains a certain text
     *
     * @param $needle
     * @param $nth
     * @param  string  $description
     */
    public function assertEmailNthHtmlContains($needle, $nth, $description = '')
    {
        $this->assertEmailHtmlContains($needle, $this->getEmailMessage($nth), $description);
    }

    /**
     * Assert HTML body of Email contains a certain text
     *
     * @param        $needle
     * @param        $email
     * @param  string  $description
     */
    public function assertEmailHtmlContains($needle, $email, $description = '')
    {
        $response = $this->mailcatcher->get("/messages/{$email->id}.html");
        $this->assertStringContainsString($needle, (string) $response->getBody(), $description);
    }

    /**
     * Assert Text body of First Email contains a certain text
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailFirstTextContains($needle, $description = '')
    {
        $this->assertEmailTextContains($needle, $this->getEmailFirstMessage(), $description);
    }

    /**
     * Assert Text body of Last Email contains a certain text
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailLastTextContains($needle, $description = '')
    {
        $this->assertEmailTextContains($needle, $this->getEmailLastMessage(), $description);
    }

    /**
     * Assert Text body of Nth Email contains a certain text
     *
     * @param        $needle
     * @param        $nth
     * @param  string  $description
     */
    public function assertEmailNthTextContains($needle, $nth, $description = '')
    {
        $this->assertEmailTextContains($needle, $this->getEmailMessage($nth), $description);
    }


    /**
     * Assert Text body of Email contains a certain text
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailTextContains($needle, $email, $description = '')
    {
        $response = $this->mailcatcher->get("/messages/{$email->id}.plain");
        $this->assertStringContainsString($needle, (string) $response->getBody(), $description);
    }


    /**
     * Assert that the sender of first Email is equal to a string
     *
     * @param        $expected
     * @param  string  $description
     */
    public function assertEmailFirstSenderEquals($expected, $description = '')
    {
        $this->assertEmailSenderEquals($expected, $this->getEmailFirstMessage(), $description);
    }

    /**
     * Assert that the sender of last Email is equal to a string
     *
     * @param        $expected
     * @param  string  $description
     */
    public function assertEmailLastSenderEquals($expected, $description = '')
    {
        $this->assertEmailSenderEquals($expected, $this->getEmailLastMessage(), $description);
    }

    /**
     * Assert that the sender of Nth Email is equal to a string
     *
     * @param        $expected
     * @param        $nth
     * @param  string  $description
     */
    public function assertEmailNthSenderEquals($expected, $nth, $description = '')
    {
        $this->assertEmailSenderEquals($expected, $this->getEmailMessage($nth), $description);
    }

    /**
     * Assert that the sender is equal to a string
     *
     * @param        $expected
     * @param        $email
     * @param  string  $description
     */
    public function assertEmailSenderEquals($expected, $email, $description = '')
    {
        $expected = '<'.$expected.'>';
        $this->assertEquals($expected, $email->sender, $description);
    }

    /**
     * Assert that the recipients list of First Email contains a certain one
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailFirstRecipientsContain($needle, $description = '')
    {
        $this->assertEmailRecipientsContain($needle, $this->getEmailFirstMessage(), $description);
    }

    /**
     * Assert that the recipients list of Last Email contains a certain one
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailLastRecipientsContain($needle, $description = '')
    {
        $this->assertEmailRecipientsContain($needle, $this->getEmailLastMessage(), $description);
    }

    /**
     * Assert that the recipients list of Nth Email contains a certain one
     *
     * @param        $needle
     * @param        $nth
     * @param  string  $description
     */
    public function assertEmailNthRecipientsContain($needle, $nth, $description = '')
    {
        $this->assertEmailRecipientsContain($needle, $this->getEmailMessage($nth), $description);
    }


    /**
     * Assert that the recipients list of Email contains a certain one
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailRecipientsContain($needle, $email, $description = '')
    {
        $needle = '<'.$needle.'>';
        $this->assertTrue(in_array($needle,$email->recipients),$description);
    }

    /**
     * Assert that the cc list of First Mail contains a certain one
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailFirstCcContain($needle, $description = '')
    {
        $this->assertEmailCcContain($needle, $this->getEmailFirstMessage(), $description);
    }

    /**
     * Assert that the cc list of Last Mail contains a certain one
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailLastCcContain($needle, $description = '')
    {
        $this->assertEmailCcContain($needle, $this->getEmailLastMessage(), $description);
    }

    /**
     * Assert that the cc list of Nth Mail contains a certain one
     *
     * @param        $needle
     * $param        $nth
     * @param  string  $description
     */
    public function assertEmailNthCcContain($needle, $nth, $description = '')
    {
        $this->assertEmailCcContain($needle, $this->getEmailMessage($nth), $description);
    }

    /**
     * Assert that the cc list of Email contains a certain one
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailCcContain($needle, $email, $description = '')
    {
        $needle = '<'.$needle.'>';
        $this->assertTrue(in_array($needle,$email->recipients),$description);
    }

    /**
     * Assert that the Bcc exists on the First Email
     * Mailcatcher doesn't add a seperate bcc field, it creates a new email
     * with the bcc address as the recipient.
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailFirstBccContain($needle, $description = '')
    {
        return $this->fetchEmailWithBcc($needle, $this->getEmailMessages(), $description);
    }


    /**
     * Assert that the Bcc list of the Last Email contains a certain one
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailLastBccContain($needle, $description = '')
    {
        return $this->fetchEmailWithBcc($needle, array_reverse($this->getEmailMessages()), $description);
    }

    /**
     * Assert that the Bcc list of the Nth Email contains a certain one
     *
     * @param        $needle
     * @param        $nth
     * @param  string  $description
     */
    public function assertEmailNthtBccContain($needle, $nth, $description = '')
    {
        return $this->fetchEmailWithBcc($needle, array_slice($this->getEmailMessages(), $nth - 1), $description);
    }

    /**
     * Assert that the Bcc list of Email contains a certain one
     *
     * @param        $needle
     * @param  string  $description
     */
    public function assertEmailBccContain($needle, $email, $description = '')
    {
        $this->assertTrue(in_array($needle,$email->recipients),$description);
    }

    /**
     * Helper in order to hack the mailcatcher issue with Bcc field
     * @param $needle
     * @param $description
     * @param $messages
     */
    private function fetchEmailWithBcc($needle, $messages, $description)
    {
        $needle = '<'.$needle.'>';

        if (empty($messages)) {
            $this->fail("No messages received");
        }
        foreach ($messages as $message) {
            if (in_array($needle, $message->recipients)) {
                return $this->assertEmailBccContain($needle, $message, $description);
            }
        }

        $this->fail("No bcc found");
    }

    /**
     * Get the first message
     */
    private function getEmailFirstMessage()
    {
        $messages = $this->getEmailMessages();
        if (empty($messages)) {
            $this->fail("No messages received");
        }

        return array_shift($messages);
    }

    /**
     * Get the last message
     */
    private function getEmailLastMessage()
    {
        $messages = $this->getEmailMessages();
        if (empty($messages)) {
            $this->fail("No messages received");
        }

        return end($messages);
    }

    /**
     * Get a certain message
     */
    private function getEmailMessage($nth)
    {
        $messages = $this->getEmailMessages();
        if (empty($messages)) {
            $this->fail("No messages received");
        }

        return array_values($messages)[$nth - 1];
    }


    /**
     * Get all messages
     */
    private function getEmailMessages()
    {
        $jsonResponse = $this->mailcatcher->get('/messages');
        return json_decode($jsonResponse->getBody());
    }

    /**
     * Abstract methods from PhpUnit
     */
    abstract public function assertStringContainsString(string $needle, string $haystack, string $message = ''): void;

    abstract public function assertEquals($expected, $actual, string $message = ''): void;

    abstract public function fail(string $message = ''): void;

    abstract public function assertNotEmpty($actual, string $message = ''): void;

}
