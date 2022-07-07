<?php

namespace App\Service\Transport\MessageHandler;

use App\Service\Transport\Message\CheckUrlMessage;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use App\Facade\CheckUrlFacade;
use App\Repository\UrlRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

class CheckUrlMessageHandler implements MessageHandlerInterface
{
    use MessageHandlerTrait;

    /**
     * @param EntityManagerInterface $entityManager
     * @param MessageBusInterface    $bus
     * @param UrlRepository          $urlRepository
     * @param CheckUrlFacade         $checkUrlFacade
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MessageBusInterface $bus,
        private UrlRepository $urlRepository,
        private CheckUrlFacade $checkUrlFacade,
    ) {
    }

    /**
     * @param CheckUrlMessage $message
     *
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function __invoke(CheckUrlMessage $message): void
    {
        $url = $this->urlRepository->getById($message->getUrlId());

        //если все попытки отработали то удаляем сообщение
        if ($url->isChecked()) {
            return;
        }

        $this->checkUrlFacade->check($url);

        $this->requeueMessage(
            $message,
            //умножаем на тысячу, потому что микросекунды
            new DelayStamp($url->getFrequency() * 1000),
        );

        $this->entityManager->clear();
    }

    /**
     * @return MessageBusInterface
     */
    protected function getBus(): MessageBusInterface
    {
        return $this->bus;
    }
}
