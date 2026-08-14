<meta name="csrf-token" content="{{ csrf_token() }}">
<style>


#stepTitle{
    color: #496d09;
}
#stepDesc{
font-size:13px;  margin:0;
color:black;
}
body.checkout-open {
    overflow: hidden;
}
.checkout-box input {
  position: relative;
  z-index: 1;
}
#checkoutModal {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.6);
  z-index: 11000;
  display: none;pointer-events: auto;
}

/* WHEN ACTIVE */
#checkoutModal.active {
  display: block;
}

/* BOTTOM SHEET */
.checkout-box {
  position: fixed;
  left: 0;
  bottom: -100%;
  width: 100%;
  max-width: 100%;
  background: white;
  color: #000000;
  border-radius: 18px 18px 0 0;
  padding: 20px;

  box-shadow: 0 -10px 30px rgba(#0a0b09);
  transition: all 0.35s ease-in-out;
  /* ✅ FIX ADDED */
  display: flex;
  flex-direction: column;
  max-height: 90vh;z-index: 100000;
  pointer-events: auto;
}

/* SLIDE UP ANIMATION */
#checkoutModal.active .checkout-box {
  bottom: 0;
}

/* HEADER */
.checkout-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;

  /* FIX */
  flex-shrink: 0;
}

/* CLOSE BUTTON */
.close-btn {
  font-size: 22px;
  cursor: pointer;
  color: black;
  background: transparent;
  border: none;
}

/* STEPS */
.step input {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border-radius: 8px;
  border: 1px solid #333;
  background: #000;
  color: #fff;
}

/* BUTTONS */
.actions {
  margin-top: 15px;
  display: flex;
  justify-content: space-between;

  /* FIX */
  flex-shrink: 0;
}

.actions button {
  padding: 10px 15px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

#nextBtn {
  background: #9eef0b;
  color: #000;
}

#prevBtn {
  background: #333;
  color: #fff;
}

/* ✅ SCROLL FIX ADDED */
.checkout-content {
  overflow-y: auto;
  flex: 1;
  padding-right: 5px;
  -webkit-overflow-scrolling: touch;
}

/* optional scrollbar */
.checkout-content::-webkit-scrollbar {
  width: 4px;
}
.checkout-content::-webkit-scrollbar-thumb {
  background: #9eef0b;
  border-radius: 10px;
}

#productQuickView.checkout-hidden {
    pointer-events: none;
    opacity: 0.3;
}
.checkout-box input,
.checkout-box textarea {
  pointer-events: auto;
  user-select: text;
}
#checkoutModal {
  pointer-events: auto;
}
</style>




<meta name="csrf-token" content="{{ csrf_token() }}">
<div id="checkoutModal">

  <div class="checkout-box">

    <!-- HEADER -->
    <div class="checkout-header">
      <div>
        <h4 id="stepTitle" style="margin:0;">Contact Details</h4>

        <p id="stepDesc" >
          Enter your basic contact information
        </p>
      </div>

      <button class="close-btn" onclick="closeCheckoutModal()">✕</button>
    </div>

    <!-- ✅ SCROLLABLE AREA WRAPPER ADDED -->
    <div class="checkout-content">

      <!-- STEP 1 -->
      <div class="step step-1">
        <input type="text" id="name" placeholder="Full Name" required>
        
        <input type="email" id="email" placeholder="Email Address" required>
        
        <input type="text" id="phone" placeholder="Phone Number" required>
      </div>

      <!-- STEP 2 -->
      <div class="step step-2" style="display:none;">
        <input type="text" id="address1" placeholder="Address Line 1" required>
        <input type="text" id="city" placeholder="City" required>
        <input type="text" id="postal" placeholder="Postal Code" required>

<small id="postal-error" style="color:red;display:none;">
    Please enter the correct postal code.
</small> 



        <input type="text" id="country" placeholder="Country" required>
      </div>
       <!-- STEP 3 (MAP LOCATION) -->
   <div class="step step-3" style="display:none;">

     <h3 style="color:black; margin-bottom:10px;">Select Delivery Location</h3>

      <div id="map" style="width:100%; height:250px; border-radius:12px;"></div>

      <p style="margin-top:10px; font-size:13px; color:Black;">
      Disclamer! Please Confirm Your Exact Location.
      </p>

      <p id="selectedCoords" style="margin-top:5px; color:#Black;"></p>

    </div>


      <!-- STEP 3 -->
      <div class="step step-4 text-center" style="display:none;">
        <h2 style="color:#9eef0">Review Your Order.</h2>
        <div id="orderSummary"></div>

        <div id="loaderBox">
          <p style="margin-bottom:10px;">Preparing your order...</p>

          <div style="width:100%; background:#333; height:8px; border-radius:10px;">
            <div id="loaderBar" style="width:0%; height:100%; background:#9eef0b; transition:0.3s;"></div>
          </div>
        </div>
      </div>

    </div>




    <span id="inputError" class="text-danger"></span>
    <!-- BUTTONS -->
    <div class="actions">
      <button id="prevBtn" style="display:none;">Back</button>
      <button id="nextBtn">Next</button>
    </div>

  </div>
</div>



<script>

window.authUser = @json($authUser);
window.currencyConfig = @json(config('currency'));
window.currentCurrency = "{{ session('currency', 'GBP') }}";
window.currencyConfig = @json(config('currency'));
window.currentCurrency = "{{ session('currency', 'GBP') }}";

function formatPrice(price) {

  const currency = window.currentCurrency || window.currencyConfig.default || "GBP";

  const config = window.currencyConfig?.currencies?.[currency];

  if (!config) {
    console.warn("Currency not found:", currency);
    return `£ ${price}`;
  }

  const converted = price * config.rate;

  return `${config.symbol} ${converted.toFixed(2)}`;
}





localStorage.removeItem("checkout_cart");
document.getElementById("productQuickView")?.classList.add("checkout-hidden");
document.getElementById("productQuickView")?.classList.remove("checkout-hidden");
let currentStep = 1;

function showLoader() {
  let bar = document.getElementById("loaderBar");
  let width = 0;

  const interval = setInterval(() => {
    width += 10;
    bar.style.width = width + "%";

    if (width >= 100) {
      clearInterval(interval);
    }
  }, 100);
}



let map, marker;
let selectedLat = null;
let selectedLng = null;

function initMap() {

  if (map) return;

  map = L.map('map').setView([24.7136, 46.6753], 10);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: ''
  }).addTo(map);

  map.on('click', function (e) {

    selectedLat = e.latlng.lat;
    selectedLng = e.latlng.lng;

    document.getElementById("selectedCoords").innerText =
      `Selected: ${selectedLat.toFixed(5)}, ${selectedLng.toFixed(5)}`;

    if (marker) {
      marker.setLatLng(e.latlng);
    } else {
      marker = L.marker(e.latlng).addTo(map);
    }
  });
}


function updateMapLocation(lat, lng) {

    if (!map) {
        initMap();
    }

    map.setView([lat, lng], 15, {
        animate: true
    });

    if (marker) {
        marker.setLatLng([lat, lng]);
    } else {
        marker = L.marker([lat, lng]).addTo(map);
    }
    updateLocationName(lat,lng);
    
}


async function updateLocationName(lat, lng) {

    try {

        const response = await fetch(
            `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=jsonv2&addressdetails=1`
        );

        const data = await response.json();

        document.getElementById("selectedCoords").innerText =
            data.display_name || "Location not found";

    } catch (error) {

        document.getElementById("selectedCoords").innerText =
            "Unable to determine location.";

        console.error(error);
    }
}




window.fillAuthUserData = function () {
    const user = window.authUser;
    
    if (!user) return;

    const setValue = (id, value) => {
        const el = document.getElementById(id);
        if (!el) return;
        el.value = value ?? '';
    };

    setValue("name", user.name);
    setValue("email", user.email);
    setValue("phone", user.phone);
    setValue("address1", user.address1);
    setValue("city", user.city);
    setValue("country", user.country);
}


document.addEventListener("click", function (e) {

  if (e.target.id === "nextBtn") goNextStep();
  if (e.target.id === "prevBtn") goPrevStep();

});
async function goNextStep() {

    window.fillAuthUserData();

    if (currentStep === 1) {

        // Check if any Step 1 information is empty
        const inputs = document.querySelectorAll(
            ".step-1 input, .step-1 select, .step-1 textarea"
        );

        let isValid = true;

        inputs.forEach(function (input) {
            if (input.value.trim() === "") {
                isValid = false;
            }
        });

        // Show error if any field is empty
        if (!isValid) {
            document.getElementById("inputError").innerText =
                "Please fill all the information.";
            return;
        }

        // Clear previous error
        document.getElementById("inputError").innerText = "";

        document.querySelector(".step-1").style.display = "none";
        document.querySelector(".step-2").style.display = "block";

        document.getElementById("stepTitle").innerText = "Address Details";
        document.getElementById("stepDesc").innerText = "Enter your delivery address";

        document.getElementById("prevBtn").style.display = "inline-block";
        currentStep = 2;
        return;
    }


    // STEP 2 → MAP
    if (currentStep === 2) {

        // Check Step 2 address information
        const addressFields = [
            document.getElementById("address1"),
            document.getElementById("city"),
            document.getElementById("postal"),
            document.getElementById("country")
        ];

        let isValid = true;

        addressFields.forEach(function (input) {

            if (!input || input.value.trim() === "") {
                isValid = false;
            }

        });

        // Show error if any address field is empty
        if (!isValid) {
            document.getElementById("inputError").innerText =
                "Please fill all the information.";
            return;
        }

        // Clear previous error
        document.getElementById("inputError").innerText = "";

        saveToLocalStorage();

        document.querySelector(".step-2").style.display = "none";
        document.querySelector(".step-3").style.display = "block";

        document.getElementById("stepTitle").innerText = "Select Location";
        document.getElementById("stepDesc").innerText = "Pick your delivery location";

        initMap(); // load map

        currentStep = 3;
        return;
    }


    // MAP → FINAL REVIEW
    if (currentStep === 3) {

        if (!selectedLat || !selectedLng) {
            alert("Please select location on map");
            return;
        }

        // store location
        const cart = JSON.parse(localStorage.getItem("checkout_cart")) || {};
        cart.location = { lat: selectedLat, lng: selectedLng };
        localStorage.setItem("checkout_cart", JSON.stringify(cart));

        // move to review
        document.querySelector(".step-3").style.display = "none";
        document.querySelector(".step-4").style.display = "block";

        document.getElementById("stepTitle").innerText = "";
        document.getElementById("stepDesc").innerText = "";

        showLoader();
        loadFinalReview();

        currentStep = 4;
        const nextBtn = document.getElementById("nextBtn");

        nextBtn.innerHTML = `
            <i class="fas fa-lock"></i>
            Secure Pay`;

        return;
    }


    if (currentStep === 4) {

        const nextBtn = document.getElementById("nextBtn");

        const cart = JSON.parse(localStorage.getItem("checkout_cart"));

        const payload = {

            name: document.getElementById("name")?.value || "",
            email: document.getElementById("email")?.value || "",
            phone: document.getElementById("phone")?.value || "",
            currency: window.currentCurrency,
            address1: document.getElementById("address1")?.value || "",
            city: document.getElementById("city")?.value || "",
            postal: document.getElementById("postal")?.value || "",
            country: document.getElementById("country")?.value || "",
            product_id: cart.product.id,
            quantity: cart.product.quantity,
            purchase_type: cart.product.purchase_type,
            option: cart.product.option,
            lat: selectedLat,
            lng: selectedLng,

            product: {
                product_id: cart.product.id,
                quantity: cart.product.quantity,
                purchase_type: cart.product.purchase_type,
                option: cart.product.option
            }
        };

        nextBtn.disabled = true;
        nextBtn.classList.add("loading");

        nextBtn.innerHTML = `
            <span class="btn-spinner"></span>
            Creating Order...
        `;


        try {

            const res = await fetch("/create-product-order", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content")
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json().catch(() => null);


            if (!res.ok) {
                throw data;
            }


            if (data?.status) {

                const orderId = data.order_id;
                const total = data.total_price || 0;
                const type = data.type;

                if (!orderId) {

                    Swal.fire({
                        icon: "error",
                        title: "Order Error",
                        text: "No order was created."
                    });

                    return;
                }

                window.location.href =
                    `/stripe/checkout?order_ids=${orderId}&total=${total}&type=${type}`;

                return;
            }


            throw data;

        } catch (err) {

            console.error(err);

            nextBtn.disabled = false;
            nextBtn.classList.remove("loading");

            nextBtn.innerHTML = `
                <i class="fas fa-lock"></i>
                Secure Pay
            `;

            Swal.fire({
                icon: "error",
                title: "Order Failed",
                text: err?.message || "Something went wrong"
            });
        }

        return;
    }

}










function resetCheckout() {
  currentStep = 1;
  const nextBtn = document.getElementById("nextBtn");

nextBtn.disabled = false;
nextBtn.classList.remove("loading");
nextBtn.innerHTML = "Next";
  // reset inputs
  document.querySelectorAll("#checkoutModal input").forEach(input => {
    input.value = "";
  });

  // reset steps visibility
  document.querySelector(".step-1").style.display = "block";
  document.querySelector(".step-2").style.display = "none";
  document.querySelector(".step-3").style.display = "none";
  document.querySelector(".step-4").style.display = "none";

  // reset UI text
  document.getElementById("stepTitle").innerText = "Contact Details";
  document.getElementById("stepDesc").innerText = "Enter your basic contact information";

  document.getElementById("prevBtn").style.display = "none";

  // reset map state
  selectedLat = null;
  selectedLng = null;

  const coordBox = document.getElementById("selectedCoords");
  if (coordBox) coordBox.innerText = "";

  if (marker && map) {
    map.removeLayer(marker);
    marker = null;
  }

  // reset loader
  const loaderBox = document.getElementById("loaderBox");
  if (loaderBox) loaderBox.style.display = "block";

  const bar = document.getElementById("loaderBar");
  if (bar) bar.style.width = "0%";

  document.getElementById("orderSummary").innerHTML = "";

  // remove stored checkout data
  localStorage.removeItem("checkout_cart");
}
function goPrevStep() {

  if (currentStep === 2) {
    document.querySelector(".step-2").style.display = "none";
    document.querySelector(".step-1").style.display = "block";

    document.getElementById("stepTitle").innerText = "Contact Details";
    document.getElementById("stepDesc").innerText = "Enter your basic contact information";

    document.getElementById("prevBtn").style.display = "none";
    currentStep = 1;
    return;
  }

  // BACK FROM MAP → ADDRESS
  if (currentStep === 3) {
    document.querySelector(".step-3").style.display = "none";
    document.querySelector(".step-2").style.display = "block";

    document.getElementById("stepTitle").innerText = "Address Details";
    currentStep = 2;
    return;
  }

  // BACK FROM REVIEW → MAP
  if (currentStep === 4) {
    document.querySelector(".step-4").style.display = "none";
    document.querySelector(".step-3").style.display = "block";

    currentStep = 3;
    
    return;
  }
}

function saveToLocalStorage() {

  const existingCart =
      JSON.parse(localStorage.getItem("checkout_cart")) || {};

  existingCart.user = {
      name: document.getElementById("name").value,
      email: document.getElementById("email").value,
      phone: document.getElementById("phone").value,
      address1: document.getElementById("address1").value,
      city: document.getElementById("city").value,
      postal: document.getElementById("postal").value,
      country: document.getElementById("country").value,
  };

  localStorage.setItem(
      "checkout_cart",
      JSON.stringify(existingCart)
  );
}

function loadFinalReview() {

  const cart = JSON.parse(localStorage.getItem("checkout_cart"));
  if (!cart || !cart.product.id) return;

  fetch(`/api/get-product-by-id/${cart.product.id}`)
    .then(res => res.json())
    .then(data => {

      const product = data.data;

      document.getElementById("loaderBox").style.display = "none";

      const option = cart.product.option || null;

      // ✅ FINAL PRICE LOGIC
      const finalPrice = (option && option.price)
        ? option.price
        : product.price;

      document.getElementById("orderSummary").innerHTML = `
    <div style="color:#fff; font-family:Arial;">

  <!-- PRODUCT CARD -->
  <div style="background:#0d0d0d; border:1px solid #222; border-radius:14px; overflow:hidden; margin-bottom:15px;">

    <img src="${product.main_image}" 
      style="width:100%; height:200px; object-fit:contain; background:#111; padding:10px;" />

    <div style="padding:15px;">

      <h3 style="margin:0 0 8px 0; color:#9eef0b; font-size:18px;">
        ${product.name}
      </h3>

      <p style="margin:0; font-size:13px; color:#aaa; line-height:1.4;">
        ${product.description ? product.description.substring(0,120) + "..." : ""}
      </p>

      <!-- ✅ PRICE ALWAYS SHOWN -->
      <p style="margin-top:10px; font-size:16px;">
        <b>Price:</b> <span style="color:#9eef0b;">${formatPrice(finalPrice)}</span>
      </p>

    </div>
  </div>

  <!-- OPTION CARD -->
  <div style="background:#0d0d0d; border:1px solid #222; border-radius:14px; padding:15px; margin-bottom:15px;">

    <h4 style="margin:0 0 10px 0; color:#9eef0b; font-size:15px;">
      Selected Option
    </h4>

    ${
      option && Object.keys(option).length > 0
        ? `
        <div style="display:flex; align-items:center; gap:12px;">

          ${option.image ? `
            <img src="${option.image}" 
              style="width:55px;height:55px;object-fit:cover;border-radius:10px;border:1px solid #333;">
          ` : ""}

          <div>
            <p style="margin:0; font-size:14px;">
              <b>Pack:</b> ${option.pack || '-'}
            </p>

            <p style="margin:0; font-size:14px;">
              <b>Price:</b> <span style="color:#9eef0b;">${formatPrice(option.price)}</span>
            </p>

            <p style="margin:0; font-size:13px; color:#aaa;">
              Duration: ${option.duration || '-'} days
            </p>
          </div>

        </div>
        `
        : `<p style="color:#999;">No option selected</p>`
    }

  </div>

  <!-- ORDER DETAILS -->
  <div style="background:#0d0d0d; border:1px solid #222; border-radius:14px; padding:15px; margin-bottom:15px;">

    <h4 style="margin:0 0 10px 0; color:#9eef0b; font-size:15px;">
      Order Details
    </h4>

    <p style="margin:5px 0;"><b>Quantity:</b> ${cart.product.quantity}</p>
    <p style="margin:5px 0;"><b>Type:</b> ${cart.product.purchase_type}</p>

  </div>

  <!-- CUSTOMER -->
  <div style="background:#0d0d0d; border:1px solid #222; border-radius:14px; padding:15px;">

    <h4 style="margin:0 0 12px 0; color:#9eef0b; font-size:15px;">
      Customer Information
    </h4>

    <p><b>Name:</b> ${cart.user.name}</p>
    <p><b>Email:</b> ${cart.user.email}</p>
    <p><b>Phone:</b> ${cart.user.phone}</p>

    <p style="margin-top:10px; font-size:13px; color:#aaa;">
      ${cart.user.address1}, ${cart.user.city}<br>
      ${cart.user.postal}, ${cart.user.country}
    </p>

  </div>

</div>
`;
    });
}





document.getElementById("postal").addEventListener("change", async function () {
    const postal = this.value.trim();
    const country = document.getElementById("country").value.trim();
  



    if (!postal) return;

    try {
        const response = await fetch(
            `https://nominatim.openstreetmap.org/search?postalcode=${encodeURIComponent(postal)}&country=${encodeURIComponent(country)}&format=jsonv2&limit=1`
        );

        const data = await response.json();

        if (data.length === 0) {
            this.style.border = "2px solid red";
            showPostalError("Please try another postal code.");
            return;
        }

        this.style.border = "2px solid #28a745";
        removePostalError();

        selectedLat = parseFloat(data[0].lat);
        selectedLng = parseFloat(data[0].lon);

        updateMapLocation(selectedLat, selectedLng);

    } catch (e) {
        console.error(e);
        showPostalError("Unable to verify postal code.");
    }
});





function showPostalError(message) {
    const error = document.getElementById("postal-error");
    error.innerText = message;
    error.style.display = "block";
}

function removePostalError() {
    document.getElementById("postal-error").style.display = "none";
}

</script>    