<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginFormRequest;

class ApiController extends Controller
{
    public function login(LoginFormRequest $request)
    {
        // Find user by email
        $user = User::where('email', $request['email'])->first();
        // Check if user exists and password is correct
        if (! $user || ! Hash::check($request['password'], $user->password)) {
            // Return error response for invalid credentials
            $response = [
                'success' => false,
                'message' => 'User password is incorrect.',
            ];

            return response()->json($response, 404);
        }

        // Create and return access token for successful login
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
        $response = [
            'message' => 'User logged in successfully',
            'access_token' => $token,
            'user' => $user,
        ];

        return response()->json($response, 200);
    }
    
    public function index(){
        $user = auth()->user();
        // Access a user's currently selected company...
        // Acceder a la empresa actualmente seleccionada por un usuario...
        $user->currentCompany; //: Wallo\FilamentCompanies\Company
 
        // Access all of the companies (including owned companies) that a user belongs to...
        // Acceder a todas las empresas (incluidas las propias) a las que pertenece un usuario...
        return $user->allCompanies(); //: Illuminate\Support\Collection
        
        // Access all of a user's owned companies...
        // Acceder a todas las empresas propiedad de un usuario...
        $user->ownedCompanies; //: Illuminate\Database\Eloquent\Collection
        
        // Access all of the companies that a user belongs to but does not own...
        // Acceder a todas las empresas a las que pertenece un usuario pero de las que no es propietario..
        $user->companies; //: Illuminate\Database\Eloquent\Collection
        
        // Access a user's "personal" company...
        // Acceder a la empresa «personal» de un usuario...
        $user->personalCompany(); //: Wallo\FilamentCompanies\Company
        
        // Determine if a user owns a given company...
        // Determinar si un usuario es propietario de una empresa determinada...
        $user->ownsCompany($company); //: bool
        
        // Determine if a user belongs to a given company...
        // Determinar si un usuario pertenece a una empresa dada...
        $user->belongsToCompany($company); //: bool
        
        // Get the role that the user is assigned on the company...
        // Obtener el rol que el usuario tiene asignado en la empresa...
        $user->companyRole($company); //: \Wallo\FilamentCompanies\Role
        
        // Determine if the user has the given role on the given company...
        // Determinar si el usuario tiene el rol dado en la empresa dada...
        $user->hasCompanyRole($company, 'admin'); //: bool
        
        // Access an array of all permissions a user has for a given company...
        // Accede a un array de todos los permisos que tiene un usuario para una empresa dada...
        $user->companyPermissions($company); //: array
        
        // Determine if a user has a given company permission...
        // Determina si un usuario tiene un permiso de una empresa determinada...
        $user->hasCompanyPermission($company, 'server:create'); //: bool
    }
}
