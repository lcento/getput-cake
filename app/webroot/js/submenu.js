// script: submenu.js
// desc: on/off submenu

// Node Functions

function toggleMenu( id_sub_mnu, id_tag_mnu, class_tag )
{
	$(id_sub_mnu).toggle();
	$(id_tag_mnu).toggleClassName(class_tag);

	return null;
}
