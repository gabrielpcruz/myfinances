@extends('layout.layout')

@section('title', 'My finances | Backup')

@section('backup-active', 'active')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form id="newAccountForm">
                <div class="form-group">
                    <label for="accountsJson">Backup Accounts (JSON)</label>
                    <textarea
                        id="accountsJson"
                        readonly
                        class="form-control"
                        rows="5"
                        cols="5"
                    >{{ trim($accounts) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="transactionsJson">Backup Transactions (JSON)</label>
                    <textarea
                        id="transactionsJson"
                        readonly
                        class="form-control"
                        rows="5"
                        cols="5"
                    >{{ $transactions }}</textarea>
                </div>

                <div class="form-group">
                    <label for="accounts">Accounts Restore (JSON)</label>
                    <textarea id="accounts" class="form-control" required rows="5" cols="5"></textarea>
                </div>

                <div class="form-group">
                    <label for="transactions">Transactions Restore (JSON)</label>
                    <textarea id="transactions" class="form-control" required rows="5" cols="5"></textarea>
                </div>

                <div class="form-group">
                    <button id="restore" class="btn btn-block btn-primary">Restore</button>
                </div>
            </form>
        </div>
    </div>
@endsection
