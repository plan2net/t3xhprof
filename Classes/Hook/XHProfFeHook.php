<?php
/*
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, version 2 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
*/
namespace Plan2net\T3Xhprof\Hook;

require_once \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('t3_xhprof').'/vendor/lox/xhprof/xhprof_lib/utils/xhprof_runs.php';
require_once \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('t3_xhprof').'/vendor/lox/xhprof/xhprof_lib/utils/xhprof_lib.php';

class XHProfFeHook {

	public function preInit($_funcRef, $_params) {

		if (extension_loaded('xhprof')) {
			$conf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3_xhprof']);
			if ($conf['enabled'] && $conf['get_param'] && \TYPO3\CMS\Core\Utility\GeneralUtility::_GET($conf['get_param'])) {
				xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
			}
		}
	}

	public function contentPostProc($_funcRef, $_params) {

		if (extension_loaded('xhprof')) {
			$conf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3_xhprof']);
			if ($conf['enabled'] && $conf['get_param'] && \TYPO3\CMS\Core\Utility\GeneralUtility::_GET($conf['get_param'])) {
				$profiler_namespace = 'typo3';  // namespace for your application
				$output_url = 'typo3conf/ext/t3_xhprof/vendor/lox/xhprof/'; // keep the trailing slash
				$xhprof_data = xhprof_disable();
				$xhprof_runs = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('XHProfRuns_Default');
				$run_id = $xhprof_runs->save_run($xhprof_data, $profiler_namespace);

				// url to the XHProf UI libraries (change the host name and path)
				$profiler_url = sprintf($output_url.'xhprof_html/index.php?run=%s&source=%s', $run_id, $profiler_namespace);
				$styles = ' style="display: block; position: absolute; left: 5px; bottom: 5px; background: red; padding: 8px; z-index: 10000; color: #fff;"';
				echo '<a href="'.$profiler_url.'" target="_blank" '.$styles.'>Profiler output</a>';
			}
		}
	}
}
