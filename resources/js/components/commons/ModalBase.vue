<template>
    <modal :name="modalName" @before-open="beforeOpenEvent">
        <ActionList :actions="[
                {
                    class: 'danger',
                    icon: 'fa-solid fa-xmark',
                    iconSize: 'lg',
                    title: 'Close',
                    onClick: closeEvent
                }
            ]" :isDisplayed="true" />
        <h2>{{ title }}</h2>
        <div class="modal__body">
            <slot name="body"></slot>
        </div>
        <div class="modal__footer">
            <slot name="footer"></slot>
        </div>
    </modal>
</template>

<script>
import ActionList from './ActionList.vue';

export default {
    name: "ModalBase",
    components: {
        ActionList
    },
    props: {
        modalName: String,
        title: String,
        beforeOpenEvent: [Function, undefined],
        closeEvent: Function
    }
}
</script>

<style lang="scss" scoped>
@import '../../../css/variables';

.button__close {
    border: none;
    background: white;
    font-weight: bold;
    position: absolute;
    right: 10px;
    top: 10px;
    font-size: 15px;
    border-radius: 50%;
    cursor: pointer;
    padding: 2px 5px;
    transition: background-color $transitionTimeFast;

    &:hover {
        background-color: darken(white, 10%);
    }
}

.action-list {
    position: absolute;
    top: -14px;
    right: 8px;
}
</style>
