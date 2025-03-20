<template>
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <button class="close-button" @click="closeModal">×</button>
        <component :is="currentComponent" @login-success="handleLoginSuccess" @register-success="handleRegisterSuccess" @show-register="showRegister" @show-login="showLogin" />
        <button v-if="isLoggedIn" class="continue-button" @click="continueCheckout">Продолжить оформление заказа</button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, shallowRef, computed } from 'vue';
  import { useUserStore } from '../../../stores/userStore.js';
  import Login from './Login.vue';
  import Register from './Register.vue';
  
  const props = defineProps({
    showModal: Boolean,
  });
  
  const emit = defineEmits(['close', 'continue-checkout']);
  
  const userStore = useUserStore();
  const isLoggedIn = computed(() => userStore.isLoggedIn);
  
  const currentComponent = shallowRef(Login);
  
  const showRegister = () => {
    currentComponent.value = Register;
  };
  
  const showLogin = () => {
    currentComponent.value = Login;
  };
  
  const handleLoginSuccess = () => {
    // После успешного входа, скрываем форму и показываем информацию об аккаунте
    // Устанавливаем компонент в null, чтобы показать блок с аккаунтом
    currentComponent.value = null;
  };
  
  const handleRegisterSuccess = () => {
    // После успешной регистрации, автоматически входим в аккаунт
    userStore.login(email.value, password.value);
    emit('login-success');
  };
  
  const closeModal = () => {
    emit('close');
    document.body.classList.remove('modal-open');
  };
  
  const continueCheckout = () => {
    emit('continue-checkout');
  };
  
  if (props.showModal) {
    document.body.classList.add('modal-open');
  }
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 400;
  }
  
  .modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    position: relative;
    width: 50%;
    height: auto;
  }
  
  .close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
  }
  
  .continue-button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
  }
  
  .continue-button:hover {
    background-color: #0056b3;
  }
  
  .modal-open {
    overflow: hidden;
  }
  </style>