<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Exception;
use Mail;
use App\Mail\SendEmailCode;
use App\Models\UserEmailCode;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'statut',
        'role',
        'initial',
        'photo',
        'theme',
        'lastConnexion',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateCode()
    {
        $user = auth()->user();
        $existingCode = UserEmailCode::where('user_id', $user->id)->first();
    
        // Check if a code was generated in the last 5 minutes
        if ($existingCode && $existingCode->created_at->gt(Carbon::now()->subMinutes(5))) {
            return response()->json(['message' => 'A code has already been sent. Please wait before requesting a new code.'], 429);
        }

        $code = rand(1000, 9999);
  
        UserEmailCode::updateOrCreate(
            [ 'user_id' => auth()->user()->id ],
            [ 'code' => $code ]
        );
    
        try {
  
            $details = [
                'title' => 'Votre code de vérification Smartylex.',
                'code' => $code
            ];
             
            Mail::to(auth()->user()->email)->send(new SendEmailCode($details));
    
        } catch (Exception $e) {
            info("Error: ". $e->getMessage());
        }
    }
}