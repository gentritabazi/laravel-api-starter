<?php

namespace Infrastructure\Database\Eloquent\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;

/**
 * Add transactional events to your eloquent models.
 * Will automatically detect changes in your models within a transaction and will fire events on commit or rollback.
 * Should mimic the same functionality as transactional callbacks in Ruby on Rails.
 * You want to use this if you want to listen on events fired by models within a transaction and you want to be sure the transaction has completed successfully (or is rolled back).
 *
 * Package URL: https://github.com/mvanduijker/laravel-transactional-model-events
*/

trait TransactionalAwareEvents
{
    protected static $transactionalEloquentEvents = [
        'created', 'updated', 'saved', 'restored',
        'deleted', 'forceDeleted',
    ];

    protected static $queuedTransactionalEvents = [];

    public static function bootTransactionalAwareEvents()
    {
        $dispatcher = static::getEventDispatcher();

        if (!$dispatcher) {
            return;
        }

        foreach (self::$transactionalEloquentEvents as $event) {
            static::registerModelEvent($event, function (Model $model) use ($event) {
                if ($model->getConnection()->transactionLevel()) {
                    // In some rare cases the connection name on the model can be null,
                    // fallback on the connection name from the connection
                    $connectionName = $model->getConnectionName() ?? $model->getConnection()->getName();
                    self::$queuedTransactionalEvents[$connectionName][$event][] = $model;
                } else {
                    // auto fire the afterCommit callback when we are not in a transaction
                    $model->fireModelEvent('afterCommit' . $event);
                    $model->fireModelEvent('afterCommit' . ucfirst($event));
                }
            });
        }

        $dispatcher->listen(TransactionCommitted::class, function (TransactionCommitted $event) {
            if ($event->connection->transactionLevel() > 0) {
                return;
            }

            foreach ((self::$queuedTransactionalEvents[$event->connectionName] ?? []) as $eventName => $models) {
                /** @var Model $model */
                foreach ($models as $model) {
                    $model->fireModelEvent('afterCommit' . $eventName);
                    $model->fireModelEvent('afterCommit' . ucfirst($eventName));
                }
            }
            self::$queuedTransactionalEvents[$event->connectionName] = [];
        });

        $dispatcher->listen(TransactionRolledBack::class, function (TransactionRolledBack $event) {
            if ($event->connection->transactionLevel() > 0) {
                return;
            }

            foreach ((self::$queuedTransactionalEvents[$event->connectionName] ?? []) as $eventName => $models) {
                /** @var Model $model */
                foreach ($models as $model) {
                    $model->fireModelEvent('afterRollback.' . $eventName);
                    $model->fireModelEvent('afterRollback' . ucfirst($eventName));
                }
            }
            self::$queuedTransactionalEvents[$event->connectionName] = [];
        });
    }

    public function initializeTransactionalAwareEvents()
    {
        foreach (self::$transactionalEloquentEvents as $eloquentEvent) {
            $this->addObservableEvents('afterCommit' . ucfirst($eloquentEvent));
            $this->addObservableEvents('afterRollback' . ucfirst($eloquentEvent));
        }
    }
}
