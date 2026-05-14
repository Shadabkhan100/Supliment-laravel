





 <!-- SALE BANNER START -->
<section class="sale-banner py-40">
  <div class="container-fluid">
    
    <div class="sale-block p-24"
      style="
        background-image: url('/images/home/clock.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 400px;
        display: flex;
        align-items: center;
      ">

      <div class="row w-100">
        <div class="col-lg-6 col-md-8">

          <div class="sale-text d-flex flex-column gap-32">

         

            <ul class="unstyled countdown d-flex align-items-stretch gap-16" style="margin-top: 91px;justify-content: center;">
              <li><h3>365</h3><p>Days</p></li>
              <li><h3>24</h3><p>Hrs</p></li>
              <li><h3>60</h3><p>Min</p></li>
              <li><h3>60</h3><p>Secs</p></li>
            </ul>

          </div>

        </div>
      </div>

    </div>

  </div>
</section>



<div class="full-image-wrapper">

    <img src="{{ asset('images/home/footer.jpg') }}"
         alt="Coming Soon">

</div>

<style>

.full-image-wrapper{
    width: 100%;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px;
    background: #000;
    overflow: hidden;
}

.full-image-wrapper img{
    width: 100%;
    max-width: 1400px;
    height: auto;
    max-height: 90vh;
    object-fit: contain;
    display: block;
}

/* TABLET */
@media (max-width: 992px){

    .full-image-wrapper{
        min-height: auto;
        padding: 20px;
    }

    .full-image-wrapper img{
        width: 100%;
        max-height: 80vh;
    }

}

/* MOBILE */
@media (max-width: 576px){

    .full-image-wrapper{
        padding: 15px;
    }

    .full-image-wrapper img{
        width: 100%;
        max-height: 70vh;
    }

}

</style>
<!-- SALE BANNER END -->