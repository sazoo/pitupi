<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Document;
use App\L_transaction;
use Auth;
use App\Transaction;
use Carbon\Carbon;
use DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.welcome');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $p_documents = Document::where(['user_id' => $id,
                                        'type' => 0])->get();

        $t_documents = Document::where(['user_id' => $id,
                                        'type' => 1])->get();
        $l_transactions = L_transaction::where('user_id',$id)->get();

        


        return view('admin.profile',['user' => $user,
                                     'l_transactions' => $l_transactions,
                                     'p_documents' => $p_documents,
                                     't_documents' => $t_documents]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users',['users' => $users]);
    }

    public function approve_loan(Request $request){
        L_transaction::where('loan_transaction_id', $request->loan_id)
                     ->update(['approved_by' => Auth::id(),
                               'approved_date' => date('Y-m-d H:i:s'),
                               'is_approved' => 1]);
        return  $request->loan_id;
        //return  $request->loan_id;
    }

    public function transfer(Request $request){
        $user_id            = $request->user_id;
        $amount             = $request->amount;
        $document_id        = $request->document_id;
        $transaction_type   = 0;
        $approved_by        = Auth::id();
        $approved_date      = date('Y-m-d H:i:s');

        $transaction = new transaction;
        $transaction->user_id = $user_id;
        $transaction->document_id = $document_id;
        $transaction->amount = $amount;
        $transaction->transaction_type  = $transaction_type;
        $transaction->approved_date = $approved_date;
        $transaction->save();
    }
}
