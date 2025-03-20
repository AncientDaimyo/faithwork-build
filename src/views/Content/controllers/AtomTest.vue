<template>
    <div class="test-page">
        <button class="fw-btn fw-btn--disabled" disabled>Кнопка</button>
        <button class="fw-btn fw-btn--primary">Кнопка</button>
        <input class="fw-input" type="text" placeholder="Текстовое поле">
        <input class="fw-input fw-input--disabled" type="text" placeholder="Текстовое поле" disabled>

        <h1 class="fw-h1">Heading 1</h1>
        <h2 class="fw-h2">Heading 2</h2>
        <h3 class="fw-h3">Heading 3</h3>
        <h4 class="fw-h4">Heading 4</h4>
        <p class="fw-p">This is a paragraph. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia
            odio
            vitae vestibulum vestibulum. Cras venenatis euismod malesuada.</p>


        <button class="fw-btn fw-btn--primary" @click="openModal">Открыть модалку</button>
        <div :class="['fw-modal', { 'fw-modal--visible': isVisible }]" @click.self="closeModal">
            <div class="fw-modal-content">
                <div class="fw-modal-header">
                    <span class="fw-modal-close" @click="closeModal">&times;</span>
                </div>
                <div class="fw-modal-body">
                    <p class="fw-p">Модальное окно</p>
                    <img class="fw-img fw-img--responsive" src="../pic/FW_GIRL_FACE_black.png" />
                </div>
                <div class="fw-modal-footer">
                    <button class="fw-btn fw-btn--primary" @click="save">Закрыть</button>
                </div>
            </div>
        </div>


        <a href="https://instagram.com/faithwork_clothing?igshid=ZDdkNTZiNTM="
            class="fw-icon fw-icon--color-secondary fw-icon--clickable">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
                    fill="currentColor" />
            </svg>
        </a>

        <a href="https://t.me/faithworkclothing">
            <svg class="fw-icon fw-icon--clickable fw-icon--color-primary" xmlns="http://www.w3.org/2000/svg" width="22"
                height="22" viewBox="0 0 127.50933 105.1879">
                <g id="a">
                    <path d="M49.65612,69.86895l-2.6875,28.5625s-1.125,8.75,7.625,0,17.125-15.5,17.125-15.5"
                        fill="currentColor" />
                </g>
                <g id="b">
                    <path
                        d="M31.34689,61.31405L2.55202,51.93145s-3.43757-1.39583-2.33341-4.5625c.22781-.65333,.68743-1.20833,2.0625-2.16667C8.66243,40.75494,120.38536,.59812,120.38536,.59812c0,0,3.15504-1.0621,5.01873-.35566,.85186,.32288,1.39584,.68749,1.85417,2.02082,.16665,.48481,.26236,1.51615,.25,2.54167-.00891,.73959-.1,1.42482-.16667,2.5-.68071,10.97892-21.03964,92.91817-21.03964,92.91817,0,0-1.21793,4.7949-5.58333,4.95833-1.59135,.05958-3.52354-.26307-5.83326-2.25-8.56532-7.3683-38.17199-27.26509-44.71389-31.64116-.36815-.24627-.47368-.56717-.53618-.87967-.09221-.46104,.40916-1.0332,.40916-1.0332,0,0,51.55294-45.82496,52.92417-50.63347,.10623-.37251-.29251-.55677-.83326-.39583-3.42466,1.25964-62.78055,38.74072-69.33098,42.87983-.3832,.24214-1.45749,.0861-1.45749,.0861Z"
                        fill="currentColor" />
                </g>
            </svg>
        </a>



        <div class="fw_radio_btn">
            <input type="radio" id="option1" name="radio-group" value="option1">
            <label for="option1">M</label>
        </div>

        <div class="fw_radio_btn">
            <input type="radio" id="option2" name="radio-group" value="option2">
            <label for="option2">L</label>
        </div>

        <!-- Example with a disabled radio button -->
        <div class="fw_radio_btn">
            <input type="radio" id="option3" name="radio-group" value="option3" disabled>
            <label for="option3">Option 3 (Disabled)</label>
        </div>

    </div>
    < </template>

<script setup>
import { ref } from 'vue';

console.log('Setup script loaded');

const isVisible = ref(false);
const title = 'Модальное окно';

const openModal = () => {
    isVisible.value = true;
    console.log('Modal opened');
};

const closeModal = () => {
    console.log('Closing modal');
    isVisible.value = false;
};

const save = () => {
    console.log('Saving and closing modal');
    isVisible.value = false;
};
</script>

<style scoped>
.test-page {
    height: 150vh;
}
</style>
