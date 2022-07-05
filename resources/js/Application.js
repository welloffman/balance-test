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