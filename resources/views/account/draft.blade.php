@extends('layout.layout')

@section('title', 'My finances | Draft')

@section('content')
    <div class="col-md-12">
        <form method="POST" action="{{ url('/draft/store') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="selectAccount">Select an account</label>
                </div>

                <select class="custom-select" id="selectAccount" name="selectAccount">
                    @foreach($accounts as $account)
                        <option value="{{$account->id}}">{{$account->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="value">Draft value</label>
                <input type="text" class="form-control" id="value" name="value">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="This transation is..."
                          rows="3"></textarea>
            </div>

            <div class="form-group">
                <button id="draft" class="btn btn-block btn-primary">Draft</button>
            </div>
        </form>
    </div>
@endsection

@section('custom-scripts')
    <script>
        $(document).ready(function() {
            $("#value").mask('#.##0,00', { reverse: true });
        });
    </script>
@endsection
