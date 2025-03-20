import { defineStore } from 'pinia';

export const useBurgerMenuStore = defineStore('menu', {
  state: () => ({
    isOpen: false,
  }),
  actions: {
    toggle() {
      this.isOpen = !this.isOpen;
    },
  },
});