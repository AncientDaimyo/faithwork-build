<template>
    <footer id="footer_common">
        <FooterSocial />
        <FooterCopyright />
    </footer>
</template>

<script>
import FooterCopyright from '../components/FooterCopyright.vue';
import FooterSocial from '../components/FooterSocial.vue';

export default {
    components: {
        FooterSocial,
        FooterCopyright
    }
}

</script>