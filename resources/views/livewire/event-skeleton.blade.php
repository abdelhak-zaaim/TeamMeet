<div class="listing-skeleton">
    <div class="card">
        <div class="card-content">
            <div class="d-flex justify-content-between align-items-end">
                <div class="skeleton-search-box pulsate rounded-1"> </div>
                <div class="d-flex">
                    <div class="add-button-box pulsate me-2 rounded-1"></div>
                </div>
            </div>
        </div>
        <div class="card-content my-5">
            <div class="row">
                @for ($i = 1; $i <= 6; $i++)
                    <div class="col-md-6 col-lg-6 col-12 col-xl-4">
                        <div class="event-box pulsate rounded-1"> </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>


