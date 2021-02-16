@extends('layout.layout')

@section('title', 'My finances | Transfer')

@section('content')
    <div class="col-md-12">
        <form method="POST" action="{{ url('/transfer/store') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="origin">Select an account (Origin)</label>
                </div>

                <select class="custom-select" id="origin" name="origin">
                    @foreach($accounts as $account)
                        <option value="{{$account->id}}">{{$account->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="target">Select an account (Target)</label>
                </div>

                <select class="custom-select" id="target" name="target">
                    @foreach($accounts as $account)
                        <option value="{{$account->id}}">{{$account->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="value">Value</label>
                <input type="text" class="form-control" id="value" name="value">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="This transation is..."
                          rows="3"></textarea>
            </div>

            <div class="form-group">
                <button id="transfer" class="btn btn-block btn-primary">Transfer</button>
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
