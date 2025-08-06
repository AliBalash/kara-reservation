// show steps

const allSteps = document.querySelectorAll("form .step");
const thankStep = document.querySelector(".thanks-step");
const nextBtn = document.getElementById("next");
const backBtn = document.getElementById("back");
// const changeCarBtn = document.querySelector("#changeCar");
const addonss = document.querySelectorAll(".addons .addon");
const addonChecks = document.querySelectorAll(".addons .form-check-input");
const carName = document.querySelector(".car-name");
const carPriceSp = document.querySelector(".car-price");
const monthCar = document.querySelector("#month-car");
const yearCar = document.querySelector("#year-car");
const monthlyAddons = document.querySelector("#monthly-addons");
const yearlyAddons = document.querySelector("#yearly-addons");
const checkoutForm = document.getElementById("checkoutForm");
const mcarCards = document.querySelectorAll("#month-car .car");
const ycarCards = document.querySelectorAll("#year-car .car");
const monthlyCarBtns = document.querySelectorAll("#month-car .car-type");
const yearlyCarBtns = document.querySelectorAll("#year-car .car-type");
const pricingTables = document.getElementsByClassName("table");
const themeMode = document.querySelector(".theme-mode");

//vars
let currentStep = 0;



//Run
updateStep();
chooseCar();
// chooseAddons();

//form steps
function updateStep() {
  // مخفی کردن تمام مراحل
  allSteps.forEach((step) => {
    step.classList.add("d-none");
  });

  // نمایش مرحله فعلی
  allSteps[currentStep].classList.remove("d-none");

  // مدیریت دکمه برگشت
  if (currentStep == 0) {
    backBtn.classList.add("d-none");
  } else {
    backBtn.classList.remove("d-none");
  }

  scrollToTop(); // اسکرول به بالا

  // تغییر متن و رفتار دکمه Next در مراحل مختلف
  if (currentStep == allSteps.length - 1) {
    nextBtn.innerHTML = "تایید و ارسال نهایی";
    nextBtn.classList.add("done");
  } else {
    nextBtn.innerHTML = "مرحله بعد";
    nextBtn.classList.remove("done");
  }
}


nextBtn.addEventListener("click", nextStep);
backBtn.addEventListener("click", backStep);

function nextStep(e) {
  if (currentStep == 0 || currentStep == 1 || currentStep == 2 || currentStep == 3 || currentStep == 4) {
    if (!formChecker()) {
      return 0;
    }
  }

  if (nextBtn.classList.contains("done")) {
    // تغییر نوع دکمه به submit
    nextBtn.type = "submit";

    // ارسال فرم و نمایش پیام تشکر
    checkoutForm.submit();
    checkoutForm.classList.add("d-none");
    thankStep.classList.remove("d-none");
  } else {
    currentStep++; // حرکت به مرحله بعد
    updateStep();
  }
}

function backStep() {
  if (currentStep == 3) {
    currentStep--;
    updateStep();
  } else {
    currentStep--;
    updateStep();
  }
}

// remove any addon if car changed
function removeIfChange() {
  if (addonDiv) {
    addonDiv.forEach((addon) => {
      removeAddon(addon.id);
    });
  }
}

//choose car
function chooseCar(btns = monthlyCarBtns, cars = mcarCards) {
  // انتخاب تمام دکمه‌های رادیو و والدین آن‌ها

  // افزودن رویداد به هر دکمه
  btns.forEach((btn, ind) => {
    btn.addEventListener("change", function () {
      // حذف کلاس checked از تمام آیتم‌ها
      cars.forEach((car) => {
        car.classList.remove("checked");
      });

      // افزودن کلاس checked به آیتم انتخاب‌شده
      if (btn.checked) {
        cars[ind].classList.add("checked");
      }
    });
  });

}

//add car to summary
function addCar(btnValue) {
  let [dur, type] = btnValue.split("-");
  let period = dur == "month" ? "Month" : "Year";
  let carPrice = carPrices[type][dur];
  carName.innerHTML = `${type} (${period}ly)`;
  carPriceSp.innerHTML = `+$${carPrice}/${period}`;
  addonCarPrices.set("carType", period);
  addonCarPrices.set("carPrice", carPrice);
}

// Disabling form submissions if there are invalid fields
function formChecker() {

  let valid = true;
  if (currentStep == 0) {

    let returnDate = checkoutForm.return_date;
    let pickupDate = checkoutForm.pickup_date;
    let pickupLocation = checkoutForm.pickup_location;
    let returnLocation = checkoutForm.return_location;

    // Validate Return Date is after Pickup Date
    if (!isReturnDateAfterPickupDate(pickupDate, returnDate)) {
      valid = false;
    }
    // Validate Pickup Date
    if (!isValidDate(pickupDate)) {

      valid = false;
    }
    // Validate Return Date
    if (!isValidDate(returnDate)) {

      valid = false;
    }
    // Validate Pickup Location
    if (!isValidPickupLocation(pickupLocation)) {
      valid = false;
    }
    // Validate Return Location
    if (!isValidReturnLocation(returnLocation)) {
      valid = false;
    }
    return valid;
  }

  if (currentStep == 1) {

    if (!validateCars()) {
      valid = false;
    }
    return valid;
  }

  if (currentStep == 2) {

    let acceptTerms = document.getElementById("accept_terms");
    let acceptTermsError = document.getElementById("accept_terms_error");

    let valid = true;

    if (!acceptTerms.checked) {
      acceptTerms.classList.add("is-invalid");
      acceptTermsError.textContent = "برای ادامه، باید شرایط را بپذیرید.";
      valid = false;
    } else {
      acceptTerms.classList.remove("is-invalid");
      acceptTerms.classList.add("is-valid");
      acceptTermsError.textContent = "";
    }
    return valid;
  }

  if (currentStep == 3) {
    return valid;

  }
  if (currentStep == 4) {

    let email = checkoutForm.email;
    let firstName = checkoutForm.first_name;
    let lastName = checkoutForm.last_name;
    let phone = checkoutForm.phone;
    let messengerPhone = checkoutForm.messenger_phone;

    // Validate First Name
    if (!isValidName(firstName)) {
      valid = false;
    }

    // Validate Last Name
    if (!isValidName(lastName)) {
      valid = false;
    }

    // Validate Email
    if (!isValidEmail(email)) {
      valid = false;
    }

    // Validate Phone
    if (!isValidPhone(phone)) {
      valid = false;
    }

    // Validate Messenger Phone
    if (!isValidMessengerPhone(messengerPhone)) {
      valid = false;
    }

    return valid;

  }

}

function isValidName(nameField) {
  let validName = true;
  let re = /\w{3,}/ig;
  if (!re.test(nameField.value)) {
    validName = false;
    nameField.classList.remove("is-valid");
    nameField.classList.add("is-invalid");
  } else {
    nameField.classList.remove("is-invalid");
    nameField.classList.add("is-valid");
  }
  return validName;
}

function isValidEmail(email) {
  let validEmail = true;
  let re = /[a-zA-Z0-9]+@[a-zA-Z0-9]+.\w{1,}/ig;
  if (!re.test(email.value)) {
    validEmail = false;
    email.classList.remove("is-valid");
    email.classList.add("is-invalid");
  }
  else {
    email.classList.remove("is-invalid");
    email.classList.add("is-valid");
  }
  return validEmail
}

function isValidPhone(phoneField) {
  let validPhone = true;
  let re = /^09\d{9}$/; // Regex baraye shomare haye Iran
  let feedbackElement = phoneField.nextElementSibling; // Element ba class 'invalid-feedback'

  if (!re.test(phoneField.value)) {
    validPhone = false;
    phoneField.classList.remove("is-valid");
    phoneField.classList.add("is-invalid");

    // Update message bar asas khata
    if (phoneField.value.length < 11) {
      feedbackElement.textContent = "شماره تلفن باید ۱۱ رقمی باشد!";
    } else if (!phoneField.value.startsWith("09")) {
      feedbackElement.textContent = "شماره تلفن باید با ۰۹ شروع شود.";
    } else {
      feedbackElement.textContent = "فرمت شماره تلفن نادرست است.";
    }
  } else {
    phoneField.classList.remove("is-invalid");
    phoneField.classList.add("is-valid");
    feedbackElement.textContent = ""; // Clear error message
  }

  return validPhone;
}
function isValidMessengerPhone(phoneField) {
  let validMessengerPhone = true;
  const re = /^\d{10,15}$/; // فقط عدد، بین 10 تا 15 رقم

  let feedbackElement = phoneField.nextElementSibling;

  if (!re.test(phoneField.value)) {
    validMessengerPhone = false;
    phoneField.classList.remove("is-valid");
    phoneField.classList.add("is-invalid");

    // پیام خطا
    if (phoneField.value.length < 10) {
      feedbackElement.textContent = "شماره باید حداقل ۱۰ رقم باشد.";
    } else if (phoneField.value.length > 15) {
      feedbackElement.textContent = "شماره نباید بیشتر از ۱۵ رقم باشد.";
    } else if (!/^\d+$/.test(phoneField.value)) {
      feedbackElement.textContent = "شماره فقط باید شامل ارقام باشد.";
    } else {
      feedbackElement.textContent = "فرمت شماره معتبر نیست.";
    }
  } else {
    phoneField.classList.remove("is-invalid");
    phoneField.classList.add("is-valid");
    feedbackElement.textContent = "";
  }

  return validMessengerPhone;
}


function validateCars() {
  const radioButtons = document.querySelectorAll("input[name='carId']");
  const feedback = document.querySelector(".bad-feedback-car");

  if (!feedback) {
    console.error("Element with class 'bad-feedback-car' not found!");
    return false;
  }

  let selected = false;
  for (let radio of radioButtons) {
    if (radio.checked) {
      selected = true;
      break;
    }
  }

  if (!selected) {
    feedback.classList.remove("d-none");
    return false;
  } else {
    feedback.classList.add("d-none");
    return true;
  }
}


function isValidDate(dateField) {

  if (!dateField || !dateField.value || isNaN(new Date(dateField.value).getTime())) {
    dateField.classList.remove("is-valid");
    dateField.classList.add("is-invalid");
    return false;
  }
  dateField.classList.remove("is-invalid");
  dateField.classList.add("is-valid");
  return true;
}

function isReturnDateAfterPickupDate(pickupField, returnField) {
  let pickupDate = new Date(pickupField.value);
  let returnDate = new Date(returnField.value);
  let errorDiv = document.getElementById("date-error");

  // Moghayese be timestamp baraye asalat
  if (pickupDate.getTime() > returnDate.getTime()) {
    returnField.classList.remove("is-valid");
    returnField.classList.add("is-invalid");
    errorDiv.classList.remove("d-none"); // Show error message
    return false;
  } else {
    returnField.classList.remove("is-invalid");
    returnField.classList.add("is-valid");
    errorDiv.classList.add("d-none"); // Hide error message
    return true;
  }
}

function isValidPickupLocation(locationField) {
  let validLocation = true;
  if (locationField.value === "") {
    validLocation = false;
    locationField.classList.remove("is-valid");
    locationField.classList.add("is-invalid");
  } else {
    locationField.classList.remove("is-invalid");
    locationField.classList.add("is-valid");
  }
  return validLocation;
}

function isValidReturnLocation(locationField) {
  let validLocation = true;
  if (locationField.value === "") {
    validLocation = false;
    locationField.classList.remove("is-valid");
    locationField.classList.add("is-invalid");
  } else {
    locationField.classList.remove("is-invalid");
    locationField.classList.add("is-valid");
  }
  return validLocation;
}

function scrollToTop() {
  const wrapper = document.querySelector('.wrapper');
  if (wrapper) {
    wrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
}
