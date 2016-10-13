<?php
class Brivium_ViewMembersList_ControllerPublic_Member extends XFCP_Brivium_ViewMembersList_ControllerPublic_Member {

	public function actionIndex() {

		$permission = XenForo_Visitor::getInstance ()->hasPermission ( 'general', 'BR_viewListMember' );
		if (! $permission) {
			return $this->responseNoPermission ();
		}
		return parent::actionIndex ();
	}
}