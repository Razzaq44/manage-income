<div x-data="{ show: false, message: '', type: '' }"
    x-on:toast.window="
        message = $event.detail.message;
        type = $event.detail.type;
        show = true;
        setTimeout(() => show = false, 5000);
    "
    x-show="show" x-transition class="toast toast-end" x-cloak>
    <div class="alert" :class="'alert-' + type">
        <span x-text="message"></span>
    </div>
</div>
