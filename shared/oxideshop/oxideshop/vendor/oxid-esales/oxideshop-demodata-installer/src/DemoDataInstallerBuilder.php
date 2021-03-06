<?php
/**
 * This file is part of OXID eSales Demo Data Installer.
 *
 * OXID eSales Demo Data Installer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eSales Demo Data Installer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eSales Demo Data Installer.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2017
 */

namespace OxidEsales\DemoDataInstaller;

use Symfony\Component\Filesystem\Filesystem;
use OxidEsales\Facts\Facts;

class DemoDataInstallerBuilder
{
    public function build()
    {
        $facts = new Facts();
        $edition = $facts->getEdition();
        $demoDataPathSelector = new DemoDataPathSelector($facts, $edition);
        $filesystem = new Filesystem();

        return new DemoDataInstaller($facts, $demoDataPathSelector, $filesystem);
    }
}
