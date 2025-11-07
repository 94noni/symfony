<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Messenger\Middleware;

use Psr\Log\LoggerInterface;

/**
 * @author Antoine Makdessi <amakdessi@me.com>
 */
final class AuditMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ?LoggerInterface $logger = null,
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $messageClass = $envelope->getMessage()::class;

        $startTime = microtime(true)

        $this->logger?->info(\sprintf('Starting "{message}" message.', ['message' => $messageClass]);

        try {
            $envelope = $stack->next()->handle($envelope, $stack);
        } finally {
            $endTime = \microtime(true);

            $this->logger?->info(\sprintf('Ending "{message}" message. Time {time}.', ['message' => $messageClass, 'time' => $endTime - $startTimeF]);
        }

        return $envelope;
    }
}
