@extends('layout.layout')

@section('title', 'My finances | New account')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ url('/account/store') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="form-group">
                    <label for="accountName">Account name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Car dream">
                </div>
                <div class="form-group">
                    <label for="initialBalance">Initial balance</label>
                    <input type="text" class="form-control" id="balance" name="balance">
                </div>
                <div class="form-group">
                    <label for="targetValue">Target value</label>
                    <input type="text" step="any" class="form-control" id="target" name="target">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>

                    <textarea class="form-control"
                              id="description"
                              name="description"
                              placeholder="This account will help me to..."
                              rows="3">
                    </textarea>
                </div>

                <div class="form-group">
                    <button id="save" class="btn btn-block btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('custom-scripts')
    <script>
        $(document).ready(function() {
            $("#balance").mask('#.##0,00', { reverse: true });
            $("#target").mask('#.##0,00', { reverse: true });
        });
    </script>
@endsection
