@extends('layout.layout')

@section('title', 'My finances | Report')

@section('custom-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <style>
        /*
        *
        * ==========================================
        * CUSTOM UTIL CLASSES
        * ==========================================
        *
        */
        .datepicker td, .datepicker th {
            width: 2.5rem;
            height: 2.5rem;
            font-size: 0.85rem;
        }

        .datepicker {
            margin-bottom: 3rem;
        }

        /*
        *
        * ==========================================
        * FOR DEMO PURPOSES
        * ==========================================
        *
        */
        body {
            min-height: 100vh;
            background-color: #fafafa;
        }

        input.form-control:focus {
            box-shadow: none;
        }

        input.form-control::placeholder {
            font-style: italic;
        }

        .input-group-text {
            border-radius: 0 30rem 30rem 0;
            border: none;
        }

        .datepicker-dropdown {
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

    </style>
@endsection

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

        <div class="form-row">
            <div class="form-group col-6">
                <label class="mr-2">Período</label>
                <div class="form-inline">
                    <div class="input-group mr-4">
                        <input type="text" value="{{ $initialDate }}" class="form-control datepicker" name="initialDate">
                        <span class="input-group-addon">
                            <button class="btn default date-set" type="button">
                                <i class="fas fa-calendar-day"></i>
                            </button>
                        </span>
                    </div>
                    <div class="input-group">
                        <input type="text" value="{{ $finalDate }}" class="form-control datepicker" name="finalDate">
                        <span class="input-group-addon">
                            <button class="btn default date-set" type="button">
                                <i class="fas fa-calendar-day"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group col-6">
                <label for="transactionType" class="mr-2">Transaction type</label>
                <select class="form-control" name="transactionType" id="transactionType">
                    <option {{is_transaction_type_selected($transactionType, "")}} value="">All</option>
                    <option {{is_transaction_type_selected($transactionType, \App\Enum\TransactionType::INPUT)}} value="{{\App\Enum\TransactionType::INPUT}}">Input</option>
                    <option {{is_transaction_type_selected($transactionType, \App\Enum\TransactionType::OUTPUT)}} value="{{\App\Enum\TransactionType::OUTPUT}}">Output</option>
                </select>
            </div>
        </div>

        <hr>

        <div class="form-group mt-4">
            <button id="statement" class="btn btn-block btn-primary">Get report</button>
        </div>
    </form>

    @if(isset($transactions))
        <hr>
        <table class="table table-hover table-bordered">
            <tr>
                <th class="text-center text-light bg-dark">Inputs</th>
                <th class="text-center text-light bg-dark">Outputs</th>
                <th class="text-center text-light bg-dark">Total</th>
            </tr>
            <tr>
                <th class="text-center text-success">{{ number_format(round_value($totalInputs), 2, ',', '.') }}</th>
                <th class="text-center text-danger">{{ number_format(round_value($totalOutputs), 2, ',', '.') }}</th>
                <th class="text-center">{{ number_format(round_value(($totalInputs - $totalOutputs)), 2, ',', '.') }}</th>
            </tr>
        </table>
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
                        <td class="text-left text-nowrap">
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

@section('custom-scripts')
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous"></script>

    <script type="text/javascript">
        $('.datepicker').datepicker({
            clearBtn: true
        });
    </script>

@endsection
