<?php
	
	class FieldPublishNotes extends Field {
		
	/*-------------------------------------------------------------------------
		Definition:
	-------------------------------------------------------------------------*/
		
		public function __construct(&$parent)
		{
			parent::__construct($parent);
			
			$this->_name = 'Publish Notes';
			$this->_required = FALSE;
			$this->set('show_column', 'no');
		}
		
		/*-------------------------------------------------------------------------
			Overrides:
		-------------------------------------------------------------------------*/	
		
		function createTable()
		{
			return $this->_engine->Database->query(
				"CREATE TABLE IF NOT EXISTS `tbl_entries_data_" . $this->get('id') . "` (
					`id` int(11) unsigned NOT NULL auto_increment,
					`entry_id` int(11) unsigned NOT NULL,
					`value` text,
					PRIMARY KEY  (`id`),
					KEY `entry_id` (`entry_id`)
				) TYPE=MyISAM;"
			);
		}
		
		public function fetchIncludableElements()
		{
			return NULL;
		}
		
		/*-------------------------------------------------------------------------
			Publish Panel:
		-------------------------------------------------------------------------*/
		
		function displayPublishPanel(&$wrapper, $data=NULL, $flagWithError=NULL, $fieldnamePrefix=NULL, $fieldnamePostfix=NULL)
		{
			$note = (isset($data['value'])) ? $data['value'] : $this->get('note');
			# Add <div>
			$div = new XMLElement(
				"div",
				$note,
				array(
					"id"		=> Lang::createHandle($this->get('label')),
					"class" => "publishnotes-editable"
				)
			);
			$edit = new XMLElement(
				"a",
				"Edit note",
				array(
					"class"	=> "publishnotes-edit",
					"href" 	=> "#"
				)
			);
			$wrapper->appendChild($edit);
			$wrapper->appendChild($div);
			
			# Add <textarea>
			$label = Widget::Label("Edit: ".$this->get('label'), NULL, Lang::createHandle($this->get('label')));
			$textarea = Widget::Textarea('fields'.$fieldnamePrefix.'['.$this->get('element_name').']'.$fieldnamePostfix, 8, '50', (strlen($note) != 0 ? General::sanitize($note) : NULL));

			$label->appendChild($textarea);
			
			$control = new XMLElement(
				"div",
				'<input type="submit" value="Change note"/> or <a href="#">cancel</a>',
				array(
					"class" => "control" 
				)
			);
			$label->appendChild($control);
			
			if($flagWithError != NULL) $wrapper->appendChild(Widget::wrapFormElementWithError($label, $flagWithError));
			else $wrapper->appendChild($label);
		}
		
		/*-------------------------------------------------------------------------
			Setting Panel:
		-------------------------------------------------------------------------*/
		
		public function displaySettingsPanel(&$wrapper, $errors = NULL)
		{
			parent::displaySettingsPanel($wrapper, $errors);
			$order = $this->get('sortorder');
			
			# Panel
			$label = new XMLElement("label", "Note");
			$label->appendChild(new XMLElement("i", "The raw output will be shown on the 'Publish' screen", array("class" => "help")));
			$label->appendChild(Widget::Textarea("fields[$order][note]", 5, 40, $this->get('note')));
			
			$wrapper->appendChild($label);
		}
		
		/*-------------------------------------------------------------------------
			Transform and move out:
		-------------------------------------------------------------------------*/
		public function commit()
		{
			if(!parent::commit()) return FALSE;

			$id = $this->get('id');

			if($id === FALSE) return FALSE;

			$fields = array();

			$fields['field_id'] = $id;
			$fields['note'] = $this->get('note');

			$this->_engine->Database->query("DELETE FROM `tbl_fields_".$this->handle()."` WHERE `field_id` = '$id' LIMIT 1");		
			return $this->_engine->Database->insert($fields, 'tbl_fields_' . $this->handle());
		}
		
	}