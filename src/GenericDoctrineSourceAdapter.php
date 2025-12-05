<?php
/*
 * (c) webfactory GmbH <info@webfactory.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webfactory\ContentMapping\SourceAdapter\Doctrine;

use ArrayIterator;
use Doctrine\Persistence\ObjectRepository;
use RuntimeException;
use Webfactory\ContentMapping\SourceAdapter;

/**
 * Implementation for Doctrine as a source system.
 */
final class GenericDoctrineSourceAdapter implements SourceAdapter
{
    /**
     * @param non-empty-string $repositoryMethod
     *
     * @psalm-assert callable([$repository, $repositoryMethod]): iterable
     */
    public function __construct(
        private readonly ObjectRepository $repository,
        private readonly string $repositoryMethod = 'findForContentMapping'
    ) {
    }

    public function getObjectsOrderedById(): iterable
    {
        $entities = $this->repository->{$this->repositoryMethod}();

        if (is_array($entities)) {
            return new ArrayIterator($entities);
        }

        if (!is_iterable($entities)) {
            throw new RuntimeException('The repository method must return either an array or iterable');
        }

        return $entities;
    }
}
