<template>
    <div v-if="!isLoading" :class="containerClass">
        <TopMenu />
        <Board />
    </div>
</template>

<script>
import { getThemeDataByKey, getDefaultThemeKey } from '../modules/theme';

import TopMenu from './TopMenu.vue';
import Board from './Board.vue';

const themeSwitchDurationMS = 400;

export default {
    name: "App",
    components: {
        Board,
        TopMenu
    },
    props: {
        initialBoardHash: String
    },
    provide() {
        return {
            appReactive: this.reactive,
            switchTheme: this.switchTheme
        };
    },
    data () {
        return {
            isLoading: true,
            boardHash: "",
            reactive: {
                theme: ""
            },
            isSwitchingTheme: false
        }
    },
    methods: {
        switchTheme: function (themeKey) {
            if (!getThemeDataByKey(themeKey)) {
                return false;
            }

            if (this.reactive.theme !== themeKey) {
                this.isSwitchingTheme = true;

                setTimeout(function () {
                    this.isSwitchingTheme = false;
                }.bind(this), themeSwitchDurationMS);
            }

            this.reactive.theme = themeKey;
        }
    },
    mounted () {
        this.reactive.theme = getDefaultThemeKey(); //TODO: save the board theme in the database and load it

        this.isLoading = false;
    },
    computed: {
        containerClass () {
            let resultArray = [
                'app',
                'app--' + this.reactive.theme
            ];

            if (this.isSwitchingTheme) {
                resultArray.push('app--theme-switch');
            }

            return resultArray.join(' ');
        }
    }
}
</script>

<style lang="scss">
    @import '../../css/variables';

    .app {
        display: flex;
        flex-direction: column;
        height: 100%;

        &.app--theme-switch * {
            transition: all $transitionTimeMedium;
        }
    }

    input[type=text], textarea, select, .imitate-select {
        width: 100%;
        border-radius: 4px;
        border: 1px solid var(--colorInputBorder);
        padding: 10px 15px;
        resize: none;

        + input[type=text], + textarea {
            margin-top: 10px;
        }
    }

    select, .imitate-select {
        padding: 10px 5px;
    }

    .button {
        border: none;
        padding: 10px 15px;
        font-size: 14px;
        border-radius: $borderRadiusDefault;
        cursor: pointer;
        transition: background-color $transitionTimeFast;

        &--main {
            background-color: var(--colorButtonMainBackground);
            color: white;
            &:hover {
                background-color: var(--colorButtonMainBackgroundHover);
            }
        }

        &--muted {
            background-color: transparent;
        }

        &--warning {
            background-color: var(--colorButtonWarningBackground);
            color: white;
            &:hover {
                background-color: var(--colorButtonWarningBackgroundHover);
            }
        }

        &--danger {
            background-color: var(--colorButtonDangerBackground);
            color: white;
            &:hover {
                background-color: var(--colorButtonDangerBackgroundHover);
            }
        }

        &--thin {
            padding: 5px 15px;
        }

        &--extra-thin {
            padding: 3px 15px;
        }
    }

    .vm--container .vm--modal {
        background-color: var(--colorModalBackground);
        border-radius: $borderRadiusDefault;
        padding: 10px;
        display: flex;
        flex-direction: column;
        overflow: visible;

        h2 {
            margin: 0 0 20px;
            text-transform: uppercase;
        }

        .modal__body {
            flex-grow: 1;
        }

        .modal__footer {
            text-align: right;
        }
    }

    .hidden {
        display: none;
    }
</style>
