<template>
    <div class="top-menu">
        <h1>
            Kanban board example by Mykola Mykhaliuk
        </h1>
        <div class="top-menu__settings">
            <ThemeSelect />
        </div>
    </div>
</template>

<script>
import ThemeSelect from './TopMenu/ThemeSelect';

export default {
    name: "TopMenu",
    components: {
        ThemeSelect
    }
}
</script>

<style lang="scss" scoped>
    .top-menu {
        display: flex;
        justify-content: space-between;
        background-color: var(--colorTopMenuBackground);
        min-height: 50px;
        align-items: center;
        padding: 0 20px;
    }

    h1 {
        margin: 0;
        font-size: 26px;
    }
</style>
