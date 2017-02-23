<?php


namespace Drakakisgeo\Mailtester;

use RuntimeException;
use Swift_Message;
use Swift_Mailer;
use Swift_Mime_MimePart;
use Swift_SmtpTransport;

trait InteractsWithSwiftEmailer
{
    private $emailMessage = null;

    public function sendMail()
    {
        if (is_null($this->emailMessage)) {
            throw new RuntimeException('You need to create the message first and chain it.');
        }

        $transport = Swift_SmtpTransport::newInstance(getenv('MAIL_HOST'), getenv('MAIL_PORT'));
        $mailer = Swift_Mailer::newInstance($transport);

        if (!$mailer->send($this->emailMessage)) {
            throw new RuntimeException('Can\'t send the Email message');
        }

        $this->emailMessage = null;
    }

    public function buildMailMessage(array $option)
    {
        // Set defaults
        if (!array_key_exists('from', $option)) {
            $option['from'] = ['fromtest@test.gr' => 'FromTester'];
        }

        if (!array_key_exists('to', $option)) {
            $option['to'] = ['totest@test.gr' => 'ToTester'];
        }

        if (!array_key_exists('subject', $option)) {
            $option['subject'] = 'Testing Email';
        }
        // Make sure Body exists
        if (!array_key_exists('body', $option)) {
            throw new RuntimeException('You really need to set the body');
        }

        $this->emailMessage = Swift_Message::newInstance()
            ->setSubject($option['subject'])
            ->setFrom($option['from'])
            ->setTo($option['to'])
            ->setBody($option['body']);
        return $this;
    }
}
