<template>
    <header id="header_main" class="header_ride">
        <div class="desktop">
            <HeaderMainMenu />
        </div>
        <div class="mobile">
            <BurgerMenu />
        </div>
        <HeaderLogo />
        <div class="navigation-icons">
            <HeaderIcons />
        </div>
    </header>
</template>

<script>

import HeaderMainMenu from '../components/HeaderMainMenu.vue'
import HeaderLogo from '../components/HeaderLogo.vue'
import HeaderIcons from '../components/HeaderIcons.vue'
import BurgerMenu from '../components/BurgerMenu.vue';

export default {
    components: {
        HeaderMainMenu,
        HeaderLogo,
        HeaderIcons,
        BurgerMenu,
    }
}

</script>