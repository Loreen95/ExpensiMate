<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    //
    public function switch($locale)
    {
        // Store the selected locale in the session
        Session::put('locale', $locale);

        // Redirect back to the previous page
        return redirect()->back();
    }
}
