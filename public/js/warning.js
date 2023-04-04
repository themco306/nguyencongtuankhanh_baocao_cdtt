const dels = document.querySelectorAll('.del');
const warnings = document.querySelectorAll('.warning');

dels.forEach(del => {
    del.addEventListener('mouseover', () => {
        warnings.forEach(warning => {
            warning.style.display = 'inline-block';
        });
    });

    del.addEventListener('mouseout', () => {
        warnings.forEach(warning => {
            warning.style.display = 'none';
        });
    });
});