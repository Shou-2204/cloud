<?php

namespace App\Services\Sms;

class SmsMessage
{
    /**
     * The text content of the SMS.
     *
     * @var string
     */
    public $content;

    /**
     * The sender identifier (e.g. "MyCompany").
     *
     * @var string|null
     */
    public $from;

    /**
     * Create a new SMS message instance.
     *
     * @param  string  $content
     * @return void
     */
    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the content of the SMS.
     *
     * @param  string  $content
     * @return $this
     */
    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the sender of the SMS.
     *
     * @param  string  $from
     * @return $this
     */
    public function from(string $from): self
    {
        $this->from = $from;

        return $this;
    }
}
