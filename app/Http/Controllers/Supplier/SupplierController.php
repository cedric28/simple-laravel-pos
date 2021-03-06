<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Log;
use App\Supplier;
use Carbon\Carbon;
use Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        $InactiveSuppliers = Supplier::onlyTrashed()->get();
        return view("supplier.index", [
            'suppliers' => $suppliers,
            'InactiveSuppliers' => $InactiveSuppliers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        return view("supplier.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");
        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {
            //validate request value
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:50|unique:suppliers,name',
                'short_name' => 'required|string|max:50',
                'address' => 'required|string|max:50',
                'contact_number' => 'required|digits:10',
                'email' => 'required|email|max:50'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            //check current user
            $user = \Auth::user()->id;

            //save supplier
            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->short_name = $request->short_name;
            $supplier->address = $request->address;
            $supplier->contact_number = $request->contact_number;
            $supplier->email = $request->email;
            $supplier->creator_id = $user;
            $supplier->updater_id = $user;
            $supplier->save();

            $log = new Log();
            $log->log = "User " . \Auth::user()->email . " create supplier " . $supplier->name . " at " . Carbon::now();
            $log->creator_id =  \Auth::user()->id;
            $log->updater_id =  \Auth::user()->id;
            $log->save();
            /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();

            return redirect()->route('supplier.create')
                ->with('successMsg', 'Supplier Save Successful');
        } catch (\Exception $e) {
            //if error occurs rollback the data from it's previos state
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        $supplier = Supplier::withTrashed()->findOrFail($id);

        return view('supplier.show', [
            'supplier' => $supplier
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        $supplier = Supplier::withTrashed()->findOrFail($id);


        return view('supplier.edit', [
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        /*
        | @Begin Transaction
        |---------------------------------------------*/
        \DB::beginTransaction();

        try {
            //check supplier if exist
            $supplier = Supplier::withTrashed()->findOrFail($id);

            //validate the request value
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|unique:suppliers,name,' . $supplier->id,
                'short_name' => 'required|string|max:50',
                'address' => 'required|string|max:50',
                'contact_number' => 'required|digits:10',
                'email' => 'required|email|max:50'
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator->errors())->withInput();
            }

            //check current user
            $user = \Auth::user()->id;

            //save the update value
            $supplier->name = $request->name;
            $supplier->short_name = $request->short_name;
            $supplier->address = $request->address;
            $supplier->contact_number = $request->contact_number;
            $supplier->email = $request->email;
            $supplier->updater_id = $user;
            $supplier->update();

            $log = new Log();
            $log->log = "User " . \Auth::user()->email . " edit supplier " . $supplier->name . " at " . Carbon::now();
            $log->creator_id =  \Auth::user()->id;
            $log->updater_id =  \Auth::user()->id;
            $log->save();
            /*
            | @End Transaction
            |---------------------------------------------*/
            \DB::commit();

            return back()->with("successMsg", "Supplier Update Successfully");
        } catch (\Exception $e) {
            //if error occurs rollback the data from it's previos state
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //prevent other user to access to this page
        $this->authorize("isAdmin");

        //delete category
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        $log = new Log();
        $log->log = "User " . \Auth::user()->email . " delete supplier " . $supplier->name . " at " . Carbon::now();
        $log->creator_id =  \Auth::user()->id;
        $log->updater_id =  \Auth::user()->id;
        $log->save();
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        \DB::beginTransaction();
        try {

            $supplier = Supplier::onlyTrashed()->findOrFail($id);

            /* Restore supplier */
            $supplier->restore();

            $log = new Log();
            $log->log = "User " . \Auth::user()->email . " restore supplier " . $supplier->name . " at " . Carbon::now();
            $log->creator_id =  \Auth::user()->id;
            $log->updater_id =  \Auth::user()->id;
            $log->save();

            \DB::commit();

            return back()->with("successMsg", "Successfully Restore the data");
        } catch (\Exception $e) {
            \DB::rollback();
            return back()->withErrors($e->getMessage());
        }
    }
}
