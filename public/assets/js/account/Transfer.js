var Transfer = (function () {

    let transfer = function () {
        $(document).on("click", "#transfer", function (event) {
            event.preventDefault();

            try {
                if (isAnyFieldEmpty()) {
                    throw new Error(Message.MSG001);
                }

                let originAccountId = $("#originAccount").val();
                let targetAccountId = $("#targetAccount").val();

                if (originAccountId == targetAccountId) {
                    throw new Error(Message.MSG004);
                }

                let originAccount = AccountStorage.get(originAccountId);
                let targetAccount = AccountStorage.get(targetAccountId);

                let transferValue = $("#transferValue").val();
                transferValue = transferValue.replace('.', '');
                transferValue = transferValue.replace(',', '.').trim();
                transferValue = parseFloat(transferValue.replace(',', '.').trim());

                if (transferValue < 0.01 || isNaN(transferValue)) {
                    throw new Error(Message.MSG005);
                }

                if (transferValue > parseFloat(originAccount.balance)) {
                    throw new Error(Message.MSG003);
                }

                let descriptionTransferPrefix = "<strong>Transferência entre contas</strong>: ";
                let descriptionTransferSufix = " (Transferência entre as contas <strong>" + originAccount.accountName + "</strong> e <strong>" + targetAccount.accountName + ")</strong>";
                let description = $("#description").val();

                let descriptionComplete = descriptionTransferPrefix + description + descriptionTransferSufix ;

                //Origin Account
                let originResult = parseFloat(originAccount.balance);
                originResult -= transferValue;
                originAccount.balance = originResult.toFixed(2);

                let transactionOrigin = Script.getNewTransaction(originAccount.id);
                transactionOrigin.value = "-" + transferValue.toFixed(2);
                transactionOrigin.description = descriptionComplete;

                StatementStorage.add(transactionOrigin);


                //Target Account
                let targetResult = parseFloat(targetAccount.balance);
                targetResult += transferValue;
                targetAccount.balance = targetResult.toFixed(2);
                
                let transactionTarget = Script.getNewTransaction(targetAccount.id);
                transactionTarget.value = transferValue.toFixed(2);
                transactionTarget.description = descriptionComplete;

                StatementStorage.add(transactionTarget);

                AccountStorage.update(originAccount);
                AccountStorage.update(targetAccount);

                Script.goHome();
            } catch (error) {
                toastr.error(error.message);
            }
        });
    };

    let isAnyFieldEmpty = function () {
        if ($("#transferForm #description").val() == '') {
            return true;
        }

        return false;
    };

    return {
        init: function () {
            transfer();
        }
    }

})();
