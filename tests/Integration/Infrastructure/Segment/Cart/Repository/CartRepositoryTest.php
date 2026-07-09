<?php

declare(strict_types=1);

namespace Tests\Integration\Infrastructure\Segment\Cart\Repository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use App\Core\Domain\Segment\Cart\Entity\Cart;

use App\Core\Ports\Segment\Cart\Repository\CartRepositoryContract;

use App\Infrastructure\Segment\Cart\Repository\CartRepository;

use Tests\{
    Support\Factory\CartFactory,
    Support\Factory\UserFactory,
    Support\Provides\Persistence
};

/**
 * @coversDefaultClass \App\Infrastructure\Segment\Cart\Repository\CartRepository
*/
class CartRepositoryTest extends KernelTestCase
{
    use Persistence;
    use UserFactory;
    use CartFactory;

    private EntityManagerInterface $em;
    private CartRepository $repository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->em         = $this->getEntityManager();
        $this->repository = $this->getRepository();

        $this->em->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->em->rollback();

        parent::tearDown();
    }

    public function testImplementsContract(): void
    {
        $this->assertInstanceOf(CartRepositoryContract::class, $this->repository);
    }

    public function testFindCartForUserReturnsCartWhenExists(): void
    {
        $user = $this->createAndPersistUser('test@example.com');
        $this->createAndPersistCart($user);

        $result = $this->repository->findCartForUser($user->getId());

        $this->assertInstanceOf(Cart::class, $result);
        $this->assertSame($user->getId(), $result->getUser()->getId());
    }

    public function testFindCartForUserReturnsNullWhenNotExists(): void
    {
        $result = $this->repository->findCartForUser(999999);

        $this->assertNull($result);
    }

    public function testFindCartForUserReturnsOnlyCartForGivenUser(): void
    {
        $userA = $this->createAndPersistUser('1-test@example.com');
        $userB = $this->createAndPersistUser('2-test@example.com');

        $this->createAndPersistCart($userA);
        $this->createAndPersistCart($userB);

        $result = $this->repository->findCartForUser($userA->getId());

        $this->assertNotNull($result);
        $this->assertSame($userA->getId(), $result->getUser()->getId());
    }

    private function getRepository(): CartRepository
    {
        $repository = static::getContainer()->get(CartRepository::class);
        assert($repository instanceof CartRepository);

        return $repository;
    }
}
