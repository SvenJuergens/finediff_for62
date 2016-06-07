<?php
defined('TYPO3_MODE') or die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Core\\Utility\\DiffUtility'] = array(
	'className' => 'SvenJuergens\\FinediffFor62\\Xclass\\DiffUtility',
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Backend\\History\\RecordHistory'] = array(
	'className' => 'SvenJuergens\\FinediffFor62\\Xclass\\RecordHistory',
);

$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('finediff_for62');

if (!class_exists('cogpowered\\FineDiff\\Granularity\\Word') || !class_exists('cogpowered\\FineDiff\\Diff')) {
    require_once 'phar://' . $extPath . '/Resources/Private/Libraries/fineDiff.phar/vendor/autoload.php';
}