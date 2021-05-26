<?php

namespace srag\DataTableUI\Component\Column\Formatter;

use srag\DataTableUI\Component\Column\Column;
use srag\DataTableUI\Component\Data\Row\RowData;
use srag\DataTableUI\Component\Format\Format;

/**
 * Interface Formatter
 *
 * @package srag\DataTableUI\Component\Column\Formatter
 */
interface Formatter
{

    /**
     * @param Format $format
     * @param Column $column
     * @param string $table_id
     *
     * @return string
     */
    public function formatHeaderCell(Format $format, Column $column, string $table_id) : string;


    /**
     * @param Format  $format
     * @param mixed   $value
     * @param Column  $column
     * @param RowData $row
     * @param string  $table_id
     *
     * @return string
     */
    public function formatRowCell(Format $format, $value, Column $column, RowData $row, string $table_id) : string;
}
