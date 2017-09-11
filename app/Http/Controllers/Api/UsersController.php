<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Access\User\User;
use App\Models\Access\User\UserLoginTrack;
use App\Models\Access\User\UserToken;
use Response;
use Carbon;
use App\Repositories\Backend\User\UserContract;
use App\Repositories\Backend\UserNotification\UserNotificationRepositoryContract;
use App\Http\Transformers\UserTransformer;
use App\Http\Utilities\FileUploads;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;
use Auth;
use App\Repositories\Backend\Access\User\UserRepository;

class UsersController extends Controller 
{
    protected $userTransformer;
    /**
     * __construct
     * @param UserTransformer                    $userTransformer
     */
    public function __construct(UserTransformer $userTransformer, UserRepository $repository)
    {
        $this->userTransformer  = $userTransformer;
        $this->repository       = $repository;
    }

    /**
     * Login request
     * 
     * @param Request $request
     * @return type
     */
    public function login(Request $request) 
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        
        $user = Auth::user()->toArray();

        $userData = array_merge($user, ['token' => $token]);

        $responseData = $this->userTransformer->transform((object)$userData);

        if($request->get('lat') && $request->get('long'))
        {
            UserLoginTrack::create([
                'user_id'   => $user['id'],
                'lat'       => $request->get('lat'),
                'long'      => $request->get('long')
            ]);
        }


        if($request->get('token'))
        {
            UserToken::where('user_id', $user['id'])->delete();
            UserToken::create([
                'user_id'   => $user['id'],
                'token'       => $request->get('token')
            ]);
        }

        // if no errors are encountered we can return a JWT
        return response()->json($responseData);
    }

    public function register(Request $request)
    {
        $input = $request->all();

        if($request->file('image'))
        {
            
            $imageName  = rand(11111, 99999) . '_profile-pic.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(base_path() . '/public/profile-pictures/', $imageName);

            $input = array_merge($input, ['profile_picture' => $imageName]);
        }

        $status = $this->repository->signup($input);

        if($status)
        {
            $credentials = $request->only('email', 'password');

            try {
                // verify the credentials and create a token for the user
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 401);
                }
            } catch (JWTException $e) {
                // something went wrong
                return response()->json(['error' => 'could_not_create_token'], 500);
            }
            
            $user = Auth::user()->toArray();

            $userData = array_merge($user, ['token' => $token]);

            $responseData = $this->userTransformer->transform((object)$userData);

            // if no errors are encountered we can return a JWT
            return response()->json($responseData);
        }
        return response()->json(['error' => 'Unable to Register New User !'], 500);
    }

    /**
     * Logout request
     * @param  Request $request
     * @return json
     */
    public function logout(Request $request) 
    {
        $userId     = $request->header('UserId');
        $userToken  = $request->header('UserToken');
        $response   = $this->users->deleteUserToken($userId, $userToken);

        if ($response)
        {
            return $this->ApiSuccessResponse(array());
        } else {
            return $this->respondInternalError('Error in Logout');
        }
    }
}
