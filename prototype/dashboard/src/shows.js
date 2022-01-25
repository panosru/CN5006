import * as React from "react";
import {
    Datagrid, DateField,
    List, TextField, EditButton,
    DeleteButton, Edit, Create,
    SimpleForm, NumberInput,
    TextInput, DateTimeInput,
    ReferenceInput, SelectInput, useRedirect
} from "react-admin";

export const ShowList = props => (
    <List {...props}>
        <Datagrid rowClick="edit">
            <TextField source="movie.title" label="Movie" />
            <TextField source="hall_number" />
            <DateField source="datetime" showTime={true} />
            <DateField source="created_at" />
            <DateField source="updated_at" />
            <EditButton />
            <DeleteButton />
        </Datagrid>
    </List>
);

export const ShowEdit = props => (
    <Edit {...props}>
        <SimpleForm>
            <ReferenceInput label="Movie" reference="movies" source="movie_id">
                <SelectInput optionText="title" optionValue="id" />
            </ReferenceInput>
            <ReferenceInput label="Hall" reference="halls" source="hall_number">
                <SelectInput optionText="number" optionValue="number" />
            </ReferenceInput>
            <DateTimeInput source="datetime" />
        </SimpleForm>
    </Edit>
);

export const ShowCreate = props => {

    const redirect = useRedirect();
    const onSuccess = () => {
        redirect('/shows');
    };

    return (
        <Create onSuccess={onSuccess} {...props}>
            <SimpleForm>
                <ReferenceInput label="Movie" reference="movies" source="movie_id">
                    <SelectInput optionText="title" optionValue="id" />
                </ReferenceInput>
                <ReferenceInput label="Hall" reference="halls" source="hall_number">
                    <SelectInput optionText="number" optionValue="number" />
                </ReferenceInput>
                <DateTimeInput source="datetime" />
            </SimpleForm>
        </Create>
    );
}
