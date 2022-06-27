<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use App\Repository\CheckRepository;

#[ORM\Entity(
    repositoryClass: CheckRepository::class,
)]
#[ORM\Table(
    name: 'check_url',
)]
class Check implements JsonSerializable
{
    /**
     * @var int
     */
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id]
    #[ORM\GeneratedValue()]
    private int $id;

    /**
     * @var DateTimeImmutable
     */
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    /**
     * @var int
     */
    #[ORM\Column(type: Types::INTEGER)]
    private int $code;

    /**
     * @var int
     */
    #[ORM\Column(type: Types::INTEGER)]
    private int $repeatNumber;

    /**
     * @var Url
     */
    #[ORM\ManyToOne(targetEntity: Url::class, inversedBy: 'checks')]
    private Url $url;

    /**
     * @param int               $code
     * @param int               $repeatNumber
     * @param Url               $url
     */
    public function __construct(
        int $code,
        int $repeatNumber,
        Url $url
    ) {
        $this->createdAt = new DateTimeImmutable();
        $this->code = $code;
        $this->repeatNumber = $repeatNumber;
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return int
     */
    public function getRepeatNumber(): int
    {
        return $this->repeatNumber;
    }

    /**
     * @return Url
     */
    public function getUrl(): Url
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'repeat_number' => $this->getRepeatNumber(),
            'http_code' => $this->getCode(),
            'url' => $this->getUrl()->getUrl(),
        ];
    }
}
