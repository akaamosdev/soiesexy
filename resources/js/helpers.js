import { reactive } from 'vue';

const state = reactive({
    visible: false,
    message: '',
    timeoutMs: 3000
});

let hideTimer = null;

export function showToast(message, durationMs = 3000) {
    state.message = message;
    state.timeoutMs = durationMs;
    state.visible = true;

    if (hideTimer) clearTimeout(hideTimer);
    hideTimer = setTimeout(() => {
        state.visible = false;
        hideTimer = null;
    }, durationMs);
}

export function hideToast() {
    state.visible = false;
    if (hideTimer) {
        clearTimeout(hideTimer);
        hideTimer = null;
    }
}

export function useToastStore() {
    return state;
}
