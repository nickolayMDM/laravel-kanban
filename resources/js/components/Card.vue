<template>
    <div class="card" @mouseover="displayActions" @mouseout="hideActions">
        <ActionList :actions="[
                {
                    class: 'warning',
                    icon: 'fa-solid fa-pen',
                    title: 'Edit the card',
                    onClick: openCardEditModal
                },
                {
                    class: 'danger',
                    icon: 'fa-solid fa-xmark',
                    iconSize: 'lg',
                    title: 'Delete the card',
                    onClick: openDeleteModal
                }
            ]" :isDisplayed="isActionListDisplayed" />
        <div class="card__title">
            {{ name }}
        </div>
    </div>
</template>

<script>
import ActionList from './commons/ActionList.vue';

import { library } from '@fortawesome/fontawesome-svg-core';
import { faPen, faXmark } from '@fortawesome/free-solid-svg-icons';
library.add(faPen);
library.add(faXmark);

export default {
    name: "Card",
    components: {
        ActionList
    },
    props: {
        name: String,
        description: String,
        index: Number,
        columnIndex: Number
    },
    data () {
        return {
            isActionListDisplayed: false
        };
    },
    methods: {
        openCardEditModal: function () {
            this.$modal.show("card-modal", {
                name: this.name,
                description: this.description,
                index: this.index,
                columnIndex: this.columnIndex
            });
        },
        displayActions: function () {
            this.isActionListDisplayed = true;
        },
        hideActions: function () {
            this.isActionListDisplayed = false;
        },
        openDeleteModal: function () {
            this.$modal.show("delete-card-modal", {
                index: this.index,
                columnIndex: this.columnIndex
            });
        }
    }
}
</script>

<style lang="scss" scoped>
    .card {
        margin-bottom: 15px;

        &__title {
            padding: 10px;
        }
    }

    .action-list {
        position: absolute;
        top: -14px;
        right: 8px;
    }
</style>
