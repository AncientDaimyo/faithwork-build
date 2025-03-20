<!-- src/components/Gambling.vue -->
<template>
    <HeaderCommon />
    <div class="grid">
      <div class="row" v-for="rowIndex in rows" :key="rowIndex">
        <PlayingCard v-for="(card, index) in getRowCards(rowIndex)" :key="index" :card="card" />
      </div>
    </div>
    <FooterSecond />
  </template>
  
  <script>
  import { useGamblingStore } from '../../../stores/gambling.js'; // Импортируем хранилище
  import HeaderCommon from '../../Shared/controllers/HeaderCommon.vue'; // Импортируем хедер
  import FooterSecond from '../../Shared/controllers/FooterSecond.vue'; // Импортируем футер
  import PlayingCard from './PlayingCard.vue'; // Импортируем компонент PlayingCard
  
  export default {
    components: {
      HeaderCommon,
      FooterSecond,
      PlayingCard,
    },
    setup() {
      const gamblingStore = useGamblingStore();
      gamblingStore.loadCardImages(); // Загружаем изображения карт
      const rows = 4; // Количество рядов
  
      const getRowCards = (rowIndex) => {
        const start = (rowIndex - 1) * 13;
        return gamblingStore.cards.slice(start, start + 13);
      };
  
      return { getRowCards, rows };
    },
  };
  </script>
  
  <style lang="scss">
  .grid {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .row {
    display: flex;
    justify-content: center;
  }
  </style>