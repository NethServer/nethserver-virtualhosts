<?php
namespace NethServer\Module\VirtualHosts;

/*
 * Copyright (C) 2016Nethesis S.r.l.
 *
 * This script is part of NethServer.
 *
 * NethServer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * NethServer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with NethServer.  If not, see <http://www.gnu.org/licenses/>.
 */

use Nethgui\System\PlatformInterface as Validate;
use Nethgui\Controller\Table\Modify as Table;

/**
 * Modify Virtual Hosts
 *
 */
class Modify extends \Nethgui\Controller\Table\Modify
{

    public function initialize()
    {
        $virtualHostValidator = $this->createValidator()->orValidator($this->createValidator(Validate::HOSTNAME_FQDN), $this->createValidator()->equalTo('__ANY__'));
        
        $schema = array(
            array('name', Validate::USERNAME, Table::KEY),
            array('Description', Validate::ANYTHING, Table::FIELD, 'Description'),
            array('Status', Validate::SERVICESTATUS, Table::FIELD, 'status'),
            array('VirtualHost', $virtualHostValidator, Table::FIELD, 'VirtualHost'),
            array('PasswordStatus', Validate::SERVICESTATUS, Table::FIELD, 'PasswordStatus'),
            array('PasswordValue', Validate::NOTEMPTY, Table::FIELD, 'PasswordValue'),
            array('Access', $this->createValidator()->memberOf('public', 'private'), Table::FIELD, 'Access'),
            array('CgiBin', Validate::SERVICESTATUS, Table::FIELD, 'CgiBinStatus'),
            array('AliasType', $this->createValidator()->memberOf('default', 'root', 'custom'), Table::FIELD, 'AliasType'),
            array('AliasCustom', '/^([a-z]|[0-9]){1,12}$/', Table::FIELD, 'AliasCustom'),
            array('ForceSsl', Validate::SERVICESTATUS, Table::FIELD, 'ForceSslStatus'),
            array('AllowOverride', Validate::SERVICESTATUS, Table::FIELD, 'AllowOverrideStatus'),
        );

        $this
            ->setDefaultValue('Status', 'enabled')
            ->setDefaultValue('PasswordValue', '')
            ->setDefaultValue('PasswordStatus', 'disabled')
            ->setDefaultValue('Access', 'private')
            ->setDefaultValue('CgiBin', 'disabled')
            ->setDefaultValue('AliasType', 'default')
            ->setDefaultValue('ForceSsl', 'disabled')
            ->setDefaultValue('AllowOverride', 'disabled')
        ;

        $this->setSchema($schema);

        parent::initialize();
    }

    public function prepareView(\Nethgui\View\ViewInterface $view)
    {
        parent::prepareView($view);

        $view['VirtualHostDatasource'] = array_merge(
            array(array('__ANY__', $view->translate('ANY_VHOST'))),
            $this->getVirtualHostDatasource()
        );
    }

    public function getVirtualHostDatasource()
    {
        $ds = array();

        foreach ($this->getPlatform()->getDatabase('hosts')->getAll('self') as $hostName => $record) {
            if (isset($record['Description'])
                && $record['Description']) {
                $description = sprintf("%s (%s)", $hostName, trim($record['Description']));
            } else {
                $description = $hostName;
            }
            $ds[] = array($hostName, $description);
        }

        return $ds;
    }

}
