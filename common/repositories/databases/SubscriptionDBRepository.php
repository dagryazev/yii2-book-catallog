<?php

namespace common\repositories\databases;

use common\dto\SubscriptionDTO;
use common\models\Subscription;
use common\repositories\interfaces\SubscriptionRepositoryInterface;

class SubscriptionDBRepository implements SubscriptionRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function create(int $userId, int $authorId): SubscriptionDTO
    {
        $subscription = new Subscription();
        $subscription->user_id = $userId;
        $subscription->author_id = $authorId;

        if (!$subscription->save()) {
            throw new \RuntimeException('Не удалось создать подписку.');
        }

        return $this->mapToDto($subscription);
    }

    /**
     * @inheritdoc
     */
    public function findByUserAndAuthor(int $userId, int $authorId): ?SubscriptionDTO
    {
        $subscription = Subscription::findOne([
            'user_id' => $userId,
            'author_id' => $authorId
        ]);

        return $subscription ? $this->mapToDto($subscription) : null;
    }

    /**
     * @inheritdoc
     */
    public function findByUser(int $userId): array
    {
        return Subscription::find()->where(['user_id' => $userId])->all();
    }

    /**
     * @inheritdoc
     */
    public function findByAuthor(int $authorId): array
    {
        return Subscription::find()->where(['author_id' => $authorId])->all();
    }

    /**
     * @inheritdoc
     */
    public function delete(int $userId, int $authorId): void
    {
        $subscription = Subscription::findOne([
            'user_id' => $userId,
            'author_id' => $authorId
        ]);
        if ($subscription) {
            if (!$subscription->delete()) {
                throw new \RuntimeException('Не удалось удалить подписку.');
            }
        }
    }

    private function mapToDto(Subscription $subscription): SubscriptionDTO
    {
        return new SubscriptionDTO(
            userId: $subscription->user_id,
            authorId: $subscription->author_id,
        );
    }
}
