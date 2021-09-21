<?php

namespace TeamsBot;

use TeamsBot\Interfaces\AttachmentInterface;

class ProActiveMessage
{
    public const CONST_TYPE_MESSAGE = 'message';
    public const CONST_TEXT_FORMAT_PLAIN = 'plain';
    public const LOCALE_RU_RU = 'ru-RU';

    /**
     * @var array Array of Attachment objects
     */
    private array $attachments = [];
    /**
     * @var array
     */
    public array $data;

    /**
     * Activity constructor.
     * The constructor creates from Context the underlying data array to send.
     * You can pass the Context from the incoming request or create a new one.
     *
     * @param Context $request
     */
    public function __construct()
    {
        $this->data = [
            'type' => self::CONST_TYPE_MESSAGE,
            'text' => '',
            'textFormat' => self::CONST_TEXT_FORMAT_PLAIN,
            'conversation' => [
                'id' => ''
            ]
        ];
    }

    /**
     * Set text field
     *
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->data['text'] = $text;
    }


    public function setConversationID(string $text): void
    {
        $this->data['conversation']['id'] = $text;
    }

    /**
     * Get Activity data array with Attachments
     *
     * @return array
     */
    public function getData(): array
    {
        $message_data = $this->data;
        if (count($this->attachments)) {
            $message_data['attachments'] = [];
            foreach ($this->attachments as $attachment) {
                $message_data['attachments'][] = $attachment->toAttachment();
            }
        }
        return $message_data;
    }

    /**
     * Add a new Attachment to Activity
     *
     * @param AttachmentInterface $attachment
     */
    public function addAttachment(AttachmentInterface $attachment): void
    {
        $this->attachments[] = $attachment;
    }

    /**
     * Get URL for POST Activity
     *
     * @return string
     */
    public function getPostUrl(): string
    {
        return
            'https://smba.trafficmanager.net/amer/v3/conversations/' .
            $this->data['conversation']['id'] .
            '/activities';
    }
}
