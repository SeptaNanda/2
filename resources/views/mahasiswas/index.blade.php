@extends('mahasiswas.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            </div>
            <div class="float-right my-2">
                <a class="btn btn-success" href="{{ route('mahasiswas.create') }}"> Input Mahasiswa</a>
            </div>
            <form method="get" action="{{ route('mahasiswas.index') }}" id="myForm" role="search">
            <div class="form-group">                   
                <input type="text" name="cari" class="form-control" id="cari" aria-describedby="cari" placeholder="Cari">
                <button type="submit" class="btn btn-primary">Submit</button>           
            </div>
            </form>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>Nim</th>
            <th>Email</th>
            <th>Nama</th>
            <th>Tanggal Lahir</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>No_Handphone</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($mahasiswas as $Mahasiswa)
        <tr>
            
            <td>{{ $Mahasiswa->nim }}</td>
            <td>{{ $Mahasiswa->email }}</td>
            <td>{{ $Mahasiswa->nama }}</td>
            <td>{{ $Mahasiswa->tgl_lahir }}</td>
            <td>{{ $Mahasiswa->kelas->nama_kelas }}</td>
            <td>{{ $Mahasiswa->jurusan }}</td>
            <td>{{ $Mahasiswa->nomor_handphone }}</td>
            <td>
            <form action="{{ route('mahasiswas.destroy',$Mahasiswa->nim) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('mahasiswas.show',$Mahasiswa->nim) }}">Show</a>

                    <a class="btn btn-primary" href="{{ route('mahasiswas.edit',$Mahasiswa->nim) }}">Edit</a>

                   
                    @method('DELETE')
                    @csrf

                    <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            </td>
        </tr>
        @endforeach
    </table>
    <br>
    {{-- Halaman : {{$mahasiswas->currentPage()}} <br/>
    Jumlah Data : {{$mahasiswas->total()}} <br/>
    Data Per Halaman : {{$mahasiswas->perPage()}} <br/> --}}

    {{$mahasiswas->links()}}

@endsection
