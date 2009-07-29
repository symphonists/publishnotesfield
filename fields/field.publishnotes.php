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
			return TRUE;
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
			$note = $this->get('note');
			if( ! isset($note)) return;
			
			$div = new XMLElement(
				"div",
				$note,
				array(
					"id"		=> Lang::createHandle($this->get('label'))
				)
			);
			$wrapper->appendChild($div);
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