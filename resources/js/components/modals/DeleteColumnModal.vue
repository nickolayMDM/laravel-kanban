<template>
    <ModalBase :modal-name="modalName" :before-open-event="beforeOpen" :close-event="close" title="Confirm deleting the column">
        <template v-slot:footer>
            <button class="button button--muted" @click="close">Cancel</button>
            <button class="button button--main" @click="confirm">Delete</button>
        </template>
    </ModalBase>
</template>

<script>
import ModalBase from '../commons/ModalBase.vue';

export default {
    name: "DeleteColumnModal",
    components: {
        ModalBase
    },
    data() {
        return {
            modalName: "delete-column-modal",
            index: -1
        };
    },
    inject: ['deleteColumn'],
    methods: {
        confirm: function (event) {
            event.preventDefault();

            this.deleteColumn(this.index);
            this.close();
        },
        close: function () {
            this.$modal.hide(this.modalName);
        },
        beforeOpen: function (event) {
            this.index = event.params.index;
        }
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
</style>
