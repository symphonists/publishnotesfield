# Field: Publish Notes
 
* Version: 0.1.2
* Author: [Max Wheeler](http://makenosound.com)
* Build Date: 2011-03-18
* Compatability: Symphony 2.2

Lets you add arbitary HTML to the Publish screen.

## Installation

1. Upload the 'publishnotesfield' folder in to your Symphony 'extensions' folder.
2. Enable it by selecting the "Field: Publish Notes", choose Enable from the with-selected menu, then click Apply.
3. Add "Publish Notes" to your sections wherever you feel the need.


## Notes

* The "Label" field is required by Symphony, the extension outputs your "Label" in handle-ised form as the ID if your notes field on the Publish screen. While not immediately useful it gives you a hook for use by custom JavaScript if you need it.
* With great power comes great responsibility: the "Note" field let you put whatever you want in it and that raw output is included on the Publish screen.
	
	Be careful you don't break anything.

## Changelog ##

* **0.1.2** Updated for Symphony 2.2
* **0.1.1** Allow notes to be entry specific, added inline editor.