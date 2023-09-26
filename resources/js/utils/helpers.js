export function deepClone (value) {
    return JSON.parse(JSON.stringify(value));
}

export function __hardcoded (value) {
    return value;
}

export function createObjectURL (file) {
    return window.URL.createObjectURL(file);
}

export function toFormData (payload) {
    const formData = new FormData();
    Object.keys(payload).forEach(key => {
        const value = payload[key];
        if (Array.isArray(value)) {
            value.forEach(v => {
                formData.append(`${key}[]`, v);
            })
        } else {
            formData.append(key, value);
        }
    })
    return formData;
}

export function openWA (phone) {
    const link = document.createElement('a');
    link.href = `https://api.whatsapp.com/send?phone=${phone}`;
    link.target = '_blank';
    link.click();
}

export function reverseDate (date) {
    return date
        .split('.')
        .reverse()
        .join('-');
}
