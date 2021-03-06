<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 10 juil. 08 at 13:27:45
 * Version : $Id:
 * ****************************************************************************
 */
if (!defined('XOOPS_ROOT_PATH')) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH.'/kernel/object.php';
//if (!class_exists('Obituaries_XoopsPersistableObjectHandler')) {
//	include_once XOOPS_ROOT_PATH.'/modules/obituaries/class/PersistableObjectHandler.php';
//}

class users_obituaries extends XoopsObject
{
	function __construct()
	{
		$this->initVar('obituaries_id',XOBJ_DTYPE_INT,null,false);
		$this->initVar('obituaries_uid',XOBJ_DTYPE_INT,null,false);
		$this->initVar('obituaries_date',XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar('obituaries_photo',XOBJ_DTYPE_TXTBOX,null,false);
        $this->initVar('obituaries_description',XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('obituaries_survivors',XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('obituaries_service',XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar('obituaries_memorial',XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('obituaries_firstname',XOBJ_DTYPE_TXTBOX,null,false);
        $this->initVar('obituaries_lastname',XOBJ_DTYPE_TXTBOX,null,false);
        $this->initVar('obituaries_comments',XOBJ_DTYPE_INT,null,false);
		// Pour autoriser le html
		$this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
	}

	/**
	 * Retourne l'URL de l'image
	 * @return string	L'URL
	 */
	function getPictureUrl()
	{
		if(xoops_trim($this->getVar('obituaries_photo')) != '') {
	        return obituaries_utils::getModuleOption('folder_url').'/'.$this->getVar('obituaries_photo');
		} else {
		    return '';
		}
	}

	/**
	 * Retourne le chemin de l'image
	 * @return string	Le chemin
	 */
	function getPicturePath()
	{
	    if(xoops_trim($this->getVar('obituaries_photo')) != '') {
		    return obituaries_utils::getModuleOption('folder_path').DIRECTORY_SEPARATOR.$this->getVar('obituaries_photo');
	    } else {
	        return '';
	    }
	}

	/**
	 * Indique si l'image existe
	 *
	 * @return boolean	Vrai si l'image existe sinon faux
	 */
	function pictureExists()
	{
		$return = false;
		if(xoops_trim($this->getVar('obituaries_photo')) != '' && file_exists(obituaries_utils::getModuleOption('folder_path').DIRECTORY_SEPARATOR.$this->getVar('obituaries_photo'))) {
			$return = true;
		}
		return $return;
	}

	/**
	 * Supprime l'image associ�e
	 * @return void
	 */
	function deletePicture()
	{
		if($this->pictureExists()) {
			@unlink(obituaries_utils::getModuleOption('folder_path').DIRECTORY_SEPARATOR.$this->getVar('obituaries_photo'));
		}
		$this->setVar('obituaries_photo', '');
	}

	/**
	 * Rentourne la chaine � envoyer dans une balise <a> pour l'attribut href
	 *
	 * @return string
	 */
	function getHrefTitle()
	{
		return obituaries_utils::makeHrefTitle(xoops_trim($this->getVar('obituaries_lastname')).' '.xoops_trim($this->getVar('obituaries_firstname')));
	}

    /**
     * Retourne l'utilisateur Xoops li� � l'enregistrement courant
     *
     */
	function getXoopsUser()
	{
        $ret = null;
	    static $member_handler;
	    if($this->getVar('obituaries_uid') > 0) {
	        if(!isset($member_handler)) {
    	        $member_handler =& xoops_gethandler('member');
	        }
	        $user = $member_handler->getUser($this->getVar('obituaries_uid'));
	        if(is_object($user)) {
	            $ret = $user;
	        }
	    }
	    return $ret;
	}

	function getFullName()
	{
	    return xoops_trim($this->getVar('obituaries_lastname')).' '.xoops_trim($this->getVar('obituaries_firstname'));
	}


	/**
	 * Retourne les �l�ments format�s pour affichage
	 *
	 * @param string $format	Le format � utiliser
	 * @return array	Les donn�es formatt�es
	 */
	function toArray($format = 's')
    {
		$ret = array();
		foreach ($this->vars as $k => $v) {
			$ret[$k] = $this->getVar($k, $format);
		}
		$ret['obituaries_full_imgurl'] = $this->getPictureUrl();
		$ret['obituaries_href_title'] = $this->getHrefTitle();
		$user = null;
		$user = $this->getXoopsUser();
		if(is_object($user)) {
		    $ret['obituaries_user_name'] = $user->getVar('name');
		    $ret['obituaries_user_uname'] = $user->getVar('uname');
		    $ret['obituaries_user_email'] = $user->getVar('email');
		    $ret['obituaries_user_url'] = $user->getVar('url');
    		$ret['obituaries_user_user_avatar'] = $user->getVar('user_avatar');
	    	$ret['obituaries_user_user_from'] = $user->getVar('user_from');
		}

        $ret['obituaries_picture_url'] = $this->getPictureUrl();

		$ret['obituaries_formated_date'] = formatTimestamp(strtotime($this->getVar('obituaries_date')), 's');
		$ret['obituaries_fullname'] = $this->getFullName();
		return $ret;
    }
}


class ObituariesUsers_obituariesHandler extends XoopsPersistableObjectHandler //Obituaries_XoopsPersistableObjectHandler
{
	function __construct($db)
	{	//								Table		    Classe		 	Id		        Description
		parent::__construct($db, 'users_obituaries', 'users_obituaries', 'obituaries_id', 'obituaries_lastname');
	}

    /**
     * Retourne un utilisateur � partir de son uid
     *
     * @param integer $uid	L'ID Xoops recherch�
     * @return object
     */
	function getFromUid($uid)
    {
        $criteria = new Criteria('obituaries_uid', intval($uid), '=');
        if($this->getCount($criteria) > 0) {
            $temp = array();
            $temp = $this->getObjects($criteria);
            if(count($temp) > 0) {
                return $temp[0];
            }
        }
        return $this->create(true);
    }

    /**
     * Cr�ation du formulaire de saisie
     *
     * @param users_obituaries $item	L'�l�ment � ajouter/modifier
     * @param string $baseurl	L'url de destination
     * @param boolean	$withUserSelect	Indique s'il faut inclure la liste de s�lection de l'utilisateur
     * @return object	Le formulaire � utiliser
     */
	function getForm(users_obituaries $item, $baseurl, $withUserSelect = true)
	{
	    require_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
	    require_once XOOPS_ROOT_PATH.'/modules/obituaries/class/formtextdateselect.php';
        global $xoopsModuleConfig;
        $edit = true;
        if($item->isNew()) {
            $edit = false;
        }

        if($edit) {
            $labelSubmit = _AM_OBITUARIES_MODIFY;
            $title = _AM_OBITUARIES_MODIFY_ITEM;
        } else {
            $labelSubmit = _AM_OBITUARIES_ADD;
            $title = _AM_OBITUARIES_ADD_ITEM;
        }
    	// Formulaire de cr�ation
    	$sform = new XoopsThemeForm($title, 'frmadd', $baseurl);
    	$sform->setExtra('enctype="multipart/form-data"');
    	$sform->addElement(new XoopsFormHidden('op', 'saveedit'));
    	$sform->addElement(new XoopsFormHidden('obituaries_id', $item->getVar('obituaries_id')));
        if($withUserSelect) {
            $selectUser = new XoopsFormSelectUser(_AM_OBITUARIES_USERNAME, 'obituaries_uid', true, $item->getVar('obituaries_uid', 'e'));
            $selectUser->setDescription(_AM_OBITUARIES_USE_ANONYMOUS);
	        $sform->addElement($selectUser);
        }
	    $date = strtotime($item->getVar('obituaries_date'));
        $sform->addElement(new XoopsFormTextDateSelect(_AM_OBITUARIES_DATE, 'obituaries_date', 15, $date));
        $sform->addElement(new XoopsFormText(_AM_OBITUARIES_FIRSTNAME, 'obituaries_firstname', 50,150, $item->getVar('obituaries_firstname', 'e')), false);
        $sform->addElement(new XoopsFormText(_AM_OBITUARIES_LASTNAME, 'obituaries_lastname',50,150, $item->getVar('obituaries_lastname', 'e')), false);

//	    $editor1 = obituaries_utils::getWysiwygForm(_OBITUARIES_DESCRIPTION, 'obituaries_description', $item->getVar('obituaries_description', 'e'), 15, 60, 'description_hidden');
//        $editor2 = obituaries_utils::getWysiwygForm(_OBITUARIES_SURVIVORS, 'obituaries_survivors', $item->getVar('obituaries_survivors', 'e'), 15, 60, 'survivors_hidden');
//	    $editor3 = obituaries_utils::getWysiwygForm(_OBITUARIES_SERVICE, 'obituaries_service', $item->getVar('obituaries_service', 'e'), 15, 60, 'service_hidden');
//		$editor4 = obituaries_utils::getWysiwygForm(_OBITUARIES_MEMORIAL, 'obituaries_memorial', $item->getVar('obituaries_memorial', 'e'), 15, 60, 'memorial_hidden');
//	    if($editor1) {
//            $sform->addElement($editor1, false);
//        }
//        if($editor2) {
//            $sform->addElement($editor2, false);
//        }
//        if($editor3) {
//            $sform->addElement($editor3, false);
//        }
//        if($editor4) {
//            $sform->addElement($editor4, false);
//        }
//

        $options_tray1 = new XoopsFormElementTray(_AM_OBITUARIES_DESCRIPTION, '<br />');

        if (class_exists('XoopsFormEditor')) {
            $options['name'] = 'obituaries_description';
            $options['value'] = $item->getVar('obituaries_description', 'e');
            $options['rows'] = 10;
            $options['cols'] = '100%';
            $options['width'] = '100%';
            $options['height'] = '600px';
            $obituaries_description = new XoopsFormEditor('', $xoopsModuleConfig['form_options'], $options, $nohtml = false, $onfailure = 'textarea');
            $options_tray1->addElement($obituaries_description);
        } else {
            $obituaries_description = new XoopsFormDhtmlTextArea('', 'obituaries_description', $item->getVar('obituaries_description', 'e'), '100%', '100%');
            $options_tray1->addElement($obituaries_description);
        }
        $sform->addElement($options_tray1);

        $options_tray2 = new XoopsFormElementTray(_AM_OBITUARIES_SURVIVORS, '<br />');
        if (class_exists('XoopsFormEditor')) {
            $options['name'] = 'obituaries_survivors';
            $options['value'] = $item->getVar('obituaries_survivors', 'e');
            $options['rows'] = 10;
            $options['cols'] = '100%';
            $options['width'] = '100%';
            $options['height'] = '600px';
            $obituaries_survivors = new XoopsFormEditor('', $xoopsModuleConfig['form_options'], $options, $nohtml = false, $onfailure = 'textarea');
            $options_tray2->addElement($obituaries_survivors);
        } else {
            $obituaries_survivors = new XoopsFormDhtmlTextArea('', 'contents_contents', $item->getVar('obituaries_survivors', 'e'), '100%', '100%');
            $options_tray2->addElement($obituaries_survivors);
        }
        $sform->addElement($options_tray2);

        $options_tray3 = new XoopsFormElementTray(_AM_OBITUARIES_SERVICE, '<br />');
        if (class_exists('XoopsFormEditor')) {
            $options['name'] = 'obituaries_service';
            $options['value'] = $item->getVar('obituaries_service', 'e');
            $options['rows'] = 10;
            $options['cols'] = '100%';
            $options['width'] = '100%';
            $options['height'] = '600px';
            $obituaries_service = new XoopsFormEditor('', $xoopsModuleConfig['form_options'], $options, $nohtml = false, $onfailure = 'textarea');
            $options_tray3->addElement($obituaries_service);
        } else {
            $obituaries_service = new XoopsFormDhtmlTextArea('', 'obituaries_service', $item->getVar('obituaries_service', 'e'), '100%', '100%');
            $options_tray3->addElement($obituaries_service);
        }
        $sform->addElement($options_tray3);

        $options_tray4 = new XoopsFormElementTray(_AM_OBITUARIES_MEMORIAL, '<br />');
        if (class_exists('XoopsFormEditor')) {
            $options['name'] = 'obituaries_memorial';
            $options['value'] = $item->getVar('obituaries_memorial', 'e');
            $options['rows'] = 10;
            $options['cols'] = '100%';
            $options['width'] = '100%';
            $options['height'] = '600px';
            $obituaries_memorial = new XoopsFormEditor('', $xoopsModuleConfig['form_options'], $options, $nohtml = false, $onfailure = 'textarea');
            $options_tray4->addElement($obituaries_memorial);
        } else {
            $obituaries_memorial = new XoopsFormDhtmlTextArea('', 'obituaries_memorial', $item->getVar('obituaries_memorial', 'e'), '100%', '100%');
            $options_tray4->addElement($obituaries_memorial);
        }


        $sform->addElement($options_tray4);


    	if( $edit && trim($item->getVar('obituaries_photo')) != '' && $item->pictureExists() ) {
		    $pictureTray = new XoopsFormElementTray(_AM_OBITUARIES_CURRENT_PICTURE ,'<br />');
		    $pictureTray->addElement(new XoopsFormLabel('', "<img src='".$item->getPictureUrl()."' alt='' border='0' />"));
		    $deleteCheckbox = new XoopsFormCheckBox('', 'delpicture');
		    $deleteCheckbox->addOption(1, _DELETE);
		    $pictureTray->addElement($deleteCheckbox);
		    $sform->addElement($pictureTray);
		    unset($pictureTray, $deleteCheckbox);
        }
	    $sform->addElement(new XoopsFormFile(_AM_OBITUARIES_PICTURE, 'attachedfile', obituaries_utils::getModuleOption('maxuploadsize')), false);

	    $button_tray = new XoopsFormElementTray('' ,'');
	    $submit_btn = new XoopsFormButton('', 'post', $labelSubmit, 'submit');
	    $button_tray->addElement($submit_btn);
	    $sform->addElement($button_tray);
	    $sform = obituaries_utils::formMarkRequiredFields($sform);
	    return $sform;
	}

    /**
     * Enregistre un utilisateur apr�s modification (ou ajout)
     *
     * @param boolean	$withCurrentUser	Indique s'il faut prendre l'utilisateur courant ou pas
     * @return boolean	Vrai si l'enregistrement a r�ussi sinon faux
     */
	function saveUser($withCurrentUser = false)
	{
	    global $destname;
        $images_width = obituaries_utils::getModuleOption('images_width');
        $images_height = obituaries_utils::getModuleOption('images_height');
        $id = isset($_POST['obituaries_id']) ? intval($_POST['obituaries_id']) : 0;
		if(!empty($id)) {
			$edit = true;
			$item = $this->get($id);
			if(!is_object($item)) {
				return false;
			}
			$item->unsetNew();
		} else {
			$edit = false;
			$item = $this->create(true);
		}
		$item->setVars($_POST);
		if($withCurrentUser) {
            global $xoopsUser;
            $item->setVar('obituaries_uid', $xoopsUser->getVar('uid'));
		}
		if(isset($_POST['delpicture']) && intval($_POST['delpicture']) == 1) {
			if(trim($item->getVar('obituaries_photo')) != '' && $item->pictureExists() ) {
				$item->deletePicture();
			}
			$item->setVar('obituaries_photo', '');
		}

        $uploadFolder=obituaries_utils::getModuleOption('folder_path');

		$return = obituaries_utils::uploadFile(0,$uploadFolder );
		if($return === true) {
			$newDestName = obituaries_utils::createUploadName($uploadFolder, basename($destname), true);

            $retval = obituaries_utils::resizePicture($uploadFolder.DIRECTORY_SEPARATOR.$destname, $uploadFolder.DIRECTORY_SEPARATOR.$newDestName, $images_width, $images_height);
			if($retval == 1 || $retval == 3) {
				$item->setVar('obituaries_photo', $newDestName);
			}
		} else {
			if($return !== false) {
				echo $return;
			}
		}
		$res = $this->insert($item);
		if($res) {
			obituaries_utils::updateCache();
		}
		return $res;
	}

    /**
     * Suppression d'un utilisateur
     *
     * @param users_obituaries $user	L'utilisateur � supprimer
     * @return boolean	Le r�sultat de la suppression
     */
	function deleteUser(users_obituaries $user)
	{
	    $user->deletePicture();
	    $res = $this->delete($user, true);
		if($res) {
			obituaries_utils::updateCache();
		}
		return $res;
	}

    /**
     * Mise � jour du compteur de commentaires pour un utilisateur
     *
     * @param intger $userId
     * @param integer $total_num
     * @return void
     */
	function updateCommentsCount($userId, $commentsCount)
	{
		$userId = intval($userId);
		$commentsCount = intval($commentsCount);
		$user = null;
		$user = $this->get($userId);
		if(is_object($user)) {
			$criteria = new Criteria('obituaries_id', $userId, '=');
			$this->updateAll('prod_comments', $commentsCount, $criteria, true);
		}
	}

    /**
     * Retourne les anniversaires du jour
     * @return array	Objets de type users_obituaries
     */
	function getTodayObituariess($start = 0, $limit = 0, $sort = 'obituaries_lastname', $order = 'ASC')
	{
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('day(obituaries_date)', date('j'), '='));
		$criteria->add(new Criteria('month(obituaries_date)', date('n'), '='));
		$criteria->setStart($start);
		if($limit > 0) {
		    $criteria->setLimit($limit);
        }
		$criteria->setSort($sort);
		$criteria->setOrder($order);
		return $this->getObjects($criteria);
	}
	
	 /**
     * Return random obituarues
     * @return array	Objets de type users_obituaries
     */
	function getRandomObituariess($start = 0, $limit = 0)
	{
	    //disable cache for this one
	    $this->setCachingOptions(array('caching' => false));
	    
		$criteria = new CriteriaCompo(null);
		$criteria->setStart($start);
		if($limit > 0) {
		    $criteria->setLimit($limit);
        }
		$criteria->setSort('rand()');
		return $this->getObjects($criteria);
	}

	 /**
     * Return last obituarues
     * @return array	Objets de type users_obituaries
     */
	function getLastObituariess($start = 0, $limit = 0, $sort = 'obituaries_date', $order = 'DESC')
	{
		$criteria = new CriteriaCompo();
		$criteria->setStart($start);
		if($limit > 0) {
		    $criteria->setLimit($limit);
        }
		$criteria->setSort($sort);
		$criteria->setOrder($order);
		return $this->getObjects($criteria);
	}

    /**
     * Retourne le nombre total d'anniversaires du jour
     * @return integer
     */
	function getTodayObituariessCount()
	{
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('day(obituaries_date)', date('j'), '='));
		$criteria->add(new Criteria('month(obituaries_date)', date('n'), '='));
		return $this->getCount($criteria);
	}

    /**
     * Retourne le nombre total d'utilisateurs
     *
     * @return integer
     */
	function getAllUsersCount()
	{
	    return $this->getCount();
	}

    /**
     * Retourne la liste de tous les utilisateurs
     *
     * @param integer $start	Position de d�part
     * @param integer $limit	Nombre maximum d'enregistrements
     * @param string $sort		Champ � utiliser pour le tri
     * @param string $order		Ordre de tri
     * @return array	Objets de type users_obituaries
     */
	function getAllUsers($start = 0, $limit = 0, $sort = 'obituaries_lastname', $order = 'ASC')
	{
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('obituaries_id', 0, '<>'));
		$criteria->setStart($start);
		if($limit > 0) {
		    $criteria->setLimit($limit);
        }
		$criteria->setSort($sort);
		$criteria->setOrder($order);
		return $this->getObjects($criteria);
	}
}
?>