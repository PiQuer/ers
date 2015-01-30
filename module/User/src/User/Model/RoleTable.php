<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;


class UserTable extends Table {
    
    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->table = 'Role';
        $this->entityClass = '\User\Model\Entity\Role';
    }
}