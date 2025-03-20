<template>
  <div class="login-page-wrapper">
    <h2 class="login-heading">Вход</h2>
    <form @submit.prevent="loginUser" class="login-form" novalidate>
      <div class="form-group email-group">
        <label for="email" class="email-label">Почта:</label>
        <input type="email" id="email" v-model="email" placeholder="email@mail.com" class="email-input" />
        <span class="error email-error" v-if="emailError">{{ emailError }}</span>
      </div>
      <div class="form-group password-group">
        <label for="password" class="password-label">Пароль:</label>
        <div class="password-wrapper">
          <input :type="showPassword ? 'text' : 'password'" id="password" v-model="password" class="password-input" />
          <button type="button" @click="toggleShowPassword" class="toggle-password-button">
            <span v-if="showPassword" class="password-toggle-text">Скрыть</span>
            <span v-else class="password-toggle-text">Показать</span>
          </button>
        </div>
        <span class="error password-error" v-if="passwordError">{{ passwordError }}</span>
      </div>
      <span class="error login-error" v-if="loginError">{{ loginError }}</span>
      <button type="submit" class="login-button">Войти</button>
    </form>
    <p class="register-link">
      Нет аккаунта?
      <button class="register-button" @click="$emit('show-register')">Зарегистрироваться</button>
    </p>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useUserStore } from '../../../stores/userStore.js';

export default {
  name: 'Login',
  setup(_, { emit }) {
    const email = ref('');
    const password = ref('');

    const showPassword = ref(false);

    const emailError = ref('');
    const passwordError = ref('');
    const loginError = ref('');

    const userStore = useUserStore();

    const toggleShowPassword = () => {
      showPassword.value = !showPassword.value;
    };

    const validateEmail = (email) => {
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailPattern.test(email);
    };

    const validate = () => {
      emailError.value = '';
      passwordError.value = '';
      loginError.value = '';

      if (!email.value) {
        emailError.value = 'Пожалуйста, введите почту';
        return false;
      } else if (!validateEmail(email.value)) {
        emailError.value = 'Некорректный формат почты';
        return false;
      }

      if (!password.value) {
        passwordError.value = 'Пожалуйста, введите пароль';
        return false;
      }

      return true;
    };

    const loginUser = () => {
      if (validate()) {
        const success = userStore.login(email.value, password.value);
        if (!success) {
          loginError.value = 'Неправильная почта или пароль';
        } else {
          emit('login-success');
        }
      }
    };

    return {
      email,
      password,
      showPassword,
      toggleShowPassword,
      emailError,
      passwordError,
      loginError,
      loginUser,
    };
  },
};
</script>