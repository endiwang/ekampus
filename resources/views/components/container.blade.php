<div id="{{ $name ?? str()->random() }}_app_content" class="app-content flex-column-fluid">
    <div id="{{ $name ?? str()->random() }}_app_content_container" class="app-container container-xxl">
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-body py-5">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
