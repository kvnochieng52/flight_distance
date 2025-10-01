<template>
  <div
    v-show="show"
    class="loading-bar"
    :style="{
      width: `${progress}%`,
      opacity: show ? 1 : 0,
      transition: 'width 300ms ease-out'
    }"
  ></div>
</template>

<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import { router } from '@inertiajs/vue3';

const progress = ref(0);
const show = ref(false);
let timeout = null;

function startProgress() {
  clearTimeout(timeout);
  show.value = true;
  progress.value = 0;

  timeout = setTimeout(() => {
    progress.value = 30;

    timeout = setTimeout(() => {
      progress.value = 60;

      timeout = setTimeout(() => {
        progress.value = 80;
      }, 100);
    }, 100);
  }, 100);
}

function finishProgress() {
  clearTimeout(timeout);
  progress.value = 100;

  setTimeout(() => {
    show.value = false;

    setTimeout(() => {
      progress.value = 0;
    }, 300);
  }, 300);
}

// Store the event listener functions
const eventListeners = [];

onMounted(() => {
  // Add start event listener
  const startListener = router.on('start', startProgress);
  eventListeners.push(startListener);

  // Add finish event listener
  const finishListener = router.on('finish', finishProgress);
  eventListeners.push(finishListener);
});

onUnmounted(() => {
  // Clear any pending timeouts
  clearTimeout(timeout);

  // In newer versions of Inertia, router.on returns a callback to remove the listener
  // Call all those callbacks to clean up
  eventListeners.forEach(removeListener => {
    if (typeof removeListener === 'function') {
      removeListener();
    }
  });
});
</script>

<style scoped>
.loading-bar {
  position: fixed;
  top: 0;
  left: 0;
  background-color: #007bff;
  height: 3px;
  z-index: 9999;
}
</style>