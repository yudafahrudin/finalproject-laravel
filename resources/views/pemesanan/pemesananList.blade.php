@extends('layouts.index') @section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Pemesanan</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item active">Pemesanan</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if ($success_message)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{$success_message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                @endif
                @if ($alert_error)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>{{$alert_error}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                @endif
                <span>
                    Total Pesanan 
                    <span class="label label-success label-rounded">{{count($pemesanans)}}</span>
                </span>
                {{-- <a href="{{Route('pemesanan.create')}}" class="btn btn-primary waves-effect waves-light m-b-20 float-right">
                    <i class="mdi mdi-plus"></i>
                    Buat
                </a> --}}
                @if(count($pemesanans) > 0)
                <div class="table-responsive m-t-10">
                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th>Nama Pemesan</th>
                                <th>Kios</th>
                                <th>Deskripsi</th>
                                <th>qty</th>
                                <th>harga</th>
                                <th>status</th>
                                {{-- <th></th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemesanans as $pemesanan)
                            <tr>
                                <td>{{ $pemesanan->user->name }}</td>
                                <td>{{ $pemesanan->rpk->nama_kios}}</td>
                                <td>{{ $pemesanan->item->nama }}</td>
                                <td>{{ $pemesanan->qty }}</td>
                                <td>{{"Rp " . number_format($pemesanan->harga,2,',','.') }}</td>
                                <td>{{ $pemesanan->status }}</td>
                                {{-- <td style="text-align: center">
                                    <div class="dropdown" style="float: right">
                                        <button class="btn btn-success waves-effect waves-light m-r-10 dropdown-toggle"
                                            type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            aksi
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="{{Route('item.edit', $pemesanan->id)}}">Update</a>
                                                <form method="POST" action="{{Route('item.destroy', $pemesanan->id)}}">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn"> Delete </button>
                                                </form>
                                                
                                        </div>
                                    </div>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="table-responsive m-t-10">
                    belum ada
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection