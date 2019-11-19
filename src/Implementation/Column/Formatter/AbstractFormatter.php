<?php

namespace srag\DataTable\Implementation\Column\Formatter;

use ILIAS\DI\Container;
use srag\DataTable\Component\Column\Formatter\Formatter;

/**
 * Class AbstractFormatter
 *
 * @package srag\DataTable\Implementation\Column\Formatter
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractFormatter implements Formatter
{

    /**
     * @var Container
     */
    protected $dic;


    /**
     * AbstractFormatter constructor
     *
     * @param Container $dic
     */
    public function __construct(Container $dic)
    {
        $this->dic = $dic;
    }
}
