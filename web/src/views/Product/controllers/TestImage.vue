<template>
    <div class="image_test_page">
        <figure class="test_image_column">
            <a src="/shop" class="test_link"></a>
            <img class="test-card-image" src="/src/views/Shared/pic/FW_GIRL_FACE_black_2x3.png" alt="Product Image">
            <p class="test-card-name">name</p>
            <p class="test-card-cost">123123</p>
        </figure>
    </div>
</template>

<style>
.image_test_page {
    display: block;
    columns: 17em;
    column-gap: 2rem;
    column-span: 1;
    max-width: 100vw;
}

.test_image_column {
    display: flex;
    flex-flow: column nowrap;
    align-items: center;
    margin-block-end: 1rem;
    position: relative;
}

.test-card-image {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 2ch;
}

.test_link {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}
</style>