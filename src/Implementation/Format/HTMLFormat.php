<?php

namespace srag\DataTable\Implementation\Format;

use ILIAS\UI\Implementation\Render\Template;
use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Data;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Table;
use srag\DataTable\Component\UserTableSettings\Settings;

/**
 * Class HTMLFormat
 *
 * @package srag\DataTable\Implementation\Format
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class HTMLFormat extends AbstractFormat {

	/**
	 * @var Template
	 */
	protected $tpl;


	/**
	 * @inheritDoc
	 */
	public function getFormatId(): string {
		return self::FORMAT_HTML;
	}


	/**
	 * @inheritDoc
	 */
	protected function getFileExtension(): string {
		return "html";
	}


	/**
	 * @inheritDoc
	 */
	protected function initTemplate(Table $component, Data $data, Settings $user_table_settings, Renderer $renderer): void {
		$this->tpl = ($this->get_template)("tpl.datatable.html");

		$this->tpl->setVariable("ID", $component->getTableId());

		$this->tpl->setVariable("TITLE", $component->getTitle());

		$this->handleNoDataText($data, $component);
	}


	/**
	 * @inheritDoc
	 */
	protected function handleColumns(Table $component, array $columns, Settings $user_table_settings, Renderer $renderer): void {
		$this->tpl->setCurrentBlock("header");

		parent::handleColumns($component, $columns, $user_table_settings, $renderer);
	}


	/**
	 * @inheritDoc
	 */
	protected function handleColumn(string $formated_column, Table $component, Column $column, Settings $user_table_settings, Renderer $renderer): void {
		$this->tpl->setVariable("HEADER", $formated_column);

		$this->tpl->parseCurrentBlock();
	}


	/**
	 * @inheritDoc
	 */
	protected function handleRows(Table $component, array $columns, Data $data, Settings $user_table_settings, Renderer $renderer): void {
		$this->tpl->setCurrentBlock("body");

		parent::handleRows($component, $columns, $data, $user_table_settings, $renderer);
	}


	/**
	 * @inheritDoc
	 */
	protected function handleRow(Table $component, array $columns, RowData $row, Settings $user_table_settings, Renderer $renderer): void {
		$tpl = $this->tpl;

		$this->tpl = ($this->get_template)("tpl.datatablerow.html");

		$this->handleRowTemplate($component, $row);

		$this->tpl->setCurrentBlock("row");

		parent::handleRow($component, $columns, $row, $user_table_settings, $renderer);

		$tpl->setVariable("ROW", $this->tpl->get());

		$tpl->parseCurrentBlock();

		$this->tpl = $tpl;
	}


	/**
	 * @inheritDoc
	 */
	protected function handleRowTemplate(Table $component, RowData $row): void {

	}


	/**
	 * @inheritDoc
	 */
	protected function handleRowColumn(string $formated_row_column): void {
		$this->tpl->setVariable("COLUMN", $formated_row_column);

		$this->tpl->parseCurrentBlock();
	}


	/**
	 * @inheritDoc
	 */
	protected function renderTemplate(Table $component): string {
		return $this->tpl->get();
	}


	/**
	 * @param Data  $data
	 * @param Table $component
	 */
	protected function handleNoDataText(Data $data, Table $component): void {
		if ($data->getDataCount() === 0) {
			$this->tpl->setCurrentBlock("no_data");

			$this->tpl->setVariable("NO_DATA_TEXT", $component->getDataFetcher()->getNoDataText($component));

			$this->tpl->parseCurrentBlock();
		}
	}
}
