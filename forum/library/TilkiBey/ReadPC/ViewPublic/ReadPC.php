<?php

class TilkiBey_ReadPC_ViewPublic_ReadPC extends XenForo_ViewPublic_Base
{
	public function renderHtml()
	{
		$bbCodeParser = new XenForo_BbCode_Parser(XenForo_BbCode_Formatter_Base::create('Base', array('view' => $this)));
		XenForo_ViewPublic_Helper_Message::bbCodeWrapMessages($this->_params['messages'], $bbCodeParser);
	}
}