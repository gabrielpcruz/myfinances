@extends('layout.layout')

@section('title', 'My finances | Home')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover">
                <thead>
                    <th>Account name</th>
                    <th class="text-right">Objective</th>
                    <th class="text-right">Balance</th>
                    <th class="text-right">%</th>
                    <th class="text-right">
                        <a href="{{ url('/account') }}" class="btn btn-sm btn-primary text-light">
                            New account
                        </a>
                    </th>
                </thead>
                <tbody>

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
