import { defineStore } from "pinia";

export const useCartStore = defineStore("cartStore", {
  state: () => ({
    cartItems: JSON.parse(localStorage.getItem("cartItems")) || [],
  }),
  getters: {
    getCartItems(state) {
      return state.cartItems;
    },
    cartTotalPrice(state) {
      return state.cartItems.reduce((total, item) => {
        return total + item.product.cost * item.quantity;
      }, 0);
    },
    // Добавляем геттер для проверки наличия товара с выбранным размером
    hasItemWithSize(state) {
      return (productUuid, size) => {
        return state.cartItems.some(
          (item) => item.product.uuid === productUuid && item.size === size
        );
      };
    },
  },
  actions: {
    // Добавление товара в корзину
    addToCart(product, sizeSelected) {
      const existingItem = this.cartItems.find(
        (item) => item.product.uuid === product.uuid && item.size === sizeSelected
      );

      if (existingItem) {
        existingItem.quantity++;
      } else {
        this.cartItems.push({
          product,
          size: sizeSelected,
          quantity: 1,
        });
      }

      this.saveCartToLocalStorage(); // Сохраняем изменения
    },
    // Удаление товара из корзины
    removeFromCart(productUuid, size) {
      this.cartItems = this.cartItems.filter(
        (item) => !(item.product.uuid === productUuid && item.size === size)
      );
      this.saveCartToLocalStorage(); // Сохраняем изменения
    },
    // Увеличение количества товара
    increaseQuantity(productUuid, size) {
      const item = this.cartItems.find(
        (item) => item.product.uuid === productUuid && item.size === size
      );
      if (item) {
        item.quantity++;
        this.saveCartToLocalStorage(); // Сохраняем изменения
      }
    },
    // Уменьшение количества товара
    decreaseQuantity(productUuid, size) {
      const item = this.cartItems.find(
        (item) => item.product.uuid === productUuid && item.size === size
      );
      if (item && item.quantity > 1) {
        item.quantity--;
      } else {
        this.removeFromCart(productUuid, size); // Удаляем товар, если количество 0
      }
      this.saveCartToLocalStorage(); // Сохраняем изменения
    },
    // Полная очистка корзины
    clearCart() {
      this.cartItems = []; // Очищаем массив
      this.saveCartToLocalStorage(); // Сохраняем изменения
    },
    // Сохранение корзины в localStorage
    saveCartToLocalStorage() {
      localStorage.setItem("cartItems", JSON.stringify(this.cartItems));
    },
  },
});