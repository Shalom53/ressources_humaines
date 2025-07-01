<?php


namespace App\Http\Controllers;

use App\Repositories\Interfaces\CycleRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;



class LoginController extends Controller
{
    protected CycleRepositoryInterface $cycleRepo;

    public function __construct(CycleRepositoryInterface $cycleRepo)
    {
        $this->cycleRepo = $cycleRepo;
    }


// ✅ Afficher la page login
    public function login ()
    {



        return view('login.page');




    }



// ✅ Afficher la page de création de compte
    public function register ()
    {



        return view('login.register');




    }

// ✅ Retour vers la page login
    public function logout(Request $request)
    {



        return redirect('/login');

    }


}
