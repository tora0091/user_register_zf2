<?php

namespace UserRegister\Service;

use UserRegister\Service\AbstractService;

class SectionService extends AbstractService
{
    public function getSection()
    {
        /** @see \UserRegister\Resource\Db\Table\SectioinTable::getSection() */
        return $this->getTable('SectionTable')->getSection();
    }
}