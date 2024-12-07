<template>
    <div class="modal">
        <div class="modal-overlay" @click="$emit('close')"></div>
        <div class="modal-content">
            <slot name="header"></slot>
            <slot name="body"></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        show: Boolean,
    },
};
</script>

<style scoped>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    visibility: visible;
}
.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
}
.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    position: relative;
    z-index: 1;
}
</style>
