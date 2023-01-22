<template>
    <ModalBase :modal-name="modalName" :before-open-event="beforeOpen" :close-event="close" title="Confirm deleting the card">
        <template v-slot:footer>
            <button class="button button--muted" @click="close">Cancel</button>
            <button class="button button--main" @click="confirm">Delete</button>
        </template>
    </ModalBase>
</template>

<script>
import ModalBase from '../commons/ModalBase.vue';

export default {
    name: "DeleteCardModal",
    components: {
        ModalBase
    },
    data() {
        return {
            modalName: "delete-card-modal",
            index: -1,
            columnIndex: -1
        };
    },
    inject: ['deleteCard'],
    methods: {
        confirm: function (event) {
            event.preventDefault();

            this.deleteCard({
                index: this.index,
                columnIndex: this.columnIndex
            });
            this.close();
        },
        close: function () {
            this.$modal.hide(this.modalName);
        },
        clear: function () {
            this.name = "";
        },
        beforeOpen: function (event) {
            this.index = event.params.index;
            this.columnIndex = event.params.columnIndex;
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
