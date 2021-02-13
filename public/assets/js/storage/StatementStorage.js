var StatementStorage = (function () {

    let store = function ($object) {

        let statements = window.localStorage.getItem('statements') || false;

        if (!statements) {
            let statement = {
                id : $object.accountId,
                transactions : [$object]
            }

            statements = [statement];

            window.localStorage.setItem('statements', JSON.stringify(statements));
        } else {
            statements = JSON.parse(statements);

            let statement = {
                id : $object.accountId,
                transactions : [$object]
            }

            statements.push(statement);

            window.localStorage.setItem('statements', JSON.stringify(statements));
        }
    };

    let add = function ($object) {
        let statements = window.localStorage.getItem('statements') || false;

        if (statements) {
            statements = JSON.parse(statements);

            let indexStatement = false;
            let idToBeIcrease = $object.accountId;

            statements.forEach(function (current, index) {
                if (current.id == idToBeIcrease) {
                    indexStatement = index;
                }
            })

            statements[indexStatement].transactions.push($object);

            window.localStorage.setItem('statements', JSON.stringify(statements));
        }
    }

    let get = function ($objectId) {

        let statements = getAll();

        let indexStatement = false;
        let idToBeUpdate = $objectId;

        statements.forEach(function (current, index) {
            if (current.id == idToBeUpdate) {
                indexStatement = index;
            }
        })

        return statements[indexStatement];
    };

    let getAll = function () {
        let statements = window.localStorage.getItem('statements') || false;

        if (!statements) {
            throw new Error(Message.MSG002);
        }

        return JSON.parse(statements);
    };

    let getJsonBackup = function () {
        let statements = window.localStorage.getItem('statements') || false;

        if (!statements) {
            throw new Error("Dont have data");
        }

        return statements;
    };

    let restore = function ($backup) {
        window.localStorage.setItem('statements', JSON.stringify($backup))
    };


    return {
        store: function ($object) {
            store($object);
        },
        add: function ($object) {
            add($object);
        },
        get: function ($objectId) {
            return get($objectId);
        },
        getAll: function () {
            return getAll();
        },
        getJsonBackup: function () {
            return getJsonBackup();
        },
        restore: function ($backup) {
            return restore($backup);
        }
    }
})();
