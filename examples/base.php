<?php

use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Data\Data;
use srag\DataTable\Component\Factory\Factory as FactoryInterface;
use srag\DataTable\Component\Filter\Sort\FilterSortField;
use srag\DataTable\Component\Filter\Filter;
use srag\DataTable\Example\Column\Formater\SimplePropertyColumnFormater;
use srag\DataTable\Example\Column\Formater\SimplePropertyExportFormater;
use srag\DataTable\Example\Filter\Storage\TableFilterStorage;
use srag\DataTable\Implementation\Data\Fetcher\AbstractDataFetcher;
use srag\DataTable\Implementation\Factory\Factory;

/**
 * @return string
 */
function base(): string {
	global $DIC;

	$action_url = $DIC->ctrl()->getLinkTargetByClass(ilSystemStyleDocumentationGUI::class) . "&node_id=TableDataData";

	$factory = new Factory($DIC); // TODO: Later from `$DIC->ui()->factory()->table()->data()`

	$table = $factory->table("example_datatable_actions", $action_url, "Example data table with actions", [
		$factory->column("column1", "Column 1", new SimplePropertyColumnFormater($DIC), new SimplePropertyExportFormater($DIC)),
		$factory->column("column2", "Column 2", new SimplePropertyColumnFormater($DIC), new SimplePropertyExportFormater($DIC)),
		$factory->column("column3", "Column 3", new SimplePropertyColumnFormater($DIC), new SimplePropertyExportFormater($DIC))
	], new class($DIC) extends AbstractDataFetcher {

		/**
		 * @inheritDoc
		 */
		public function fetchData(Filter $filter, FactoryInterface $factory): Data {
			$data = array_map(function (int $index): stdClass {
				return (object)[
					"column1" => $index,
					"column2" => "text $index",
					"column3" => ($index % 2 === 0 ? "true" : "false")
				];
			}, range(0, 25));

			$data = array_filter($data, function (stdClass $data) use ($filter): bool {
				$match = true;

				foreach ($filter->getFieldValues() as $key => $value) {
					if (!empty($value)) {
						switch (true) {
							case is_array($value):
								$match = in_array($data->{$key}, $value);
								break;

							case is_integer($data->{$key}):
							case is_float($data->{$key}):
								$match = ($data->{$key} === intval($value));
								break;

							case is_string($data->{$key}):
								$match = (stripos($data->{$key}, $value) !== false);
								break;

							default:
								$match = ($data->{$key} === $value);
								break;
						}

						if (!$match) {
							break;
						}
					}
				}

				return $match;
			});

			usort($data, function (stdClass $o1, stdClass $o2) use ($filter): int {
				foreach ($filter->getSortFields() as $sort_field) {
					$s1 = strval($o1->{$sort_field->getSortField()});
					$s2 = strval($o2->{$sort_field->getSortField()});

					$i = strnatcmp($s1, $s2);

					if ($sort_field->getSortFieldDirection() === FilterSortField::SORT_DIRECTION_DOWN) {
						$i *= - 1;
					}

					if ($i !== 0) {
						return $i;
					}
				}

				return 0;
			});

			$max_count = count($data);

			$data = array_slice($data, $filter->getLimitStart(), $filter->getLimitEnd());

			$data = array_map(function (stdClass $row) use ($factory): RowData {
				return $factory->rowData($row->column1, $row);
			}, $data);

			return $factory->data($data, $max_count);
		}
	}, new TableFilterStorage($DIC));

	return $DIC->ui()->renderer()->render($table);
}
