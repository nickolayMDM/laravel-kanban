const themes = {
    "darkblue": {
        "title": "Dark Blue"
    },
    "monochrome": {
        "title": "Monochrome"
    }
};

export function getThemeKeys () {
    return Object.keys(themes);
}

export function getThemes () {
    return themes;
}

export function getThemeDataByKey (themeKey) {
    if (!themes[themeKey]) {
        return false;
    }

    return themes[themeKey];
}

export function getDefaultThemeKey () {
    return Object.keys(themes)[0];
}
