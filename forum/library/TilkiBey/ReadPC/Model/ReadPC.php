<?php

/**
 * [tLk] ReadPC model file
 * this file is a copy of XenForo_Model_Conversation file (copied and edited)
 */
class TilkiBey_ReadPC_Model_ReadPC extends XenForo_Model
{
	const FETCH_LAST_MESSAGE_AVATAR = 0x01;

	/**
	 * Gets the specified conversation message record.
	 *
	 * @param integer $messageId
	 *
	 * @return array|false
	 */
	public function getConversationMessageById($messageId)
	{
		return $this->_getDb()->fetchRow('
			SELECT message.*,
				user.*, IF(user.username IS NULL, message.username, user.username) AS username,
				user_profile.*
			FROM xf_conversation_message AS message
			LEFT JOIN xf_user AS user ON
				(user.user_id = message.user_id)
			LEFT JOIN xf_user_profile AS user_profile ON
				(user_profile.user_id = message.user_id)
			WHERE message.message_id = ?
		', $messageId);
	}

	/**
	 * Gets the specified user conversation.
	 *
	 * @param integer $conversationId
	 * @param integer $userId
	 * @param array $fetchOptions Options for extra data to fetch
	 *
	 * @return array|false
	 */
	public function getConversation($conversationId, array $fetchOptions = array())
	{
		$joinOptions = $this->prepareConversationFetchOptions($fetchOptions);

		return $this->_getDb()->fetchRow('
			SELECT conversation_master.*,
				conversation_user.*,
				conversation_recipient.recipient_state, conversation_recipient.last_read_date
				' . $joinOptions['selectFields'] . '
			FROM xf_conversation_user AS conversation_user
			INNER JOIN xf_conversation_master AS conversation_master ON
				(conversation_user.conversation_id = conversation_master.conversation_id)
			INNER JOIN xf_conversation_recipient AS conversation_recipient ON
					(conversation_user.conversation_id = conversation_recipient.conversation_id
					AND conversation_user.owner_user_id = conversation_recipient.user_id)
				' . $joinOptions['joinTables'] . '
			WHERE conversation_user.conversation_id = ?
		', array($conversationId));
	}

	/**
	 * Gets information about all recipients of a conversation.
	 *
	 * @param integer $conversationId
	 * @param array $fetchOptions Options for extra data to fetch
	 *
	 * @return array Format: [user id] => info
	 */
	public function getConversationRecipients($conversationId, array $fetchOptions = array())
	{
		return $this->fetchAllKeyed('
			SELECT conversation_recipient.*,
				user.*, user_option.*
			FROM xf_conversation_recipient AS conversation_recipient
			INNER JOIN xf_user AS user ON
				(user.user_id = conversation_recipient.user_id)
			INNER JOIN xf_user_option AS user_option ON
				(user_option.user_id = user.user_id)
			WHERE conversation_recipient.conversation_id = ?
			ORDER BY user.username
		', 'user_id', $conversationId);
	}

	/**
	 * Get conversations that a user can see, ordered by the latest message first.
	 *
	 * @param integer $userId
	 * @param array $conditions Conditions for the WHERE clause
	 * @param array $fetchOptions Options for extra data to fetch
	 *
	 * @return array Format: [conversation id] => info
	 */
	public function getConversations(array $conditions = array(), array $fetchOptions = array())
	{
		$joinOptions = $this->prepareConversationFetchOptions($fetchOptions);
		$whereClause = $this->prepareConversationConditions($conditions, $fetchOptions);

		$limitOptions = $this->prepareLimitFetchOptions($fetchOptions);

		return $this->fetchAllKeyed($this->limitQueryResults(
			'
				SELECT conversation_master.*,
					conversation_user.*,
					conversation_starter.*,
					conversation_recipient.recipient_state, conversation_recipient.last_read_date
					' . $joinOptions['selectFields'] . '
				FROM xf_conversation_user AS conversation_user
				INNER JOIN xf_conversation_master AS conversation_master ON
					(conversation_user.conversation_id = conversation_master.conversation_id)
				INNER JOIN xf_conversation_recipient AS conversation_recipient ON
					(conversation_user.conversation_id = conversation_recipient.conversation_id
					AND conversation_user.owner_user_id = conversation_recipient.user_id)
				LEFT JOIN xf_user AS conversation_starter ON
					(conversation_starter.user_id = conversation_master.user_id)
					' . $joinOptions['joinTables'] . '
				ORDER BY conversation_user.last_message_date DESC
			', $limitOptions['limit'], $limitOptions['offset']
		), 'conversation_id');
	}

	/**
	 * Gets the total number of conversations that a user has.
	 *
	 * @param integer $userId
	 * @param array $conditions Conditions for the WHERE clause
	 * @param array $fetchConditions Only used in tandem with $conditions at this point
	 *
	 * @return integer
	 */
	public function countConversations()
	{
		return $this->_getDb()->fetchOne('
			SELECT COUNT(*)
			FROM xf_conversation_master AS conversation_master
			');
	}

	public function prepareConversationFetchOptions(array $fetchOptions)
	{
		$selectFields = '';
		$joinTables = '';

		if (!empty($fetchOptions['join']))
		{
			if ($fetchOptions['join'] & self::FETCH_LAST_MESSAGE_AVATAR)
			{
				$selectFields .= ',
					last_message_user.avatar_date AS last_message_avatar_date,
					last_message_user.gender AS last_message_gender,
					last_message_user.gravatar AS last_message_gravatar';
				$joinTables .= '
					LEFT JOIN xf_user AS last_message_user ON
						(last_message_user.user_id = conversation_user.last_message_user_id)';
			}
		}

		return array(
			'selectFields' => $selectFields,
			'joinTables'   => $joinTables
		);
	}

	/**
	 * Prepares a set of conditions against which to select conversations.
	 *
	 * @param array $conditions List of conditions.
	 * --popupMode (boolean) constrains results to unread, or sent within timeframe specified by options->conversationPopupExpiryHours
	 * @param array $fetchOptions The fetch options that have been provided. May be edited if criteria requires.
	 *
	 * @return string Criteria as SQL for where clause
	 */
	public function prepareConversationConditions(array $conditions, array $fetchOptions)
	{
		$sqlConditions = array();

		$options = XenForo_Application::get('options');

		if (!empty($conditions['popupMode']))
		{
			$cutOff = XenForo_Application::$time - 3600 * $options->conversationPopupExpiryHours;

			$sqlConditions[] = 'conversation_user.is_unread = 1 OR conversation_user.last_message_date > ' . $cutOff;
		}

		return $this->getConditionsForClause($sqlConditions);
	}

	/**
	 * Get messages within a given conversation.
	 *
	 * @param integer $conversationId
	 * @param array $fetchOptions Options for extra data to fetch
	 *
	 * @return array Format [message id] => info
	 */
	public function getConversationMessages($conversationId, array $fetchOptions = array())
	{
		$limitOptions = $this->prepareLimitFetchOptions($fetchOptions);

		return $this->fetchAllKeyed($this->limitQueryResults(
			'
				SELECT message.*,
					user.*, IF(user.username IS NULL, message.username, user.username) AS username,
					user_profile.*
				FROM xf_conversation_message AS message
				LEFT JOIN xf_user AS user ON
					(user.user_id = message.user_id)
				LEFT JOIN xf_user_profile AS user_profile ON
					(user_profile.user_id = message.user_id)
				WHERE message.conversation_id = ?
				ORDER BY message.message_date
			', $limitOptions['limit'], $limitOptions['offset']
		), 'message_id', $conversationId);
	}

	/**
	 * Count the number of messages before a given date in a conversation.
	 *
	 * @param integer $conversationId
	 * @param integer $messageDate
	 *
	 * @return integer
	 */
	public function countMessagesBeforeDateInConversation($conversationId, $messageDate)
	{
		return $this->_getDb()->fetchOne('
			SELECT COUNT(*)
			FROM xf_conversation_message AS conversation_message
			WHERE conversation_message.conversation_id = ?
				AND conversation_message.message_date < ?
		', array($conversationId, $messageDate));
	}

	/**
	 * Prepare a conversation for display or further processing.
	 *
	 * @param array $conversation
	 *
	 * @return array
	 */
	public function prepareConversation(array $conversation)
	{
		$conversation['isNew'] = ($conversation['last_message_date'] > $conversation['last_read_date']);
		$conversation['title'] = XenForo_Helper_String::censorString($conversation['title']);

		$conversation['lastPageNumbers'] = $this->getLastPageNumbers($conversation['reply_count']);

		$conversation['last_message'] = array(
			'message_id' => $conversation['last_message_id'],
			'message_date' => $conversation['last_message_date'],
			'user_id' => $conversation['last_message_user_id'],
			'username' => $conversation['last_message_username']
		);

		if (isset($conversation['last_message_avatar_date']))
		{
			$conversation['last_message']['avatar_date'] = $conversation['last_message_avatar_date'];
		}

		if (isset($conversation['last_message_gender']))
		{
			$conversation['last_message']['gender'] = $conversation['last_message_gender'];
		}

		if (isset($conversation['last_message_gravatar']))
		{
			$conversation['last_message']['gravatar'] = $conversation['last_message_gravatar'];
		}

		return $conversation;
	}

	/**
	 * Prepare a collection of conversations for display or further processing.
	 *
	 * @param array $conversations
	 *
	 * @return array
	 */
	public function prepareConversations(array $conversations)
	{
		foreach ($conversations AS &$conversation)
		{
			$conversation = $this->prepareConversation($conversation);
		}

		return $conversations;
	}

	/**
	 * Prepare a collection of messages (in the same conversation) for display or
	 * further processing.
	 *
	 * @param array $messages
	 * @param array $conversation
	 *
	 * @return array Prepared messages
	 */
	public function prepareMessages(array $messages, array $conversation)
	{
		$pagePosition = 0;

		foreach ($messages AS &$message)
		{
			$message['position_on_page'] = ++$pagePosition;
		}

		return $messages;
	}

	/**
	 * Returns the last few page numbers of a conversation
	 *
	 * @param integer $replyCount
	 *
	 * @return array|boolean
	 */
	public function getLastPageNumbers($replyCount)
	{
		$perPage = XenForo_Application::get('options')->messagesPerPage;

		if (($replyCount +1) > $perPage)
		{
			return XenForo_Helper_Discussion::getLastPageNumbers($replyCount, $perPage);
		}
		else
		{
			return false;
		}
	}
	
	public function deleteConversation($conversationId)
	{
		$db = $this->_getDb();
		XenForo_Db::beginTransaction($db);
		
		$dw = XenForo_DataWriter::create('XenForo_DataWriter_ConversationMaster');
		$dw->setExistingData($conversationId);
		$dw->delete();
		
		XenForo_Db::commit($db);
	}
}