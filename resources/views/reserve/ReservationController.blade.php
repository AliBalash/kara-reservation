<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <!-- displays site properly based on user's device -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('assets/reserve/assets/images/favicon-32x32.png') }}" />
    <!-- Bootstrap css file -->
    <link rel="stylesheet" href="{{ asset('assets/reserve/styles/bootstrap.min.css') }}" />
    <!-- main style file -->
    <link rel="stylesheet" href="{{ asset('assets/reserve/styles/main.css') }}" />
    <title>Frontend Mentor | Multi-step form</title>

    <!-- Feel free to remove these styles or customise in your own stylesheet 👍 -->
    <style>
        .attribution {
            font-size: 11px;
            text-align: center;
        }

        .attribution a {
            color: hsl(228, 45%, 44%);
        }
    </style>
</head>

<body class="">
    <!-- main container start -->
    <div class="center-box d-flex justify-content-center align-items-center">
        <div class="wrapper p-4">
            <label for="darkmode" class="">
                <input type="checkbox" id="darkmode" />
                <div class="theme-mode d-flex">
                    <img src="{{ asset('assets/reserve/assets/images/dark1.png') }}" class=""
                        alt="darkMode icon from flat icons" />
                </div>
            </label>
            <div class="row gx-1 ">
                <!-- Start Sidebar -->
                <aside class="col-md-4">
                    <div class="sidebar p-5">
                        <div class="steps d-flex justify-content-center align-items-center mb-4">
                            <div
                                class="icon d-flex justify-content-center align-items-center border border-2 rounded-circle me-2 checked">
                                1</div>
                            <div class="text flex-grow-1 d-none d-md-block">
                                <span class="d-block">Step 1</span>
                                <span class="text-uppercase text-white fw-bold">Your Info</span>
                            </div>
                        </div>
                        <div class="steps d-flex justify-content-center align-items-center mb-4">
                            <div
                                class="icon d-flex justify-content-center align-items-center border border-2 rounded-circle me-2">
                                2</div>
                            <div class="text flex-grow-1 d-none d-md-block">
                                <span class="d-block">Step 2</span>
                                <span class="text-uppercase text-white fw-bold">Select plan</span>
                            </div>
                        </div>
                        <div class="steps d-flex justify-content-center align-items-center mb-4">
                            <div
                                class="icon d-flex justify-content-center align-items-center border border-2 rounded-circle me-2">
                                3</div>
                            <div class="text flex-grow-1 d-none d-md-block">
                                <span class="d-block">Step 3</span>
                                <span class="text-uppercase text-white fw-bold">Add-ons</span>
                            </div>
                        </div>
                        <div class="steps d-flex justify-content-center align-items-center mb-4">
                            <div
                                class="icon d-flex justify-content-center align-items-center border border-2 rounded-circle me-2">
                                4</div>
                            <div class="text flex-grow-1 d-none d-md-block">
                                <span class="d-block">Step 4</span>
                                <span class="text-uppercase text-white fw-bold">Summary</span>
                            </div>
                        </div>
                    </div>
                </aside>
                <!-- End Sidebar -->
                <form class="col-md-8 p-1 needs-validation" action="/" method="post" id="checkoutForm" novalidate>


                    <!-- Start profile step -->
                    <div class="step step-1 row profile-step p-4 d-none">
                        <header class="col-12">
                            <h1 class="">Profile Info</h1>
                            <p class="lead">Please provide your name, email address, and phone number.</p>
                        </header>

                        <div class="mb-3 col-12 col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" required id="first_name" name="first_name"
                                placeholder="First Name" />
                            <div class="invalid-feedback">First Name is required!</div>
                        </div>
                        <div class="mb-3 col-12 col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" required id="last_name" name="last_name"
                                placeholder="Last Name" />
                            <div class="invalid-feedback">Last Name is required!</div>
                        </div>

                        <div class="mb-3 col-12 col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" required id="email" name="email"
                                placeholder="name@example.com" />
                            <div class="invalid-feedback">Valid Email is required!</div>
                        </div>

                        <div class="mb-3 col-12 col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" required id="phone" name="phone"
                                placeholder="eg 09123456789" />
                            <div class="invalid-feedback">Phone is required!</div>
                        </div>

                        <div class="mb-3 col-12 col-md-6">
                            <label for="messenger-phone" class="form-label">Telegram/WhatsApp Number</label>
                            <input type="tel" class="form-control" required id="messenger-phone"
                                name="messenger_phone" placeholder="eg 09123456789" />
                            <div class="invalid-feedback">Messenger number is required!</div>
                        </div>

                    </div>
                    <!-- End profile-step -->


                    <!-- Start plan step -->
                    <div class="step step-2 plan-step p-2 d-none">
                        <header class="col-12">
                            <h1 class="">Select your plan</h1>
                            <p class="lead">You have the option of monthly or yearly billing.</p>
                        </header>


                        <div class="form-check plans d-flex gap-2 flex-column flex-md-row row" id="month-plan">

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="arcade"
                                    class="form-check-input plan-type d-none" value="month-arcade" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-arcade.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Arcade" />
                                <div>
                                    <h5>Arcade</h5>
                                    <h6 class="m-y-on">$9/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="advanced"
                                    class="form-check-input plan-type d-none" value="month-advanced" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-advanced.svg') }}""
                                    class="me-2 me-md-0 mb-0 mb-md-5 alt="Advanced" />
                                <div>
                                    <h5>Advanced</h5>
                                    <h6>$12/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="pro"
                                    class="form-check-input plan-type d-none" value="month-pro" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-pro.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Pro" />
                                <div>
                                    <h5>Pro</h5>
                                    <h6>$20/mo</h6>
                                </div>

                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="arcade"
                                    class="form-check-input plan-type d-none" value="month-arcade" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-arcade.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Arcade" />
                                <div>
                                    <h5>Arcade</h5>
                                    <h6 class="m-y-on">$9/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="advanced"
                                    class="form-check-input plan-type d-none" value="month-advanced" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-advanced.svg') }}""
                                    class="me-2 me-md-0 mb-0 mb-md-5 alt="Advanced" />
                                <div>
                                    <h5>Advanced</h5>
                                    <h6>$12/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="pro"
                                    class="form-check-input plan-type d-none" value="month-pro" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-pro.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Pro" />
                                <div>
                                    <h5>Pro</h5>
                                    <h6>$20/mo</h6>
                                </div>

                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="arcade"
                                    class="form-check-input plan-type d-none" value="month-arcade" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-arcade.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Arcade" />
                                <div>
                                    <h5>Arcade</h5>
                                    <h6 class="m-y-on">$9/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="advanced"
                                    class="form-check-input plan-type d-none" value="month-advanced" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-advanced.svg') }}""
                                    class="me-2 me-md-0 mb-0 mb-md-5 alt="Advanced" />
                                <div>
                                    <h5>Advanced</h5>
                                    <h6>$12/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="pro"
                                    class="form-check-input plan-type d-none" value="month-pro" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-pro.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Pro" />
                                <div>
                                    <h5>Pro</h5>
                                    <h6>$20/mo</h6>
                                </div>

                            </label>
                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="arcade"
                                    class="form-check-input plan-type d-none" value="month-arcade" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-arcade.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Arcade" />
                                <div>
                                    <h5>Arcade</h5>
                                    <h6 class="m-y-on">$9/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="advanced"
                                    class="form-check-input plan-type d-none" value="month-advanced" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-advanced.svg') }}""
                                    class="me-2 me-md-0 mb-0 mb-md-5 alt="Advanced" />
                                <div>
                                    <h5>Advanced</h5>
                                    <h6>$12/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="pro"
                                    class="form-check-input plan-type d-none" value="month-pro" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-pro.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Pro" />
                                <div>
                                    <h5>Pro</h5>
                                    <h6>$20/mo</h6>
                                </div>

                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="arcade"
                                    class="form-check-input plan-type d-none" value="month-arcade" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-arcade.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Arcade" />
                                <div>
                                    <h5>Arcade</h5>
                                    <h6 class="m-y-on">$9/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="advanced"
                                    class="form-check-input plan-type d-none" value="month-advanced" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-advanced.svg') }}""
                                    class="me-2 me-md-0 mb-0 mb-md-5 alt="Advanced" />
                                <div>
                                    <h5>Advanced</h5>
                                    <h6>$12/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="pro"
                                    class="form-check-input plan-type d-none" value="month-pro" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-pro.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Pro" />
                                <div>
                                    <h5>Pro</h5>
                                    <h6>$20/mo</h6>
                                </div>

                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="arcade"
                                    class="form-check-input plan-type d-none" value="month-arcade" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-arcade.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Arcade" />
                                <div>
                                    <h5>Arcade</h5>
                                    <h6 class="m-y-on">$9/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="advanced"
                                    class="form-check-input plan-type d-none" value="month-advanced" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-advanced.svg') }}""
                                    class="me-2 me-md-0 mb-0 mb-md-5 alt="Advanced" />
                                <div>
                                    <h5>Advanced</h5>
                                    <h6>$12/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="pro"
                                    class="form-check-input plan-type d-none" value="month-pro" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-pro.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Pro" />
                                <div>
                                    <h5>Pro</h5>
                                    <h6>$20/mo</h6>
                                </div>

                            </label>
                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="arcade"
                                    class="form-check-input plan-type d-none" value="month-arcade" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-arcade.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Arcade" />
                                <div>
                                    <h5>Arcade</h5>
                                    <h6 class="m-y-on">$9/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="advanced"
                                    class="form-check-input plan-type d-none" value="month-advanced" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-advanced.svg') }}""
                                    class="me-2 me-md-0 mb-0 mb-md-5 alt="Advanced" />
                                <div>
                                    <h5>Advanced</h5>
                                    <h6>$12/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="pro"
                                    class="form-check-input plan-type d-none" value="month-pro" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-pro.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Pro" />
                                <div>
                                    <h5>Pro</h5>
                                    <h6>$20/mo</h6>
                                </div>

                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="arcade"
                                    class="form-check-input plan-type d-none" value="month-arcade" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-arcade.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Arcade" />
                                <div>
                                    <h5>Arcade</h5>
                                    <h6 class="m-y-on">$9/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="advanced"
                                    class="form-check-input plan-type d-none" value="month-advanced" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-advanced.svg') }}""
                                    class="me-2 me-md-0 mb-0 mb-md-5 alt="Advanced" />
                                <div>
                                    <h5>Advanced</h5>
                                    <h6>$12/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="pro"
                                    class="form-check-input plan-type d-none" value="month-pro" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-pro.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Pro" />
                                <div>
                                    <h5>Pro</h5>
                                    <h6>$20/mo</h6>
                                </div>

                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="arcade"
                                    class="form-check-input plan-type d-none" value="month-arcade" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-arcade.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Arcade" />
                                <div>
                                    <h5>Arcade</h5>
                                    <h6 class="m-y-on">$9/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="advanced"
                                    class="form-check-input plan-type d-none" value="month-advanced" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-advanced.svg') }}""
                                    class="me-2 me-md-0 mb-0 mb-md-5 alt="Advanced" />
                                <div>
                                    <h5>Advanced</h5>
                                    <h6>$12/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="pro"
                                    class="form-check-input plan-type d-none" value="month-pro" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-pro.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Pro" />
                                <div>
                                    <h5>Pro</h5>
                                    <h6>$20/mo</h6>
                                </div>

                            </label>
                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="arcade"
                                    class="form-check-input plan-type d-none" value="month-arcade" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-arcade.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Arcade" />
                                <div>
                                    <h5>Arcade</h5>
                                    <h6 class="m-y-on">$9/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="advanced"
                                    class="form-check-input plan-type d-none" value="month-advanced" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-advanced.svg') }}""
                                    class="me-2 me-md-0 mb-0 mb-md-5 alt="Advanced" />
                                <div>
                                    <h5>Advanced</h5>
                                    <h6>$12/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="pro"
                                    class="form-check-input plan-type d-none" value="month-pro" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-pro.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Pro" />
                                <div>
                                    <h5>Pro</h5>
                                    <h6>$20/mo</h6>
                                </div>

                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="arcade"
                                    class="form-check-input plan-type d-none" value="month-arcade" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-arcade.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Arcade" />
                                <div>
                                    <h5>Arcade</h5>
                                    <h6 class="m-y-on">$9/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="advanced"
                                    class="form-check-input plan-type d-none" value="month-advanced" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-advanced.svg') }}""
                                    class="me-2 me-md-0 mb-0 mb-md-5 alt="Advanced" />
                                <div>
                                    <h5>Advanced</h5>
                                    <h6>$12/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="pro"
                                    class="form-check-input plan-type d-none" value="month-pro" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-pro.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Pro" />
                                <div>
                                    <h5>Pro</h5>
                                    <h6>$20/mo</h6>
                                </div>

                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="arcade"
                                    class="form-check-input plan-type d-none" value="month-arcade" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-arcade.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Arcade" />
                                <div>
                                    <h5>Arcade</h5>
                                    <h6 class="m-y-on">$9/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="advanced"
                                    class="form-check-input plan-type d-none" value="month-advanced" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-advanced.svg') }}""
                                    class="me-2 me-md-0 mb-0 mb-md-5 alt="Advanced" />
                                <div>
                                    <h5>Advanced</h5>
                                    <h6>$12/mo</h6>
                                </div>
                            </label>

                            <label class="plan shadow-sm p-3 m-1 rounded d-flex d-md-block">
                                <input type="radio" name="plan" id="pro"
                                    class="form-check-input plan-type d-none" value="month-pro" />
                                <img src="{{ asset('assets/reserve/assets/images/icon-pro.svg') }}"
                                    class="me-2 me-md-0 mb-0 mb-md-5" alt="Pro" />
                                <div>
                                    <h5>Pro</h5>
                                    <h6>$20/mo</h6>
                                </div>

                            </label>

                        </div>

                        <div class="bad-feedback d-none">Please choose a plan.</div>
                        
                        <div class="month-year mt-2 d-flex justify-content-center align-items-center rounded p-2">
                            <div class="form-check form-switch ms-2 me-2">
                                <input class="form-check-input" type="checkbox" id="sub" />
                                <label class="form-check-label" for="sub"></label>
                            </div>
                        </div>
                    </div>
                    <!-- End plan-step -->



                    <!-- Start addons step -->
                    <div class="step addons-step p-4">
                        <header>
                            <h1 class="">Pick add-on</h1>
                            <p class="lead">Add-ons help enhance your gaming experience.</p>
                        </header>
                        <div class="addons d-flex gap-2 flex-column" id="monthly-addons">
                            <div class="addon shadow-sm p-3 mb-2 mb-md-3 rounded d-flex align-items-center">
                                <div class="me-4">
                                    <input class="form-check-input mt-0" type="checkbox" value="month-onlineService"
                                        name="addon" aria-label="Checkbox for following text input" />
                                </div>
                                <div>
                                    <p>Online service</p>
                                    <p>Access to multiplayer games</p>
                                </div>
                                <div class="ms-auto">+$1/mo</div>
                            </div>
                            <div class="addon shadow-sm p-3 mb-2 mb-md-3 rounded d-flex align-items-center">
                                <div class="me-4">
                                    <input class="form-check-input mt-0" type="checkbox" value="month-largeStorage"
                                        name="addon" aria-label="Checkbox for following text input" />
                                </div>
                                <div>
                                    <p>Larger storage</p>
                                    <p>Extra 1TB of cloud save</p>
                                </div>
                                <div class="ms-auto">+$2/mo</div>
                            </div>
                            <div class="addon shadow-sm p-3 mb-2 mb-md-3 rounded d-flex align-items-center">
                                <div class="me-4">
                                    <input class="form-check-input mt-0" type="checkbox" value="month-customProfile"
                                        name="addon" aria-label="Checkbox for following text input" />
                                </div>
                                <div>
                                    <p>Customizable Profile</p>
                                    <p>Custom theme on your profile</p>
                                </div>
                                <div class="ms-auto">+$1/mo</div>
                            </div>
                        </div>
                        <div class="addons d-flex gap-2 flex-column d-none" id="yearly-addons">
                            <div class="addon shadow-sm p-3 mb-2 mb-md-3 rounded d-flex align-items-center">
                                <div class="me-4">
                                    <input class="form-check-input mt-0" type="checkbox" value="year-onlineService"
                                        name="addon" aria-label="Checkbox for following text input" />
                                </div>
                                <div>
                                    <p>Online service</p>
                                    <p>Access to multiplayer games</p>
                                </div>
                                <div class="ms-auto">+$10/yr</div>
                            </div>
                            <div class="addon shadow-sm p-3 mb-2 mb-md-3 rounded d-flex align-items-center">
                                <div class="me-4">
                                    <input class="form-check-input mt-0" type="checkbox" value="year-largeStorage"
                                        name="addon" aria-label="Checkbox for following text input" />
                                </div>
                                <div>
                                    <p>Larger storage</p>
                                    <p>Extra 1TB of cloud save</p>
                                </div>
                                <div class="ms-auto">+$20/yr</div>
                            </div>
                            <div class="addon shadow-sm p-3 mb-2 mb-md-3 rounded d-flex align-items-center">
                                <div class="me-4">
                                    <input class="form-check-input mt-0" type="checkbox" value="year-customProfile"
                                        name="addon" aria-label="Checkbox for following text input" />
                                </div>
                                <div>
                                    <p>Customizable Profile</p>
                                    <p>Custom theme on your profile</p>
                                </div>
                                <div class="ms-auto">+$20/yr</div>
                            </div>
                        </div>
                    </div>
                    <!-- End addon-step -->
                    <!-- Start summary step -->
                    <div class="step summary-step p-4 d-none">
                        <header>
                            <h1 class="">Finishing up</h1>
                            <p class="lead">Double-check everything looks OK before confirming.</p>
                        </header>
                        <div class="summary d-flex gap-2 flex-column">
                            <div class="plan p-3 mb-2 mb-md-3 d-flex align-items-center justify-content-between">
                                <div class="d-flex flex-column">
                                    <span class="fw-bold plan-name"></span>
                                    <a href="#changePlan" id="changePlan">Change</a>
                                </div>
                                <div class="plan-price"></div>
                            </div>
                            <hr />
                        </div>
                    </div>
                    <!-- End summary-step -->
                    <div class="next-step mt-5 d-flex align-items-center">
                        <button type="button" id="back" class="fw-bold btn">Go Back</button>

                        <button type="button" id="next" class="btn btn-primary ms-auto">Next Step</button>
                    </div>
                </form>
                <!-- Start thanks step -->
                <div class="thanks-step step d-flex align-items-center col-md-8 p-4 d-none">
                    <header class="d-flex flex-column align-items-center">
                        <img class="w-25 mb-4" src="{{ asset('assets/reserve/assets/images/icon-thank-you.svg') }}"
                            alt="" />

                        <h1 class="">Thank You</h1>
                        <p class="text-center lead">
                            Thanks for confirming your subscription! We hope you have fun using our platform. If you
                            ever need support, please feel free to email us at support@loremgaming.com.
                        </p>
                    </header>
                </div>
                <!-- End thanks-step -->
            </div>
        </div>
    </div>
    <div class="attribution">
        Challenge by
        <a href="https://www.frontendmentor.io?ref=challenge" target="_blank">Frontend Mentor</a>. Coded by <a
            href="#">Abdo</a>.
    </div>
    <!-- main js -->
    <script src="{{ asset('assets/reserve/js/main.js') }}" defer></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/reserve/js/bootstrap.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scrollableBox = document.querySelector('#month-plan');

            if (scrollableBox) {
                const scrollSequence = async () => {
                    const boxHeight = scrollableBox.scrollHeight;
                    const boxViewHeight = scrollableBox.clientHeight;

                    // محاسبه موقعیت وسط
                    const scrollToMiddle = (boxHeight - boxViewHeight) / 2;

                    // اسکرول به وسط و اضافه کردن افکت سایه
                    await smoothScroll(scrollableBox, scrollToMiddle, 0);
                    addFocusEffect(); // اضافه کردن افکت تمرکز

                    // برگشت به بالا
                    await smoothScroll(scrollableBox, 0, 0);
                    removeFocusEffect(); // حذف افکت تمرکز
                };

                // تابع اسکرول نرم
                const smoothScroll = (element, top, left) => {
                    return new Promise((resolve) => {
                        element.scrollBy({
                            top: top,
                            left: left,
                            behavior: 'smooth'
                        });
                        setTimeout(resolve, 1000); // صبر برای 1 ثانیه
                    });
                };

                // اضافه کردن افکت تمرکز (سایه یا رنگ)
                const addFocusEffect = () => {
                    const plans = document.querySelectorAll('.plan');
                    plans.forEach(plan => {
                        plan.classList.add('highlight');
                    });
                };

                // حذف افکت تمرکز
                const removeFocusEffect = () => {
                    const plans = document.querySelectorAll('.plan');
                    plans.forEach(plan => {
                        plan.classList.remove('highlight');
                    });
                };

                // شروع تسلسل اسکرول
                scrollSequence().then(() => {
                    scrollableBox.scrollTo({
                        top: 0,
                        left: 0,
                        behavior: 'smooth'
                    });
                });
            }
        });
    </script>

</body>

</html>
