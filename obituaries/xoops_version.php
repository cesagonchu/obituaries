<?php
if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

$modversion['name'] = _MI_OBITUARIES_TITRE;
$modversion['version'] = 2.31;
$modversion['description'] = _MI_OBITUARIES_DESC;
$modversion['author'] = "Mariane Antoun based on Birthday module by Herve Thouzard";
$modversion['credits'] = "The XOOPS Project";
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = "www.gnu.org/licenses/gpl-2.0.html/";
$modversion['official'] = 0;
$modversion['image'] = "images/obituaries_slogo2.png";
$modversion['dirname'] = "obituaries";

$modversion['dirmoduleadmin'] = '/Frameworks/moduleclasses/moduleadmin';
$modversion['icons16'] = '../../Frameworks/moduleclasses/icons/16';
$modversion['icons32'] = '../../Frameworks/moduleclasses/icons/32';

//about
$modversion['release_date'] = '2011/12/21';
$modversion["module_website_url"] = "www.xoops.org/";
$modversion["module_website_name"] = "XOOPS";
$modversion["module_status"] = "Final";
$modversion['min_php'] = '5.2';
$modversion['min_xoops'] = "2.5.5";
$modversion['min_admin'] = '1.1';
$modversion['min_db'] = array('mysql' => '5.0.7', 'mysqli' => '5.0.7');

// ********************************************************************************************************************
// Administration *****************************************************************************************************
// ********************************************************************************************************************
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';
$modversion['system_menu'] = 1;

// ********************************************************************************************************************
// Blocks *************************************************************************************************************
// ********************************************************************************************************************
$cptb = 0;

$cptb++;
$modversion['blocks'][$cptb]['file'] = 'b_obituaries.php';
$modversion['blocks'][$cptb]['name'] = _MI_OBITUARIES_TITRE;
$modversion['blocks'][$cptb]['description'] = '_MI_OBITUARIES_DESC';
$modversion['blocks'][$cptb]['show_func'] = 'b_obituaries_show';
$modversion['blocks'][$cptb]['edit_func'] = 'b_obituaries_edit';
$modversion['blocks'][$cptb]['options'] = '5|0|130';	
$modversion['blocks'][$cptb]['template'] = 'obituaries_block_obituaries.html';

$cptb++;
$modversion['blocks'][$cptb]['file'] = 'b_obituaries.php';
$modversion['blocks'][$cptb]['name'] = _MI_OBITUARIES_RANDOM;
$modversion['blocks'][$cptb]['description'] = '_MI_BD_RANDOM_DESC';
$modversion['blocks'][$cptb]['show_func'] = 'b_obituaries_random_show';
$modversion['blocks'][$cptb]['edit_func'] = 'b_obituaries_random_edit';
$modversion['blocks'][$cptb]['options'] = '5|0|130';
$modversion['blocks'][$cptb]['template'] = 'obituaries_block_random_obituaries.html';

$cptb++;
$modversion['blocks'][$cptb]['file'] = 'b_obituaries.php';
$modversion['blocks'][$cptb]['name'] = _MI_OBITUARIES_LAST;
$modversion['blocks'][$cptb]['description'] = '_MI_BD_LAST_DESC';
$modversion['blocks'][$cptb]['show_func'] = 'b_obituaries_last_show';
$modversion['blocks'][$cptb]['edit_func'] = 'b_obituaries_last_edit';
$modversion['blocks'][$cptb]['options'] = '5|0|130';
$modversion['blocks'][$cptb]['template'] = 'obituaries_block_last_obituaries.html';

// ********************************************************************************************************************
// Search *************************************************************************************************************
// ********************************************************************************************************************
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'obituaries_search';


// ********************************************************************************************************************
// Templates **********************************************************************************************************
// ********************************************************************************************************************
$cptt = 0;

$cptt++;
$modversion['templates'][$cptt]['file'] = 'obituaries_index.html';
$modversion['templates'][$cptt]['description'] = "Index page";

$cptt++;
$modversion['templates'][$cptt]['file'] = 'obituaries_user.html';
$modversion['templates'][$cptt]['description'] = "Display a user page";

$cptt++;
$modversion['templates'][$cptt]['file'] = 'obituaries_users.html';
$modversion['templates'][$cptt]['description'] = "List of Users";


// ********************************************************************************************************************
// Menu ***************************************************************************************************************
// ********************************************************************************************************************
$modversion['hasMain'] = 1;

// ********************************************************************************************************************
// Tables *************************************************************************************************************
// ********************************************************************************************************************
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0] = 'users_obituaries';

// ********************************************************************************************************************
// Preferences ********************************************************************************************************
// ********************************************************************************************************************
$cpto = 0;

/**
 * Images width
 */
$cpto++;
$modversion['config'][$cpto]['name']= 'images_width';
$modversion['config'][$cpto]['title'] = '_MI_OBITUARIES_IMAGES_WIDTH';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 150;


/**
 * Images height
 */
$cpto++;
$modversion['config'][$cpto]['name']= 'images_height';
$modversion['config'][$cpto]['title'] = '_MI_OBITUARIES_IMAGES_HEIGHT';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 150;

/**
 * Folder's path (where to save pictures)
 */
$cpto++;
$modversion['config'][$cpto]['name']= 'folder_path';
$modversion['config'][$cpto]['title'] = '_MI_OBITUARIES_FOLDER_PATH';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = XOOPS_UPLOAD_PATH;

/**
 * Folder's url (where to save pictures)
 */
$cpto++;
$modversion['config'][$cpto]['name']= 'folder_url';
$modversion['config'][$cpto]['title'] = '_MI_OBITUARIES_FOLDER_URL';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = XOOPS_UPLOAD_URL;

/**
 * Items count per page
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'perpage';
$modversion['config'][$cpto]['title'] = '_MI_OBITUARIES_PERPAGE';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 15;

/**
 * Mime Types
 * Default values : Web pictures (png, jpeg)
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'mimetypes';
$modversion['config'][$cpto]['title'] = '_MI_OBITUARIES_MIMETYPES';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textarea';
$modversion['config'][$cpto]['valuetype'] = 'text';
$modversion['config'][$cpto]['default'] = "image/jpeg\nimage/pjpeg\nimage/x-png\nimage/png";

/**
 * MAX Filesize Upload in kilo bytes
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'maxuploadsize';
$modversion['config'][$cpto]['title'] = '_MI_OBITUARIES_UPLOADFILESIZE';
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'textbox';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['default'] = 1048576;

/**
 * Editor to use
 */
//$cpto++;
//$modversion['config'][$cpto]['name'] = 'form_options';
//$modversion['config'][$cpto]['title'] = "_MI_OBITUARIES_FORM_OPTIONS";
//$modversion['config'][$cpto]['description'] = '_MI_OBITUARIES_FORM_OPTIONS_DESC';
//$modversion['config'][$cpto]['formtype'] = 'select';
//$modversion['config'][$cpto]['valuetype'] = 'text';
//$modversion['config'][$cpto]['options'] = array(
//											_MI_OBITUARIES_FORM_DHTML=>'dhtml',
//											_MI_OBITUARIES_FORM_COMPACT=>'textarea',
//											_MI_OBITUARIES_FORM_SPAW=>'spaw',
//											_MI_OBITUARIES_FORM_HTMLAREA=>'htmlarea',
//											_MI_OBITUARIES_FORM_KOIVI=>'koivi',
//											_MI_OBITUARIES_FORM_FCK=>'fck',
//											_MI_OBITUARIES_FORM_TINYEDITOR=>'tinyeditor'
//											);
//$modversion['config'][$cpto]['default'] = 'dhtml';

$cpto++;
xoops_load('XoopsEditorHandler');
$editor_handler = XoopsEditorHandler::getInstance();
$editorList = array_flip($editor_handler->getList());

$modversion['config'][$cpto] = array('name'        => 'form_options',
                                'title'       => '_MI_BIRTHDAY_FORM_OPTIONS',
                                'description' => '_MI_BIRTHDAY_FORM_OPTIONS_DESC',
                                'formtype'    => 'select',
                                'valuetype'   => 'text',
                                'options'     => $editorList,
                                'default'     => 'dhtml');
/**
 * Sort order
 */
$cpto++;
$modversion['config'][$cpto]['name'] = 'userslist_sortorder';
$modversion['config'][$cpto]['title'] = "_MI_OBITUARIES_SORT_ORDER";
$modversion['config'][$cpto]['description'] = '';
$modversion['config'][$cpto]['formtype'] = 'select';
$modversion['config'][$cpto]['valuetype'] = 'int';
$modversion['config'][$cpto]['options'] = array(
											_MI_OBITUARIES_SORT_ORDER1 => 1,
											_MI_OBITUARIES_SORT_ORDER2 => 2
											);
$modversion['config'][$cpto]['default'] = 1;


// ********************************************************************************************************************
// Comments ***********************************************************************************************************
// ********************************************************************************************************************
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'obituaries_id';
$modversion['comments']['pageName'] = 'user.php';

// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'obituaries_com_approve';
$modversion['comments']['callback']['update'] = 'obituaries_com_update';
?>
