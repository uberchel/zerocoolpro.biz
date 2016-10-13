<?php
class TilkiBey_ReadPC_Listener_Listener{
    public static function templateHook($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template){
		$visitor = XenForo_Visitor::getInstance();
		$canReadPc = XenForo_Permission::hasPermission($visitor['permissions'], 'tlk_readpc', 'permission_check'); 
		if ($canReadPc AND $hookName == 'navigation_visitor_tab_links2'){
			$contents .= $template->create('tlk_readpc_link', $template->getParams());
		}
	}
}
?>