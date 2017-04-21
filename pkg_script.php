<?php
/**
 * @version    1-1-0-0 // Y-m-d 2017-04-21
 * @author     HR IT-Solutions Florian Häusler https://www.hr-it-solutions.com
 * @copyright  Copyright (C) 2011 - 2017 Didldu e.K. | HR IT-Solutions
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 **/

defined('_JEXEC') or die();

class PKG_DD_GMaps_ModuleInstallerScript
{

	protected $name = 'DD GMaps Module Package';

	protected $moduleName = 'mod_dd_gmaps_module';

	protected $extensionsToEnable = array(

		array(  'name'  => 'dd_gmaps_locations_geocode',
				'type'  => 'plugin',
				'group' => 'system')

	);

	/**
	 * Enable extensions
	 *
	 * @since Version 1.1.0.2
	 *
	 * @return void
	 */
	private function enableExtensions()
	{
		foreach ($this->extensionsToEnable as $extension)
		{
			$db  = JFactory::getDbo();
			$query = $db->getQuery(true)
					->update('#__extensions')
					->set($db->qn('enabled') . ' = ' . $db->q(1))
					->where('type = ' . $db->quote($extension['type']))
					->where('element = ' . $db->quote($extension['name']));

			if ($extension['type'] === 'plugin')
			{
				$query->where('folder = ' . $db->quote($extension['group']));
			}

			$db->setQuery($query);
			$db->execute();
		}
	}

	/**
	 * JInstaller
	 *
	 * @param   object  $parent  \JInstallerAdapterPackageParent
	 *
	 * @return  boolean
	 *
	 * @since Version 1.1.0.2
	 */
	public function install($parent)
	{
		$this->enableExtensions();

		return true;
	}
}
