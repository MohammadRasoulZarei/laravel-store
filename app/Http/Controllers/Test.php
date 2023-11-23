<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\TestMail;
use App\Notifications\PostAdded;
use Illuminate\Http\Request;
use App\Notifications\PostPublished;
use Illuminate\Support\Facades\Mail;

class Test extends Controller
{
    public function mail()
    {
       // Mail::send(new TestMail());
       $user=User::find(2);
       $user->notify(new Test());
        return redirect()->route("home.index");
    }
}
