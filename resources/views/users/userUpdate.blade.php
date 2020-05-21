@extends('layouts.index') @section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">USER UPDATE</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item active">User</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ Route('user.store.update') }}">
                    @csrf
                    <input type="hidden" name="id" class="form-control" value="{{$userDetail->id}}">
                    <div class="form-body">
                        <h3 class="card-title" style="font-weight: bold">Personal Info</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Nama</label>
                                    <input type="text" name="name" class="form-control" value="{{$userDetail->name}}">
                                    {{-- <small class="form-control-feedback"> This is inline help </small> --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input type="text" name="email" class="form-control" value="{{$userDetail->email}}">
                                    {{-- <small class="form-control-feedback"> This field has error. </small>  --}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Type <small class="form-control-feedback"> user ini
                                            sekarang <strong>{{$userDetail->type}}</strong></small></label>
                                    @if($userDetail->type=='admin_default')
                                    <br /> <small class="form-control-feedback">Kamu tidak dapat mengganti tipe
                                        <strong>admin_default</strong> </small>
                                    @else
                                    <select class="form-control" name="type_user" custom-select">
                                        @foreach ($roles as $role)
                                        <option value="{{$role->name}}"
                                            {{$userDetail->type == $role->name ? 'selected' :''}}>{{$role->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Tanggal Lahir</label>
                                    <input type="text" class="form-control" placeholder="2017-06-04" name="dob"
                                        value="{{$userDetail->dob}}" id="mdatepicker" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Alamat</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{$userDetail->address}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Kota</label>
                                    <input type="text" name="city" class="form-control" value="{{$userDetail->city}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Bio singkat</label>
                                    <textarea name="short_info"
                                        class="form-control"> {{$userDetail->short_info}}   </textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Password </label>
                                    <input type="text" name="password" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                        <h3 class="card-title" style="font-weight: bold">Data Siswa</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">NIS</label>
                                    <input type="number" name="nis" class="form-control" value="{{$userDetail->nis}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Nama Orang Tua</label>
                                    <input type="text" name="parent_name" class="form-control"
                                        value="{{$userDetail->parent_name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Kelas </label>
                                    <select class="form-control" name="class_id" custom-select">
                                        @foreach ($classes as $class)
                                        <option value="{{$class->id}}"
                                            {{$userDetail->class_id == $class->id ? 'selected' :''}}>
                                            {{$class->grade}} - {{$class->majors}} {{$class->number}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <h3 class="card-title" style="font-weight: bold">Data Guru</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">NIP</label>
                                    <input type="number" name="nip" class="form-control" value="{{$userDetail->nip}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{url('/user/admin')}}" class="btn btn-inverse">Cancel</a>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
