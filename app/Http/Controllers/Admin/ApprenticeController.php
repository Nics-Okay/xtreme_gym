<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apprentice;
use Illuminate\Http\Request;

class ApprenticeController extends Controller
{
    public function show()
    {
        $apprentices = Apprentice::with(['training', 'user'])
        ->orderBy('created_at', 'DESC')
        ->paginate(10);
    
        return view('admin.apprentices.apprentices', compact('apprentices'));
    }
}
