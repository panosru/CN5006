import * as React from "react";
import {
    Datagrid, DateField,
    List, TextField, EditButton,
    DeleteButton, Edit, Create,
    SimpleForm, NumberInput, useRedirect
} from "react-admin";

export const HallList = props => (
    <List {...props}>
        <Datagrid>
            <TextField source="number" />
            <TextField source="rows" />
            <TextField source="seats_per_row" />
            <TextField source="capacity" />
            <DateField source="created_at" />
            <DateField source="updated_at" />
            <EditButton />
            <DeleteButton />
        </Datagrid>
    </List>
);

export const HallEdit = props => (
    <Edit {...props}>
        <SimpleForm>
            <NumberInput source="number" disabled />
            <NumberInput source="rows" />
            <NumberInput source="seats_per_row" />
        </SimpleForm>
    </Edit>
);

export const HallCreate = props => {

    const redirect = useRedirect();
    const onSuccess = () => {
        redirect('/halls');
    };

    return (
        <Create {...props}>
            <SimpleForm>
                <NumberInput source="number" />
                <NumberInput source="rows" />
                <NumberInput source="seats_per_row" />
            </SimpleForm>
        </Create>
    );
}
