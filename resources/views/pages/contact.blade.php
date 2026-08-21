 @extends('layout.Main')

@section('content')

 <!-- CONTACT SECTION START -->
            <section class="contact-section py-80">
                <div class="container-fluid">
                    <div class="row row-gap-4 mb-80">
                      <div class="col-xl-6">
    <div class="schedule-container">
        <h4 class="fw-600 white mb-12">Open Hours</h4>
      
        <!-- Monday -->
        <div class="time-block mb-24">
            <div class="time-icon">
                <!-- SVG unchanged -->
            </div>
            <h6 class="fw-600 white">
                Monday <span class="text-16 white">10:00 AM - 3:00 PM</span>
            </h6>
        </div>

        <!-- Tuesday -->
        <div class="time-block mb-24">
            <div class="time-icon"></div>
            <h6 class="fw-600 white">
                Tuesday <span class="text-16 white">10:00 AM - 3:00 PM</span>
            </h6>
        </div>

        <!-- Wednesday -->
        <div class="time-block mb-24">
            <div class="time-icon"></div>
            <h6 class="fw-600 white">
                Wednesday <span class="text-16 white">10:00 AM - 3:00 PM</span>
            </h6>
        </div>

        <!-- Thursday -->
        <div class="time-block mb-24">
            <div class="time-icon"></div>
            <h6 class="fw-600 white">
                Thursday <span class="text-16 white">10:00 AM - 3:00 PM</span>
            </h6>
        </div>

        <!-- Friday -->
        <div class="time-block mb-24">
            <div class="time-icon"></div>
            <h6 class="fw-600 white">
                Friday <span class="text-16 white">10:00 AM - 3:00 PM</span>
            </h6>
        </div>

        <!-- Saturday -->
        <div class="time-block mb-24">
            <div class="time-icon"></div>
            <h6 class="fw-600 white">
                Saturday <span class="text-16 text-danger">Closed</span>
            </h6>
        </div>

        <!-- Sunday -->
        <div class="time-block">
            <div class="time-icon"></div>
            <h6 class="fw-600 white">
                Sunday <span class="text-16 text-danger">Closed</span>
            </h6>
        </div>

    </div>
</div>
                        <div class="col-xl-6">
                            <div class="schedule-container">
                                <h4 class="fw-600 white mb-12">Contact Us</h4>
                                                                                             <div class="time-block mb-24">
                                    <div class="time-icon">
                                        <svg class="svg-20" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M18.2422 2.96875H1.75781C0.786602 2.96875 0 3.76023 0 4.72656V15.2734C0 16.2455 0.792383 17.0312 1.75781 17.0312H18.2422C19.2053 17.0312 20 16.2488 20 15.2734V4.72656C20 3.76195 19.2165 2.96875 18.2422 2.96875ZM17.996 4.14062C17.6369 4.49785 11.4564 10.6458 11.243 10.8581C10.9109 11.1901 10.4695 11.3729 10 11.3729C9.53047 11.3729 9.08906 11.1901 8.75594 10.857C8.61242 10.7142 2.50012 4.63414 2.00398 4.14062H17.996ZM1.17188 15.0349V4.96582L6.23586 10.0031L1.17188 15.0349ZM2.00473 15.8594L7.06672 10.8296L7.9284 11.6867C8.48176 12.2401 9.21746 12.5448 10 12.5448C10.7825 12.5448 11.5182 12.2401 12.0705 11.6878L12.9333 10.8296L17.9953 15.8594H2.00473ZM18.8281 15.0349L13.7641 10.0031L18.8281 4.96582V15.0349Z" fill="#141516"></path>
                                        </svg>
                                    </div>
                                    <h6 class="fw-600 white">Email Address   <a href="mailto:example@sample.com" class="text-16 white">info@slimza.com</a></h6>
                                </div>
                              
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-80 p-3">
                        <div class="col-xl-6 col-lg-7 col-md-9 col-sm-10">
                            <h4 class="fw-600 white mb-12">Get in Touch</h4>
                           <form method="POST" action="/post-comment/contact" class="contact-form">
    @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-block mb-16">
                                            <input type="text" id="name" name="name" class="form-control" placeholder="Your Name" required=""  style="color:white;border:1px solid white;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                                <path d="M2.09731 19.3304L2.06728 19.6704H2.40859H17.5914H17.9327L17.9027 19.3304C17.5953 15.8501 14.6974 13.1079 11.1719 13.1079H8.82812C5.30261 13.1079 2.4047 15.8501 2.09731 19.3304ZM3.66148 14.7411L3.43883 14.5218L3.66148 14.7411C5.04733 13.3339 6.88146 12.561 8.82812 12.561H11.1719C13.1186 12.561 14.9527 13.3339 16.3385 14.7411C17.7179 16.1417 18.4766 17.9886 18.4766 19.9438C18.4766 20.0949 18.3541 20.2173 18.2031 20.2173H1.79688C1.64587 20.2173 1.52344 20.0949 1.52344 19.9438C1.52344 17.9886 2.28207 16.1417 3.66148 14.7411ZM5.03906 5.80322C5.03906 3.06804 7.26482 0.842285 10 0.842285C12.7352 0.842285 14.9609 3.06804 14.9609 5.80322C14.9609 8.53841 12.7352 10.7642 10 10.7642C7.26482 10.7642 5.03906 8.53841 5.03906 5.80322ZM5.58594 5.80322C5.58594 8.23741 7.56581 10.2173 10 10.2173C12.4342 10.2173 14.4141 8.23741 14.4141 5.80322C14.4141 3.36903 12.4342 1.38916 10 1.38916C7.56581 1.38916 5.58594 3.36903 5.58594 5.80322Z" fill="#464646" stroke="#464646" stroke-width="0.625"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-block mb-16">
                                            <input type="email" id="email" name="email" class="form-control" placeholder="Your Email" required style="color:white;border:1px solid white;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
                                                <path d="M18.2422 3.49854H1.75781C0.786602 3.49854 0 4.29002 0 5.25635V15.8032C0 16.7753 0.792383 17.561 1.75781 17.561H18.2422C19.2053 17.561 20 16.7786 20 15.8032V5.25635C20 4.29174 19.2165 3.49854 18.2422 3.49854ZM17.996 4.67041C17.6369 5.02764 11.4564 11.1756 11.243 11.3879C10.9109 11.7199 10.4695 11.9027 10 11.9027C9.53047 11.9027 9.08906 11.7199 8.75594 11.3868C8.61242 11.244 2.50012 5.16393 2.00398 4.67041H17.996ZM1.17188 15.5647V5.49561L6.23586 10.5329L1.17188 15.5647ZM2.00473 16.3892L7.06672 11.3594L7.9284 12.2165C8.48176 12.7699 9.21746 13.0746 10 13.0746C10.7825 13.0746 11.5182 12.7699 12.0705 12.2176L12.9333 11.3594L17.9953 16.3892H2.00473ZM18.8281 15.5647L13.7641 10.5329L18.8281 5.49561V15.5647Z" fill="#464646"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <textarea name="message" id="comment" cols="30" rows="5" class="form-control mb-16" placeholder="Write Your Comments..." style="color:white;border:1px solid white;"></textarea>
                                    </div>
                                    <div class="cus-checkBox mb-32">
                                        <input type="checkbox" id="remember" checked="" style="color:white;border:1px solid white;">
                                        <label for="remember" style="color:white;">Remember my details for future comments.</label>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="cus-btn-arrow">
                                            Send Comment
                                            <span class="icon">
                                                <i class="fa-thin fa-hand-point-left fa-rotate-90"></i>
                                            </span>
                                        </button>
                                    </div>
                                    <!-- Alert Message -->
                                    <div id="message" class="alert-msg"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="map">
                      <iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19800.07398248311!2d-0.1277583!3d51.5073509!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761b3333d2f1b7%3A0x8b5b6f7f8e4d7c9a!2sLondon%2C%20United%20Kingdom!5e0!3m2!1sen!2s!4v1733489233091!5m2!1sen!2s"
    width="100%"
    height="450"
    style="border:0;"
    allowfullscreen=""
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade">
</iframe>
                    </div>
                </div>
            </section>
            <!-- CONTACT SECTION END -->
@endsection




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
document.querySelector('.contact-form').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = this;
    const button = form.querySelector('button[type="submit"]');

    button.disabled = true;

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok && data.success) {

            Swal.fire({
                icon: 'success',
                title: 'Thank You!',
                text: data.message,
                confirmButtonText: 'OK'
            });

            form.reset();

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Something went wrong',
                text: data.message || 'Unable to submit your message.'
            });
        }

    } catch (error) {

        console.error(error);

        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong. Please try again.'
        });

    } finally {
        button.disabled = false;
    }
});
</script>