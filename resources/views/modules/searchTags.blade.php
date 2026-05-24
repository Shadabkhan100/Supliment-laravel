@php
$tabs = [
    'cleanse-reset' => 'Cleanse & Reset',
    'daily-energy' => 'Daily Energy',
    'peak-performance' => 'Peak Performance',
    'radiance-beauty' => 'Radiance & Beauty',
    'total-wellness' => 'Total Wellness',
    'restore-renew' => 'Restore & Renew',
];
@endphp


<div class="d-flex align-items-start justify-content-between flex-lg-row flex-column pb-40">

    <ul class="tabs list-unstyled">
        @foreach($tabs as $slug => $name)
            <li class="tab-link {{ $loop->first ? 'active' : '' }}">
                <a href="{{ url('search-product/' . $slug) }}" style="color: inherit; text-decoration: none;">
                    {{ $name }}
                </a>
            </li>
        @endforeach
    </ul>

    <a href="{{ url('search-product/all') }}" class="cus-btn-arrow">
        See All Products
        <div class="icon">
            <i class="fa-light fa-chevron-right"></i>
        </div>
    </a>

</div>