<?php
/*
 * (c) webfactory GmbH <info@webfactory.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webfactory\ContentMapping\SourceAdapter\Doctrine;

use Webfactory\ContentMapping\SourceAdapter;

/**
 * Implementation for Doctrine as a source system.
 */
final class GenericDoctrineSourceAdapter implements SourceAdapter
{
    public function __construct(
        private readonly object $repository,
        private readonly string $repositoryMethod = 'findForContentMapping'
    ) {
    }

    public function getObjectsOrderedById(): \Iterator
    {
        return (function () {
            yield from $this->repository->{$this->repositoryMethod}();
        })();
    }
}
