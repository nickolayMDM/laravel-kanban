<template>
    <div class="column" @mouseover="displayActions" @mouseout="hideActions">
        <div class="column__header">
            <h2 :title="name">
                {{ name }}
            </h2>
            <ActionList :actions="[
                {
                    class: 'warning',
                    icon: 'fa-solid fa-pen',
                    title: 'Edit the column',
                    onClick: openEditModal
                },
                {
                    class: 'danger',
                    icon: 'fa-solid fa-xmark',
                    iconSize: 'lg',
                    title: 'Delete the column',
                    onClick: openDeleteModal
                }
            ]" :isDisplayed="isActionListDisplayed" />
        </div>
        <div class="column__body">
            <draggable v-model="boardReactive.columns[index].cards" group="cards" @end="moveCard" :data-index="index">
                <Card v-for="(card, cardIndex) in cards" :key="cardIndex" v-bind="card" :index="cardIndex" :columnIndex="index" />
            </draggable>
            <AddCard :columnIndex="index" />
        </div>
    </div>
</template>

<script>
import Card from './Card.vue';
import AddCard from './AddCard.vue';
import ActionList from './commons/ActionList.vue';
import draggable from "vuedraggable";

export default {
    name: "Column",
    inject: [
        'boardReactive',
        'moveCard'
    ],
    components: {
        Card,
        AddCard,
        ActionList,
        draggable
    },
    props: {
        name: String,
        cards: Array,
        index: Number
    },
    data () {
        return {
            isActionListDisplayed: false
        };
    },
    methods: {
        displayActions: function () {
            this.isActionListDisplayed = true;
        },
        hideActions: function () {
            this.isActionListDisplayed = false;
        },
        openEditModal: function () {
            this.$modal.show("column-modal", {
                name: this.name,
                index: this.index
            });
        },
        openDeleteModal: function () {
            this.$modal.show("delete-column-modal", {
                index: this.index
            });
        }
    }
}
</script>

<style lang="scss" scoped>
    @import '../../css/variables';

    .column {
        position: relative;

        &__header {
            border-bottom: 1px solid #1f2022;
            margin: 0;
            display: flex;
            max-width: 100%;
            padding-bottom: 10px;
            align-items: center;
        }

        &__body {
            padding-top: 15px;
            overflow-y: auto;
        }
    }

    h2 {
        margin: 0;
        font-size: 20px;
        padding: 0 10px;
        flex-grow: 1;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .action-list {
        position: absolute;
        top: -14px;
        right: 8px;
    }
</style>
