<?php

namespace srag\TableUI\Implementation\Column;

use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\Row\TableRowData;
use srag\TableUI\Component\Export\Formater\TableExportFormater;
use srag\TableUI\Component\Export\TableExportFormat;

/**
 * Class SimplePropertyTableExportFormater
 *
 * @package srag\TableUI\Implementation\Column
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimplePropertyTableExportFormater implements TableExportFormater {

	/**
	 * @inheritDoc
	 */
	public function __construct() {

	}


	/**
	 * @inheritDoc
	 */
	public function formatHeader(TableExportFormat $export_format, TableColumn $column): string {
		$value = "";

		switch ($export_format->getId()) {
			default:
				$value = $column->getTitle();
				break;
		}

		return strval($value);
	}


	/**
	 * @inheritDoc
	 */
	public function formatRow(TableExportFormat $export_format, TableColumn $column, TableRowData $row): string {
		$value = "";

		switch ($export_format->getId()) {
			default:
				$value = strval($row->getOriginalData()->{$column->getKey()});
				break;
		}

		return strval($value);
	}
}
