import * as React from "react";
import {
    Datagrid, DateField,
    List, TextField, EditButton,
    DeleteButton, Edit, Create,
    SimpleForm, TextInput, useRedirect
} from "react-admin";

export const OptionList = props => (
    <List {...props}>
        <Datagrid rowClick="edit">
            <TextField source="key" />
            <TextField source="value" />
            <DateField source="created_at" />
            <DateField source="updated_at" />
            {permissions => [
                permissions.includes('admin') && <EditButton />,
                permissions.includes('admin') && <DeleteButton />
            ]}
        </Datagrid>
    </List>
);

export const OptionEdit = props => (
    <Edit title="key" {...props}>
        <SimpleForm>
            <TextInput source="value" />
        </SimpleForm>
    </Edit>
);

export const OptionCreate = props => {

    const redirect = useRedirect();
    const onSuccess = () => {
        redirect('/options');
    };

    return (
        <Create onSuccess={onSuccess} {...props}>
            <SimpleForm>
                <TextInput source="key" />
                <TextInput source="value" />
            </SimpleForm>
        </Create>
    );
};
