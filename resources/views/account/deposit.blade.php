@extends('layout.layout')

@section('title', 'My finances | Deposit')

@section('deposit-active', 'active')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ url('/deposit/store') }}">
                @csrf

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="selectAccount">Select an account</label>
                    </div>

                    <select class="custom-select" required id="selectAccount" name="selectAccount">
                        @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="value">Deposit value</label>
                    <input type="text" class="form-control" required id="value" name="value">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description"
                              placeholder="This transation is..."
                              rows="3"></textarea>
                </div>

                <div class="form-group">
                    <button id="deposit" class="btn btn-block btn-primary">Deposit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom-scripts')
    <script>
        $(document).ready(function () {
            $("#value").mask('#.##0,00', {reverse: true});
        });
    </script>
@endsection
