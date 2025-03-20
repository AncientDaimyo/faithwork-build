<!-- src/components/PlayingCard.vue -->
<template>
    <div class="card">
      <img v-if="card.image" :src="card.image" :alt="card.name" />
      <span>{{ card.name }}</span>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      card: {
        type: Object,
        required: true,
      },
    },
  };
  </script>
  
  <style scoped>
  .card {
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 10px;
    text-align: center;
    width: 80px;
    height: 120px; /* Высота карточки */
    margin: 10px;
    background-color: #fff;
    transition: transform 0.2s;
  }
  
  .card img {
    width: 100%;
    height: auto;
  }
  
  .card:hover {
    transform: scale(1.05);
  }
  </style>