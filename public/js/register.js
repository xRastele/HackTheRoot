const form = document.querySelector("form")
const emailInput = form.querySelector('input[name="email"]');
const confirmPasswordInput = form.querySelector('input[name="confirmPassword"]');

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function arePasswordsSame(password, confirmPassword) {
    return password === confirmPassword;
}

function markInvalid(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid')
}

emailInput.addEventListener('keyup', function() {
    setTimeout(function() {
            markInvalid(emailInput, isEmail(emailInput.value));
        },
        1000
    );
});

confirmPasswordInput.addEventListener('keyup', function() {
    setTimeout(function() {
        const condition = arePasswordsSame(
            confirmPasswordInput.previousElementSibling.value,
            confirmPasswordInput.value
        );
            markInvalid(confirmPasswordInput, condition);
        },
        1000
    );
});