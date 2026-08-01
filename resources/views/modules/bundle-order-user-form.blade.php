<style>

.form-control,
.form-select {
    transition: all .25s ease;
}

.is-invalid {
    border: 2px solid #dc3545 !important;
    box-shadow: none !important;
}

.is-valid {
    border: 2px solid #198754 !important;
    box-shadow: none !important;
}

.invalid-feedback {
    display: none;
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}

.is-invalid + .invalid-feedback {
    display: block;
}

</style>


<div class="bundle-user-form">

    <h4 class="mb-4">
        Customer Information
    </h4>
<form id="bundleUserForm">
    <div class="row">


    <!-- all of your inputs -->


        <div class="col-md-6 mb-3">
            <label class="form-label">First Name <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control"
                id="first_name"
                  name="first_name"
                placeholder="Enter first name"> <div class="invalid-feedback"></div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Last Name <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control"
                id="last_name"   name="last_name"
                placeholder="Enter last name"><div class="invalid-feedback"></div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Email Address <span class="text-danger">*</span></label>
            <input
                type="email"
                class="form-control"
                id="email" 
                 name="email"

                placeholder="Enter email address"><div class="invalid-feedback"></div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control"
                id="phone"
 name="phone"

                placeholder="Enter phone number"><div class="invalid-feedback"></div>
        </div>

        <div class="col-12 mb-3">
            <label class="form-label">Company (Optional)</label>
            <input
                type="text"
                class="form-control"
                id="company"
               name="company"

                placeholder="Company name"><div class="invalid-feedback"></div>
        </div>

        <div class="col-12 mb-3">
            <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control"
                id="address_1"
 name="address_1"

                placeholder="Street address"><div class="invalid-feedback"></div>
        </div>

        <div class="col-12 mb-3">
            <label class="form-label">Address Line 2</label>
            <input
                type="text"
                class="form-control"
                id="address_2"  name="address_2"

                placeholder="Apartment, suite, unit (optional)"><div class="invalid-feedback"></div>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">City <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control"
                id="city"  name="city"

                placeholder="City"><div class="invalid-feedback"></div>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">State / County</label>
            <input
                type="text"
                class="form-control"
                id="state"  name="state"

                placeholder="State / County"><div class="invalid-feedback"></div>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Postal Code <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control"
                id="postcode"  name="postcode"

                placeholder="Postcode"><div class="invalid-feedback"></div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Country <span class="text-danger">*</span></label>

            <select
                class="form-select"
                id="country" name="country"
>

                <option value="">Select Country</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Pakistan">Pakistan</option>

            </select><div class="invalid-feedback"></div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Delivery Notes</label>

            <textarea
                class="form-control"
                id="notes"
                rows="3" name="notes"

                placeholder="Any special delivery instructions..."></textarea><div class="invalid-feedback"></div>
        </div>

    </div>
</form>
</div>





<script>
const rules = {
    first_name: {
        regex: /^[a-zA-Z\s]{2,50}$/,
        message: "Please enter a valid first name."
    },

    last_name: {
        regex: /^[a-zA-Z\s]{2,50}$/,
        message: "Please enter a valid last name."
    },

    email: {
        regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        message: "Please enter a valid email address."
    },

    phone: {
        regex: /^[0-9+\-\s]{8,20}$/,
        message: "Please enter a valid phone number."
    },

    city: {
        regex: /^[a-zA-Z\s]{2,50}$/,
        message: "Please enter a valid city."
    },

    state: {
        regex: /^[a-zA-Z\s]{2,50}$/,
        message: "Please enter a valid state."
    },

    postcode: {
        regex: /^[A-Za-z0-9\s-]{3,12}$/,
        message: "Please enter a valid postal code."
    },

    address_1: {
        regex: /^.{5,200}$/,
        message: "Please enter a valid address."
    }
};

function validateField(field) {

    const name = field.name;

    if (!rules[name]) {
        return true;
    }

    const value = field.value.trim();

    const valid = rules[name].regex.test(value);

    field.classList.remove("is-valid", "is-invalid");

    if (valid) {
        field.classList.add("is-valid");
        field.nextElementSibling.innerText = "";
    } else {
        field.classList.add("is-invalid");
        field.nextElementSibling.innerText =
            rules[name].message;
    }

    return valid;
}

document.querySelectorAll(
    "#bundleUserForm input, #bundleUserForm select"
).forEach(field => {

    field.addEventListener("keyup", function () {
        validateField(this);
    });

    field.addEventListener("change", function () {
        validateField(this);
    });
});


function validateBundleForm() {

    let valid = true;

    document.querySelectorAll(
        "#bundleUserForm input, #bundleUserForm select"
    ).forEach(field => {

        if (
            field.name === "company" ||
            field.name === "address_2" ||
            field.name === "notes"
        ) {
            return;
        }

        if (!validateField(field)) {
            valid = false;
        }
    });

    return valid;
}

</script>

