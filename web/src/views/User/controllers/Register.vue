<template>
  <div class="register-page-wrapper">
    <h2 class="register-heading">Регистрация</h2>
    <form @submit.prevent="register" class="register-form" novalidate>
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
      <div class="form-group confirm-password-group">
        <label for="confirmPassword" class="confirm-password-label">Подтверждение пароля:</label>
        <div class="password-wrapper">
          <input :type="showConfirmPassword ? 'text' : 'password'" id="confirmPassword" v-model="confirmPassword" class="confirm-password-input" />
          <button type="button" @click="toggleShowConfirmPassword" class="toggle-password-button">
            <span v-if="showConfirmPassword" class="password-toggle-text">Скрыть</span>
            <span v-else class="password-toggle-text">Показать</span>
          </button>
        </div>
        <span class="error confirm-password-error" v-if="confirmPasswordError">{{ confirmPasswordError }}</span>
      </div>
      <button type="submit" class="register-button">Зарегистрироваться</button>
    </form>
    <p class="login-link">
      Уже есть аккаунт?
      <button class="login-button" @click="$emit('show-login')">Войти</button>
    </p>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useUserStore } from '../../../stores/userStore.js';

export default {
  name: 'Register',
  setup(_, { emit }) {
    const email = ref('');
    const password = ref('');
    const confirmPassword = ref('');

    const showPassword = ref(false);
    const showConfirmPassword = ref(false);

    const emailError = ref('');
    const passwordError = ref('');
    const confirmPasswordError = ref('');

    const userStore = useUserStore();

    const toggleShowPassword = () => {
      showPassword.value = !showPassword.value;
    };

    const toggleShowConfirmPassword = () => {
      showConfirmPassword.value = !showConfirmPassword.value;
    };

    const validateEmail = (email) => {
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailPattern.test(email);
    };

    const validate = () => {
      emailError.value = '';
      passwordError.value = '';
      confirmPasswordError.value = '';

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

      if (!confirmPassword.value) {
        confirmPasswordError.value = 'Пожалуйста, введите подтверждение пароля';
        return false;
      }

      if (password.value !== confirmPassword.value) {
        confirmPasswordError.value = 'Пароли не совпадают';
        return false;
      }

      return true;
    };

    const register = () => {
      if (validate()) {
        userStore.setUserData({ email: email.value, password: password.value });
        userStore.login(email.value, password.value); // Автоматический вход после регистрации
        emit('register-success');
      }
    };

    const goToLogin = () => {
      emit('show-login');
    };

    return {
      email,
      password,
      confirmPassword,
      showPassword,
      showConfirmPassword,
      toggleShowPassword,
      toggleShowConfirmPassword,
      emailError,
      passwordError,
      confirmPasswordError,
      register,
      goToLogin,
    };
  },
};
</script>