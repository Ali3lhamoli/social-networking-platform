<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Requests\Site\RegisterRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegisterController extends Controller
{
    public function show(){
        return view('web.site.auth.register');
    }
    
    /**
     * Handle an authentication attemp
     */
    public function register(RegisterRequest $request): RedirectResponse
    {

        $data = $request->validated();
        $user = User::create($data);
        Auth::login($user);
        return redirect()->route('site.home');
    }
    }

