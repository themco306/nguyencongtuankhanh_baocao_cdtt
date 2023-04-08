let amountElement = document.getElementById('amount');
let amount = amountElement.value;
let qty = document.getElementById('qty_input').value;
let reander = (amount) => {
    amountElement.value = amount
}
let handlePlus = () => {
    if (amount < qty)
        amount++
    reander(amount);
}
let handleMinus = () => {
    if (amount > 1)
        amount--
    reander(amount);
}
amountElement.addEventListener('input', () => {
    amount = amountElement.value;
    amount = parseInt(amount);
    amount = (isNaN(amount) || (amount == 0)) ? 1 : amount;
    amount = (amount>qty) ? qty : amount;
    reander(amount);
})
