export function isValidEmail(text) {
    let emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(!text || !text.match(emailRegex)) {
        return false;
    }
    return true;
}

export function isNumberOnly(text) {
    let onlyNumber = /^[0-9]*$/;
    if (!text || !text.match(onlyNumber)) {
        return false;
    }
    return true;
}

export function isAlphabetic(text) {
    let alphabetWithSpace = /^[a-zA-Z ]*$/;
    if(!text || !text.match(alphabetWithSpace)) {
        return false;
    }
    return true;
}