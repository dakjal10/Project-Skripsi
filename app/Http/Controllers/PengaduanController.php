<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PengaduanController extends Controller
{
    public function index()
    {
        $data = Pengaduan::where('user_id',Auth::id())->latest()->get();
        return view('pengaduan.index',compact('data'));
    }

    public function create()
    {
        return view('pengaduan.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
        $request->validate([
            'judul'=>'required',
            'isi'=>'required',
            'kategori'=>'required',
            'bukti'=>'nullable|mimes:jpg,png,pdf|max:2048'
        ]);

        $file = null;

        if($request->hasFile('bukti')){
            $file = $request->file('bukti')->store('bukti','public');
        }

        Pengaduan::create([
            'user_id'=>Auth::id(),
            'judul'=>$request->judul,
            'isi'=>$request->isi,
            'kategori'=>$request->kategori,
            'bukti'=>$file,
            'status'=>'pending'
        ]);

        return redirect()->route('pengaduan.index')->with('success','Pengaduan berhasil dikirim');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaduan $pengaduan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaduan $pengaduan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        //
    }
}
