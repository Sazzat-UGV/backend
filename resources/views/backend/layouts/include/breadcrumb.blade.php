<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ $page_name }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    @if ($parent_page)
                        <li class="breadcrumb-item active">{{ $parent_page }}</li>
                    @endif
                    <li class="breadcrumb-item active">{{ $page_name }}</li>
                </ol>
            </div>

        </div>
    </div>
</div>
