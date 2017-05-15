<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 15/05/17
 * Time: 20:18
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;

class personAdmin extends AbstractAdmin
{
    protected $searchResultActions = array('edit', 'show');
}