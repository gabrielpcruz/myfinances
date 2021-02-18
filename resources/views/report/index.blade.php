@extends('layout.layout')

@section('title', 'My finances | Report')

@section('content')
    <form method="POST" action="{{ url('/report/show') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="selectAccount">Select an account</label>
            </div>
            <select class="custom-select" required id="selectAccount" name="selectAccount">
                @foreach($accounts as $account)
                    <option
                        {{ is_account_selected($account, ($accountSelected ?? false)) }}
                        value="{{ $account->id }}"
                    >
                        {{ $account->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <button id="statement" class="btn btn-block btn-primary">Get report</button>
        </div>
    </form>

    @if(isset($transactions))
        <table id="statementTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-left">Date</th>
                    <th class="text-left">Description</th>
                    <th class="text-right">Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)

                    <tr>
                        <td class="text-left">
                            {{ (new DateTime($transaction->date))->format('d/m/Y H:i:s') }}
                        </td>
                        <td class="text-left">
                            {{ $transaction->description ?? "-" }}
                        </td>
                        <td class="text-right {{ $transaction->type == 1 ? "text-success" : "text-danger" }}">
                            {{ number_format(round_value($transaction->value), 2, ',', '.')}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

