<?php
namespace MadeITBelgium\Vat\Facade;

use Illuminate\Support\Facades\Facade;

/**
 *
 * PHP Vat Library
 *
 * @version    1.0.0
 * @package    madeitbelgium/vat
 * @copyright  Copyright (c) 2016 Made I.T. (http://www.madeit.be) - TPWeb.org (http://www.tpweb.org)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
class Vat extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'vat';
	}
}
