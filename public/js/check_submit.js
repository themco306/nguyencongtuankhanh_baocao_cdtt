document.addEventListener('DOMContentLoaded', function() {
    let form = document.querySelector('#check_submit');
    let submitButton = form.querySelector('button[type="submit"]');
    let initialData = new FormData(form);
    
    form.addEventListener('input', () => {
        let currentData = new FormData(form);
        let changed = false;
        for (let [key, value] of initialData.entries()) {
            if (currentData.get(key) !== value) {
                changed = true;
                break;
            }
        }
        submitButton.disabled = !changed;
    });
});