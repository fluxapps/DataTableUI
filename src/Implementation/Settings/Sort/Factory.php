<?php

namespace srag\DataTable\Implementation\Settings\Sort;

use srag\DataTable\Component\Settings\Sort\Factory as FactoryInterface;
use srag\DataTable\Component\Settings\Sort\SortField as SortFieldInterface;
use srag\DataTable\Utils\DataTableTrait;
use srag\DIC\DICTrait;

/**
 * Class Factory
 *
 * @package srag\DataTable\Implementation\Settings\Sort
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Factory implements FactoryInterface
{

    use DICTrait;
    use DataTableTrait;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * @return self
     */
    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Factory constructor
     */
    private function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function sortField(string $sort_field, int $sort_field_direction) : SortFieldInterface
    {
        return new SortField($sort_field, $sort_field_direction);
    }
}
