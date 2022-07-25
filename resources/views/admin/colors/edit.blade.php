@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if (session('msg'))
            <div class="alert alert-success">{{ session('msg') }}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3>Edit Color
                    <a href="{{ url('admin/colors/create') }}" class="btn btn-primary text-white btn-sm float-end">Back</a>
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ url('admin/colors/'.$color->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="">Color Name</label>
                        <input type="text" name="name" id="" class="form-control" value="{{ $color->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="">Color Code</label>
                        <input type="text" name="code" id="" value="{{ $color->code }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="">Status</label> <br>
                        <input type="checkbox" name="status" style="width:20px;height:20px;" {{ $color->status ? 'checked' : '' }}> Checked = Hidden,Unchecked = Visible
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

