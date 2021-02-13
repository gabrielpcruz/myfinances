var AccountStatement = (function () {

    let reportStatementAccount = function () {
        $(document).on("click", "#statement", function (event) {
            event.preventDefault();

            try {
                if (isAnyFieldEmpty()) {
                    throw new Error(Message.MSG001);
                }

                let accountStatementId = $("#statementForm #accountStatement").val();
               
                let statements = StatementStorage.get(accountStatementId);

                $("#statementTable").show();
                $("#statementTable tbody").html("");

                statements.transactions.forEach(element => {
                    makeLine(element);
                });

                $("table tbody .money").mask("000.000,00");
                $("table tbody .money").mask("000.000,00", { reverse: true});
            } catch (error) {
                toastr.error(error.message);
            }
        });
    };

    let makeLine = function (transaction) {
        let row = $('<tr>');

        let date = $('<td>');
        date.addClass('text-center');
        let dateTmp = new Date(transaction.date);
        date.text(dateTmp.toLocaleDateString("pt-BR"));


        let description = $('<td>');
        description.addClass('text-left');
        description.html(transaction.description);

        let value = $('<td>');
        value.addClass('text-right money');
        value.text(transaction.value);
        
        let balance = parseFloat(transaction.value).toFixed(2);
        
        if (balance < 0) {
            value.addClass('text-danger');
        } else if (balance > 0) {
            value.addClass('text-success');
        }

        row.append(date);
        row.append(description);
        row.append(value);

        $("#statementTable tbody").append(row)
    };

    let isAnyFieldEmpty = function () {
        return false;

    };

    return {
        init: function () {
            reportStatementAccount();
        }
    }
})();

$(document).ready(function () {
    AccountStatement.init();
});
