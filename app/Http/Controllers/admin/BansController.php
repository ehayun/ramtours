<?php

namespace App\Http\Controllers\admin;


use App\model\Ban;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BansController extends Controller
{
    public function __construct()
    {
        rami_setup_backend_language();
        // $this->middleware('CheckRole');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['bans'] = Ban::orderBy('created_at', 'desc')->paginate();
            $data['page_title']='Bans';
        $data['assets_admin']=url('assets/admin');
        return view('admin.bans.index', $data);
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
     * @param  \App\model\Ban  $ban
     * @return \Illuminate\Http\Response
     */
    public function show(Ban $ban)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\model\Ban  $ban
     * @return \Illuminate\Http\Response
     */
    public function edit(Ban $ban)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\model\Ban  $ban
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ban $ban)
    {
        $ban->is_ban = !$ban->is_ban;
        $ban->save();
        return redirect('admin/bans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\model\Ban  $ban
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ban $ban)
    {
        //
    }
}
