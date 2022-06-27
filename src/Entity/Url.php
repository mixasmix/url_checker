<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use App\Repository\UrlRepository;

#[ORM\Entity(
    repositoryClass: UrlRepository::class,
)]
#[ORM\Table(
    name: 'url',
)]
class Url implements JsonSerializable
{
    /**
     * @var int
     */
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\Id]
    #[ORM\GeneratedValue()]
    private int $id;

    /**
     * @var string
     */
    #[ORM\Column(type: Types::STRING)]
    private string $url;

    /**
     * @var int
     */
    #[ORM\Column(type: Types::INTEGER)]
    private int $frequency;

    /**
     * @var int
     */
    #[ORM\Column(type: Types::INTEGER)]
    private int $quantityRepeated;

    /**
     * @var DateTimeImmutable
     */
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    /**
     * @var Collection<Check>
     */
    #[ORM\OneToMany(mappedBy: 'url', targetEntity: Check::class)]
    private Collection $checks;

    /**
     * @param string $url
     * @param int    $frequency
     * @param int    $quantityRepeated
     * @param array  $checks
     */
    public function __construct(
        string $url,
        int $frequency,
        int $quantityRepeated,
        array $checks = [],
    ) {
        $this->url = $url;
        $this->frequency = $frequency;
        $this->quantityRepeated = $quantityRepeated;
        $this->createdAt = new DateTimeImmutable();
        $this->checks = new ArrayCollection(array_unique($checks, SORT_REGULAR));
    }

    /**
     * @param Check $check
     *
     * @return Url
     */
    public function addCheck(Check $check): self
    {
        if (!$this->checks->contains($check)) {
            $this->checks->add($check);
        }

        return $this;
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
    public function getId(): int
    {
        return $this->id;
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

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return Collection<Check>
     */
    public function getChecks(): Collection
    {
        return $this->checks;
    }

    /**
     * @return bool
     */
    public function isChecked(): bool
    {
        return $this->getQuantityRepeated() === $this->getChecks()->count();
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'url' => $this->getUrl(),
            'frequency' => $this->getFrequency(),
            'quantity_repeat' => $this->getQuantityRepeated(),
            'created' => $this->getCreatedAt()->format(DATE_ATOM),
            'checks' => $this->getChecks()->toArray(),
        ];
    }
}
