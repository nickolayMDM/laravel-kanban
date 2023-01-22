<template>
    <ModalBase :modal-name="modalName" :before-open-event="beforeOpen" :close-event="close" :title="title">
        <template v-slot:body>
            <form @submit="submit">
                <input type="text" placeholder="Enter a name" v-model="name"/>
                <textarea placeholder="Description" rows="4" v-model="description"/>
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
    name: "CardModal",
    components: {
        ModalBase
    },
    data() {
        return {
            modalName: "card-modal",
            name: "",
            description: "",
            index: -1,
            columnIndex: -1
        };
    },
    inject: ['handleCardDataSubmit'],
    methods: {
        submit: function (event) {
            event.preventDefault();

            this.handleCardDataSubmit({
                name: this.name,
                description: this.description,
                index: this.index,
                columnIndex: this.columnIndex
            });
            this.close();
        },
        close: function () {
            this.$modal.hide(this.modalName);
        },
        beforeOpen: function (event) {
            this.clear();

            this.columnIndex = event.params.columnIndex;
            if (event.params.index > -1) {
                this.index = event.params.index;
                this.name = event.params.name;
                this.description = event.params.description;
            }
        },
        clear: function () {
            this.name = "";
            this.description = "";
            this.columnIndex = -1;
            this.index = -1;
        }
    },
    computed: {
        title: function () {
            if (this.index > -1) {
                return "Edit Card";
            }

            return "Add a new Card";
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
