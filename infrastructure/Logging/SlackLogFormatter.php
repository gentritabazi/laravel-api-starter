<?php

namespace Infrastructure\Logging;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\SlackWebhookHandler;

class SlackLogFormatter
{
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            if ($handler instanceof SlackWebhookHandler) {
                $handler->setFormatter(new LineFormatter(
                    '[%datetime%] %channel%.%level_name%: %message% %context% %extra%'
                ));

                $handler->pushProcessor([$this, 'processLogRecord']);
            }
        }
    }

    public function processLogRecord(array $record): array
    {
        if (request()->getPathInfo()) {
            $record['extra']['Api URL'] = asset(request()->getPathInfo());
        }

        return $record;
    }
}
