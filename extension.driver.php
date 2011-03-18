<?php
	
	class Extension_PublishNotesField extends Extension {

	/*-------------------------------------------------------------------------
		Extension Definition:
	-------------------------------------------------------------------------*/
		
		public function about()
		{
			return array(
				'name'			=> 'Field: Publish Notes',
				'version'		=> '0.1.2',
				'release-date'	=> '2011-03-18',
				'author'		=> array(
					'name'			=> 'Max Wheeler',
					'website'		=> 'http://makenosound.com/',
					'email'			=> 'max@makenosound.com'
				),
				'description'	=> 'Lets you add arbitary HTML to the Publish screen.'
			);
		}
		
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
			return Symphony::Database()->query("CREATE TABLE `tbl_fields_publishnotes`(
				`id` int(11) unsigned NOT NULL auto_increment,
				`field_id` int(11) unsigned NOT NULL,
				`note` text NULL,
				PRIMARY KEY (`id`),
				KEY `field_id` (`field_id`))"
			);
		}
		
		public function uninstall()
		{
			Symphony::Database()->query("DROP TABLE `tbl_fields_publishnotes`");
			return TRUE;
		}
	
		/*-------------------------------------------------------------------------
			Delegates:
		-------------------------------------------------------------------------*/
		
		public function initaliseAdminPageHead($context)
		{
			$page = $context['parent']->Page;	
			if ($page instanceof ContentPublish AND ($page->_context['page'] == 'edit' OR $page->_context['page'] == 'new')) 
			{
				$page->addStylesheetToHead(URL . '/extensions/publishnotesfield/assets/publishnotesfield.publish.css', 'screen', 3220001);
				$page->addScriptToHead(URL . '/extensions/publishnotesfield/assets/publishnotesfield.publish.js', 3220003);
			}
		}
	}