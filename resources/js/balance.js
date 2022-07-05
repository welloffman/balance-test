const refresh_interval = 5000;
const app = new Application();

setInterval(() => {
    app.request('/refresh-balance', {}, res => {
        if(res.success) {
            refresh(res.balance_amount, res.operations);
        }
    });
}, refresh_interval);

function refresh(balance_amount, operations) {
	document.querySelector('.js-balance').innerHTML = balance_amount;
	app.refreshOperations(operations, '.js-operations');
}