<?php
/**
 * ****************************************************************************
 * Obituaries - MODULE FOR XOOPS
 * Copyright (c) Herv� Thouzard of Instant Zero (http://www.instant-zero.com)
 * Created on 11 juil. 08 at 14:53:56
 * Version : $Id:
 * ****************************************************************************
 */
function obituaries_search($queryarray, $andor, $limit, $offset, $userid){
	global $xoopsDB;
	include XOOPS_ROOT_PATH.'/modules/obituaries/include/common.php';
	include_once XOOPS_ROOT_PATH.'/modules/obituaries/class/users_obituaries.php';

	// Recherche dans les produits
	$sql = 'SELECT obituaries_id, obituaries_firstname, obituaries_lastname, obituaries_date, obituaries_uid FROM '.$xoopsDB->prefix('users_obituaries').' WHERE (obituaries_id <> 0 ';
	if ( $userid != 0 ) {
		$sql .= '  AND obituaries_uid = '.$userid;
	}
	$sql .= ') ';

	$tmpObject = new users_obituaries();
	$datas = $tmpObject->getVars();
	$tblFields = array();
	$cnt = 0;
	foreach($datas as $key => $value) {
		if($value['data_type'] == XOBJ_DTYPE_TXTBOX || $value['data_type'] == XOBJ_DTYPE_TXTAREA) {
			if($cnt == 0) {
				$tblFields[] = $key;
			} else {
				$tblFields[] = ' OR '.$key;
			}
			$cnt++;
		}
	}

	$count = count($queryarray);
	$more = '';
	if( is_array($queryarray) && $count > 0 ) {
		$cnt = 0;
		$sql .= ' AND (';
		$more = ')';
		foreach($queryarray as $oneQuery) {
			$sql .= '(';
			$cond = " LIKE '%".$oneQuery."%' ";
			$sql .= implode($cond, $tblFields).$cond.')';
			$cnt++;
			if($cnt != $count) {
				$sql .= ' '.$andor.' ';
			}
		}
	}
	$sql .= $more.' ORDER BY obituaries_date DESC';
	$i = 0;
	$ret = array();
	$myts =& MyTextSanitizer::getInstance();
	$result = $xoopsDB->query($sql,$limit,$offset);
 	while ($myrow = $xoopsDB->fetchArray($result)) {
		$ret[$i]['image'] = 'images/crown.png';
		$ret[$i]['link'] = "user.php?obituaries_id=".$myrow['obituaries_id'];
		$ret[$i]['title'] = $myts->htmlSpecialChars($myrow['obituaries_lastname'].' '.$myrow['obituaries_firstname']);
		$ret[$i]['time'] = strtotime($myrow['obituaries_date']);
		$ret[$i]['uid'] = $myrow['obituaries_uid'];
		$i++;
	}
	return $ret;
}

?>