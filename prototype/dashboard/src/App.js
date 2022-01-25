// in src/App.js
import * as React from "react";
import { fetchUtils, Admin, Resource, usePermissions } from 'react-admin';
import jsonServerProvider from 'ra-data-json-server';
import { UsersIcon, UserList, UserEdit, UserCreate } from './users';
import authProvider from './providers/authProvider';
import {MovieList, MovieCreate, MovieEdit} from "./movies";
import {HallList, HallCreate, HallEdit} from "./halls";
import {ShowList, ShowCreate, ShowEdit} from "./shows";
import {TicketCreate, TicketEdit, TicketList} from "./tickets";
import {OptionList, OptionCreate, OptionEdit} from "./options";

const httpClient = (url, options = {}) => {
    if (!options.headers) {
        options.headers = new Headers({ Accept : 'application/json' });
    }

    const token = localStorage.getItem('token');

    options.user = {
        authenticated: true,
        token: `bearer ${token}`,
    };

    return fetchUtils.fetchJson(url, options);
}

const dataProvider = jsonServerProvider('http://localhost:3002/api', httpClient);

const App = () => (
    <Admin dataProvider={dataProvider} authProvider={authProvider}>
        {permissions => [
            // Staff Resources
            permissions.includes('staff') &&
                <Resource
                    name="users"
                    list={UserList}
                    edit={UserEdit}
                    create={UserCreate}
                    icon={UsersIcon} />,

            permissions.includes('staff') &&
                <Resource
                    name="movies"
                    list={MovieList}
                    edit={MovieEdit}
                    create={MovieCreate}
                    />,

            permissions.includes('staff') &&
                <Resource
                    name="halls"
                    list={HallList}
                    edit={HallEdit}
                    create={HallCreate}
                    />,

            permissions.includes('staff') &&
                <Resource
                    name="shows"
                    list={ShowList}
                    edit={ShowEdit}
                    create={ShowCreate}
                />,

            permissions.includes('staff') &&
                <Resource
                    name="tickets"
                    list={TicketList}
                    edit={TicketEdit}
                    create={TicketCreate}
                />,

            permissions.includes('staff') &&
                <Resource
                    name="options"
                    list={OptionList}
                    edit={permissions.includes('admin') ? OptionEdit : null}
                    create={permissions.includes('admin') ? OptionCreate : null}
                />,

            <Resource name="user/roles" />,
            <Resource name="roles" />,
            <Resource name={'movies/find'} />,
            <Resource name={'shows-future'} />,
        ]}
    </Admin>
);

export default App;
