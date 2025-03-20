<template>
    <header id="header_main">
        <div class="desktop">
            <HeaderMainMenu />
        </div>
        <div class="mobile">
            <!-- <?php Templator::get_template_part_component('main_header_mobile_menu'); ?> -->
        </div>
        <HeaderLogo />
        <HeaderIcons />
    </header>
</template>

<script>

import HeaderMainMenu from '../components/HeaderMainMenu.vue'
import HeaderLogo from '../components/HeaderLogo.vue'
import HeaderIcons from '../components/HeaderIcons.vue'

export default {
    components: {
        HeaderMainMenu,
        HeaderLogo,
        HeaderIcons,
    }
}

</script>