@extends('layouts.admin')
@section('title', 'Edit Satuan')

@section('content')
<div class="row">
    <div class="col-6">
        <div class="card card-outline card-blue">
            <div class="card-header">
                <h3 class="card-title" id="card-title">Perubahan Satuan</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.satuan') }}" class="btn btn-default"><i class="fas fa-reply"></i> Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.satuan.update', $satuan->id) }}">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Nama Satuan<strong class="text-danger">*</strong></label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama Satuan" value="{{ old('nama') ? old('nama') : $satuan->nama }}" required>
                            </div>
                            <div class="text-right pt-3">
                                <button type="reset" class="btn btn-danger">Reset</button>&nbsp;
                                <button type="submit" class="btn btn-primary" id="btn-store">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@endpush
