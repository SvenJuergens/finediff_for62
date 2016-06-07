<?php
namespace SvenJuergens\FinediffFor62\Xclass;

/**
 *  Source of this Code: TYPO3 Version 7.6.7
 */


/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\DiffUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class has functions which generates a difference output of a content string
 */
class RecordHistory extends \TYPO3\CMS\Backend\History\RecordHistory
{

    /**
     * Renders HTML table-rows with the comparison information of an sys_history entry record
     *
     * @param array $entry sys_history entry record.
     * @param string $table The table name
     * @param int $rollbackUid If set to UID of record, display rollback links
     * @return string|NULL HTML table
     * @access private
     */
    public function renderDiff($entry, $table, $rollbackUid = 0)
    {
        $lines = array();
        if (is_array($entry['newRecord'])) {
            $diffUtility = GeneralUtility::makeInstance(DiffUtility::class);
            $fieldsToDisplay = array_keys($entry['newRecord']);
            $languageService = $this->getLanguageService();
            foreach ($fieldsToDisplay as $fN) {
                if (is_array($GLOBALS['TCA'][$table]['columns'][$fN]) && $GLOBALS['TCA'][$table]['columns'][$fN]['config']['type'] !== 'passthrough') {
                    // Create diff-result:
                    $diffres = $diffUtility->makeDiffDisplay(
                        BackendUtility::getProcessedValue($table, $fN, $entry['oldRecord'][$fN], 0, true),
                        BackendUtility::getProcessedValue($table, $fN, $entry['newRecord'][$fN], 0, true)
                    );
                    $lines[] = '
						<div class="diff-item">
							<div class="diff-item-title">
								' . ($rollbackUid ? $this->createRollbackLink(($table . ':' . $rollbackUid . ':' . $fN), $languageService->getLL('revertField', true), 2) : '') . '
								' . $languageService->sl(BackendUtility::getItemLabel($table, $fN), true) . '
							</div>
							<div class="diff-item-result">' . str_replace('\n', PHP_EOL, str_replace('\r\n', '\n', $diffres)) . '</div>
						</div>';
                }
            }
        }
        if ($lines) {
            return '<div class="diff">' . implode('', $lines) . '</div>';
        }
        // error fallback
        return null;
    }


     /**
     * @return \TYPO3\CMS\Lang\LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }

}