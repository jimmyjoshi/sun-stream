<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Admin\EloquentAdminRepository;
use App\Http\Transformers\UserTransformer;


/**
 * Class AdminController.
 */
class AdminController extends Controller
{
    /**
     * Repository
     * 
     * @var object
     */
    public $repository;

    public function __construct()
    {
        $this->repository = new EloquentAdminRepository;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.admin.index')->with([
            'repository' => $this->repository
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function loginMapHistory()
    {
        return view('backend.admin.login-map')->with([
            'repository' => $this->repository
        ]);
    }
}
