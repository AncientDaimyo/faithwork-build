<template>
    <header id="header_common">
        <div class="desktop">
            <HeaderMainMenu />
        </div>
        <div class="mobile">
            <BurgerMenu />
        </div>
        <HeaderLogo />
        <HeaderIcons />
    </header>
</template>

<script setup>
import HeaderMainMenu from '../components/HeaderMainMenu.vue';
import HeaderLogo from '../components/HeaderLogo.vue';
import HeaderIcons from '../components/HeaderIcons.vue';
import BurgerMenu from '../components/BurgerMenu.vue';  
</script>
