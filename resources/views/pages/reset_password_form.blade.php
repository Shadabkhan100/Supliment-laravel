@extends('layout.Main')

@section('content')

<style>
    :root {
        --primary: #a4fd0c;
        --primary-dark: #8edb00;
        --dark: #1f2937;
        --muted: #6b7280;
        --border: #e5e7eb;
        --light: #f8fafc;
    }

    .reset-page {
        min-height: 75vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px 15px;
        background: #ffffff;
    }

    .reset-wrapper {
        width: 100%;
        max-width: 520px;
    }

    .reset-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .reset-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .reset-icon {
        width: 65px;
        height: 65px;
        border-radius: 18px;
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        color: #111;
        font-size: 25px;
    }

    .reset-header h2 {
        font-size: 27px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .reset-header p {
        color: var(--muted);
        font-size: 14px;
        margin: 0;
    }

    /* =========================
       PROGRESS BAR
    ========================= */

    .progress-wrapper {
        margin-bottom: 40px;
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    .progress-line {
        position: absolute;
        top: 17px;
        left: 17px;
        right: 17px;
        height: 3px;
        background: #e9ecef;
        z-index: 1;
    }

    .progress-line-active {
        position: absolute;
        top: 17px;
        left: 17px;
        width: 0%;
        height: 3px;
        background: var(--primary);
        z-index: 2;
        transition: width 0.4s ease;
    }

    .progress-step {
        position: relative;
        z-index: 3;
        text-align: center;
        width: 33.333%;
    }

    .step-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-size: 13px;
        font-weight: 700;
        color: #999;
        transition: all 0.3s ease;
    }

    .progress-step.active .step-circle,
    .progress-step.completed .step-circle {
        background: var(--primary);
        border-color: var(--primary);
        color: #111;
    }

    .progress-step span {
        font-size: 12px;
        color: #999;
        font-weight: 500;
    }

    .progress-step.active span,
    .progress-step.completed span {
        color: #111;
        font-weight: 700;
    }

    /* =========================
       FORM
    ========================= */

    .reset-step {
        display: none;
    }

    .reset-step.active {
        display: block;
        animation: fadeIn 0.35s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .step-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .step-description {
        font-size: 14px;
        color: var(--muted);
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .form-label {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control {
        height: 52px;
        border-radius: 10px;
        border: 1px solid #dfe3e8;
        padding: 0 15px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary-dark);
        box-shadow: 0 0 0 3px rgba(164, 253, 12, 0.15);
    }

    .main-btn {
        width: 100%;
        height: 52px;
        border: none;
        border-radius: 10px;
        background: var(--primary);
        color: #111;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .main-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .back-btn {
        width: 100%;
        height: 48px;
        margin-top: 10px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: #fff;
        color: #555;
        font-weight: 600;
        cursor: pointer;
    }

    .back-btn:hover {
        background: #f8f8f8;
    }

    /* =========================
       OTP
    ========================= */

    .otp-container {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin: 25px 0;
    }

    .otp-input {
        width: 55px;
        height: 60px;
        text-align: center;
        font-size: 22px;
        font-weight: 700;
        border: 1px solid #ddd;
        border-radius: 10px;
        outline: none;
    }

    .otp-input:focus {
        border-color: var(--primary-dark);
        box-shadow: 0 0 0 3px rgba(164, 253, 12, 0.15);
    }

    .otp-info {
        text-align: center;
        color: var(--muted);
        font-size: 13px;
        margin-bottom: 20px;
    }

    .otp-info strong {
        color: #333;
    }

    .resend-wrapper {
        text-align: center;
        margin-top: 18px;
        font-size: 13px;
        color: var(--muted);
    }

    .resend-btn {
        border: none;
        background: none;
        color: #222;
        font-weight: 700;
        cursor: pointer;
        padding: 0;
    }

    .resend-btn:disabled {
        color: #aaa;
        cursor: not-allowed;
    }

    /* =========================
       PASSWORD
    ========================= */

    .password-wrapper {
        position: relative;
    }

    .password-wrapper .form-control {
        padding-right: 45px;
    }

    .password-toggle {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: none;
        color: #777;
        cursor: pointer;
    }

    .password-strength {
        height: 5px;
        background: #eee;
        border-radius: 10px;
        margin-top: 10px;
        overflow: hidden;
    }

    .password-strength-bar {
        height: 100%;
        width: 0%;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .password-hint {
        font-size: 12px;
        color: #888;
        margin-top: 8px;
    }

    .match-message {
        font-size: 12px;
        margin-top: 7px;
    }

    .success-message {
        display: none;
        text-align: center;
        padding: 15px;
        background: #f1ffe0;
        border: 1px solid #d7f7a1;
        border-radius: 10px;
        color: #4d7200;
        margin-bottom: 20px;
        font-size: 14px;
    }

    @media(max-width: 500px) {

        .reset-card {
            padding: 25px 20px;
        }

        .otp-input {
            width: 45px;
            height: 52px;
        }

        .otp-container {
            gap: 7px;
        }
    }
</style>


<div class="reset-page">

    <div class="reset-wrapper">

        <div class="reset-card">

            <!-- HEADER -->
            <div class="reset-header">

                <div class="reset-icon">
                    <i class="fas fa-lock"></i>
                </div>

                <h2>Reset Your Password</h2>

                <p>
                    Follow the steps below to securely reset your password.
                </p>

            </div>


            <!-- PROGRESS -->
            <div class="progress-wrapper">

                <div class="progress-steps">

                    <div class="progress-line"></div>
                    <div class="progress-line-active" id="progressLine"></div>

                    <!-- STEP 1 -->
                    <div class="progress-step active" id="progressStep1">

                        <div class="step-circle">
                            1
                        </div>

                        <span>Email</span>

                    </div>


                    <!-- STEP 2 -->
                    <div class="progress-step" id="progressStep2">

                        <div class="step-circle">
                            2
                        </div>

                        <span>OTP</span>

                    </div>


                    <!-- STEP 3 -->
                    <div class="progress-step" id="progressStep3">

                        <div class="step-circle">
                            3
                        </div>

                        <span>Password</span>

                    </div>

                </div>

            </div>


            <!-- =========================
                 STEP 1
            ========================== -->

            <div class="reset-step active" id="step1">

                <div class="step-title">
                    Enter your email
                </div>

                <div class="step-description">
                    Enter the email address associated with your account.
                    We will send you a verification code.
                </div>


                <div class="mb-4">

                    <label class="form-label">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="resetEmail"
                        class="form-control"
                        placeholder="Enter your email address"
                    >

                </div>


<button
    type="button"
    id="sendOtpBtn"
    onclick="goToOtp()">
    Send OTP
</button>

            </div>


            <!-- =========================
                 STEP 2
            ========================== -->

            <div class="reset-step" id="step2">

                <div class="step-title">
                    Verify your email
                </div>

                <div class="step-description">
                    Enter the 6-digit verification code sent to your email.
                </div>


                <div class="otp-info">

                    OTP sent to:
                    <strong id="displayEmail">
                        example@email.com
                    </strong>

                </div>


                <div class="otp-container">

                    <input
                        type="text"
                        maxlength="1"
                        class="otp-input"
                        inputmode="numeric"
                    >

                    <input
                        type="text"
                        maxlength="1"
                        class="otp-input"
                        inputmode="numeric"
                    >

                    <input
                        type="text"
                        maxlength="1"
                        class="otp-input"
                        inputmode="numeric"
                    >

                    <input
                        type="text"
                        maxlength="1"
                        class="otp-input"
                        inputmode="numeric"
                    >

                    <input
                        type="text"
                        maxlength="1"
                        class="otp-input"
                        inputmode="numeric"
                    >

                    <input
                        type="text"
                        maxlength="1"
                        class="otp-input"
                        inputmode="numeric"
                    >

                </div>


           <button
    type="button"
    id="verifyOtpBtn"
    onclick="verifyOtp()">
    Verify OTP
</button>


                <button
                    type="button"
                    class="back-btn"
                    onclick="showStep(1)">

                    <i class="fas fa-arrow-left me-2"></i>
                    Back

                </button>


                <div class="resend-wrapper">

                    Didn't receive the code?

                 <button
    type="button"
    id="resendBtn"
    onclick="resendOtp()">
    Resend OTP <span id="timer"></span>
</button>

                    <span id="timer"></span>

                </div>

            </div>


            <!-- =========================
                 STEP 3
            ========================== -->

            <div class="reset-step" id="step3">

                <div class="step-title">
                    Create a new password
                </div>

                <div class="step-description">
                    Choose a strong password that you haven't used before.
                </div>


                <!-- SUCCESS MESSAGE -->

                <div
                    class="success-message"
                    id="successMessage">

                    <i class="fas fa-check-circle me-1"></i>

                    OTP verified successfully.
                    You can now create your new password.

                </div>


                <!-- NEW PASSWORD -->

                <div class="mb-3">

                    <label class="form-label">
                        New Password
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            id="newPassword"
                            class="form-control"
                            placeholder="Enter new password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('newPassword', this)">

                            <i class="fas fa-eye"></i>

                        </button>

                    </div>


                    <div class="password-strength">

                        <div
                            class="password-strength-bar"
                            id="strengthBar">
                        </div>

                    </div>

                    <div class="password-hint">
                        Use at least 8 characters with a combination of letters,
                        numbers and symbols.
                    </div>

                </div>


                <!-- CONFIRM PASSWORD -->

                <div class="mb-4">

                    <label class="form-label">
                        Confirm New Password
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            id="confirmPassword"
                            class="form-control"
                            placeholder="Confirm new password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('confirmPassword', this)">

                            <i class="fas fa-eye"></i>

                        </button>

                    </div>

                    <div
                        class="match-message"
                        id="matchMessage">
                    </div>

                </div>


                <button
                    type="button"
                    class="main-btn"
                    onclick="resetPassword()">

                    <i class="fas fa-key me-2"></i>
                    Reset Password

                </button>


                <button
                    type="button"
                    class="back-btn"
                    onclick="showStep(2)">

                    <i class="fas fa-arrow-left me-2"></i>
                    Back

                </button>

            </div>

        </div>

    </div>

</div>


<script>

let currentStep = 1;
let countdown = 60;
let countdownInterval = null;
let resetEmail = '';

/*
|--------------------------------------------------------------------------
| CSRF TOKEN
|--------------------------------------------------------------------------
*/




/*
|--------------------------------------------------------------------------
| GENERIC API REQUEST
|--------------------------------------------------------------------------
*/

async function apiRequest(url, data = {}) {
  const csrfMeta = document.querySelector('meta[name="csrf-token"]');

    if (!csrfMeta) {
        throw new Error('CSRF token not found. Please check your main layout.');
    }

    const csrfToken = csrfMeta.getAttribute('content');


    const response = await fetch(url, {

        method: 'POST',

        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },

        body: JSON.stringify(data)

    });

    let result;

    try {

        result = await response.json();

    } catch (error) {

        throw new Error('Invalid server response.');

    }

    if (!response.ok) {

        let message = result.message || 'Something went wrong.';

        /*
        |--------------------------------------------------------------------------
        | Laravel validation errors
        |--------------------------------------------------------------------------
        */

        if (result.errors) {

            const firstError = Object.values(result.errors)[0];

            if (Array.isArray(firstError)) {
                message = firstError[0];
            }

        }

        throw new Error(message);
    }

    return result;
}


/*
|--------------------------------------------------------------------------
| BUTTON LOADING
|--------------------------------------------------------------------------
*/

function setButtonLoading(button, loading, loadingText = 'Please wait...') {

    if (!button) return;

    if (loading) {

        button.dataset.originalText = button.innerHTML;

        button.disabled = true;

        button.innerHTML = `
            <span
                class="spinner-border spinner-border-sm me-2"
                role="status"
                aria-hidden="true">
            </span>
            ${loadingText}
        `;

    } else {

        button.disabled = false;

        if (button.dataset.originalText) {
            button.innerHTML = button.dataset.originalText;
        }

    }

}


/*
|--------------------------------------------------------------------------
| SHOW ERROR
|--------------------------------------------------------------------------
*/

function showError(message) {

    alert(message);

}


/*
|--------------------------------------------------------------------------
| CHANGE STEP
|--------------------------------------------------------------------------
*/

function showStep(step) {

    currentStep = step;

    /*
    |--------------------------------------------------------------------------
    | Hide all steps
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.reset-step').forEach(function(element) {

        element.classList.remove('active');

    });


    /*
    |--------------------------------------------------------------------------
    | Show selected step
    |--------------------------------------------------------------------------
    */

    const selectedStep = document.getElementById('step' + step);

    if (selectedStep) {
        selectedStep.classList.add('active');
    }


    /*
    |--------------------------------------------------------------------------
    | Progress steps
    |--------------------------------------------------------------------------
    */

    for (let i = 1; i <= 3; i++) {

        const progressStep =
            document.getElementById('progressStep' + i);

        if (!progressStep) continue;

        progressStep.classList.remove(
            'active',
            'completed'
        );

        if (i < step) {

            progressStep.classList.add('completed');

        }

        if (i === step) {

            progressStep.classList.add('active');

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Progress line
    |--------------------------------------------------------------------------
    */

    const progressLine =
        document.getElementById('progressLine');

    if (!progressLine) return;

    if (step === 1) {

        progressLine.style.width = '0%';

    } else if (step === 2) {

        progressLine.style.width = '50%';

    } else if (step === 3) {

        progressLine.style.width = '100%';

    }

}


/*
|--------------------------------------------------------------------------
| STEP 1
| SEND OTP
|--------------------------------------------------------------------------
*/

async function goToOtp() {

    const emailInput =
        document.getElementById('resetEmail');

    const button =
        document.getElementById('sendOtpBtn');

    if (!emailInput) return;

    const email = emailInput.value.trim();


    /*
    |--------------------------------------------------------------------------
    | Validate email
    |--------------------------------------------------------------------------
    */

    if (!email) {

        showError('Please enter your email address.');

        emailInput.focus();

        return;
    }


    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {

        showError('Please enter a valid email address.');

        emailInput.focus();

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Save email
    |--------------------------------------------------------------------------
    */

    resetEmail = email;


    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    */

    setButtonLoading(
        button,
        true,
        'Sending OTP...'
    );


    try {

        /*
        |--------------------------------------------------------------------------
        | Send OTP
        |--------------------------------------------------------------------------
        */

        const response = await apiRequest(
            '/reset-password/send-otp',
            {
                email: email
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        console.log('OTP Response:', response);


        const displayEmail =
            document.getElementById('displayEmail');

        if (displayEmail) {

            displayEmail.textContent = email;

        }


        /*
        |--------------------------------------------------------------------------
        | Clear previous OTP
        |--------------------------------------------------------------------------
        */

        clearOtp();


        /*
        |--------------------------------------------------------------------------
        | Go to OTP step
        |--------------------------------------------------------------------------
        */

        showStep(2);


        /*
        |--------------------------------------------------------------------------
        | Start resend timer
        |--------------------------------------------------------------------------
        */

        startTimer();


        /*
        |--------------------------------------------------------------------------
        | Focus first OTP field
        |--------------------------------------------------------------------------
        */

        setTimeout(function() {

            const firstOtp =
                document.querySelector('.otp-input');

            if (firstOtp) {
                firstOtp.focus();
            }

        }, 200);


    } catch (error) {

        console.error(
            'Send OTP Error:',
            error
        );

        showError(
            error.message ||
            'Unable to send OTP. Please try again.'
        );

    } finally {

        setButtonLoading(
            button,
            false
        );

    }

}


/*
|--------------------------------------------------------------------------
| OTP INPUTS
|--------------------------------------------------------------------------
*/

const otpInputs =
    document.querySelectorAll('.otp-input');


otpInputs.forEach(function(input, index) {


    /*
    |--------------------------------------------------------------------------
    | INPUT
    |--------------------------------------------------------------------------
    */

    input.addEventListener('input', function() {

        this.value =
            this.value.replace(/[^0-9]/g, '');


        /*
        |--------------------------------------------------------------------------
        | Move to next input
        |--------------------------------------------------------------------------
        */

        if (
            this.value &&
            index < otpInputs.length - 1
        ) {

            otpInputs[index + 1].focus();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | BACKSPACE
    |--------------------------------------------------------------------------
    */

    input.addEventListener('keydown', function(e) {

        if (
            e.key === 'Backspace' &&
            !this.value &&
            index > 0
        ) {

            otpInputs[index - 1].focus();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | PASTE OTP
    |--------------------------------------------------------------------------
    */

    input.addEventListener('paste', function(e) {

        e.preventDefault();

        const pastedData =
            e.clipboardData
                .getData('text')
                .replace(/\D/g, '')
                .substring(0, 6);


        pastedData.split('').forEach(function(value, i) {

            if (otpInputs[i]) {

                otpInputs[i].value = value;

            }

        });


        if (
            otpInputs[pastedData.length - 1]
        ) {

            otpInputs[
                pastedData.length - 1
            ].focus();

        }

    });

});


/*
|--------------------------------------------------------------------------
| GET OTP VALUE
|--------------------------------------------------------------------------
*/

function getOtp() {

    let otp = '';

    otpInputs.forEach(function(input) {

        otp += input.value;

    });

    return otp;

}


/*
|--------------------------------------------------------------------------
| CLEAR OTP
|--------------------------------------------------------------------------
*/

function clearOtp() {

    otpInputs.forEach(function(input) {

        input.value = '';

    });

}


/*
|--------------------------------------------------------------------------
| STEP 2
| VERIFY OTP
|--------------------------------------------------------------------------
*/

async function verifyOtp() {

    const otp = getOtp();

    const button =
        document.getElementById('verifyOtpBtn');


    /*
    |--------------------------------------------------------------------------
    | Validate OTP
    |--------------------------------------------------------------------------
    */

    if (otp.length !== 6) {

        showError(
            'Please enter the complete 6-digit OTP.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    */

    setButtonLoading(
        button,
        true,
        'Verifying...'
    );


    try {

        /*
        |--------------------------------------------------------------------------
        | Verify OTP
        |--------------------------------------------------------------------------
        */

        const response = await apiRequest(
            '/reset-password/verify-otp',
            {
                email: resetEmail,
                otp: otp
            }
        );


        console.log(
            'OTP Verification:',
            response
        );


        /*
        |--------------------------------------------------------------------------
        | Show success message
        |--------------------------------------------------------------------------
        */

        const successMessage =
            document.getElementById('successMessage');

        if (successMessage) {

            successMessage.style.display =
                'block';

        }


        /*
        |--------------------------------------------------------------------------
        | Stop resend timer
        |--------------------------------------------------------------------------
        */

        stopTimer();


        /*
        |--------------------------------------------------------------------------
        | Go to password step
        |--------------------------------------------------------------------------
        */

        showStep(3);


        /*
        |--------------------------------------------------------------------------
        | Focus password
        |--------------------------------------------------------------------------
        */

        setTimeout(function() {

            const password =
                document.getElementById('newPassword');

            if (password) {
                password.focus();
            }

        }, 200);


    } catch (error) {

        console.error(
            'Verify OTP Error:',
            error
        );


        /*
        |--------------------------------------------------------------------------
        | Clear OTP after invalid attempt
        |--------------------------------------------------------------------------
        */

        clearOtp();


        showError(
            error.message ||
            'Invalid verification code.'
        );


        /*
        |--------------------------------------------------------------------------
        | Focus first OTP
        |--------------------------------------------------------------------------
        */

        if (otpInputs[0]) {

            otpInputs[0].focus();

        }

    } finally {

        setButtonLoading(
            button,
            false
        );

    }

}


/*
|--------------------------------------------------------------------------
| RESEND OTP TIMER
|--------------------------------------------------------------------------
*/

function startTimer() {

    stopTimer();

    countdown = 60;

    const resendBtn =
        document.getElementById('resendBtn');

    const timer =
        document.getElementById('timer');


    if (resendBtn) {

        resendBtn.disabled = true;

    }


    if (timer) {

        timer.textContent =
            ` (${countdown}s)`;

    }


    countdownInterval =
        setInterval(function() {

            countdown--;


            if (timer) {

                timer.textContent =
                    ` (${countdown}s)`;

            }


            if (countdown <= 0) {

                stopTimer();

            }

        }, 1000);

}


/*
|--------------------------------------------------------------------------
| STOP TIMER
|--------------------------------------------------------------------------
*/

function stopTimer() {

    if (countdownInterval) {

        clearInterval(countdownInterval);

        countdownInterval = null;

    }


    const resendBtn =
        document.getElementById('resendBtn');

    const timer =
        document.getElementById('timer');


    if (resendBtn) {

        resendBtn.disabled = false;

    }


    if (timer) {

        timer.textContent = '';

    }

}


/*
|--------------------------------------------------------------------------
| RESEND OTP
|--------------------------------------------------------------------------
*/

async function resendOtp() {

    if (!resetEmail) {

        showError(
            'Your email address is missing. Please start again.'
        );

        showStep(1);

        return;

    }


    const button =
        document.getElementById('resendBtn');


    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    */

    setButtonLoading(
        button,
        true,
        'Sending...'
    );


    try {

        const response = await apiRequest(
            '/reset-password/send-otp',
            {
                email: resetEmail
            }
        );


        console.log(
            'Resend OTP:',
            response
        );


        /*
        |--------------------------------------------------------------------------
        | Clear old OTP
        |--------------------------------------------------------------------------
        */

        clearOtp();


        /*
        |--------------------------------------------------------------------------
        | Restart timer
        |--------------------------------------------------------------------------
        */

        startTimer();


        /*
        |--------------------------------------------------------------------------
        | Focus OTP
        |--------------------------------------------------------------------------
        */

        if (otpInputs[0]) {

            otpInputs[0].focus();

        }


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        alert(
            response.message ||
            'A new OTP has been sent to your email.'
        );


    } catch (error) {

        console.error(
            'Resend OTP Error:',
            error
        );


        showError(
            error.message ||
            'Unable to resend OTP.'
        );

    } finally {

        /*
        |--------------------------------------------------------------------------
        | Don't immediately enable resend if timer is running
        |--------------------------------------------------------------------------
        */

        if (countdown > 0) {

            if (button) {

                button.disabled = true;

            }

        } else {

            setButtonLoading(
                button,
                false
            );

        }

    }

}


/*
|--------------------------------------------------------------------------
| PASSWORD VISIBILITY
|--------------------------------------------------------------------------
*/

function togglePassword(id, button) {

    const input =
        document.getElementById(id);

    const icon =
        button.querySelector('i');


    if (!input) return;


    if (input.type === 'password') {

        input.type = 'text';

        icon.classList.remove(
            'fa-eye'
        );

        icon.classList.add(
            'fa-eye-slash'
        );

    } else {

        input.type = 'password';

        icon.classList.remove(
            'fa-eye-slash'
        );

        icon.classList.add(
            'fa-eye'
        );

    }

}


/*
|--------------------------------------------------------------------------
| PASSWORD STRENGTH
|--------------------------------------------------------------------------
*/

const newPasswordInput =
    document.getElementById('newPassword');


if (newPasswordInput) {

    newPasswordInput.addEventListener(
        'input',
        function() {

            const password =
                this.value;

            const strengthBar =
                document.getElementById(
                    'strengthBar'
                );


            if (!strengthBar) return;


            let strength = 0;


            /*
            |--------------------------------------------------------------------------
            | 8 characters
            |--------------------------------------------------------------------------
            */

            if (password.length >= 8) {

                strength++;

            }


            /*
            |--------------------------------------------------------------------------
            | Uppercase
            |--------------------------------------------------------------------------
            */

            if (/[A-Z]/.test(password)) {

                strength++;

            }


            /*
            |--------------------------------------------------------------------------
            | Number
            |--------------------------------------------------------------------------
            */

            if (/[0-9]/.test(password)) {

                strength++;

            }


            /*
            |--------------------------------------------------------------------------
            | Special character
            |--------------------------------------------------------------------------
            */

            if (/[^A-Za-z0-9]/.test(password)) {

                strength++;

            }


            const widths = [
                '0%',
                '25%',
                '50%',
                '75%',
                '100%'
            ];


            strengthBar.style.width =
                widths[strength];

        }
    );

}


/*
|--------------------------------------------------------------------------
| PASSWORD MATCH
|--------------------------------------------------------------------------
*/

const confirmPasswordInput =
    document.getElementById(
        'confirmPassword'
    );


if (confirmPasswordInput) {

    confirmPasswordInput.addEventListener(
        'input',
        function() {

            const password =
                document.getElementById(
                    'newPassword'
                ).value;

            const confirm =
                this.value;

            const message =
                document.getElementById(
                    'matchMessage'
                );


            if (!message) return;


            if (!confirm) {

                message.textContent = '';

                return;

            }


            if (password === confirm) {

                message.textContent =
                    '✓ Passwords match';

                message.style.color =
                    '#5d8a00';

            } else {

                message.textContent =
                    '✕ Passwords do not match';

                message.style.color =
                    '#dc3545';

            }

        }
    );

}


/*
|--------------------------------------------------------------------------
| FINAL PASSWORD RESET
|--------------------------------------------------------------------------
*/

async function resetPassword() {

    const password =
        document.getElementById(
            'newPassword'
        ).value;

    const confirm =
        document.getElementById(
            'confirmPassword'
        ).value;

    const button =
        document.getElementById(
            'resetPasswordBtn'
        );


    /*
    |--------------------------------------------------------------------------
    | Validate password
    |--------------------------------------------------------------------------
    */

    if (password.length < 8) {

        showError(
            'Password must be at least 8 characters.'
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Confirm password
    |--------------------------------------------------------------------------
    */

    if (password !== confirm) {

        showError(
            'Passwords do not match.'
        );

        return;

    }


    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    */

    setButtonLoading(
        button,
        true,
        'Updating Password...'
    );


    try {

        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */

        const response = await apiRequest(
            '/reset-password/update',
            {
                password: password,
                password_confirmation: confirm
            }
        );


        console.log(
            'Password Reset:',
            response
        );


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        alert(
            response.message ||
            'Your password has been updated successfully.'
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        if (response.redirect) {

            window.location.href =
                response.redirect;

        } else {

            window.location.href =
                '/login';

        }


    } catch (error) {

        console.error(
            'Password Reset Error:',
            error
        );


        showError(
            error.message ||
            'Unable to update your password.'
        );


    } finally {

        setButtonLoading(
            button,
            false
        );

    }

}


/*
|--------------------------------------------------------------------------
| INITIAL STATE
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    function() {

        showStep(1);

    }
);

</script>

@endsection