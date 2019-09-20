ILIAS 6.0 Table Data UI

### Usage

#### Composer
First add the following to your `composer.json` file:
```json
"require": {
  "srag/datatable": ">=0.1.0"
},
```
And run a `composer install`.

#### Use

Expand you plugin class for installing languages of the library to your plugin
```php
...
	/**
	 * @inheritdoc
	 */
	public function updateLanguages($a_lang_keys = null) {
		parent::updateLanguages($a_lang_keys);

		LibraryLanguageInstaller::getInstance()->withPlugin(self::plugin())->withLibraryLanguageDirectory(__DIR__ . "/../vendor/srag/datatable/lang")
			->updateLanguages($a_lang_keys);
	}
...
```

In your code
```php
...
use srag\DataTable\x\Implementation\Table;
...
new Table(...);
...
```

Get action id
```php
$table->getActionRowId();
```

Get mutliple action ids
```php
$table->getMultipleActionRowIds();
```

### Requirements
* ILIAS 5.4 or ILIAS 6.0
* PHP >=7.2

### Adjustment suggestions
* External users can report suggestions and bugs at https://plugins.studer-raimann.ch/goto.php?target=uihk_srsu_LTABLEUI
* Adjustment suggestions by pull requests via github
* Customer of studer + raimann ag: 
	* Adjustment suggestions which are not yet worked out in detail by Jira tasks under https://jira.studer-raimann.ch/projects/LTABLEUI
	* Bug reports under https://jira.studer-raimann.ch/projects/LTABLEUI
