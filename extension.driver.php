<?php

	class Extension_PublishNotesField extends Extension {

	/*-------------------------------------------------------------------------
		Extension Definition:
	-------------------------------------------------------------------------*/

		public function getSubscribedDelegates() {
			return array(
				array(
					'page'		=> '/backend/',
					'delegate'	=> 'InitaliseAdminPageHead',
					'callback'	=> 'initaliseAdminPageHead'
				)
			);
		}

		public function install()
		{
			return Symphony::Database()
				->create('tbl_fields_publishnotes')
				->ifNotExists()
				->charset('utf8')
				->collate('utf8_unicode_ci')
				->fields([
					'id' => [
						'type' => 'int(11)',
						'auto' => true,
					],
					'field_id' => 'int(11)',
					'note' => [
						'type' => 'text',
						'null' => true,
					],
					'editable' => [
						'type' => 'tinyint(1)',
						'default' => 0,
					],
				])
				->keys([
					'id' => 'primary',
					'field_id' => 'key',
				])
				->execute()
				->success();
		}

		public function uninstall()
		{
			return Symphony::Database()
				->drop('tbl_fields_publishnotes')
				->ifExists()
				->execute()
				->success();
		}

		public function update($previousVersion = false)
		{
			$status = true;

			if(Symphony::Database()->tableContainsField('tbl_fields_publishnotes', 'editable') === false) {
				$status = Symphony::Database()
					->alter('tbl_fields_publishnotes')
					->add([
						'editable' => [
							'type' => 'tinyint(1)',
							'default' => 0,
						],
					])
					->execute()
					->success();
			}

			return $status;
		}

		/*-------------------------------------------------------------------------
			Delegates:
		-------------------------------------------------------------------------*/

		public function initaliseAdminPageHead($context)
		{
			$page = Administration::instance()->Page;
			if ($page instanceof ContentPublish AND ($context == 'edit' OR $context == 'new'))
			{
				$page->addStylesheetToHead(URL . '/extensions/publishnotesfield/assets/publishnotesfield.publish.css', 'screen', 3220001);
				$page->addScriptToHead(URL . '/extensions/publishnotesfield/assets/publishnotesfield.publish.js', 3220003);
			}
		}
	}
