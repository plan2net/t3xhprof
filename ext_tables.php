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

$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/index_ts.php']['preprocessRequest'][] = Plan2net\T3Xhprof\Hook\XHProfFeHook::preInit();
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['hook_eofe'][] = Plan2net\T3Xhprof\Hook\XHProfFeHook::contentPostProc();
