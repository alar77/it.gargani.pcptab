<?php

require_once 'CRM/Core/Page.php';

/**
 *
 * @author giovanni
 * Shows all personal campaigns for a contact
 * Contact id is take from input var cid
 *
 */
class CRM_Pcptab_Page_List extends CRM_Core_Page {
	/**
	 * A container for all debug messages. Only printed if called with debug=1
	 *
	 * @var array
	 */
	private $debug;
	private function summarize($carry,$item) {
		$carry+=$item['amount'];
		return $carry;
	}
	public function run() {
		// Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
		CRM_Utils_System::setTitle(ts('ContactPersonalCampaign'));
		$params=array(
			'sequential'=>true,
			'contact_id'=>$_GET['cid'],
			'api.ContributionPage.get'=> array(
					'id'=>'$value.page_id',
					'return'=>'id,title'
			),
			'api.Event.get'=> array(
					'id'=>'$value.page_id',
					'return'=>'id,title'
			),
			'api.ContributionSoft.get'=> array(
					'pcp_id'=>'$value.id',
			),
		);
		try {
			$pcps = civicrm_api3('PCP', 'get', $params);
			$this->debug['pcps']=$pcps;
		}
		catch (CiviCRM_API3_Exception $e) {
			// Handle error here.
			$errorMessage = $e->getMessage();
			$errorCode = $e->getErrorCode();
			$errorData = $e->getExtraParams();
			$this->debug['error']= array(
					'error' => $errorMessage,
					'error_code' => $errorCode,
					'error_data' => $errorData,
			);
			return $this->debug['error'];
		}
		$this->browse($pcps['values'],$pages);
		$this->assign('debug','<pre>'.print_r($this->debug,true).'</pre>');
		parent::run();
	}
	function browse($rows,$pages)  {
		$this->debug['pages']=$pages;
		$status = CRM_PCP_BAO_PCP::buildOptions('status_id', 'create');
		$this->debug['status']=$status;
		$approvedId = CRM_Core_OptionGroup::getValue('pcp_status', 'Approved', 'name');
		$class = '';
		foreach ($rows as $pcp) {

			$class = '';

			if ($pcp['status_id'] != $approvedId || $pcp['is_active'] != 1) {
				$class = 'disabled';
			}
			$pcp['status_id']=1;
			$page_id = (int) $pcp['page_id'];
			if ($pcp['page_type']=='contribute') {
				$title=$pcp['api.ContributionPage.get']['values']['0']['title'];
				if (empty($title)) {
					$title = '(no title found for ' . $page_type . ' id ' . $page_id . ')';
				}
				$pageUrl = CRM_Utils_System::url('civicrm/contribute/transact', 'reset=1&id=' . $pcp['page_id']);
			}
			else {
				$title=$pcp['api.Event.get']['values']['0']['title'];
				if (empty($title)) {
					$title = '(no title found for ' . $page_type . ' id ' . $page_id . ')';
				}
				$pageUrl = CRM_Utils_System::url('civicrm/event/register', 'reset=1&id=' . $pcp['page_id']);
			}
			$pcpSummary[] = array(
					'id' => $pcp['id'],
					'status_id' => $status[$pcp['status_id']],
					'page_id' => $page_id,
					'page_title' => $title,
					'page_url' => $pageUrl,
					'page_type' => $page_type,
					'title' => $pcp['title'],
					'class' => $class,
					'numcontributions'=>count($pcp['api.ContributionSoft.get']['values']),
					'raised'=>array_reduce($pcp['api.ContributionSoft.get']['values'], array($this,'summarize'),0),
					'goal' =>floatval($pcp['goal_amount'])
			);
		}
		$this->debug['summary']=$pcpSummary;
		$this->assign('rows',$pcpSummary);
	}
}

