<template>
    <ModalBase :modal-name="modalName" type="form" :before-open-event="clear" :close-event="close" title="Add a new column">
        <template v-slot:body>
            <form @submit="submit">
                <input type="text" placeholder="Enter a name" v-model="name"/>
            </form>
        </template>
        <template v-slot:footer>
            <button class="button button--muted" @click="close">Cancel</button>
            <button class="button button--main" @click="submit">Submit</button>
        </template>
    </ModalBase>
</template>

<script>
import ModalBase from '../commons/ModalBase.vue';

export default {
    name: "AddColumnModal",
    components: {
        ModalBase
    },
    data() {
        return {
            modalName: "add-column-modal",
            name: ""
        };
    },
    inject: ['addNewColumn'],
    methods: {
        submit: function (event) {
            event.preventDefault();

            this.addNewColumn(this.name);
            this.close();
        },
        close: function () {
            this.$modal.hide(this.modalName);
        },
        clear: function () {
            this.name = "";
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
