// in src/users.js
import * as React from "react";
import {
    List,
    EditButton,
    DeleteButton,
    Datagrid,
    TextField,
    EmailField,
    DateField,
    ReferenceManyField,
    SingleFieldList,
    ChipField,
    Create,
    TextInput,
    SelectInput,
    Edit,
    SimpleForm,
    PasswordInput,
    CheckboxGroupInput,
    ReferenceInput,
    ReferenceArrayInput, useRedirect
} from 'react-admin';
import { Users } from './icons/users';

export const UserList = props => (
    <List {...props}>
        <Datagrid rowClick="edit">
            <TextField source="name" />
            <TextField source="surname" />
            <EmailField source="email" />
            <ReferenceManyField reference="user/roles" target="user_id" label="Roles">
                <SingleFieldList>
                    <ChipField source="display_name" />
                </SingleFieldList>
            </ReferenceManyField>
            <DateField source="created_at" />
            <DateField source="updated_at" />
            <EditButton />
            <DeleteButton />
        </Datagrid>
    </List>
);

const EditTitle = ({ record }) => {
    return <span>User {record ? `${record.name} ${record.surname}` : ''}</span>;
};

// const Roles = () => {
//     const request = new Request('http://localhost:3002/api/roles', {
//         method: 'GET',
//         headers: new Headers({
//             'Content-Type': 'application/json',
//             'Authorization': 'Bearer ' + localStorage.getItem('token')
//         }),
//     })
//
//     return fetch(request)
//         .then(response => {
//             if (response.status < 200 || response.status >= 300) {
//                 throw new Error(response.statusText);
//             }
//             console.log(response);
//             return response.json();
//         });
// }

export const UserEdit = props => (
    <Edit title={<EditTitle />} {...props}>
        <SimpleForm>
            <TextInput source="name" />
            <TextInput source="surname" />
            <TextInput source="email" type="email" />
            {/*<CheckboxGroupInput*/}
            {/*    source="my_junction_table"*/}
            {/*    choices={Roles()}*/}
            {/*    initialValue={['f']}*/}
            {/*/>*/}
            {/*<CheckboxGroupInput*/}
            {/*    source="my_junction_table"*/}
            {/*    choices={[*/}
            {/*        { id: 'm', name: 'Male' },*/}
            {/*        { id: 'f', name: 'Female' }*/}
            {/*    ]}*/}
            {/*    initialValue={['f']}*/}
            {/*/>*/}
            <PasswordInput source="password" />
        </SimpleForm>
    </Edit>
);

export const UserCreate = props => {
    const redirect = useRedirect();
    const onSuccess = () => {
        redirect('/users');
    };

    return (
        <Create onSuccess={onSuccess} {...props}>
            <SimpleForm>
                <TextInput source="name" />
                <TextInput source="surname" />
                <TextInput source="email" type="email" />
                <SelectInput source="role_id" choices={[
                    { role: 'admin', name: 'Admin' },
                    { role: 'staff', name: 'Staff' },
                    { role: 'user', name: 'User' },
                ]} />
            </SimpleForm>
        </Create>
    );
}

export const UsersIcon = Users;
