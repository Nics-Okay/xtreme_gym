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
        ->whereRaw('LOWER(status) = ?', ['enrolled'])
        ->orderBy('created_at', 'DESC')
        ->paginate(10);
    
        return view('admin.apprentices.apprentices', compact('apprentices'));
    }

    public function destroy(Apprentice $apprentice)
    {
        $apprentice->delete();

        return redirect()->route('apprentice.show')->with('success', 'Transaction Deleted Successfully');
    }
}
