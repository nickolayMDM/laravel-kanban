<template>
    <div class="card" @click="openAddCardModal">
        + Add card
    </div>
</template>

<script>
export default {
    name: "AddCard",
    props: {
        columnIndex: Number
    },
    methods: {
        openAddCardModal: function () {
            this.$modal.show("card-modal", {
                columnIndex: this.columnIndex
            });
        }
    }
}
</script>

<style lang="scss" scoped>
    @import '../../css/themeColors';

    .card {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: transparent;
        border-style: dashed;
        border-width: 2px;
        border-color: $colorShark;
        cursor: pointer;
        padding: 10px;
        transition: background-color $transitionTimeFast;

        &:hover {
            background-color: rgba(0,0,0,0.1);
        }
    }
</style>
