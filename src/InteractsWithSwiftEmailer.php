<?php

namespace Drakakisgeo\Mailtester;

use RuntimeException;
use Swift_Message;
use Swift_Mailer;
use Swift_SmtpTransport;

trait InteractsWithSwiftEmailer
{
    private $emailMessage = null;

    public function sendMail()
    {
        if (is_null($this->emailMessage)) {
            throw new RuntimeException('You need to create the message first and chain it.');
        }
        
        $mailer = new Swift_Mailer(new Swift_SmtpTransport(getenv('MAIL_HOST'),getenv('MAIL_PORT')));

        if (!$mailer->send($this->emailMessage)) {
            throw new RuntimeException('Can\'t send the Email message');
        }

        $this->emailMessage = null;
    }

    public function buildMailMessage(array $options)
    {
        $options = $this->setDefaults($options);

        // Make sure Body exists
        if (!array_key_exists('body', $options)) {
            throw new RuntimeException('You really need to set the body');
        }

        $this->emailMessage = (new Swift_Message())
            ->setSubject($options['subject'])
            ->setFrom($options['from'])
            ->setCc($options['cc'])
            ->setBcc($options['bcc'])
            ->setTo($options['to'])
            ->setBody($options['body'], $options['contentType']);

        return $this;
    }

    private function setDefaults($options)
    {
        $defaults = [
            'from' => ['fromtest@test.gr' => 'FromTester'],
            'to' => ['totest@test.gr' => 'ToTester'],
            'subject' => 'Testing Email',
            'contentType' => 'text/html',
            'cc' => [],
            'bcc' => []
        ];

        foreach ($defaults as $key=>$value) {
            if (!array_key_exists($key, $options)) {
                $options[$key] = $value;
            }
        }

        return $options;
    }
}
