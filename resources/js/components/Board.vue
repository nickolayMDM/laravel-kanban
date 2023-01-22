<template>
    <div class="board">
        <draggable class="board__draggable" v-model="reactive.columns" group="columns" @end="moveColumn">
            <Column v-for="(column, index) in reactive.columns" :key="index" v-bind="column" :index="index" />
        </draggable>
        <AddColumn />

        <DumpSqlButton />

        <ColumnModal />
        <CardModal />
        <DeleteColumnModal />
        <DeleteCardModal />
    </div>
</template>

<script>
import TopMenu from './TopMenu.vue';
import Column from './Column.vue';
import AddColumn from './AddColumn.vue';
import ColumnModal from './modals/ColumnModal.vue';
import DeleteColumnModal from './modals/DeleteColumnModal.vue';
import DeleteCardModal from './modals/DeleteCardModal.vue';
import CardModal from './modals/CardModal.vue';
import draggable from "vuedraggable";

export default {
    name: "Board",
    components: {
        Column,
        AddColumn,
        ColumnModal,
        DeleteColumnModal,
        DeleteCardModal,
        CardModal,
        draggable,
        TopMenu
    },
    data () {
        return {
            reactive: {
                columns: []
            }
        }
    },
    provide () {
        return {
            boardReactive: this.reactive,
            handleColumnDataSubmit: this.handleColumnDataSubmit,
            deleteColumn: this.deleteColumn,
            handleCardDataSubmit: this.handleCardDataSubmit,
            moveCard: this.moveCard,
            deleteCard: this.deleteCard
        };
    },
    async mounted () {
        let state = await this.$stateSync.getBoardColumns();

        this.reactive.columns = state.data.columns;
    },
    methods: {
        handleColumnDataSubmit: function ({name, description, index, columnIndex}) {
            if (index > -1) {
                return this.editColumn(arguments[0]);
            }

            return this.addNewColumn(arguments[0]);
        },
        addNewColumn: function ({name}) {
            this.reactive.columns.push({
                name,
                cards: []
            });

            this.$stateSync.postColumn({
                name,
                index: this.reactive.columns.length - 1
            });
        },
        editColumn: function ({name, index}) {
            this.reactive.columns[index].name = name;

            this.$stateSync.editColumn({
                name,
                index
            });
        },
        moveColumn: function (event) {
            let index = event.newIndex;
            let oldIndex = event.oldIndex;

            if (index === oldIndex) {
                return;
            }

            this.$stateSync.moveColumn({
                index,
                oldIndex
            });
        },
        deleteColumn: function (index) {
            this.reactive.columns.splice(index, 1);

            this.$stateSync.deleteColumn({
                index
            });
        },

        handleCardDataSubmit: function ({name, description, index, columnIndex}) {
            if (index > -1) {
                return this.editCard(arguments[0]);
            }

            return this.addNewCard(arguments[0]);
        },
        addNewCard: function ({name, description, columnIndex}) {
            this.reactive.columns[columnIndex].cards.push({
                name,
                description
            });

            this.$stateSync.postCard({
                name,
                description,
                columnIndex,
                index: this.reactive.columns[columnIndex].cards.length - 1
            });
        },
        editCard: function ({name, description, index, columnIndex}) {
            this.reactive.columns[columnIndex].cards[index].name = name;
            this.reactive.columns[columnIndex].cards[index].description = description;

            this.$stateSync.editCard({
                name,
                description,
                index,
                columnIndex
            });
        },
        moveCard: function (event) {
            let columnIndex = event.to.getAttribute('data-index');
            let index = event.newIndex;
            let oldColumnIndex = event.from.getAttribute('data-index');
            let oldIndex = event.oldIndex;

            if (index === oldIndex && columnIndex === oldColumnIndex) {
                return;
            }

            this.$stateSync.moveCard({
                index,
                columnIndex,
                oldColumnIndex,
                oldIndex
            });
        },
        deleteCard: function ({index, columnIndex}) {
            this.reactive.columns[columnIndex].cards.splice(index, 1);

            this.$stateSync.deleteCard({
                index,
                columnIndex
            });
        }
    }
}
</script>

<style lang="scss">
    @import '../../css/variables';

    .board {
        height: 100%;
        background-color: var(--colorBoardBackground);
        display: flex;
        padding: 20px;
        min-height: 400px;
        overflow-x: auto;
        font-size: 20px;
        font-weight: bold;

        &__draggable {
            display: flex;
        }
    }

    .column {
        width: 300px;
        min-width: 300px;
        border-radius: $borderRadiusDefault;
        background-color: var(--colorColumnBackground);
        padding: 10px;
        display: flex;
        flex-direction: column;

        + .column {
            margin-left: 20px;
        }
    }

    .card {
        border: 1px solid var(--colorCardBorder);
        border-radius: $borderRadiusDefault;
        background-color: var(--colorCardBackground);
        position: relative;
    }
</style>
