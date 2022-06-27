<?php

namespace App\DTO;

class AddUrlData
{
    /**
     * @param string $url
     * @param int    $frequency
     * @param int    $quantityRepeated
     */
    public function __construct(private string $url, private int $frequency, private int $quantityRepeated)
    {
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getFrequency(): int
    {
        return $this->frequency;
    }

    /**
     * @return int
     */
    public function getQuantityRepeated(): int
    {
        return $this->quantityRepeated;
    }
}
