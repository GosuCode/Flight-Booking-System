document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".register-form");
  const usernameInput = document.getElementById("username");
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("password");
  const confirmPasswordInput = document.getElementById("confirm_password");

  const usernameError = document.getElementById("username-error");
  const emailError = document.getElementById("email-error");
  const passwordError = document.getElementById("password-error");
  const confirmPasswordError = document.getElementById(
    "confirm-password-error"
  );

  const ruleLength = document.getElementById("rule-length");
  const ruleUppercase = document.getElementById("rule-uppercase");
  const ruleSpecial = document.getElementById("rule-special");

  // Function to show error message
  function showError(element, message) {
    element.textContent = message;
    element.style.color = "red";
  }

  // Function to clear error message
  function clearError(element) {
    element.textContent = "";
  }

  // Validate password strength
  function validatePassword() {
    const password = passwordInput.value;
    const minLength = password.length >= 8;
    const hasUpperCase = /[A-Z]/.test(password);
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    ruleLength.style.color = minLength ? "green" : "black";
    ruleUppercase.style.color = hasUpperCase ? "green" : "black";
    ruleSpecial.style.color = hasSpecialChar ? "green" : "black";
  }

  passwordInput.addEventListener("input", validatePassword);

  form.addEventListener("submit", function (event) {
    let valid = true;
    clearError(usernameError);
    clearError(emailError);
    clearError(passwordError);
    clearError(confirmPasswordError);

    const username = usernameInput.value.trim();
    const email = emailInput.value.trim();
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;

    // Username validation
    if (!/^[a-zA-Z]{3,}$/.test(username)) {
      showError(usernameError, "Username must be at least 3 letters.");
      valid = false;
    }

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      showError(emailError, "Please enter a valid email address.");
      valid = false;
    }

    // Password validation
    if (password.length < 8) {
      showError(passwordError, "Password must be at least 8 characters long.");
      valid = false;
    }

    if (!/[A-Z]/.test(password)) {
      showError(
        passwordError,
        "Password must contain at least one uppercase letter."
      );
      valid = false;
    }

    if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
      showError(
        passwordError,
        "Password must contain at least one special character."
      );
      valid = false;
    }

    // Confirm Password validation
    if (password !== confirmPassword) {
      showError(confirmPasswordError, "Passwords do not match.");
      valid = false;
    }

    if (!valid) {
      event.preventDefault();
    }
  });
});
