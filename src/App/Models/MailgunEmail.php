<?php

namespace App\Models;

/**
 * Data structure for a Mailgun email entity
 *
 * Class MailgunEmail
 * @package App\Models
 */
class MailgunEmail implements EmailInterface
{
    /**
     * @var string
     */
    private $to;
    /**
     * @var string
     */
    private $toName;
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $fromName;
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $body;

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getToName(): string
    {
        return $this->toName;
    }

    /**
     * @param string $toName
     */
    public function setToName(string $toName): void
    {
        $this->toName = $toName;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * @param string $fromName
     */
    public function setFromName(string $fromName): void
    {
        $this->fromName = $fromName;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * Exchange internal values from provided array
     *
     * @param array $array
     * @return void
     */
    public function exchangeArray(array $array): void
    {
        $allowedFields = [
            'to'        => 'setTo',
            'to_name'   => 'setToName',
            'from'      => 'setFrom',
            'from_name' => 'setFromName',
            'subject'   => 'setSubject',
            'body'      => 'setBody',
        ];
        foreach ($allowedFields as $field => $setter) {
            if (array_key_exists($field, $array)) {
                $this->$setter($array[$field]);
            }
        }
    }

    /**
     * Return an array representation of the object
     *
     * @return array
     */
    public function getArrayCopy(): array
    {
        return [
            'to'        => $this->getTo(),
            'to_name'   => $this->getToName(),
            'from'      => $this->getFrom(),
            'from_name' => $this->getFromName(),
            'subject'   => $this->getSubject(),
            'body'      => $this->getBody(),
        ];
    }

    /**
     * Config representation that a Client can send
     * @param string $apiKey
     * @return array
     */
    public function getConfig(string $apiKey): array
    {
        return [
            'multipart' => [
                [
                    'name'     => 'from',
                    'contents' => "{$this->getFromName()} <{$this->getFrom()}>",
                ],
                [
                    'name'     => 'to',
                    'contents' => "{$this->getToName()} <{$this->getTo()}>",
                ],
                [
                    'name'     => 'subject',
                    'contents' => $this->getSubject(),
                ],
                [
                    'name'     => 'text',
                    'contents' => $this->getBody(),
                ],
            ],
            'auth'      => ['api', $apiKey],
        ];
    }
}
