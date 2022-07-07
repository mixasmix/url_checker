<?php

namespace App\Service\Transport\Message;

use JsonSerializable;

class CheckUrlMessage implements JsonSerializable
{
    /**
     * @param int $urlId
     */
    public function __construct(private int $urlId)
    {
    }

    /**
     * @return int
     */
    public function getUrlId(): int
    {
        return $this->urlId;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->urlId,
        ];
    }
}
