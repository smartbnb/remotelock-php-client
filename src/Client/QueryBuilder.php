<?php declare(strict_types=1);

namespace Smartbnb\RemoteLockApi\Client;

use Smartbnb\RemoteLockApi\Queries\QueryableProperty;
use Smartbnb\RemoteLockApi\Queries\SortableProperty;

class QueryBuilder
{
    /** @var QueryableProperty[] */
    private $queries = [];

    /** @var SortableProperty[] */
    private $sorts = [];

    public function addQuery(QueryableProperty $query): self
    {
        $this->queries[] = $query;

        return $this;
    }

    public function addQueries(QueryableProperty ...$queries): self
    {
        foreach ($queries as $query) {
            $this->addQuery($query);
        }

        return $this;
    }

    public function addSort(SortableProperty $sort): self
    {
        $this->sorts[] = $sort;

        return $this;
    }

    public function addSorts(SortableProperty ...$sorts): self
    {
        foreach ($sorts as $sort) {
            $this->addSort($sort);
        }

        return $this;
    }

    public function __toString()
    {
        $buildableQuery = [];

        // Generate the sort values in name[]=value format.
        $buildableQuery['sort'] = array_map(function (SortableProperty $sort) {
            return $sort->getValue();
        }, $this->sorts);

        // Build the query data in name[]=value format.
        foreach ($this->queries as $query) {
            if (!isset($buildableQuery[$query->getName()])) {
                $buildableQuery[$query->getName()] = [];
            }

            $buildableQuery[$query->getName()][] = $query->getValue();
        }

        // Any single items can be set as name=value instead of name[]=value
        $buildableQuery = array_map(function (array $queryItem) {
            if (count($queryItem) === 1) {
                return $queryItem[0];
            } else {
                return $queryItem;
            }
        }, $buildableQuery);

        // Generate the query
        $query = http_build_query($buildableQuery);

        // Remove numeric indices
        return preg_replace('/%5B[0-9]+%5D/simU', '%5B%5D', $query);
    }
}
