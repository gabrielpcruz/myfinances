@extends('layout.layout')

@section('title', 'My finances | Edit account')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ url('/account/update') }}">
                @csrf

                <input type="hidden" name="id" value="{{ $account->id }}" />

                <div class="form-group">
                    <label for="accountName">Account name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $account->name }}" placeholder="Car dream">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>

                    <textarea class="form-control"
                              id="description"
                              name="description"
                              placeholder="This account will help me to..."
                              rows="3"
                    >{{ $account->description }}</textarea>
                </div>

                <div class="form-group">
                    <button id="update" class="btn btn-block btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
