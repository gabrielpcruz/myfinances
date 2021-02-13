var Draft = (function () {

    let draft = function () {
        $(document).on("click", "#draft", function (event) {
            event.preventDefault();

            try {
                if (isAnyFieldEmpty()) {
                    throw new Error(Message.MSG001);
                }

                let draft = $("#draftForm #draftValue").val().replace("R$", '');
                draft = draft.replace('.', '');
                draft = draft.replace(',', '.').trim();

                let targetAccountId = $("#draftForm #selectAccounts").val();
            
                let account = AccountStorage.get(targetAccountId);

                let balance = parseFloat(account.balance);
                draft = parseFloat(draft);

                if (draft < 0.01 || isNaN(draft)) {
                    throw new Error(Message.MSG006);
                }

                if (draft > balance) {
                    throw new Error(Message.MSG003)
                }

                let result = balance - draft;

                account.balance = result.toFixed(2);

                let transaction = Script.getNewTransaction(account.id);
                transaction.value = "-" + draft.toFixed(2);
                transaction.description = $("#draftForm #description").val();

                AccountStorage.update(account);
                StatementStorage.add(transaction);

                Script.goHome();
            } catch (error) {
                toastr.error(error.message);
            }
        });
    };

    let isAnyFieldEmpty = function () {
        if ($("#draftForm #description").val() == '') {
            return true;
        }

        return false;
    };

    return {
        init: function () {
            draft();
        }
    }

})();
