@extends('layout.Main')

@section('content')
   <style>
.faq-section .accordion-button{
    font-weight:600;
    color:#111;
    background:#fff;
    box-shadow:none;
}

.faq-section .accordion-button:not(.collapsed){
    background:#f9fff0;
    color:#000;
}

.faq-section .accordion-item{
    border-radius:12px;
    overflow:hidden;
    border:1px solid #eee;
}
</style>
 <main class="main-wrapper">
      <section class="title-banner">
                <div class="container">
                    <h2 class="white fw-600 text-center">Frequently Asked Questions</h2>
                </div>
            </section>
<!-- FAQ SECTION START -->
<section class="faq-section py-40">
    <div class="container">

        <div class="mb-32">
            <h2 class="fw-600 black mb-12" style="color:#9eef0b;">Frequently Asked Questions</h2>
            <p style="color: #bab4b4;">Find answers to the most common questions about Slimza and our wellness products.</p>
        </div>

        <div class="accordion" id="faqAccordion">

            <!-- Q1 -->
            <div class="accordion-item mb-12">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        What is Slimza?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Slimza is a wellness brand focused on providing premium health and wellbeing products
                        designed to support healthier lifestyles, confidence, and everyday wellness naturally.
                    </div>
                </div>
            </div>

            <!-- Q2 -->
            <div class="accordion-item mb-12">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        Why choose natural wellness products?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Natural wellness solutions support long-term lifestyle habits and overall wellbeing.
                        They help maintain balance through nutrition, hydration, and healthy routines.
                    </div>
                </div>
            </div>

            <!-- Q3 -->
            <div class="accordion-item mb-12">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        Are natural wellness solutions safer than injections?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Natural wellness products are often preferred for long-term lifestyle support.
                        They are designed to complement healthy habits and overall wellbeing routines.
                    </div>
                </div>
            </div>

            <!-- Q4 -->
            <div class="accordion-item mb-12">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                        Are Slimza products high quality?
                    </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes. Slimza products are carefully selected with a focus on quality, safety,
                        effectiveness, and customer satisfaction.
                    </div>
                </div>
            </div>

            <!-- Q5 -->
            <div class="accordion-item mb-12">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                        Who can use Slimza products?
                    </button>
                </h2>
                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Slimza products are designed for adults who want to improve their health and lifestyle.
                        Always follow usage guidelines and consult a professional if needed.
                    </div>
                </div>
            </div>

            <!-- Q6 -->
            <div class="accordion-item mb-12">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                        How long does it take to see results?
                    </button>
                </h2>
                <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Results vary based on lifestyle, consistency, and personal goals.
                        Wellness is a long-term journey that requires consistency.
                    </div>
                </div>
            </div>

            <!-- Q7 -->
            <div class="accordion-item mb-12">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                        Do I need exercise and a healthy diet?
                    </button>
                </h2>
                <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes. Products work best when combined with a balanced diet, exercise,
                        hydration, sleep, and healthy routines.
                    </div>
                </div>
            </div>

            <!-- Q8 -->
            <div class="accordion-item mb-12">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                        Does Slimza offer customer support?
                    </button>
                </h2>
                <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes. We provide dedicated customer support to ensure a smooth shopping experience
                        and assist with any queries.
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
<!-- FAQ SECTION END -->  </main>

@endsection