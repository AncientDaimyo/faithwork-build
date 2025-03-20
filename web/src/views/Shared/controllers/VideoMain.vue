<template>
    <section class="video_section">
      <video
        id="video_main_autoplay"
        :style="videoStyle"
        loop
        preload="auto"
        autoplay
        muted
      >
        <source src="../video/IMG_0852.mp4" type="video/mp4">
      </video>
    </section>
  </template>
  
  <script setup>
  import { ref, onMounted, onUnmounted } from 'vue';
  
  const videoStyle = ref({
    width: '100vw',
    height: '85vh',
    objectFit: 'cover'
  });
  
  const updateVideoSize = () => {
    videoStyle.value = {
      width: '100vw',
      height: '85vh',
      objectFit: 'cover'
    };
  };
  
  onMounted(() => {
    updateVideoSize();
    window.addEventListener('resize', updateVideoSize);
  });
  
  onUnmounted(() => {
    window.removeEventListener('resize', updateVideoSize);
  });
  </script>