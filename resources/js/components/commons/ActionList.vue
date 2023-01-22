<template>
    <div :class="['action-list', displayClass].join(' ')">
        <button v-if="actions.length" v-for="action in actions" :class="'button button--' + action.class" :title="action.title" @click="action.onClick">
            <FontAwesomeIcon :icon="action.icon" :size="action.iconSize" />
        </button>
    </div>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

export default {
    name: "ActionList",
    components: {
        FontAwesomeIcon
    },
    props: {
        actions: Array,
        isDisplayed: Boolean
    },
    computed: {
        displayClass: function () {
            return (this.isDisplayed) ? "" : "hidden";
        }
    }
}
</script>

<style lang="scss" scoped>
    button {
        height: 30px;
        width: 30px;
        border-radius: 50%;
        padding: 0;

        + button {
            margin-left: 7px;
        }
    }
</style>
