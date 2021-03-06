<?php
/**
*
* Product reviews table
*
* @package	VirtueMart
* @subpackage
* @author RolandD
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2012 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: ratings.php 3267 2011-05-16 22:51:49Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

if(!class_exists('VmTable')) require(VMPATH_ADMIN.DS.'helpers'.DS.'vmtable.php');

/**
 * Product review table class
 * The class is is used to manage the reviews in the shop.
 *
 * @package		VirtueMart
 * @author Max Milbers
 */
class TableRating_votes extends VmTable {

	/** @var int Primary key */
	var $virtuemart_rating_vote_id	= 0;
	/** @var int Product ID */
	var $virtuemart_product_id			= 0;

	var $vote				= '';
	var $lastip      		= '';


	/**
	* @author Max Milbers
	* @param JDataBase $db
	*/
	function __construct(&$db) {
		parent::__construct('#__virtuemart_rating_votes', 'virtuemart_rating_vote_id', $db);
		$this->setPrimaryKey('virtuemart_rating_vote_id');

		$this->setLoggable();
	}

	function check(){

		if($this->created_by>0) {
			$q = 'SELECT `virtuemart_rating_vote_id` FROM `#__virtuemart_rating_votes` WHERE `virtuemart_product_id`="'.$this->virtuemart_product_id.'" AND `created_by`="'.$this->created_by.'" ';
			$this->_db->setQuery($q);
			if($r = $this->_db->loadResult()){
				vmdebug('__virtuemart_rating_votes check set virtuemart_rating_vote_id',$r);
				$this->virtuemart_rating_vote_id = $r;
			}
		} else if(empty($this->created_by) and !empty($this->customer) and vmAccess::manager('ratings')){
			$this->created_by = -1;
		}

		return parent::check();
	}
}
// pure php no closing tag
