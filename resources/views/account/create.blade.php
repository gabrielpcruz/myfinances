@extends('layout.layout')

@section('title', 'My finances | New account')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ url('/account/store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Account name</label>
                    <input type="text" class="form-control" required id="name" name="name" placeholder="Car dream">
                </div>
                <div class="form-group">
                    <label for="balance">Initial balance</label>
                    <input placeholder="0,00" type="text" class="form-control" required id="balance" name="balance">
                </div>
                <div class="form-group">
                    <label for="target">Target value</label>
                    <input placeholder="0,00" type="text" step="any" class="form-control" required id="target" name="target">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>

                    <textarea class="form-control"
                              id="description"
                              name="description"
                              placeholder="This account will help me to..."
                              rows="3"
                    ></textarea>
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
