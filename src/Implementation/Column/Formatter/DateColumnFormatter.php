<?php

namespace srag\DataTable\Implementation\Column\Formatter;

use ilDatePresentation;
use ilDateTime;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Format\Format;

/**
 * Class DateColumnFormatter
 *
 * @package srag\DataTable\Implementation\Column\Formatter
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class DateColumnFormatter extends DefaultFormatter
{

    /**
     * @inheritDoc
     */
    public function formatRowCell(Format $format, $date, Column $column, RowData $row, string $table_id) : string
    {
        if (empty($date)) {
            return "";
        }

        if (!$date instanceof ilDateTime) {
            if (is_numeric($date)) {
                $date = new ilDateTime($date, IL_CAL_UNIX);
            } else {
                $date = new ilDateTime($date, IL_CAL_DATETIME);
            }
        }

        switch ($format->getFormatId()) {
            case Format::FORMAT_BROWSER:
            case Format::FORMAT_PDF:
            case Format::FORMAT_HTML:
                return ilDatePresentation::formatDate($date);

            case Format::FORMAT_EXCEL:
                return $date->get(IL_CAL_DATETIME);

            case Format::FORMAT_CSV:
            default:
                return strval($date->getUnixTime());
        }
    }
}
