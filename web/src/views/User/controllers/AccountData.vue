<template>
  <div>
    <h2>ПЕРСОНАЛЬНАЯ ИНФОРМАЦИЯ</h2>
    <div class="form-group">
      <label for="firstName">Имя</label>
      <input type="text" id="firstName" v-model="userData.firstName">
    </div>
    <div class="form-group">
      <label for="lastName">Фамилия</label>
      <input type="text" id="lastName" v-model="userData.lastName">
    </div>
    <div class="form-group">
      <label for="birthdate">Дата рождения</label>
      <input type="date" id="birthdate" v-model="userData.birthdate">
    </div>
    <div class="form-group">
      <label for="email">E-mail</label>
      <input type="email" id="email" v-model="userData.email">
    </div>
    <div class="form-group">
      <label for="phone">Номер телефона</label>
      <input type="tel" id="phone" v-model="userData.phone" v-mask="'+7 (###) ###-##-##'">
    </div>
    <div class="checkbox-group">
      <input type="checkbox" id="newsletter" v-model="userData.newsletter">
      <label for="newsletter">Вы подписаны на рассылку</label>
    </div>
    <div class="account-data-buttons">
      <button class="save-button" @click="saveChanges">СОХРАНИТЬ</button>
      <button class="logout-button" @click="showLogoutConfirmation">ВЫЙТИ ИЗ АККАУНТА</button>
    </div>

    <!-- Блок для отображения сохраненных данных -->
    <div v-if="savedData" class="saved-data">
      <h3>Сохраненные данные:</h3>
      <p><strong>Имя:</strong> {{ savedData.firstName }}</p>
      <p><strong>Фамилия:</strong> {{ savedData.lastName }}</p>
      <p><strong>Дата рождения:</strong> {{ savedData.birthdate }}</p>
      <p><strong>E-mail:</strong> {{ savedData.email }}</p>
      <p><strong>Номер телефона:</strong> {{ savedData.phone }}</p>
      <p><strong>Подписан на рассылку:</strong> {{ savedData.newsletter ? 'Да' : 'Нет' }}</p>
    </div>

    <!-- Модальное окно для подтверждения выхода -->
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <p>Вы уверены, что хотите выйти из аккаунта?</p>
        <button @click="confirmLogout">Да</button>
        <button @click="cancelLogout">Нет</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useUserStore } from '../../../stores/userStore.js';

const userStore = useUserStore();
const userData = computed({
  get() {
    return userStore.userData;
  },
  set(value) {
    userStore.setUserData(value);
  }
});

const savedData = ref(null);
const showModal = ref(false);

const saveChanges = () => {
  // Логика сохранения изменений в хранилище Pinia
  userStore.setUserData(userData.value);
  // Сохраняем данные для отображения
  savedData.value = { ...userData.value };
};

const showLogoutConfirmation = () => {
  showModal.value = true;
};

const confirmLogout = () => {
  userStore.clearUserData();
  // Перенаправляем пользователя на страницу входа
  // Здесь можно добавить логику для перенаправления на страницу входа
  showModal.value = false;
};

const cancelLogout = () => {
  showModal.value = false;
};
</script>

<style scoped>
.form-group input {
  width: 25%;
}

.account-data-buttons {
  width: 25%;
}

.save-button {
  width: 25%;
}

.saved-data {
  margin-top: 20px;
  padding: 10px;
  border: 1px solid #ddd;
  background-color: #f9f9f9;
}

.saved-data h3 {
  margin-bottom: 10px;
}

.saved-data p {
  margin: 5px 0;
}

.logout-button {
  margin-top: 20px;
  padding: 10px 20px;
  background-color: #dc3545;
  color: white;
  border: none;
  cursor: pointer;
}

.logout-button:hover {
  background-color: #c82333;
}

.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
  text-align: center;
}

.modal-content button {
  margin: 10px;
  padding: 10px 20px;
  cursor: pointer;
}
</style>
