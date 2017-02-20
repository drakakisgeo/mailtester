<?php


namespace Drakakisgeo\Mailtester;


trait MailtesterHelper
{

    /**
     * Init setup
     */
    public function setUp()
    {
        parent::setUp();
        $this->initCatcher();
    }


    /**
     * Get the last message
     */
    public function getLastMessage()
    {
        $messages = $this->getMessages();
        if (empty($messages)) {
            $this->fail("No messages received");
        }
        // messages are in descending order
        return reset($messages);
    }

    /**
     * Get all messages
     */
    public function getMessages()
    {
        $jsonResponse = $this->mailcatcher->get('/messages')->send();
        return json_decode($jsonResponse->getBody());
    }

    /**
     * Assert that an email was send
     */
    public function assertEmailIsSent($description = '')
    {
        $this->assertNotEmpty($this->getMessages(), $description);
    }

    /**
     * Assert that Email's subject contains a string
     * @param $needle
     * @param $email
     * @param string $description
     */
    public function assertEmailSubjectContains($needle, $email, $description = '')
    {
        $this->assertContains($needle, $email->subject, $description);
    }

    /**
     * Assert that Email's subject is equal to a string
     * @param $expected
     * @param $email
     * @param string $description
     */
    public function assertEmailSubjectEquals($expected, $email, $description = '')
    {
        $this->assertContains($expected, $email->subject, $description);
    }

    /**
     * Assert HTML body of Email contains a certain text
     * @param $needle
     * @param $email
     * @param string $description
     */
    public function assertEmailHtmlContains($needle, $email, $description = '')
    {
        $response = $this->mailcatcher->get("/messages/{$email->id}.html")->send();
        $this->assertContains($needle, (string)$response->getBody(), $description);
    }

    /**
     * Assert Text body of Email contains a certain text
     * @param $needle
     * @param $email
     * @param string $description
     */
    public function assertEmailTextContains($needle, $email, $description = '')
    {
        $response = $this->mailcatcher->get("/messages/{$email->id}.plain")->send();
        $this->assertContains($needle, (string)$response->getBody(), $description);
    }

    /**
     * Assert that the sender is equal to a string
     * @param $expected
     * @param $email
     * @param string $description
     */
    public function assertEmailSenderEquals($expected, $email, $description = '')
    {
        $response = $this->mailcatcher->get("/messages/{$email->id}.json")->send();
        $email = json_decode($response->getBody());
        $this->assertEquals($expected, $email->sender, $description);
    }

    /**
     * Assert that the recipients list contains a certain one
     * @param $needle
     * @param $email
     * @param string $description
     */
    public function assertEmailRecipientsContain($needle, $email, $description = '')
    {
        $response = $this->mailcatcher->get("/messages/{$email->id}.json")->send();
        $email = json_decode($response->getBody());
        $this->assertContains($needle, $email->recipients, $description);
    }

    /**
     * Clear the list from all emails
     */
    public function cleanMessages()
    {
        $this->mailcatcher->delete('/messages')->send();
    }

    /**
     * Init client and clean the messages
     */
    public function initCatcher()
    {
        $this->mailcatcher = new \Guzzle\Http\Client('http://192.168.115.27:1080');
        $this->cleanMessages();
    }


}