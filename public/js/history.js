class Application {
    request(url, data, successCallback, errorCallback, type = 'POST') {
        data._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const xhr = new XMLHttpRequest();
        xhr.open(type, url);
        xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhr.send( JSON.stringify(data) );

        xhr.onload = () => {
            if (xhr.status != 200) {
                if(errorCallback) {
                    errorCallback({status: xhr.status, status_text: xhr.statusText, message: `Не удалось выполнить запрос: ${xhr.statusText}`});
                }
            } else {
                successCallback( JSON.parse(xhr.response) );
            }
        };

        xhr.onerror = () => {
            errorCallback({message: 'Не удалось выполнить запрос'});
        };
    }

    refreshOperations(operations, selector) {
        const el = document.querySelector(selector);
        while(el.firstChild) {
            el.removeChild(el.firstChild);
        }

        operations.forEach(item => {
            if(item.is_hidden) {
                return false;
            }

            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${item.amount}</td><td>${item.type}</td><td>${item.description}</td><td>${item.created_at}</td>`;
            el.appendChild(tr);
        });
    }
}
const app = new Application();
let operations = makeOperations();
let is_desc = true;

document.querySelector('.js-sort').addEventListener('click', (e) => {
    toggleSort();
}, false);


document.querySelector('.js-filter').addEventListener('keypress', (e) => {
    if(e.key == 'Enter') {
        filter(e.target.value);
    }
}, false);


function makeOperations() {
    const items = [];
    const rows = document.querySelectorAll('.js-operations tr');

    rows.forEach(row => {
        const item = {};
        const cells = row.querySelectorAll('td');
        items.push({
            amount: cells[0].innerHTML,
            type: cells[1].innerHTML,
            description: cells[2].innerHTML,
            created_at: cells[3].innerHTML
        });
    });
 
    return items;
}

function toggleSort() {
    is_desc = !is_desc;

    operations = operations.sort((a, b) => {
        if(is_desc) {
            return Date(a.created_at) > Date(b.created_at) ? 1 : -1;
        } else {
            return Date(a.created_at) < Date(b.created_at) ? 1 : -1;
        }
    });

    app.refreshOperations(operations, '.js-operations');
}

function filter(str) {
    if(!str) {
        operations.forEach(item => {
            item.is_hidden = false;
        });
    } else {
        str = str.toLowerCase();
        operations.forEach(item => {
            if(item.description.toLowerCase().indexOf(str) == -1) {
                item.is_hidden = true;
            } else {
                item.is_hidden = false;
            }
        });
    }

    app.refreshOperations(operations, '.js-operations');
}