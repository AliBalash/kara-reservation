const allSteps = document.querySelectorAll("form .step");
const thankStep = document.querySelector(".thanks-step");
const nextBtn = document.getElementById("next");
const backBtn = document.getElementById("back");
const checkoutForm = document.getElementById("checkoutForm");

let currentStep = 0;

// Initialize the form
updateStep();

// Event listeners for navigation buttons
nextBtn.addEventListener("click", nextStep);
backBtn.addEventListener("click", backStep);

// Update the displayed step
function updateStep() {
  allSteps.forEach((step) => step.classList.add("d-none"));
  allSteps[currentStep].classList.remove("d-none");

  backBtn.classList.toggle("d-none", currentStep === 0);

  if (currentStep === allSteps.length - 1) {
    nextBtn.innerHTML = "تایید و ارسال نهایی";
    nextBtn.classList.add("done");
  } else {
    nextBtn.innerHTML = "مرحله بعد";
    nextBtn.classList.remove("done");
  }

  scrollToTop();
}

// Navigate to the next step
function nextStep(e) {
  // Add a delay to allow Livewire DOM updates to complete
  setTimeout(() => {
    if (currentStep <= 4 && !formChecker()) {
      return;
    }

    if (nextBtn.classList.contains("done")) {
      checkoutForm.dispatchEvent(new Event("submit", { cancelable: true }));
      checkoutForm.classList.add("d-none");
      thankStep.classList.remove("d-none");
    } else {
      currentStep++;
      updateStep();
    }
  }, 300); // 300ms delay for Livewire DOM updates
}

// Navigate to the previous step
function backStep() {
  currentStep--;
  updateStep();
}

// Form validation for each step
function formChecker() {
  let valid = true;

  if (currentStep === 0) {
    let pickupDate = checkoutForm.pickup_date;
    let returnDate = checkoutForm.return_date;
    let pickupLocation = checkoutForm.pickup_location;
    let returnLocation = checkoutForm.return_location;

    if (!isValidDate(pickupDate)) valid = false;
    if (!isValidDate(returnDate)) valid = false;
    if (valid && !isReturnDateAfterPickupDate(pickupDate, returnDate)) valid = false;
    if (!isValidPickupLocation(pickupLocation)) valid = false;
    if (!isValidReturnLocation(returnLocation)) valid = false;

    return valid;
  }

  if (currentStep === 1) {
    return validateCars();
  }

  if (currentStep === 2) {
    let acceptTerms = document.getElementById("accept_terms");
    let acceptTermsError = document.getElementById("accept_terms_error");

    if (acceptTermsError && !acceptTermsError.textContent) {
      acceptTermsError.textContent = "برای ادامه، باید شرایط را بپذیرید.";
    }

    if (!acceptTerms.checked) {
      acceptTerms.classList.add("is-invalid");
      if (acceptTermsError) acceptTermsError.classList.remove("d-none");
      return false;
    } else {
      acceptTerms.classList.remove("is-invalid");
      if (acceptTermsError) acceptTermsError.classList.add("d-none");
      return true;
    }
  }

  if (currentStep === 3) {
    return true;
  }

  if (currentStep === 4) {
    let firstName = checkoutForm.first_name;
    let lastName = checkoutForm.last_name;
    let email = checkoutForm.email;
    let phone = checkoutForm.phone;
    let messengerPhone = checkoutForm.messenger_phone;

    if (!isValidName(firstName)) valid = false;
    if (!isValidName(lastName)) valid = false;
    if (!isValidEmail(email)) valid = false;
    if (!isValidPhone(phone)) valid = false;
    if (!isValidMessengerPhone(messengerPhone)) valid = false;

    return valid;
  }

  return valid;
}

// Validate name fields
function isValidName(nameField) {
  const re = /\w{3,}/i;
  let feedbackElement = nameField.nextElementSibling;
  if (!feedbackElement) {
    return false; // Gracefully fail if feedback element is missing
  }
  if (!feedbackElement.textContent) {
    feedbackElement.textContent = "نام باید حداقل ۳ حرف باشد.";
  }
  if (!re.test(nameField.value)) {
    nameField.classList.remove("is-valid");
    nameField.classList.add("is-invalid");
    feedbackElement.classList.add("d-block");
    return false;
  }
  nameField.classList.remove("is-invalid");
  nameField.classList.add("is-valid");
  feedbackElement.classList.remove("d-block");
  feedbackElement.textContent = "";
  return true;
}

// Validate email
function isValidEmail(email) {
  const re = /[a-zA-Z0-9]+@[a-zA-Z0-9]+\.\w{1,}/i;
  let feedbackElement = email.nextElementSibling;
  if (!feedbackElement) {
    return false; // Gracefully fail if feedback element is missing
  }
  if (!feedbackElement.textContent) {
    feedbackElement.textContent = "لطفاً یک ایمیل معتبر وارد کنید.";
  }
  if (!re.test(email.value)) {
    email.classList.remove("is-valid");
    email.classList.add("is-invalid");
    feedbackElement.classList.add("d-block");
    return false;
  }
  email.classList.remove("is-invalid");
  email.classList.add("is-valid");
  feedbackElement.classList.remove("d-block");
  feedbackElement.textContent = "";
  return true;
}

// Validate phone number
function isValidPhone(phoneField) {
  const re = /^\d{10,15}$/;
  let feedbackElement = phoneField.nextElementSibling;
  if (!feedbackElement) {
    return false; // Gracefully fail if feedback element is missing
  }
  if (!feedbackElement.textContent) {
    if (phoneField.value.length < 10) {
      feedbackElement.textContent = "شماره باید حداقل ۱۰ رقم باشد.";
    } else if (phoneField.value.length > 15) {
      feedbackElement.textContent = "شماره نباید بیشتر از ۱۵ رقم باشد.";
    } else if (!/^\d+$/.test(phoneField.value)) {
      feedbackElement.textContent = "شماره فقط باید شامل ارقام باشد.";
    } else {
      feedbackElement.textContent = "فرمت شماره معتبر نیست.";
    }
  }
  if (!re.test(phoneField.value)) {
    phoneField.classList.remove("is-valid");
    phoneField.classList.add("is-invalid");
    feedbackElement.classList.add("d-block");
    return false;
  }
  phoneField.classList.remove("is-invalid");
  phoneField.classList.add("is-valid");
  feedbackElement.classList.remove("d-block");
  feedbackElement.textContent = "";
  return true;
}

// Validate messenger phone (optional)
function isValidMessengerPhone(phoneField) {
  const re = /^\d{10,15}$/;
  let feedbackElement = phoneField.nextElementSibling;
  if (!feedbackElement) {
    return false; // Gracefully fail if feedback element is missing
  }
  if (phoneField.value === "") {
    phoneField.classList.remove("is-invalid");
    phoneField.classList.remove("is-valid");
    feedbackElement.textContent = "";
    feedbackElement.classList.remove("d-block");
    return true;
  }
  if (!feedbackElement.textContent) {
    if (phoneField.value.length < 10) {
      feedbackElement.textContent = "شماره باید حداقل ۱۰ رقم باشد.";
    } else if (phoneField.value.length > 15) {
      feedbackElement.textContent = "شماره نباید بیشتر از ۱۵ رقم باشد.";
    } else if (!/^\d+$/.test(phoneField.value)) {
      feedbackElement.textContent = "شماره فقط باید شامل ارقام باشد.";
    } else {
      feedbackElement.textContent = "فرمت شماره معتبر نیست.";
    }
  }
  if (!re.test(phoneField.value)) {
    phoneField.classList.remove("is-valid");
    phoneField.classList.add("is-invalid");
    feedbackElement.classList.add("d-block");
    return false;
  }
  phoneField.classList.remove("is-invalid");
  phoneField.classList.add("is-valid");
  feedbackElement.classList.remove("d-block");
  feedbackElement.textContent = "";
  return true;
}

// Validate car selection
function validateCars() {
  const feedback = document.querySelector(".bad-feedback-car");
  const selectedCar = document.querySelector(".car-card.card-active");

  if (!feedback) {
    return false; // Gracefully fail if feedback element is missing
  }

  if (!selectedCar) {
    if (!feedback.textContent) {
      feedback.textContent = "لطفاً یک خودرو انتخاب کنید.";
    }
    feedback.classList.remove("d-none");
    return false;
  } else {
    feedback.classList.add("d-none");
    return true;
  }
}

// Validate date fields
function isValidDate(dateField) {
  let feedbackElement = dateField.nextElementSibling;
  if (!feedbackElement) {
    return false; // Gracefully fail if feedback element is missing
  }

  if (!dateField.value || isNaN(new Date(dateField.value).getTime())) {
    feedbackElement.textContent = "لطفاً یک تاریخ معتبر وارد کنید.";
    dateField.classList.remove("is-valid");
    dateField.classList.add("is-invalid");
    feedbackElement.classList.add("d-block");
    return false;
  }

  // Ensure the date is not in the past (compare with current time)
  const currentTime = new Date();
  const selectedTime = new Date(dateField.value);
  if (selectedTime < currentTime) {
    feedbackElement.textContent = "تاریخ نمی‌تواند در گذشته باشد.";
    dateField.classList.remove("is-valid");
    dateField.classList.add("is-invalid");
    feedbackElement.classList.add("d-block");
    return false;
  }

  dateField.classList.remove("is-invalid");
  dateField.classList.add("is-valid");
  feedbackElement.classList.remove("d-block");
  feedbackElement.textContent = "";
  return true;
}

// Validate return date is after pickup date
function isReturnDateAfterPickupDate(pickupField, returnField) {
  let pickupDate = new Date(pickupField.value);
  let returnDate = new Date(returnField.value);
  let errorDiv = document.getElementById("date-error");
  let feedbackElement = returnField.nextElementSibling;

  if (!feedbackElement) {
    return false; // Gracefully fail if feedback element is missing
  }

  if (isNaN(pickupDate.getTime()) || isNaN(returnDate.getTime())) {
    feedbackElement.textContent = "لطفاً تاریخ‌های معتبر وارد کنید.";
    returnField.classList.remove("is-valid");
    returnField.classList.add("is-invalid");
    feedbackElement.classList.add("d-block");
    if (errorDiv) errorDiv.classList.remove("d-none");
    return false;
  }

  if (pickupDate.getTime() >= returnDate.getTime()) {
    feedbackElement.textContent = "تاریخ بازگشت باید بعد از تاریخ تحویل باشد.";
    returnField.classList.remove("is-valid");
    returnField.classList.add("is-invalid");
    feedbackElement.classList.add("d-block");
    if (errorDiv) errorDiv.classList.remove("d-none");
    return false;
  }

  returnField.classList.remove("is-invalid");
  returnField.classList.add("is-valid");
  feedbackElement.classList.remove("d-block");
  feedbackElement.textContent = "";
  if (errorDiv) errorDiv.classList.add("d-none");
  return true;
}

// Validate pickup location
function isValidPickupLocation(locationField) {
  let feedbackElement = locationField.nextElementSibling;
  if (!feedbackElement) {
    return false; // Gracefully fail if feedback element is missing
  }

  if (locationField.value === "") {
    feedbackElement.textContent = "لطفاً محل تحویل را انتخاب کنید.";
    locationField.classList.remove("is-valid");
    locationField.classList.add("is-invalid");
    feedbackElement.classList.add("d-block");
    return false;
  }

  locationField.classList.remove("is-invalid");
  locationField.classList.add("is-valid");
  feedbackElement.classList.remove("d-block");
  feedbackElement.textContent = "";
  return true;
}

// Validate return location
function isValidReturnLocation(locationField) {
  let feedbackElement = locationField.nextElementSibling;
  if (!feedbackElement) {
    return false; // Gracefully fail if feedback element is missing
  }

  if (locationField.value === "") {
    feedbackElement.textContent = "لطفاً محل بازگشت را انتخاب کنید.";
    locationField.classList.remove("is-valid");
    locationField.classList.add("is-invalid");
    feedbackElement.classList.add("d-block");
    return false;
  }

  locationField.classList.remove("is-invalid");
  locationField.classList.add("is-valid");
  feedbackElement.classList.remove("d-block");
  feedbackElement.textContent = "";
  return true;
}

// Scroll to the top of the form
function scrollToTop() {
  const wrapper = document.querySelector(".wrapper");
  if (wrapper) {
    wrapper.scrollIntoView({ behavior: "smooth", block: "start" });
  }
}