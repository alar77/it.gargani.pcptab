<?php

require_once 'pcptab.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function pcptab_civicrm_config(&$config) {
  _pcptab_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function pcptab_civicrm_xmlMenu(&$files) {
  _pcptab_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function pcptab_civicrm_install() {
  _pcptab_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function pcptab_civicrm_uninstall() {
  _pcptab_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function pcptab_civicrm_enable() {
  _pcptab_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function pcptab_civicrm_disable() {
  _pcptab_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function pcptab_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _pcptab_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function pcptab_civicrm_managed(&$entities) {
  _pcptab_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * @param array $caseTypes
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function pcptab_civicrm_caseTypes(&$caseTypes) {
  _pcptab_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function pcptab_civicrm_angularModules(&$angularModules) {
_pcptab_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function pcptab_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _pcptab_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function pcptab_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function pcptab_civicrm_navigationMenu(&$menu) {
  _pcptab_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'it.gargani.pcptab')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _pcptab_civix_navigationMenu($menu);
} // */
/**
 * Implementation of hook_civicrm_tabset()
 *
 * Display a campaign tab .
 */
//function pcptab_civicrm_tabs(&$tabs, $cid) {

function pcptab_civicrm_tabset($tabsetName, &$tabs, $context) {
	if ($tabsetName!='civicrm/contact/view') return;
	$cid=$context['contact_id'];
	$result = civicrm_api3('PCP', 'getcount', array(
			'sequential' => 1,
			'contact_id' => $cid,
	));
	$count=$result;
	$tabs[] = array(
			'id' => 'campaign',
			'count' => $count,
			'title' => ts('Personal Campaigns'),
			'weight' => '40',
			'url' => CRM_Utils_System::url('civicrm/contact/view/pcp', "reset=1&cid={$cid}", false, null, false),
	);
}
