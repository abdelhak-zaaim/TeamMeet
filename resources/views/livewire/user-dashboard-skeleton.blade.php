<div class="dashboard-skeleton">
    <div class="card">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    @for ($i = 0; $i <= 3; $i++)
                        <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                            <div class="sub-card pulsate">
                            </div>
                        </div>
                    @endfor
                </div>

            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card-content">
                        <div class="block2 pulsate rounded-1"></div>
                        <div class="table pulsate rounded-1"> </div>
                        <div class="row">
                            @for ($i = 1; $i <= 16; $i++)
                                <div class="col-3 mb-5">
                                    <div class="dashboard-column-box  pulsate rounded-1"> </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-content">
                        <div class="block2 pulsate rounded-1"></div>
                        <div class="table pulsate rounded-1"> </div>
                        <div class="row">
                            @for ($i = 1; $i <= 16; $i++)
                                <div class="col-3 mb-5">
                                    <div class="dashboard-column-box pulsate rounded-1"> </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
