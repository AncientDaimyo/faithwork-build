<template>
    <div class="account-page-wrapper">
        <HeaderCommon />

        <div class="account-content" v-if="isLoggedIn">
            <h1></h1>
            <div class="account-sections">
                <div class="left-section">
                    <ul>
                        <li :class="{ active: currentTab === 'accountData' }" @click="changeTab('accountData')">ДАННЫЕ
                            АККАУНТА</li>
                        <li :class="{ active: currentTab === 'orderHistory' }" @click="changeTab('orderHistory')">
                            ИСТОРИЯ ЗАКАЗОВ</li>
                        <li :class="{ active: currentTab === 'addresses' }" @click="changeTab('addresses')">АДРЕСА</li>
                    </ul>
                </div>
                <div class="right-section">
                    <AccountData v-if="currentTab === 'accountData'" />
                    <OrderHistory v-if="currentTab === 'orderHistory'" />
                    <Addresses v-if="currentTab === 'addresses'" />
                </div>
            </div>
        </div>
        <div v-else>
            <component :is="currentComponent" @login-success="handleLoginSuccess"
                @register-success="handleRegisterSuccess" @show-register="showRegister" @show-login="showLogin" />
        </div>
        <FooterSecond />
    </div>
</template>

<script setup>
import { shallowRef, computed, ref } from 'vue';
import { useUserStore } from '../../../stores/userStore.js';
import Register from '../../User/controllers/Register.vue';
import Login from '../../User/controllers/Login.vue';
import HeaderCommon from '../../Shared/controllers/HeaderCommon.vue';
import FooterSecond from '../../Shared/controllers/FooterSecond.vue';
import AccountData from './AccountData.vue';
import OrderHistory from './OrderHistory.vue';
import Addresses from './Addresses.vue';


const userStore = useUserStore();

const isLoggedIn = computed(() => userStore.isLoggedIn);
const userData = computed(() => userStore.userData);

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
    // После успешной регистрации, переходим на страницу входа
    currentComponent.value = Login;
};

const currentTab = ref('accountData');

const changeTab = (tab) => {
    currentTab.value = tab;
};
</script>

<style scoped>
.account-page-wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.account-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.account-sections {
    display: flex;
    width: 100%;
    max-width: 1200px;
}

.left-section {
    width: 30%;
    padding: 20px;
    background-color: #f4f4f4;
}

.left-section ul {
    list-style-type: none;
    padding: 0;
}

.left-section ul li {
    cursor: pointer;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.left-section ul li:last-child {
    border-bottom: none;
}

.left-section ul li.active {
    background-color: #ddd;
    font-weight: bold;
}

.right-section {
    width: 70%;
    padding: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
}

.checkbox-group {
    margin-bottom: 20px;
}

.save-button,
.change-password-button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
}

.save-button:hover,
.change-password-button:hover {
    background-color: #0056b3;
}
</style>