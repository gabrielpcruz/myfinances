@extends('layout.layout')

@section('title', 'My finances | Home')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover">
                <thead>
                    <th class="text-left">Account name</th>
                    <th class="text-right">Objective</th>
                    <th class="text-right">Balance</th>
                    <th class="text-right">%</th>
                    <th class="text-right">
                        <a href="{{ url('/account/create') }}" class="btn btn-sm btn-primary text-light">
                            New account
                        </a>
                    </th>
                </thead>
                <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td class="text-left">
                                {{ $account->name }}
                            </td>
                            <td class="text-right">
                                {{ number_format($account->target, 2, ',', '.') }}
                            </td>
                            <td class="text-right">
                                {{ number_format($account->balance, 2, ',', '.') }}
                            </td>
                            <td class="text-right">
                                {{ number_format(roundValue($account), 2, ',', '.') }}%
                            </td>
                            <td class="text-right">
                                <a href="{{ url("/account/edit/{$account->id}") }}"
                                   class="btn btn-info"
                                >
                                    Update
                                </a>
                                <a href="{{ url("/account/remove/{$account->id}") }}"
                                   class="btn btn-danger"
                                >
                                    Remove
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td>
                        <strong>Total</strong>
                    </td>
                    <td class="text-right" colspan="2">
                        <strong id="total"></strong>
                    </td>
                    <td colspan="2">&nbsp;</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
