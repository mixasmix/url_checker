<?php

namespace App\Facade;

use App\Service\Transport\Message\CheckUrlMessage;
use Exception;
use Guzzle\Http\Client;
use App\DTO\AddUrlData;
use App\Entity\Url;
use App\Service\CheckService;
use App\Service\UrlService;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class CheckUrlFacade
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @param UrlService          $urlService
     * @param MessageBusInterface $bus
     * @param CheckService        $checkService
     */
    public function __construct(
        private UrlService $urlService,
        private MessageBusInterface $bus,
        private CheckService $checkService
    ) {
        $this->client = new Client();
    }

    /**
     * @param Url $url
     *
     * @return int
     *
     * @throws Exception
     */
    public function check(Url $url): int
    {
        $code = $this->client->get(
            uri: $url->getUrl(),
            options: [
                'http_errors' => false,
            ],
        )->send()->getStatusCode();

        $this->checkService->create(
            url: $url,
            statusCode: $code,
        );

        return $code;
    }

    /**
     * @param AddUrlData $data
     *
     * @return Url
     *
     * @throws Exception
     */
    public function create(AddUrlData $data): Url
    {
        $url = $this->urlService->create(
            $data->getUrl(),
            $data->getFrequency(),
            $data->getQuantityRepeated(),
        );

        $this->bus->dispatch(new Envelope(new CheckUrlMessage($url->getId())));

        return $url;
    }
}
