<?php

declare(strict_types=1);

namespace App\Infrastructure\Segment\Cart\Repository;

use Doctrine\{
    Bundle\DoctrineBundle\Repository\ServiceEntityRepository,
    Persistence\ManagerRegistry
};

use App\Core\Domain\Segment\Cart\Entity\Cart;

use App\Core\Ports\Segment\Cart\Repository\CartRepositoryContract;

/**
 * @extends ServiceEntityRepository<Cart>
*/
class CartRepository extends ServiceEntityRepository implements CartRepositoryContract
{
    /**
     * @param ManagerRegistry $registry
    */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct(
            $registry,
            Cart::class,
        );
    }

    /**
     * @param int $userId
     *
     * @return Cart|null
    */
    public function findCartForUser(int $userId): ?Cart
    {
        return $this->findOneBy(['user' => $userId]);
    }

    /**
     * @param \DateTimeImmutable $threshold
     *
     * @return Cart[]
    */
    public function findInactiveSince(\DateTimeImmutable $threshold): array
    {
        /** @var Cart[] $result */
        $result = $this->createQueryBuilder('c')
            ->where('c.updatedAt < :threshold')
            ->setParameter('threshold', $threshold)
            ->getQuery()
            ->getResult();

        return $result;
    }
}
