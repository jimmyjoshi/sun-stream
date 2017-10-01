<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Transformers\ChargeTransformer;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Charge\EloquentChargeRepository;

class APIChargeHistoryController extends BaseApiController 
{   
    /**
     * Event Transformer
     * 
     * @var Object
     */
    protected $chargeTransformer;

    /**
     * Repository
     * 
     * @var Object
     */
    protected $repository;

    /**
     * __construct
     * 
     * @param ChargeTransformer $chargeTransformer
     */
    public function __construct(EloquentChargeRepository $repository, ChargeTransformer $chargeTransformer)
    {
        parent::__construct();

        $this->repository           = $repository;
        $this->chargeTransformer    = $chargeTransformer;
    }

    /**
     * List of All Events
     * 
     * @param Request $request
     * @return json
     */
    public function index(Request $request) 
    {
        $user   = $this->getAuthenticatedUser();
        $items  = $this->repository->getAllByUser($user)->toArray();

        if($items && count($items))
        {
            $itemData = $this->chargeTransformer->transformCollection($items);

            return $this->successResponse($itemData);
        }

        $error = [
            'reason' => 'Unable to find Charge History!'
        ];

        return $this->setStatusCode(400)->failureResponse($error, 'No Charge History Found !');
    }

    /**
     * Create
     * 
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $model = $this->repository->create($request->all());

        if($model)
        {
            $responseData = $this->chargeTransformer->createCharge($model);

            return $this->successResponse($responseData, 'Charge Entry Created Successfully', 200, true);
        }

        $error = [
            'reason' => 'Invalid Inputs'
        ];

        return $this->setStatusCode(400)->failureResponse($error, 'Something went wrong !');
    }

    /**
     * Edit
     * 
     * @param Request $request
     * @return string
     */
    public function edit(Request $request)
    {
        $chargeId   = (int) $request->charge_id;
        $model      = $this->repository->updateHistory($chargeId, $request->all());

        if($model)
        {
            $chargedata      = $this->repository->getById($chargeId);
            $responseData   = $this->chargeTransformer->transform($chargedata);


            return $this->successResponse($responseData, 'Charge History is Edited Successfully', 200, true);
        }

        $error = [
            'reason' => 'Invalid Inputs'
        ];

        return $this->setStatusCode(400)->failureResponse($error, 'Something went wrong !');
    }

    /**
     * Delete
     * 
     * @param Request $request
     * @return string
     */
    public function delete(Request $request)
    {
        $eventId = (int) $request->event_id;

        if($eventId)
        {
            $status = $this->repository->destroy($eventId);

            if($status)
            {
                $responseData = [
                    'success' => 'Event Deleted'
                ];

                return $this->successResponse($responseData, 'Event is Deleted Successfully');
            }
        }

        $error = [
            'reason' => 'Invalid Inputs'
        ];

        return $this->setStatusCode(404)->failureResponse($error, 'Something went wrong !');
    }
}
