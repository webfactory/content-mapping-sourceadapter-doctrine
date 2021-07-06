<?php
/*
 * (c) webfactory GmbH <info@webfactory.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webfactory\ContentMapping\SourceAdapter\Doctrine;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Webfactory\ContentMapping\SourceAdapter;

/**
 * Implementation for Doctrine as a source system.
 *
 * @final by default.
 */
final class GenericDoctrineSourceAdapter implements SourceAdapter
{
    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @var string
     */
    private $repositoryMethod;

    /**
     * @param EntityRepository $repository to query
     * @param string $repositoryMethod Which returns a Collection of all objects to map, ordered by their ascending IDs.
     */
    public function __construct($repository, $repositoryMethod = 'findForContentMapping')
    {
        $this->repository = $repository;
        $this->repositoryMethod = $repositoryMethod;
    }

    /**
     * {@inheritDoc}
     */
    public function getObjectsOrderedById()
    {
        $entities = $this->repository->{$this->repositoryMethod}();
        if (is_array($entities) === false) {
            throw new \RuntimeException(
                'The result of ' . get_class($this->repository) . '->' . $this->repositoryMethod . '() is no array, '
                . 'which it has to be if you wish to use ' . __CLASS__
            );
        }

        if (!$entities[0] instanceof MappableEntityInterface) {
            trigger_error('Mapping objects not implementing the MappableEntityInterface is deprecated and will
            not be possible as of v2.0.0', E_USER_DEPRECATED);
        }

        if (method_exists($entities[0], 'getId')) { // BC Layer
            usort($entities, function ($a, $b) {
                return $a->getId() <=> $b->getId();
            });
        }

        /** @var Collection mixed[] */
        return new \ArrayIterator($entities);
    }
}
