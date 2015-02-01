<?php
/**
 * mm_inherit
 * @version 1.1 (2012-11-13)
 * 
 * Inherit values from a parent.
 * 
 * @uses ManagerManager plugin 0.4.
 * 
 * @link http://code.divandesign.biz/modx/mm_inherit/1.1
 * 
 * @copyright 2012
 */

function mm_inherit($fields, $roles = '', $templates = ''){
	global $mm_fields, $modx;
	$e = &$modx->event;
	
	// if we've been supplied with a string, convert it into an array
	$fields = makeArray($fields);
	
	// if we aren't creating a new document or folder, we don't want to do this
	if (!($modx->manager->action == '85' || $modx->manager->action == '4')){
		return;
	}
	
	// Are we using this rule?
	if ($e->name == 'OnDocFormRender' && useThisRule($roles, $templates)){
		// Get the parent info
		if (isset($_REQUEST['pid']) && is_numeric($_REQUEST['pid'])){
			$parentID = intval($_REQUEST['pid']);
		} else if (isset($_REQUEST['parent']) && is_numeric($_REQUEST['parent'])){
			$parentID = intval($_REQUEST['parent']);
		}else{
			$parentID = 0;
		}
		
		if($parentID==0) return;
		
		$output = "//  -------------- mm_inherit (from page $parentID) :: Begin ------------- \n";
		
		foreach ($fields as $field){
			// get some info about the field we are being asked to use
			if (isset($mm_fields[$field]['dbname'])){
				$fieldtype = $mm_fields[$field]['fieldtype'];
				$fieldname = $mm_fields[$field]['fieldname'];
				$dbname = $mm_fields[$field]['dbname'];
				if(!empty($mm_fields[$field]['tv'])) $dbname = $field;
				
				// Get this field data from the parent
				$newArray = $modx->getTemplateVarOutput($dbname, $parentID);
				if ( empty($newArray)) { // If no results, check if there is an unpublished doc
					$newArray = $modx->getTemplateVarOutput($dbname, $parentID, 0);
				}
				$newvalue = $newArray[$dbname];
			}else{
				break;	 // If it's not something stored in the database, don't get the value
			}
			
			if(empty($newvalue)) continue;
			
			$output .= "
			// fieldtype $fieldtype
			// fieldname $fieldname
			// dbname $dbname
			// newvalue $newvalue
			";
			$date_format = $modx->toDateFormat(null, 'formatOnly');
			
			switch ($field){
				case 'log':
				case 'hide_menu':
				case 'show_in_menu':
					$output .=  '$j("input[name='.$fieldname.']").attr("checked", "'.($newvalue?'':'checked').'"); ';
				break;
				
				case 'is_folder':
				case 'is_richtext':
				case 'searchable':
				case 'cacheable':
				case 'published':
					$output .=  '$j("input[name='.$fieldname.']").attr("checked", "'.($newvalue?'checked':'').'"); ';
				break;
				
				case 'pub_date':
				case 'unpub_date':
					$output .=  '$j("input[name='.$fieldname.']").val("'.strftime($date_format . ' %H:%M:%S', $newvalue).'"); ';
				break;

				default:
					switch ($fieldtype){
						case 'textarea':
							$output .=  '$j("textarea[name='.$fieldname.']").html("' . jsSafe($newvalue) . '"); ';
						break;
						
						default:
							$output .=  '$j("'.$fieldtype.'[name='.$fieldname.']").val("' . jsSafe($newvalue) . '"); ';
						break;
					}
				break;
			}
		}
		
		$output .= "//  -------------- mm_inherit (from page $parentID) :: End ------------- \n";
		
		$e->output($output . "\n");
	}
}
?>