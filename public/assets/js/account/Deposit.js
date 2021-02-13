var Deposit = (function () {

    let deposit = function () {
        $(document).on("click", "#deposit", function (event) {
            event.preventDefault();

            try {
                if (isAnyFieldEmpty()) {
                    throw new Error(Message.MSG001);
                }

                let deposit = $("#depositForm #depositValue").val().replace("R$", '');
                deposit = deposit.replace('.', '');
                deposit = deposit.replace(',', '.').trim();

                let targetAccountId = $("#depositForm #selectAccounts").val();
            
                let account = AccountStorage.get(targetAccountId);

                let balance = parseFloat(account.balance);
                deposit = parseFloat(deposit);

                if (deposit < 0.01 || isNaN(deposit)) {
                    throw new Error(Message.MSG005);
                }

                let result = balance + deposit;

                account.balance = result.toFixed(2);

                let transaction = Script.getNewTransaction(account.id);
                transaction.value = deposit.toFixed(2);
                transaction.description = $("#depositForm #description").val();

                AccountStorage.update(account);
                StatementStorage.add(transaction)

                Script.goHome();
            } catch (error) {
                toastr.error(error.message);
            }
        });
    };

    let isAnyFieldEmpty = function () {
        if ($("#depositForm #description").val() == '') {
            return true;
        }

        return false;
    };

    return {
        init: function () {
            deposit();
        }
    }

})();
