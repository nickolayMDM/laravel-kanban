<template>
    <ModalBase :modal-name="modalName" type="form" :before-open-event="beforeOpen" :close-event="close" :title="title">
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
    name: "ColumnModal",
    components: {
        ModalBase
    },
    data() {
        return {
            modalName: "column-modal",
            name: "",
            index: -1
        };
    },
    inject: ['handleColumnDataSubmit'],
    methods: {
        submit: function (event) {
            event.preventDefault();

            this.handleColumnDataSubmit({
                name: this.name,
                index: this.index
            });
            this.close();
        },
        close: function () {
            this.$modal.hide(this.modalName);
        },
        clear: function () {
            this.name = "";
            this.index = -1;
        },
        beforeOpen: function (event) {
            this.clear();

            if (event.params && event.params.index > -1) {
                this.index = event.params.index;
                this.name = event.params.name;
            }
        }
    },
    computed: {
        title: function () {
            if (this.index > -1) {
                return "Edit Column";
            }

            return "Add a new Column";
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
