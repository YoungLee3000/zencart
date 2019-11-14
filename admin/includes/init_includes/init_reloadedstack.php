<?php
/**
* Custom message stack output to add on to messageStack variable
* @author Joe McFrederick
*/
if (isset($_SESSION) AND is_numeric($_SESSION['admin_id']) AND is_object($reloadedStack) )
{
	foreach ($reloadedStack->errors as $message)
	{
		$messageStack->errors[] = $message;
		$messageStack->size += 1;
	}
}