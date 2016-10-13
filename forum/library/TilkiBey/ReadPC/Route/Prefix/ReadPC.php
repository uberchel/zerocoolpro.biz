<?php
class TilkiBey_ReadPC_Route_Prefix_ReadPC implements XenForo_Route_Interface
{
	public function match($routePath, Zend_Controller_Request_Http $request, XenForo_Router $router)
	{
		$action = $router->resolveActionWithIntegerParam($routePath, $request, 'conversation_id');
		$action = $router->resolveActionAsPageNumber($action, $request);
		return $router->getRouteMatch('TilkiBey_ReadPC_ControllerPublic_ReadPC', $action, '');
	}

	public function buildLink($originalPrefix, $outputPrefix, $action, $extension, $data, array &$extraParams)
	{
		$action = XenForo_Link::getPageNumberAsAction($action, $extraParams);
		return XenForo_Link::buildBasicLinkWithIntegerParam($outputPrefix, $action, $extension, $data, 'conversation_id', 'title');
	}
}