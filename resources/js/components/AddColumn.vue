<template>
    <div class="column" @click="openAddColumnModal">
        + Add column
    </div>
</template>

<script>
export default {
    name: "AddColumn",
    methods: {
        openAddColumnModal: function () {
            this.$modal.show("column-modal");
        }
    }
}
</script>

<style lang="scss" scoped>
    @import '../../css/variables';

    .column {
        justify-content: center;
        align-items: center;
        background-color: transparent;
        border-style: dashed;
        border-width: 2px;
        color: white;
        border-color: white;
        cursor: pointer;
        margin-left: 20px;
        transition: background-color $transitionTimeFast;

        &:hover {
            background-color: rgba(255,255,255,0.1);
        }
    }
</style>
