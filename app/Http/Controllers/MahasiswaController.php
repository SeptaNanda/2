<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Kelas;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // $mahasiswas = Mahasiswa::all();
        // $posts = Mahasiswa::orderBy('nim', 'desc')->Paginate(6);
        // return view('mahasiswas.index', compact('mahasiswas'));
        // with('i',($request->input('page', 1) - 1) * 5);
        $mahasiswas = Mahasiswa::with('kelas')
        ->where([
            ['nama','!=',Null],
            [function ($query) use ($request){
                if(($cari = $request -> cari)){
                    $query->orWhere('nama','Like','%'.$cari.'%')->get();
                }
            }]
        ]) 
            -> orderBy("nim","asc")
            -> paginate(5);
        
        return view('mahasiswas.index', compact('mahasiswas'))
        -> with('i',(request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //TODO : Tampilkan Form Create Mahasiswa
        $kelas = Kelas::all();
        return view('mahasiswas.create',['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO : Implementasikan Proses Simpan Ke Database
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Nomor_Handphone' => 'required',
            'Email' => 'required',
            'Tgl_lahir' => 'required',
        ]);

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->nomor_handphone = $request->get('Nomor_Handphone');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->tgl_lahir = $request->get('Tgl_lahir');
        $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');
        
        //ini fungsi untuk eloquent untuk tambah data yang relasinya belongsto
        // $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->kelas()->associate($kelas); 
        $mahasiswa->save();

        return redirect()->route('mahasiswas.index')
        ->with('succes','Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //TODO : Implementasikan Proses Tampilkan Data Satu Mahasiswa Berdasarkan ID
        $Mahasiswa = Mahasiswa::find($id);
        return view('mahasiswas.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //TODO : Implementasikan Proses Tampilkan Form Update Data Mahasiswa by Id
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim',$id)->first();
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('Mahasiswa','kelas'));
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
        //TODO : Implementasikan Proses Update Data Mahasiswa By Id
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Nomor_Handphone' => 'required',
            'Email' => 'required',
            'Tgl_lahir' => 'required',
        ]);
        
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim',$id)->first();
        
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->nomor_handphone = $request->get('Nomor_Handphone');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->tgl_lahir = $request->get('Tgl_lahir');
        $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        return redirect()->route('mahasiswas.index')
        ->with('succes','Mahasiswa Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO : Implementasikan Proses Delete Mahasiswa By Id
        Mahasiswa::where('nim',$id)->delete();
        return redirect()->route('mahasiswas.index')
        ->with('succes','Mahasiswa Berhasil Dihapus');
    }
}
