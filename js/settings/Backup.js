var Backup = (function () {

    let pasteJsonData = function ($object) {
        $(document).ready(function () {
            let jsonDataBackupAccounts = AccountStorage.getJsonBackup();
            let jsonDataBackupTransactions = StatementStorage.getJsonBackup();

            $("#jsonDataBackupAccounts").text(jsonDataBackupAccounts);
            $("#jsonDataBackupTransactions").text(jsonDataBackupTransactions);
        });
    };

    let restore = function () {
        $(document).ready(function () {

            $(document).on("click", "#restore", function (event) {
                event.preventDefault();

                let jsonAccountIsValid = true;
                let jsonTransactionsIsValid = true;

                let jsonDataBackupAccounts = $("#jsonDataBackupAccountsRestore").val();
                let jsonDataBackupTransactions = $("#jsonDataBackupTransactionsRestore").val();

                try {
                    jsonAccountIsValid = $.parseJSON(jsonDataBackupAccounts);
                    jsonTransactionsIsValid = $.parseJSON(jsonDataBackupTransactions);

                } catch (err) {
                    jsonAccountIsValid = false;
                    jsonTransactionsIsValid = false;
                }

                if (!jsonTransactionsIsValid || !jsonAccountIsValid) {
                    toastr.error(Message.MSG007);
                    return;
                }

                if (
                    !Array.isArray(jsonAccountIsValid) ||
                    !Array.isArray(jsonTransactionsIsValid)
                ) {
                    toastr.error(Message.MSG007);
                    return;
                }

                AccountStorage.restore($.parseJSON(jsonDataBackupAccounts));
                StatementStorage.restore($.parseJSON(jsonDataBackupTransactions));
                
                Script.goHome();
            });
        });
    };

    return {
        init: function () {
            pasteJsonData();
            restore();
        }
    }
})();
