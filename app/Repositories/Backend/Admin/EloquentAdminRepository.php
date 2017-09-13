<?php

namespace App\Repositories\Backend\Admin;

use App\Models\Access\User\User;
use App\Repositories\DbRepository;
use App\Exceptions\GeneralException;


/**
 * Class EloquentAdminRepository.
 */
class EloquentAdminRepository extends DbRepository 
{
    /**
     * Model
     * 
     * @var object
     */
    public $model;

    public function __construct()
    {
        $this->model = new User;
    }   
}
