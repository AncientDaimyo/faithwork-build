// src/store/gamblingStore.js
import { defineStore } from 'pinia';

export const useGamblingStore = defineStore('gambling', {
  state: () => ({
    // Состояние для отображения иконок карт
    showCardIcon: localStorage.getItem('showCardIcon') === 'true' || false,

    // Масти и значения карт
    suits: ['Club', 'Diamond', 'Heart', 'Spade'], // Убедитесь, что здесь указаны правильные масти
    values: [
      { name: 'Ace' },
      { name: 'Two' },
      { name: 'Three' },
      { name: 'Four' },
      { name: 'Five' },
      { name: 'Six' },
      { name: 'Seven' },
      { name: 'Eight' },
      { name: 'Nine' },
      { name: 'Ten' },
      { name: 'Jack' },
      { name: 'Queen' },
      { name: 'King' },
    ],
    cardImages: {},
  }),

  actions: {
    setShowCardIcon(value) {
      this.showCardIcon = value;
      localStorage.setItem('showCardIcon', value.toString());
    },

    async loadCardImages() {
      const images = import.meta.glob('../assets/playing_cards/*.svg');
      console.log('Available images:', images); // Вывод доступных изображений
      for (const suit of this.suits) {
        for (const value of this.values) {
          const imagePath = `../assets/playing_cards/${value.name.toLowerCase()}_${suit}.svg`;
          if (images[imagePath]) {
            this.cardImages[`${value.name} of ${suit}`] = await images[imagePath]();
            console.log(`Loaded image: ${imagePath}`); // Вывод загруженного изображения
          } else {
            console.warn(`Image not found: ${imagePath}`); // Предупреждение, если изображение не найдено
          }
        }
      }
    }
  },

  getters: {
    cards(state) {
      return state.values.flatMap(value =>
        state.suits.map(suit => ({
          name: `${value.name} of ${suit}`,
          image: state.cardImages[`${value.name} of ${suit}`] || '', // Использовать загруженные изображения
        }))
      );
    },
  },
});