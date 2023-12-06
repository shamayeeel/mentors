// Constant variables
const registrationForm = document.getElementById('registrationForm');
const loginForm = document.getElementById('loginForm');
const userPassForm = document.getElementById('userPassForm');
const loginBtn = document.getElementById('loginBtn');

// Hide user registration
registrationForm.style.display = "none";
userPassForm.style.display = "none";

// Show registration form
function showRegistrationForm() {
    loginForm.style.display = "none";
    userPassForm.style.display = "none";
    registrationForm.style.display = "";
}

// Show login form
function showLoginForm() {
    location.reload();
}

// Validate login form
function validateUserLogin() {
    const username = document.getElementById('username');
    const password = document.getElementById('password');

    if (username.value === "") {
        document.getElementById('userAlert').textContent = "Enter your username!"
        username.style.border = "2px solid red";
    } else {
        username.style.border = "";
        document.getElementById('userAlert').textContent = "";
    }
    
    if (password.value === "") {
        document.getElementById('passAlert').textContent = "Enter your password!"
        password.style.border = "2px solid red";
    } else {
        password.style.border = "";
        document.getElementById('passAlert').textContent = "";
    }

    if (username.value === "admin" && password.value === "admin") {
        alert("Login Successfully!");
    } else {
        document.getElementById('loginAlert').textContent = "Invalid username or password. Please try again.";
        username.style.border = "2px solid red";
        password.style.border = "2px solid red";
    }
}



// Validate registration form 
function validateUserRegistration() {
    const fullName = document.getElementById('fullName');
    const phoneNumber = document.getElementById('phoneNumber');
    const email = document.getElementById('email');
    const address = document.getElementById('address');

    const fullNameAlert = document.getElementById('fullNameAlert');
    const phoneNumberAlert = document.getElementById('phoneNumberAlert');
    const emailAlert = document.getElementById('emailAlert');
    const addressAlert = document.getElementById('addressAlert');

    const regex = /^[A-Za-z\s]+$/;
    if (fullName.value === "") {
        fullName.style.border = "2px solid red";
        fullNameAlert.textContent = "Enter your full name!";
    } else if (!regex.test(fullName.value)) {
        fullNameAlert.textContent = "Enter valid name!";
        fullName.style.border = '2px solid red';
    } else {
        fullName.style.border = "";
        fullNameAlert.textContent = "";
    }

    const cleanedInput = phoneNumber.value.replace(/\D/g, '');
    if (phoneNumber.value === "") {
        phoneNumber.style.border = "2px solid red";
        phoneNumberAlert.textContent = "Enter your contact number!";
    } else if (cleanedInput.length !== 11) {
        phoneNumberAlert.textContent = "Please enter a valid 11-digit phone number.";
        phoneNumber.style.border = '2px solid red';
    } else {
        phoneNumber.style.border = "";
        phoneNumberAlert.textContent = "";
    }


    function isValidEmail(value) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(value);
    }

    const evalue = email.value;
    if (evalue === "") {
        email.style.border = '2px solid red';
        emailAlert.textContent = 'Enter your email!';
    } else if (!isValidEmail(evalue)) {
        emailAlert.textContent = 'Please enter a valid email address.';
        email.style.border = '2px solid red';
    } else {
        email.style.border = '';
        emailAlert.textContent = '';
    }

    if (address.value === "") {
        address.style.border = "2px solid red";
        addressAlert.textContent = "Enter your address!";
    } else {
        address.style.border = "";
        addressAlert.textContent = "";
    }

    if (fullNameAlert.textContent === "" && phoneNumberAlert.textContent === "" && emailAlert.textContent === "" && addressAlert.textContent === "") {
        registrationForm.style.display = "none";
        userPassForm.style.display = "";    
    }

}

// Validate creating account
function validateCreateAccount() {
    const createUsername = document.getElementById('createUsername');
    const createPassword = document.getElementById('createPassword');
    const confirmPassword = document.getElementById('confirmPassword');

    const createUsernameAlert = document.getElementById('createUsernameAlert');
    const createPasswordAlert = document.getElementById('createPasswordAlert');
    const confirmPasswordAlert = document.getElementById('confirmPasswordAlert');

    if (createUsername.value === "") {
        createUsernameAlert.textContent = "Enter your desired username!";
        createUsername.style.border = "2px solid red";
    }

    const passwordValue = createPassword.value;
    const hasUppercase = /[A-Z]/.test(passwordValue);
    const hasLowercase = /[a-z]/.test(passwordValue);
    const hasNumber = /[0-9]/.test(passwordValue);
    const hasSymbol = /[~`!@#$%^&*()_\-+={[}\]|:;"'<,>.?/]/.test(passwordValue);

    if (
        passwordValue.length >= 8 &&
        (hasUppercase + hasLowercase + hasNumber + hasSymbol) >= 3 
    ) {
        createPasswordAlert.textContent = '';
        createPassword.style.border = '';
    } else if (passwordValue === "") {
        createPasswordAlert.textContent = "Enter your desired password!";
        createPassword.style.border = "2px solid red";
    } else {
        createPasswordAlert.textContent = "Password must contain at least three of the following: uppercase letters, lowercase letters, numbers, symbols.";
        createPassword.style.border = "2px solid red";
    }

    if (confirmPassword.value !== createPassword.value) {
        confirmPasswordAlert.textContent = "Passwords don't match!";
        confirmPassword.style.border = "2px solid red";
    } else {
        confirmPasswordAlert.textContent = "";
        confirmPassword.style.border = "";
    }

    if (createUsernameAlert.textContent === "" && confirmPasswordAlert.textContent === "" && createPasswordAlert.textContent === "") {
        alert('Account Registered Successfully!');
        location.reload();
    }
}
