<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balance;
use App\Models\BalanceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Operational;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class OperationalController extends Controller
{
    public function index()
    {
        $balance = Balance::first();
        return view('operational/operational-form',compact('balance'));
    }

    public function create(Request $request)
    {
        try {
            $this->validateRequest($request);

            $currentTime = Carbon::now()->timezone('Asia/Jakarta');

            $operational = $this->createOperational($request, $currentTime);

            $this->addHistoryBills($operational);

            $this->updateBalance($operational->nominal);

            Session::flash('success');

            return redirect()->route('admin.operational-form');
        } catch (ValidationException $e) {
            return redirect()->route('admin.operational-form')->withErrors($e->errors())->withInput();
        }
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'goods' => 'required',
            'description' => 'required',            
            'nominal' => 'required',            
        ]);
    }

    private function createOperational(Request $request, $currentTime)
    {
        $operational = new Operational();
        $operational->goods = $request->input('goods');
        $operational->nominal = $request->input('nominal');
        $operational->description = $request->input('description');
        $operational->date = $currentTime->format('Y-m-d H:i:s');
        $operational->save();

        return $operational;
    }

    private function addHistoryBills(Operational $operational)
    {
        $currentTime = Carbon::now()->timezone('Asia/Jakarta');

        $balanceHistory = new BalanceHistory();
        $balanceHistory->operational_id = $operational->id;
        $balanceHistory->nominal = $operational->nominal;
        $balanceHistory->description = "Operational";
        $balanceHistory->date = $currentTime->format('Y-m-d H:i:s');
        $balanceHistory->save();
    }

    private function updateBalance($nominal)
    {
        $balance = Balance::first();
        $balance->nominal = $balance->nominal - $nominal;
        $balance->save();
    }

    public function list(Request $request)
    {
        $balance = Balance::first();

        $operationals = Operational::paginate(10);;
        $search = $request->input('search');

        $operationals = Operational::latest()->where('id', 'LIKE', "%$search%")
                ->orWhere('goods', 'LIKE', "%$search%")
                ->orWhere('description', 'LIKE', "%$search%")
                ->orWhere('nominal', 'LIKE', "%$search%")
                ->orWhere('date', 'LIKE', "%$search%")
                ->paginate(10);
                
        return view('operational.list-operational', compact('operationals', 'balance'));
    }
    
    public function detail($id)
    {
        $balance = Balance::first();
        $operationals = Operational::find($id);
        if (!$operationals) {
            return redirect()->route('admin/list-operational')->with('error', 'Operational not found.');
        }

        return view('operational.detail-operational', ['operationals' => $operationals],compact('balance'));
    }
}
