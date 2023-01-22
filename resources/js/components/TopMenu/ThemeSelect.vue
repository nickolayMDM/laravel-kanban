<template>
    <div class="theme-select">
        <select v-model="themeModelVariable" @change="onChange">
            <option class="hidden" value="">Switch Theme</option>
            <option v-for="themeData in themes" v-if="selectedTheme !== themeData.value" :class="'theme-switch__option--' + themeData.value" :value="themeData.value">{{ themeData.title }}</option>
        </select>
    </div>
</template>

<script>
import { getThemes, getDefaultThemeKey } from '../../modules/theme';

export default {
    name: "ThemeSelect",
    inject: ["appReactive", "switchTheme"],
    data() {
        return {
            themeModelVariable: "",
            selectedTheme: getDefaultThemeKey(),
            themes: []
        };
    },
    mounted() {
        let themesRaw = getThemes();

        for (let key in themesRaw) {
            this.themes.push({
                value: key,
                title: themesRaw[key].title
            });
        }
    },
    methods: {
        onChange: function () {
            this.switchTheme(this.themeModelVariable);
            this.selectedTheme = this.themeModelVariable;
            this.themeModelVariable = "";
        }
    }
}
</script>

<style scoped>
option {
    padding: 10px 5px;
}
</style>
