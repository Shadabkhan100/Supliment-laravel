@extends('layout.Main')

@section('content')
   
 <main class="main-wrapper">
 <section class="title-banner">
                <div class="container">
                    <h2 class="white fw-600 text-center">Return Policy</h2>
                </div>
            </section>

   <!-- RETURN & REFUND POLICY START -->
<section class="policy-section py-40">
    <div class="container">

        <div class="policy-box p-32 bg-white rounded-16 shadow-sm">

            <h2 class="fw-600 black mb-16">
                Return & Refund Policy
            </h2>

            <p class="mb-24">
                We want our customers to shop with confidence. Please read our returns policy carefully before making a purchase.
            </p>

            <!-- REPORT ISSUE -->
            <h5 class="fw-600 black mb-12">Reporting an Issue</h5>
            <p class="mb-24">
                If there is an issue with your order, customers must contact us within 24 hours of receiving the item.
            </p>

            <!-- RETURNS -->
            <h5 class="fw-600 black mb-12">Returns</h5>
            <p class="mb-12">
                Items can only be returned within 30 days of receiving your order.
            </p>

            <ul class="mb-24">
                <li>The item must be unopened</li>
                <li>The item must be unused</li>
                <li>The item must be in original condition</li>
                <li>Proof of purchase may be required</li>
            </ul>

            <!-- REFUNDS -->
            <h5 class="fw-600 black mb-12">Refunds</h5>

            <p class="mb-12">
                Refunds will only be processed once the returned item has been received and inspected.
            </p>

            <ul class="mb-24">
                <li>Item must pass inspection</li>
                <li>Must meet return eligibility conditions</li>
                <li>Non-compliant items will not be refunded</li>
            </ul>

            <!-- NON REFUNDABLE -->
            <h5 class="fw-600 black mb-12">Non-Refundable Items</h5>

            <ul class="mb-24">
                <li>Opened products</li>
                <li>Used products</li>
                <li>Damaged or altered items</li>
                <li>Late returns (after 30 days)</li>
            </ul>

            <!-- SHIPPING -->
            <h5 class="fw-600 black mb-12">Return Shipping</h5>
            <p class="mb-24">
                Customers may be responsible for return shipping costs unless the item is incorrect or damaged upon delivery.
            </p>

            <!-- ADDRESS -->
            <div class="p-20 rounded-12 mb-24" style="background:#f9fff0; border-left:4px solid #9eef0b;">
                <h6 class="fw-600 black mb-8">Return Address</h6>
                <p class="mb-0">
                    Slimza Returns<br>
                    PO BOX 18802<br>
                    SOLIHULL<br>
                    B90 9NP<br>
                    United Kingdom
                </p>
            </div>

            <!-- CONTACT -->
            <h5 class="fw-600 black mb-12">Contact Us</h5>
            <p class="mb-0">
                If you have any questions regarding returns or refunds, please contact our customer support team before returning any item.
            </p>

        </div>

    </div>
</section>
<!-- RETURN & REFUND POLICY END -->
  </main>

@endsection