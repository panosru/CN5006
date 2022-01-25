import React from "react";

const currentUserStorage = global.store.current_user = {
    logged: false,
    token: '',
    roles: []
};

export function isLogged() {
    return currentUserStorage.logged;
}

export function login(token, roles) {
    currentUserStorage.logged = true;
    currentUserStorage.token = token;
    currentUserStorage.roles = roles;
}

export function logout() {
    currentUserStorage.logged = false;
    currentUserStorage.token = '';
    currentUserStorage.roles = [];
}

export function getToken() {
    return currentUserStorage.token;
}

export function hasRole(role) {
    return currentUserStorage.roles.includes(role);
}
