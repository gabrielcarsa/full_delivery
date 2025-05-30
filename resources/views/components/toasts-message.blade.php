@props(['type' => '', 'message' => ''])
<div class="toast m-3 p-3 end-0 top-0 fixed-top show align-items-center {{ $type == 'danger' ? 'text-bg-danger' : 'text-bg-success' }} border-0" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body fs-6 fw-semibold">
            {{ $message }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
            aria-label="Close"></button>
    </div>
</div>