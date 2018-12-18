<?php

	class FieldPublishNotes extends Field {

	/*-------------------------------------------------------------------------
		Definition:
	-------------------------------------------------------------------------*/

		public function __construct()
		{
			parent::__construct();

			$this->_name = 'Publish Notes';
			$this->_required = false;
			$this->set('show_column', 'no');
		}

	/*-------------------------------------------------------------------------
		Setup:
	-------------------------------------------------------------------------*/

		public function createTable()
		{
			return Symphony::Database()
				->create('tbl_entries_data_' . $this->get('id'))
				->ifNotExists()
				->fields([
					'id' => [
						'type' => 'int(11)',
						'auto' => true,
					],
					'entry_id' => 'int(11)',
					'value' => [
						'type' => 'text',
						'null' => true,
					],
				])
				->keys([
					'id' => 'primary',
					'entry_id' => 'key',
				])
				->execute()
				->success();
		}

		public function fetchIncludableElements()
		{
			return null;
		}

	/*-------------------------------------------------------------------------
		Publish Panel:
	-------------------------------------------------------------------------*/

		function displayPublishPanel(XMLElement &$wrapper, $data = null, $flagWithError = null, $fieldnamePrefix = null, $fieldnamePostfix = null, $entry_id = null)
		{
			$note = (isset($data['value'])) ? $data['value'] : $this->get('note');
			$editable = $this->get('editable');

			# Add <div>
			$div = new XMLElement("div", $note, array(
				"id"	=> Lang::createHandle($this->get('label')),
				"class" => "publishnotes-note"
			));
			$wrapper->appendChild($div);

			# Editable
			if (isset($editable) && $editable) {
				$wrapper->setAttribute('class', $wrapper->getAttribute('class') . " editable");
				$edit = new XMLElement("a", __("Edit note"), array(
					"class"	=> "publishnotes-edit",
					"href" 	=> "#edit"
				));
				$wrapper->appendChild($edit);

				# Add <textarea>
				$label = Widget::Label("Edit: ".$this->get('label'), null, Lang::createHandle($this->get('label')));
				$textarea = Widget::Textarea('fields'.$fieldnamePrefix.'['.$this->get('element_name').']'.$fieldnamePostfix, 8, 50, (strlen($note) != 0 ? General::sanitize($note) : null));

				$label->appendChild($textarea);

				$control = new XMLElement("div",
					'<input type="submit" value="Change note"/> or <a href="#">cancel</a>',
					array(
						"class" => "control"
					)
				);
				$label->appendChild($control);

				if($flagWithError != null) $wrapper->appendChild(Widget::Error($label, $flagWithError));
				else $wrapper->appendChild($label);
			}
		}

	/*-------------------------------------------------------------------------
		Setting Panel:
	-------------------------------------------------------------------------*/

		public function displaySettingsPanel(XMLElement &$wrapper, $errors = null)
		{
			parent::displaySettingsPanel($wrapper, $errors);
			$order = $this->get('sortorder');

			# Value: Note
			$label = new XMLElement("label", __("Note"));
			$label->appendChild(new XMLElement("i", __("The raw output will be shown on the 'Publish' screen"), array("class" => "help")));
			$label->appendChild(Widget::Textarea("fields[$order][note]", 5, 40, $this->get('note')));
			$wrapper->appendChild($label);

			# Setting: Editable
			$div = new XMLElement('div', null, array('class' => 'compact'));
			$setting = new XMLElement('label', '<input name="fields[' . $order . '][editable]" value="1" type="checkbox"' . ($this->get('editable') == 0 ? '' : ' checked="checked"') . '/> ' . __('Allow note to be edited?'));
			$div->appendChild($setting);
			$wrapper->appendChild($div);
		}

	/*-------------------------------------------------------------------------
		Transform and move out:
	-------------------------------------------------------------------------*/

		public function commit()
		{
			if(!parent::commit()) return false;

			$id = $this->get('id');

			if($id === false) return false;

			$fields = array();

			$fields['field_id'] = $id;
			$fields['note'] = $this->get('note');
			$fields['editable'] = ($this->get('editable') ? 1 : 0);

			return FieldManager::saveSettings($id, $fields);
		}

	}
