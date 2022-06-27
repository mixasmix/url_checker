<?php

namespace App\Service\Transport\MessageHandler;

use App\Service\Transport\Message\CheckUrlMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

trait MessageHandlerTrait
{
    /**
     * Переотправляет сообщение в очередь
     *
     * @param CheckUrlMessage $message
     * @param DelayStamp      $delayStamp
     *
     * @return void
     */
    protected function requeueMessage(CheckUrlMessage $message, DelayStamp $delayStamp): void
    {
        $this->getBus()->dispatch(new Envelope($message), [$delayStamp]);
    }

    /**
     * Gets the Message Bus
     *
     * @return MessageBusInterface
     */
    abstract protected function getBus(): MessageBusInterface;
}
