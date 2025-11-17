<?php
namespace App\Services;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }


    public function register($request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $role = match($data['role']) {
            'admin' => 5,
            'vendor' => 6,
            'customer' =>7,
        };
        $data['role_id'] = $role;
        unset($data['role']);


        $user = $this->userRepo->create($data);
        $token = JWTAuth::fromUser($user);


        return ['user' => $user, 'token' => $token];
    }


    public function login($request)
    {
        $token = auth()->attempt($request->validated());
        if (!$token) return false;
        return ['token' => $token, 'user' => auth()->user()];
    }
}