<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Operational;
use Illuminate\Support\Facades\Session;

class OperationalController extends Controller
{
    public function index()
    {
        $balance = Balance::first();
        return view('operational/operational-form',compact('balance'));
    }

    public function create(Request $request)
    {      
        $request->validate([
            'goods' => 'required',
            'description' => 'required',            
            'nominal' => 'required',            
        ]);  
        
        $currentTime = Carbon::now()->timezone('Asia/Jakarta');

        $operational = new Operational();
        $operational->goods = $request->input('goods');
        $operational->nominal = $request->input('nominal');
        $operational->description = $request->input('description');
        $operational->date = $currentTime->format('Y-m-d H:i:s');
        $operational->save();        
        
        $balance = Balance::first();
        $balance->nominal = $balance->nominal - $operational->nominal;
        $balance->save();

        Session::flash('success');
        
        return redirect()->route('admin.operational-form');
    }

    public function list(Request $request)
    {
        $balance = Balance::first();
        $operationals = Operational::all();
        $search = $request->input('search');

        $operationals = Operational::latest()->where('id', 'LIKE', "%$search%")
                ->orWhere('goods', 'LIKE', "%$search%")
                ->orWhere('description', 'LIKE', "%$search%")
                ->orWhere('nominal', 'LIKE', "%$search%")
                ->orWhere('date', 'LIKE', "%$search%")
                ->paginate(10);
                
        return view('operational.list-operational', compact('operationals', 'balance'));
    }
}
