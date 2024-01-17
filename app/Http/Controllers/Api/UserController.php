<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Class constructor
     * 
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if($allUsers = $this->userRepository->all()) {
            return response()->json(['message' => 'All Users', 'data' => $allUsers->toArray(), 'success' => true], config('constants.HTTP_CODE_OK'));
        }

        return response()->json(['message' => 'Failed to fetch all.', 'success' => false], config('constants.HTTP_CODE_INTERNAL_SERVER_ERROR'));
    }
}
